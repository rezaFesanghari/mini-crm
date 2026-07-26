<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشتری‌ها · Mini CRM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body class="m-0 font-[Pelak] bg-[#FAF9F6] text-[#1B2333] [background-image:linear-gradient(#E8E4DA_1px,transparent_1px)] [background-size:100%_40px] bg-local min-h-screen antialiased">

<div class="flex flex-col md:flex-row min-h-screen w-full relative" x-data="{ sidebarOpen: false }">

    <!-- OVERLAY (Mobile) -->
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-[#0F121C]/50 z-40 md:hidden backdrop-blur-sm"
        x-cloak
    ></div>

    <!-- MOBILE TOPBAR -->
    <header class="flex md:hidden items-center justify-between px-4 py-3 sticky top-0 bg-[#FAF9F6]/95 backdrop-blur z-30 border-b border-[#E7E4DC] w-full shrink-0">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-[9px] bg-gradient-to-br from-[#1F9D7C] to-[#14735c] flex items-center justify-center font-extrabold text-sm text-white shadow-[0_3px_10px_rgba(31,157,124,0.35)]">CRM</div>
            <span class="font-extrabold text-[15px]">Mini CRM</span>
        </div>
        <button
            @click="sidebarOpen = !sidebarOpen"
            type="button"
            class="w-[38px] h-[38px] rounded-[9px] border border-[#E7E4DC] bg-white flex items-center justify-center text-[#1B2333] focus:outline-none"
            aria-label="باز کردن منو"
        >
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </header>

    <!-- SIDEBAR -->
    <aside
        :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 right-0 z-50 w-[260px] bg-[#1B2333] text-white p-6 flex flex-col transition-transform duration-300 ease-in-out
               md:static md:z-auto md:h-screen md:sticky md:top-0 md:shrink-0 overflow-y-auto"
        x-cloak
    >
        <!-- Logo -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-2.5">
                <div class="w-[34px] h-[34px] rounded-[9px] bg-gradient-to-br from-[#1F9D7C] to-[#14735c] flex items-center justify-center font-extrabold text-[15px] text-white shadow-[0_3px_10px_rgba(31,157,124,0.35)]">CRM</div>
                <div>
                    <div class="font-extrabold text-[16.5px] leading-tight">Mini CRM</div>
                    <div class="text-[11px] text-[#8A93A8] mt-0.5">فضای کاری من</div>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="md:hidden text-[#8A93A8] hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="text-[11px] text-[#6E7793] mx-1.5 mt-2 mb-2 font-semibold tracking-wide">اصلی</div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[9px] text-[#B7BECF] text-sm font-medium cursor-pointer transition-colors hover:bg-white/5 hover:text-white">
                <svg class="w-[17px] h-[17px] opacity-85 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/></svg>
                داشبورد
            </a>
            <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[9px] text-sm font-medium cursor-pointer bg-[#1F9D7C]/[0.14] text-white border-r-2 border-[#1F9D7C]">
                <svg class="w-[17px] h-[17px] opacity-85 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 014-4h6a4 4 0 014 4v2M17 3.5a4 4 0 010 7"/></svg>
                مشتری‌ها
            </a>
            <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[9px] text-[#B7BECF] text-sm font-medium cursor-pointer transition-colors hover:bg-white/5 hover:text-white">
                <svg class="w-[17px] h-[17px] opacity-85 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                شرکت‌ها
            </a>
            <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[9px] text-[#B7BECF] text-sm font-medium cursor-pointer transition-colors hover:bg-white/5 hover:text-white">
                <svg class="w-[17px] h-[17px] opacity-85 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                فرصت‌های فروش
            </a>
            <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[9px] text-[#B7BECF] text-sm font-medium cursor-pointer transition-colors hover:bg-white/5 hover:text-white">
                <svg class="w-[17px] h-[17px] opacity-85 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                تسک‌ها
            </a>
        </nav>

        <!-- User profile section -->
        <div class="mt-auto pt-4 border-t border-white/10 flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full bg-[#3A4363] flex items-center justify-center text-xs font-bold shrink-0">آ.ر</div>
            <div class="min-w-0">
                <div class="text-[13px] font-semibold truncate">آرش رضایی</div>
                <div class="text-[11px] text-[#8A93A8] truncate">مدیر فروش</div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 sm:p-6 md:p-8 max-w-[1280px] w-full min-w-0 mx-auto">
        {{ $slot }}
    </main>

</div>

@livewireScripts
</body>
</html>
