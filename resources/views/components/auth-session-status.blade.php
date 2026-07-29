@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]']) }}>
        {{ $status }}
    </div>
@endif
