@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-500']) !!}>
