@php
    $isEdit = isset($user);
    $sectionClass = 'mb-10 space-y-7 border-b border-slate-200/80 pb-10 last:mb-0 last:border-b-0 last:pb-0 dark:border-slate-700/80';
    $sectionTitleClass = 'text-lg font-bold text-slate-950 dark:text-white';
    $fieldLabelClass = 'mb-2.5 block text-sm font-semibold text-slate-700 dark:text-slate-300';
    $inputClass = 'w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-0">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <!-- Account Information -->
    <div class="{{ $sectionClass }}">
        <div class="pt-2">
            <h3 class="{{ $sectionTitleClass }}">Account Information</h3>
        </div>
        
        <div class="grid gap-x-8 gap-y-6 lg:grid-cols-2">
            <div>
                <label class="{{ $fieldLabelClass }}">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                    class="{{ $inputClass }}">
                @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" required
                    class="{{ $inputClass }}">
                @error('username')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                    class="{{ $inputClass }}">
                @error('email')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                    class="{{ $inputClass }}">
                    <option value="user" {{ old('role', ($user && $user->hasRole('admin')) ? 'admin' : 'user') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', ($user && $user->hasRole('admin')) ? 'admin' : 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="lg:col-span-2">
                <label class="{{ $fieldLabelClass }}">
                    Phone
                </label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                    class="{{ $inputClass }}">
                @error('phone')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="{{ $sectionClass }}">
        <div class="pt-2">
            <h3 class="{{ $sectionTitleClass }}">Personal Information</h3>
        </div>
        
        <div class="grid gap-x-8 gap-y-6 md:grid-cols-2 2xl:grid-cols-3">
            <div>
                <label class="{{ $fieldLabelClass }}">
                    Age
                </label>
                <input type="number" name="age" value="{{ old('age', $user->age ?? '') }}"
                    class="{{ $inputClass }}">
                @error('age')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Gender
                </label>
                <input type="text" name="gender" value="{{ old('gender', $user->gender ?? '') }}" placeholder="male / female / other"
                    class="{{ $inputClass }}">
                @error('gender')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Height (cm)
                </label>
                <input type="number" step="0.1" name="height" value="{{ old('height', $user->height ?? '') }}"
                    class="{{ $inputClass }}">
                @error('height')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Weight (kg)
                </label>
                <input type="number" step="0.1" name="weight" value="{{ old('weight', $user->weight ?? '') }}"
                    class="{{ $inputClass }}">
                @error('weight')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Authentication -->
    <div class="{{ $sectionClass }}">
        <div class="pt-2">
            <h3 class="{{ $sectionTitleClass }}">Authentication</h3>
        </div>
        
        <div class="grid gap-x-8 gap-y-6 xl:grid-cols-2">
            <div>
                <label class="{{ $fieldLabelClass }}">
                    <span class="block">
                        Password <span class="text-red-500">*</span>
                    </span>
                    @if($isEdit)
                        <span class="mt-1 block text-xs font-medium text-slate-400 dark:text-slate-500">
                            Leave blank to keep the current password
                        </span>
                    @endif
                </label>
                <input type="password" name="password" {{ $isEdit ? '' : 'required' }}
                    class="{{ $inputClass }}">
                @error('password')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="{{ $fieldLabelClass }}">
                    Confirm Password
                    <span class="mt-1 block text-xs font-medium text-slate-400 dark:text-slate-500">
                        Re-enter the password to confirm it
                    </span>
                </label>
                <input type="password" name="password_confirmation"
                    class="{{ $inputClass }}">
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="mt-10 flex flex-wrap gap-4 border-t border-slate-200/80 pt-8 dark:border-slate-700/80">
        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-semibold transition-all">
            Cancel
        </a>
    </div>
</form>
