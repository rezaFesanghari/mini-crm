<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini CRM — مدیریت هوشمند مشتریان کسب‌وکار شما</title>
    <meta name="description" content="Mini CRM؛ ابزار ساده و سریع برای مدیریت مشتری‌ها، شرکت‌ها، فرصت‌های فروش و تسک‌های روزانه‌ی کسب‌وکار شما.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{ font-family:'Vazirmatn', sans-serif; }
        .num{ font-family:'JetBrains Mono','Vazirmatn',monospace; direction:ltr; unicode-bidi:isolate; }
    </style>
</head>
<body class="antialiased bg-[#FAF9F6] text-[#1B2333]">

<!-- HEADER -->
<header class="sticky top-0 z-50 bg-[#FAF9F6]/90 backdrop-blur border-b border-[#E7E4DC]">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-[10px] bg-[linear-gradient(135deg,#1F9D7C,#14735c)] flex items-center justify-center text-white font-extrabold text-sm">CRM</div>
            <span class="font-extrabold text-[17px]">Mini CRM</span>
        </div>

        <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-[#5B6472]">
            <a href="#features" class="hover:text-[#1B2333] transition-colors">امکانات</a>
            <a href="#how-it-works" class="hover:text-[#1B2333] transition-colors">نحوه‌ی کار</a>
        </nav>

        <div class="flex items-center gap-2.5">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-5 py-2.5 rounded-[10px] text-sm font-semibold bg-[#1B2333] text-white">
                    ورود به داشبورد
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 rounded-[10px] text-sm font-semibold text-[#1B2333] hover:bg-white transition-colors">
                    ورود
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 rounded-[10px] text-sm font-semibold bg-[#1B2333] text-white hover:bg-[#2A3450] transition-colors">
                        ثبت‌نام رایگان
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>

<!-- HERO -->
<section class="relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(#E8E4DA 1px, transparent 1px); background-size:100% 40px;"></div>

    <div class="relative max-w-5xl mx-auto px-6 pt-20 pb-16 text-center">
        <div class="inline-flex items-center gap-2 bg-[#E4F5F0] text-[#157A5F] text-xs font-bold px-4 py-2 rounded-full mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-[#1F9D7C]"></span>
            ساخته‌شده برای کسب‌وکارهای کوچک و فروشندگان مستقل
        </div>

        <h1 class="text-4xl md:text-5xl font-extrabold leading-[1.3] mb-5">
            مشتری‌هاتو بهتر بشناس،<br>
            <span class="text-[#1F9D7C]">فروش بیشتری</span> ببند.
        </h1>

        <p class="text-[#5B6472] text-base md:text-lg leading-8 max-w-2xl mx-auto mb-9">
            Mini CRM یه ابزار ساده و سریعه برای مدیریت مشتری‌ها، پیگیری فرصت‌های فروش، و کارهای روزانه‌ت —
            بدون پیچیدگی‌های نرم‌افزارهای بزرگ سازمانی، دقیقاً همون چیزی که یه کسب‌وکار کوچک بهش نیاز داره.
        </p>

        <div class="flex items-center justify-center gap-3 flex-wrap">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-7 py-3.5 rounded-[12px] text-[15px] font-bold bg-[#1B2333] text-white hover:bg-[#2A3450] transition-colors">
                    رفتن به داشبورد
                </a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-7 py-3.5 rounded-[12px] text-[15px] font-bold bg-[#1B2333] text-white hover:bg-[#2A3450] transition-colors">
                        شروع رایگان
                    </a>
                @endif
                <a href="#features"
                   class="px-7 py-3.5 rounded-[12px] text-[15px] font-bold border border-[#E7E4DC] bg-white hover:bg-[#F1EFE9] transition-colors">
                    مشاهده‌ی امکانات
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="max-w-7xl mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <p class="text-[#1F9D7C] font-bold text-sm mb-2">امکانات</p>
        <h2 class="text-3xl font-extrabold mb-3">همه‌چیزی که برای مدیریت مشتری‌هات لازم داری</h2>
        <p class="text-[#5B6472] max-w-xl mx-auto">از اولین تماس با یه سرنخ تا بستن قرارداد، همه‌چیز رو یه‌جا پیگیری کن.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#E4F5F0] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#157A5F" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 014-4h6a4 4 0 014 4v2M17 3.5a4 4 0 010 7"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">مدیریت مشتری‌ها</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                مخاطبین رو به‌عنوان سرنخ یا مشتری فعال دسته‌بندی کن، اطلاعات تماس رو یه‌جا نگه‌دار و با جستجو و فیلتر سریع پیداشون کن.
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#FBEAE8] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#E15B4F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">مدیریت شرکت‌ها</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                مشتری‌های وابسته به هر شرکت رو یه‌جا ببین و مدیریت کن — مخصوصاً وقتی با چند نفر از یه سازمان در ارتباطی.
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#FBF0DF] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#96650F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">پایپ‌لاین فروش</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                فرصت‌های فروش رو رو یه تخته‌ی Kanban مرحله‌به‌مرحله پیش ببر — با درگ‌و-دراپ ساده بین «جدید»، «مذاکره»، «برنده» و...
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#EFF6FF] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#2563EB" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">تسک‌ها و یادآوری‌ها</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                هیچ پیگیری‌ای یادت نره — همه‌ی کارهای مربوط به هر مشتری رو با تاریخ سررسید ثبت کن و در یک نگاه ببین چی امروز و فرداست.
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#E4F5F0] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#157A5F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">داشبورد مدیریتی</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                ارزش معاملات، تعداد مشتری‌ها، تسک‌های امروز، و روند رشد کسب‌وکارت رو در یک نگاه ببین.
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-7">
            <div class="w-12 h-12 rounded-[12px] bg-[#FBEAE8] flex items-center justify-center mb-5">
                <svg width="22" height="22" fill="none" stroke="#E15B4F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">امنیت داده‌ها</h3>
            <p class="text-[#5B6472] text-sm leading-7">
                داده‌های هر کاربر کاملاً از بقیه جداست — هرکس فقط به مشتری‌ها و معاملات خودش دسترسی داره.
            </p>
        </div>

    </div>
</section>

<!-- HOW IT WORKS -->
<section id="how-it-works" class="bg-white border-y border-[#E7E4DC]">
    <div class="max-w-5xl mx-auto px-6 py-20">
        <div class="text-center mb-14">
            <p class="text-[#1F9D7C] font-bold text-sm mb-2">نحوه‌ی کار</p>
            <h2 class="text-3xl font-extrabold">در سه قدم شروع کن</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-[#1B2333] text-white flex items-center justify-center mx-auto mb-5 font-extrabold text-lg num">۱</div>
                <h3 class="font-bold mb-2">مشتری‌هاتو اضافه کن</h3>
                <p class="text-[#5B6472] text-sm leading-7">سرنخ‌ها و مشتری‌های فعلی‌تو با چند کلیک وارد سیستم کن.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-[#1B2333] text-white flex items-center justify-center mx-auto mb-5 font-extrabold text-lg num">۲</div>
                <h3 class="font-bold mb-2">فرصت‌های فروش رو پیش ببر</h3>
                <p class="text-[#5B6472] text-sm leading-7">هر معامله رو تو پایپ‌لاین جابه‌جا کن تا به نتیجه برسه.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-[#1B2333] text-white flex items-center justify-center mx-auto mb-5 font-extrabold text-lg num">۳</div>
                <h3 class="font-bold mb-2">از داشبورد رصد کن</h3>
                <p class="text-[#5B6472] text-sm leading-7">وضعیت کلی کسب‌وکارت رو همیشه در یک نگاه داشته باش.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="max-w-4xl mx-auto px-6 py-20 text-center">
    <h2 class="text-3xl font-extrabold mb-4">آماده‌ای شروع کنی؟</h2>
    <p class="text-[#5B6472] mb-8">همین حالا ثبت‌نام کن و اولین مشتری‌تو اضافه کن — کاملاً رایگان.</p>
    @guest
        @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="inline-block px-8 py-4 rounded-[12px] text-[15px] font-bold bg-[#1F9D7C] text-white hover:bg-[#14735c] transition-colors">
                ثبت‌نام و شروع
            </a>
        @endif
    @else
        <a href="{{ route('dashboard') }}"
           class="inline-block px-8 py-4 rounded-[12px] text-[15px] font-bold bg-[#1F9D7C] text-white hover:bg-[#14735c] transition-colors">
            رفتن به داشبورد
        </a>
    @endguest
</section>

<!-- FOOTER -->
<footer class="border-t border-[#E7E4DC] py-10">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-[8px] bg-[linear-gradient(135deg,#1F9D7C,#14735c)] flex items-center justify-center text-white font-extrabold text-[10px]">CRM</div>
            <span class="font-bold text-sm">Mini CRM</span>
        </div>
        <p class="text-xs text-[#9AA1AC]">
            ساخته‌شده با Laravel و Livewire · {{ date('Y') }}
        </p>
    </div>
</footer>

</body>
</html>
