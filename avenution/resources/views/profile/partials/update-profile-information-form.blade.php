<section>
    <header>
        <h2 class="text-xl font-bold text-slate-950 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            <!-- LEFT -->
            <div class="space-y-6">

                <!-- NAME -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="mt-1 block w-full" 
                        :value="old('name', $user->name)" 
                        required 
                        oninput="triggerChange()"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- EMAIL -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        name="email" 
                        type="email" 
                        class="mt-1 block w-full" 
                        :value="old('email', $user->email)" 
                        required 
                        oninput="triggerChange()"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

            </div>

            <!-- RIGHT -->
            <div class="flex flex-col items-center">

                <!-- FOTO (NO CROP TOTAL) -->
                <div class="w-56 flex items-center justify-center mb-5">

                    @if ($user->profile_photo_url)
                        <img 
                            id="preview-image"
                            src="{{ $user->profile_photo_url }}" 
                            class="max-w-full h-auto rounded-2xl border shadow-sm transition duration-300"
                        >
                    @else
                        <div 
                            id="preview-placeholder"
                            class="flex items-center justify-center w-56 h-56 bg-slate-900 rounded-2xl text-5xl font-bold text-white"
                        >
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                </div>

                <!-- UPLOAD -->
                <div class="flex items-center gap-3">

                    <input
                        id="profile_photo"
                        name="profile_photo"
                        type="file"
                        accept="image/*"
                        class="hidden"
                        onchange="previewImage(event); triggerChange(); updateFileName(this)"
                    >

                    <label for="profile_photo"
                        class="cursor-pointer rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Choose File
                    </label>

                    <span id="file-name" class="text-sm text-slate-500">
                        No file chosen
                    </span>

                </div>

                <!-- INFO -->
                <p class="mt-2 text-xs text-slate-400 text-center">
                    Allowed formats: JPG, PNG, GIF • Max size: 5MB
                </p>

                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />

            </div>
        </div>

        <!-- BUTTON -->
        <div class="mt-8 flex items-center gap-4">

            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <button 
                type="button"
                id="cancel-btn"
                onclick="resetForm()"
                class="hidden rounded-lg bg-red-100 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-200 transition">
                Cancel
            </button>

        </div>
    </form>
</section>

<!-- JS -->
<script>
let originalData = {
    name: "{{ $user->name }}",
    email: "{{ $user->email }}",
    image: "{{ $user->profile_photo_url }}"
};

function triggerChange() {
    document.getElementById('cancel-btn').classList.remove('hidden');
}

function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview-image');
    const placeholder = document.getElementById('preview-placeholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {

            if (preview) {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.id = 'preview-image';
                img.className = 'max-w-full h-auto rounded-2xl border shadow-sm';
                img.src = e.target.result;

                placeholder.replaceWith(img);
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function updateFileName(input) {
    const fileName = input.files[0]?.name || "No file chosen";
    document.getElementById('file-name').innerText = fileName;
}

function resetForm() {
    document.getElementById('name').value = originalData.name;
    document.getElementById('email').value = originalData.email;

    const preview = document.getElementById('preview-image');

    if (preview) {
        preview.src = originalData.image;
    }

    document.getElementById('profile_photo').value = "";
    document.getElementById('file-name').innerText = "No file chosen";

    document.getElementById('cancel-btn').classList.add('hidden');
}
</script>