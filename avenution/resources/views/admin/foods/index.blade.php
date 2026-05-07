<x-admin-layout>
    <x-slot name="title">Manage Foods</x-slot>

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Catalog</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Manage Foods</h1>
            </div>
            <div class="flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('admin.foods.import.form') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-800 shadow-sm transition-colors hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M8 12l4-4m0 0l4 4m-4-4v12"></path></svg>
                    Upload Dataset CSV
                </a>
                <a href="{{ route('admin.foods.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition-colors hover:bg-orange-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Food
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('admin.foods.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1fr_240px_120px_auto_auto]">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search food..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                </div>
                <div>
                    <select name="category" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative">
                    <select name="per_page" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-11 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>Show 10 rows</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>Show 20 rows</option>
                        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>Show 50 rows</option>
                    </select>
                </div>
                <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800">Search</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('admin.foods.index') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</a>
                @endif
            </form>
        </section>

        <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/70">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                <a href="{{ route('admin.foods.index', [...request()->query(), 'sort_by' => 'name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                    Food
                                    @if(request('sort_by') === 'name')
                                        <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                <a href="{{ route('admin.foods.index', [...request()->query(), 'sort_by' => 'category', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                    Category
                                    @if(request('sort_by') === 'category')
                                        <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                <a href="{{ route('admin.foods.index', [...request()->query(), 'sort_by' => 'calories', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                    Calories
                                    @if(request('sort_by') === 'calories')
                                        <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Macros</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($foods as $food)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">{{ $food->emoji }}</span>
                                        <span class="text-sm font-semibold text-slate-950 dark:text-white">{{ $food->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        @if($food->category === 'Protein Hewani') bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-300
                                        @elseif($food->category === 'Protein Nabati') bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300
                                        @elseif($food->category === 'Karbohidrat') bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300
                                        @elseif($food->category === 'Sayuran') bg-green-100 text-green-800 dark:bg-green-500/15 dark:text-green-300
                                        @elseif($food->category === 'Buah') bg-pink-100 text-pink-800 dark:bg-pink-500/15 dark:text-pink-300
                                        @elseif($food->category === 'Dairy') bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300
                                        @else bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300
                                        @endif">
                                        {{ $food->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-950 dark:text-white">
                                    {{ $food->calories }} kcal
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1 text-xs text-slate-700 dark:text-slate-300">
                                        <div><span class="font-semibold">P:</span> {{ $food->protein }}g <span class="font-semibold">C:</span> {{ $food->carbs }}g <span class="font-semibold">F:</span> {{ $food->fat }}g</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.foods.edit', $food) }}" class="rounded-xl bg-sky-50 px-3 py-2 text-sm font-medium text-sky-700 transition-colors hover:bg-sky-100 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">Edit</a>
                                        <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this food?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl bg-red-50 px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/20">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-slate-500 dark:text-slate-400">No foods found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-6 py-5 dark:border-slate-800">
                {{ $foods->links() }}
            </div>
        </section>
    </div>
</x-admin-layout>
