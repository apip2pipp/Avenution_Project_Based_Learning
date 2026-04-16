<x-admin-layout>
    <x-slot name="title">Preview Food Import</x-slot>

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Dataset</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Preview CSV Import</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">File: {{ $uploadedFilename }}</p>
            </div>
            <a href="{{ route('admin.foods.import.form') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                Upload Another File
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Schema</p>
                <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ strtoupper(str_replace('_', ' ', $preview['schema'])) }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Rows</p>
                <p class="mt-2 text-lg font-semibold text-slate-900 dark:text-white">{{ $preview['total_rows'] }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm dark:border-emerald-900/30 dark:bg-emerald-900/20">
                <p class="text-xs uppercase tracking-wider text-emerald-700 dark:text-emerald-200">Ready to Import</p>
                <p class="mt-2 text-lg font-semibold text-emerald-800 dark:text-emerald-100">{{ $preview['valid_rows'] }}</p>
            </div>
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/20">
                <p class="text-xs uppercase tracking-wider text-amber-700 dark:text-amber-200">Skipped / Errors</p>
                <p class="mt-2 text-lg font-semibold text-amber-800 dark:text-amber-100">{{ $preview['duplicate_rows'] + $preview['error_rows'] }}</p>
            </div>
        </section>

        @if(($preview['schema'] ?? '') === 'mapped' && !empty($preview['auto_mapping_applied']))
            <section class="rounded-[1.75rem] border border-emerald-200 bg-emerald-50 p-6 shadow-sm dark:border-emerald-900/30 dark:bg-emerald-900/20">
                <h2 class="text-lg font-semibold text-emerald-900 dark:text-emerald-100">Auto Mapping Applied</h2>
                <p class="mt-2 text-sm text-emerald-700 dark:text-emerald-200">
                    Sistem berhasil mencocokkan kolom dataset secara otomatis. Admin tinggal cek preview lalu confirm import.
                </p>
                @if(!empty($preview['selected_mapping']))
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($preview['selected_mapping'] as $target => $source)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-100">
                                {{ str_replace('_', ' ', $target) }} ← {{ $source }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        @if(count($preview['errors']) > 0)
            <section class="rounded-[1.75rem] border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-900/30 dark:bg-red-900/20">
                <h2 class="text-lg font-semibold text-red-800 dark:text-red-100">Validation Errors (first {{ count($preview['errors']) }} rows)</h2>
                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700 dark:text-red-200">
                    @foreach($preview['errors'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if(!empty($preview['mapping_errors']) && count($preview['mapping_errors']) > 0)
            <section class="rounded-[1.75rem] border border-red-200 bg-red-50 p-6 shadow-sm dark:border-red-900/30 dark:bg-red-900/20">
                <h2 class="text-lg font-semibold text-red-800 dark:text-red-100">Mapping Errors</h2>
                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-red-700 dark:text-red-200">
                    @foreach($preview['mapping_errors'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if(!empty($preview['requires_mapping']))
            <section class="rounded-[1.75rem] border border-indigo-200 bg-indigo-50 p-6 shadow-sm dark:border-indigo-900/30 dark:bg-indigo-900/20">
                <h2 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100">Unknown Schema: Set Column Mapping</h2>
                <p class="mt-2 text-sm text-indigo-700 dark:text-indigo-200">
                    Pilih kolom CSV untuk field inti nutrisi. Setelah mapping dipilih, sistem akan generate preview valid tanpa mengubah flow import lama.
                </p>

                <form action="{{ route('admin.foods.import.preview') }}" method="POST" class="mt-5 space-y-6">
                    @csrf
                    <input type="hidden" name="import_token" value="{{ $importToken }}">

                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach($preview['mappable_fields']['required'] as $field)
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-indigo-900 dark:text-indigo-100">
                                    {{ str_replace('_', ' ', $field) }} <span class="text-red-600">*</span>
                                </label>
                                <select
                                    name="mapping[{{ $field }}]"
                                    required
                                    class="w-full rounded-xl border border-indigo-300 bg-white px-3 py-2.5 text-sm text-slate-700 dark:border-indigo-700 dark:bg-slate-900 dark:text-slate-200"
                                >
                                    <option value="">Pilih kolom CSV</option>
                                    @foreach($preview['detected_headers'] as $header)
                                        <option value="{{ $header }}" @selected(($preview['selected_mapping'][$field] ?? '') === $header)>{{ $header }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-indigo-900 dark:text-indigo-100">Optional Fields</h3>
                        <div class="mt-3 grid gap-3 md:grid-cols-2">
                            @foreach($preview['mappable_fields']['optional'] as $field)
                                <div>
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-indigo-900 dark:text-indigo-100">
                                        {{ str_replace('_', ' ', $field) }}
                                    </label>
                                    <select
                                        name="mapping[{{ $field }}]"
                                        class="w-full rounded-xl border border-indigo-200 bg-white px-3 py-2.5 text-sm text-slate-700 dark:border-indigo-800 dark:bg-slate-900 dark:text-slate-200"
                                    >
                                        <option value="">Skip</option>
                                        @foreach($preview['detected_headers'] as $header)
                                            <option value="{{ $header }}" @selected(($preview['selected_mapping'][$field] ?? '') === $header)>{{ $header }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="rounded-2xl bg-indigo-700 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-indigo-600">
                        Apply Mapping & Re-Preview
                    </button>
                </form>
            </section>

            @if(!empty($preview['source_preview_rows']) && count($preview['source_preview_rows']) > 0)
                <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Raw Source Preview (first {{ count($preview['source_preview_rows']) }} rows)</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800/70">
                                <tr>
                                    @foreach(array_keys($preview['source_preview_rows'][0]) as $column)
                                        <th class="px-4 py-3 text-left">{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                                @foreach($preview['source_preview_rows'] as $rawRow)
                                    <tr>
                                        @foreach($rawRow as $value)
                                            <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        @endif

        @if(count($preview['duplicate_names']) > 0)
            <section class="rounded-[1.75rem] border border-amber-200 bg-amber-50 p-6 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/20">
                <h2 class="text-lg font-semibold text-amber-800 dark:text-amber-100">Duplicate Names Skipped (sample)</h2>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($preview['duplicate_names'] as $name)
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 dark:bg-amber-900/50 dark:text-amber-100">{{ $name }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        @if(empty($preview['requires_mapping']))
        <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Data Preview (max 20 rows)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/70">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Category</th>
                            <th class="px-4 py-3 text-left">Calories</th>
                            <th class="px-4 py-3 text-left">Protein</th>
                            <th class="px-4 py-3 text-left">Carbs</th>
                            <th class="px-4 py-3 text-left">Fat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($preview['preview_rows'] as $row)
                            <tr>
                                <td class="px-4 py-3 text-slate-900 dark:text-white">{{ $row['name'] }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $row['category'] }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $row['calories'] }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $row['protein'] }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $row['carbs'] }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $row['fat'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">Tidak ada data valid untuk diimport.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        @endif

        <section class="flex flex-wrap gap-3">
            @if(empty($preview['requires_mapping']) && $preview['valid_rows'] > 0)
                <form action="{{ route('admin.foods.import.confirm') }}" method="POST">
                    @csrf
                    <input type="hidden" name="import_token" value="{{ $importToken }}">
                    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-orange-500">Confirm Import {{ $preview['valid_rows'] }} Foods</button>
                </form>
            @endif

            <form action="{{ route('admin.foods.import.cancel') }}" method="POST">
                @csrf
                <button type="submit" class="rounded-2xl border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Cancel
                </button>
            </form>
        </section>
    </div>
</x-admin-layout>
