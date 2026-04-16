<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-slate-950 dark:bg-slate-700 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-[0.15em] hover:bg-slate-800 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
