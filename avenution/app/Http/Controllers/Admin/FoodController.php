<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Food;
use App\Services\FoodCsvImportService;
use App\Http\Requests\ImportFoodsCsvRequest;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;

class FoodController extends Controller
{
    private const IMPORT_SESSION_KEY = 'admin_food_import';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Food::query();

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $foods = $query->latest()->paginate(20);
        
        // Get all categories for filter dropdown
        $categories = Food::select('category')->distinct()->pluck('category');

        return view('admin.foods.index', compact('foods', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.foods.create');
    }

    /**
     * Show CSV import form for bulk upload.
     */
    public function importForm()
    {
        return view('admin.foods.import');
    }

    /**
     * Parse uploaded CSV and show preview before importing.
     */
    public function previewImport(ImportFoodsCsvRequest $request, FoodCsvImportService $importService)
    {
        $previousImport = session(self::IMPORT_SESSION_KEY);
        if (!empty($previousImport['path']) && Storage::exists($previousImport['path'])) {
            Storage::delete($previousImport['path']);
        }

        $uploadedFile = $request->file('csv_file');
        $storedPath = $uploadedFile->store('tmp/food-imports');
        $preview = $importService->previewFromStoragePath($storedPath);

        $token = (string) Str::uuid();
        session([
            self::IMPORT_SESSION_KEY => [
                'token' => $token,
                'path' => $storedPath,
                'filename' => $uploadedFile->getClientOriginalName(),
            ],
        ]);

        return view('admin.foods.import-preview', [
            'preview' => $preview,
            'importToken' => $token,
            'uploadedFilename' => $uploadedFile->getClientOriginalName(),
        ]);
    }

    /**
     * Persist rows from previewed CSV import.
     */
    public function confirmImport(Request $request, FoodCsvImportService $importService)
    {
        $request->validate([
            'import_token' => ['required', 'string'],
        ]);

        $importSession = session(self::IMPORT_SESSION_KEY);

        if (!$importSession || ($importSession['token'] ?? null) !== $request->string('import_token')->toString()) {
            return redirect()->route('admin.foods.import.form')
                ->with('error', 'Sesi preview import sudah tidak valid. Silakan upload ulang file CSV.');
        }

        $storedPath = $importSession['path'] ?? null;

        if (!$storedPath || !Storage::exists($storedPath)) {
            session()->forget(self::IMPORT_SESSION_KEY);

            return redirect()->route('admin.foods.import.form')
                ->with('error', 'File CSV preview tidak ditemukan. Silakan upload ulang.');
        }

        $result = $importService->importFromStoragePath($storedPath);

        Storage::delete($storedPath);
        session()->forget(self::IMPORT_SESSION_KEY);

        $message = sprintf(
            'Import selesai. Berhasil: %d, Duplikat di-skip: %d, Error: %d.',
            $result['inserted_rows'],
            $result['duplicate_rows'],
            $result['error_rows']
        );

        return redirect()->route('admin.foods.index')->with('success', $message);
    }

    /**
     * Cancel current CSV import session and cleanup temporary file.
     */
    public function cancelImport()
    {
        $importSession = session(self::IMPORT_SESSION_KEY);
        $storedPath = $importSession['path'] ?? null;

        if ($storedPath && Storage::exists($storedPath)) {
            Storage::delete($storedPath);
        }

        session()->forget(self::IMPORT_SESSION_KEY);

        return redirect()->route('admin.foods.import.form')
            ->with('success', 'Import dibatalkan dan file sementara sudah dihapus.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        Food::create($request->validated());

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Food $food)
    {
        return view('admin.foods.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $food->update($request->validated());

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('admin.foods.index')
            ->with('success', 'Food item deleted successfully!');
    }
}
