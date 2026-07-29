@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] focus:border-[#1F9D7C] transition-colors bg-white text-[#1B2333] placeholder:text-[#9AA1AC]']) }}>
