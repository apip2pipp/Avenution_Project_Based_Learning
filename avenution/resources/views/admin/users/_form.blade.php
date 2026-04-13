@php
    $isEdit = isset($user);
@endphp

<form method="POST" action="{{ $action }}" class="space-y-8">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('username')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Role</label>
            <select name="role" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                <option value="user" {{ old('role', ($user && $user->hasRole('admin')) ? 'admin' : 'user') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', ($user && $user->hasRole('admin')) ? 'admin' : 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Age</label>
            <input type="number" name="age" value="{{ old('age', $user->age ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('age')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Gender</label>
            <input type="text" name="gender" value="{{ old('gender', $user->gender ?? '') }}" placeholder="male / female / other" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('gender')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Height</label>
            <input type="number" step="0.1" name="height" value="{{ old('height', $user->height ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('height')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Weight</label>
            <input type="number" step="0.1" name="weight" value="{{ old('weight', $user->weight ?? '') }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('weight')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="lg:col-span-2">
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Password {{ $isEdit ? '(leave blank to keep current password)' : '' }}</label>
            <input type="password" name="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="lg:col-span-2">
            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800">{{ $submitLabel }}</button>
        <a href="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Cancel</a>
    </div>
</form>