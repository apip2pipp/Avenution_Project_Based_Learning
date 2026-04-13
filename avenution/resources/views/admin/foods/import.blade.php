<x-admin-layout>
    <x-slot name="title">Import Food Dataset</x-slot>

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Dataset</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Import Foods from CSV</h1>
            </div>
            <a href="{{ route('admin.foods.index') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                Back to Manage Foods
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Upload CSV</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Upload dataset baru, sistem akan mendeteksi format secara otomatis lalu menampilkan preview sebelum data disimpan.</p>

            <form action="{{ route('admin.foods.import.preview') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="csv_file" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">CSV File</label>
                    <input
                        type="file"
                        id="csv_file"
                        name="csv_file"
                        accept=".csv,text/csv"
                        required
                        class="block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"
                    >
                    @error('csv_file')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-orange-500">
                    Preview Import
                </button>
            </form>
        </section>

        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Supported CSV Formats</h2>
            <div class="mt-4 space-y-4 text-sm text-slate-600 dark:text-slate-300">
                <div>
                    <p class="font-semibold text-slate-900 dark:text-slate-100">1) Format Sederhana</p>
                    <p>Wajib: name, category, calories, protein, carbs, fat</p>
                    <p>Opsional: fiber, sugars, sodium, cholesterol, meal_type, description, image_url, dietary_tags, health_benefits, emoji</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-slate-100">2) Format nutrition.csv</p>
                    <p>Kolom umum: id, calories, proteins, fat, carbohydrate, name, image</p>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 dark:text-slate-100">3) Format nilai-gizi.csv</p>
                    <p>Kolom umum: name, serving_size, energy_kcal, protein_g, carbohydrate_g, fat_g, sugar_g, sodium_mg, fiber_g</p>
                </div>
            </div>
            <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Duplikat nama makanan akan otomatis di-skip saat preview maupun import.</p>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Jika schema belum dikenali, sistem akan mencoba auto-mapping kolom terlebih dahulu; jika belum lengkap, admin bisa koreksi mapping tanpa upload ulang file.</p>
        </section>
    </div>
</x-admin-layout>
