<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Mini CRM') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body{ font-family:'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="antialiased bg-[#FAF9F6] text-[#1B2333]"
      style="background-image:linear-gradient(#E8E4DA 1px, transparent 1px); background-size:100% 40px;">

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">

    <a href="" class="flex items-center gap-2.5 mb-8">
        <div class="w-10 h-10 rounded-[11px] bg-[linear-gradient(135deg,#1F9D7C,#14735c)] flex items-center justify-center text-white font-extrabold text-sm shadow-[0_4px_14px_rgba(31,157,124,0.3)]">CRM</div>
        <span class="font-extrabold text-lg">Mini CRM</span>
    </a>

    <div class="w-full max-w-md bg-white border border-[#E7E4DC] rounded-2xl shadow-[0_10px_34px_rgba(27,35,51,0.06)] p-8">
        {{ $slot }}
    </div>

    <p class="mt-8 text-xs text-[#9AA1AC]">
        &copy; {{ date('Y') }} Mini CRM — ساخته‌شده با Laravel و Livewire
    </p>
</div>

@livewireScripts
</body>
</html>
