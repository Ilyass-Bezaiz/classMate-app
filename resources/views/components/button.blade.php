<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-[15px] font-semibold text-xs text-white uppercase tracking-widest hover:bg-transparent hover:border-indigo-600 hover:text-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>
