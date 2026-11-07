<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-black text-xs transition-all shadow-xs hover:scale-105 active:scale-95 rounded-2xl cursor-pointer disabled:opacity-25']) }}>
    {{ $slot }}
</button>
