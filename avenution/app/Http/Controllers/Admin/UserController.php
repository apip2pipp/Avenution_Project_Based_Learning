<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = User::query();

        $users = (clone $baseQuery)
            ->withCount('analyses')
            ->with('roles')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim((string) $request->input('search'));

                $query->where(function ($nestedQuery) use ($search) {
                    $nestedQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(12);

        $users->appends($request->except('page'));

        $stats = [
            'totalUsers' => (clone $baseQuery)->count(),
            'adminUsers' => (clone $baseQuery)->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->count(),
            'verifiedUsers' => (clone $baseQuery)->whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->string('name')->toString(),
            'username' => $request->string('username')->toString(),
            'email' => $request->string('email')->lower()->toString(),
            'password' => Hash::make($request->string('password')->toString()),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'phone' => $request->input('phone'),
        ]);

        $user->syncRoles([$request->input('role', 'user')]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->ensureNonAdminUser($user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->ensureNonAdminUser($user);

        $user->fill([
            'name' => $request->string('name')->toString(),
            'username' => $request->string('username')->toString(),
            'email' => $request->string('email')->lower()->toString(),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->string('password')->toString());
        }

        $user->save();

        $user->syncRoles([$request->input('role', 'user')]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->ensureNonAdminUser($user);

        if (auth()->id() === $user->id) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    private function ensureNonAdminUser(User $user): void
    {
        if ($user->hasRole('admin')) {
            abort(403);
        }
    }
}