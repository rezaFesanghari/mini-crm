@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium mb-1.5 text-[#5B6472]']) }}>
    {{ $value ?? $slot }}
</label>
