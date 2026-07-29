<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-[#1B2333] border border-transparent rounded-[10px] font-semibold text-sm text-white hover:bg-[#2A3450] transition-colors disabled:opacity-60']) }}>
    {{ $slot }}
</button>
