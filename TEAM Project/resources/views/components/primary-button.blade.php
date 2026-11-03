<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs rounded-2xl shadow-md shadow-indigo-500/20 hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-all duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
