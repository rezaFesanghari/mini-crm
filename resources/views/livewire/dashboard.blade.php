<div>

    {{-- هدر --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3.5">
        <div>
            <p class="text-[22px] font-extrabold m-0 mb-1 text-[#1B2333]">سلام {{ explode(' ', auth()->user()->name)[0] }} 👋</p>
            <p class="text-[13.5px] text-[#5B6472] m-0">
                امروز <span class="font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ now()->format('Y/m/d') }}</span>
                — خلاصه‌ی وضعیت کسب‌وکارت
            </p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('customers.index') }}" wire:navigate
               class="flex items-center gap-1.5 px-4 py-2.5 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#1B2333] no-underline">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                مشتری جدید
            </a>
            <a href="{{ route('deals.index') }}" wire:navigate
               class="flex items-center gap-1.5 px-4 py-2.5 rounded-[9px] text-[13px] font-semibold bg-[#1B2333] text-white no-underline">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                معامله جدید
            </a>
        </div>
    </div>

    {{-- KPI ها --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 mb-[22px]">

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5">
            <div class="w-9 h-9 rounded-[10px] flex items-center justify-center mb-3 bg-[#E4F5F0]">
                <svg width="18" height="18" fill="none" stroke="#157A5F" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 014-4h6a4 4 0 014 4v2M17 3.5a4 4 0 010 7"/></svg>
            </div>
            <p class="text-xs text-[#5B6472] m-0 mb-1">کل مخاطبین</p>
            <p class="text-2xl font-extrabold m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $totalCustomers }}</p>
            @if($newCustomersThisMonth > 0)
                <p class="text-[11px] font-bold mt-1.5 flex items-center gap-1 text-[#157A5F]">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 15l-6-6-6 6"/></svg>
                    {{ $newCustomersThisMonth }} مورد جدید این ماه
                </p>
            @endif
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5">
            <div class="w-9 h-9 rounded-[10px] flex items-center justify-center mb-3 bg-[#EFF6FF]">
                <svg width="18" height="18" fill="none" stroke="#2563EB" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <p class="text-xs text-[#5B6472] m-0 mb-1">ارزش معاملات باز</p>
            <p class="text-2xl font-extrabold m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ number_format($openDealsValue) }}</p>
            <p class="text-[11px] font-bold mt-1.5 flex items-center gap-1 {{ $dealsTrendPercent >= 0 ? 'text-[#157A5F]' : 'text-[#B23A2F]' }}">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    @if($dealsTrendPercent >= 0)
                        <path d="M18 15l-6-6-6 6"/>
                    @else
                        <path d="M6 9l6 6 6-6"/>
                    @endif
                </svg>
                {{ abs($dealsTrendPercent) }}٪ نسبت به ماه قبل
            </p>
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5">
            <div class="w-9 h-9 rounded-[10px] flex items-center justify-center mb-3 bg-[#FBF0DF]">
                <svg width="18" height="18" fill="none" stroke="#96650F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            </div>
            <p class="text-xs text-[#5B6472] m-0 mb-1">تسک‌های امروز</p>
            <p class="text-2xl font-extrabold m-0">{{ $tasksToday }} مورد</p>
            @if($tasksOverdue > 0)
                <p class="text-[11px] font-bold mt-1.5 flex items-center gap-1 text-[#B23A2F]">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01"/></svg>
                    {{ $tasksOverdue }} مورد سررسیدگذشته
                </p>
            @else
                <p class="text-[11px] font-bold mt-1.5 text-[#157A5F]">همه چیز رو‌به‌راهه 🎉</p>
            @endif
        </div>

        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5">
            <div class="w-9 h-9 rounded-[10px] flex items-center justify-center mb-3 bg-[#FBEAE8]">
                <svg width="18" height="18" fill="none" stroke="#E15B4F" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            </div>
            <p class="text-xs text-[#5B6472] m-0 mb-1">شرکت‌های ثبت‌شده</p>
            <p class="text-2xl font-extrabold m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $totalCompanies }}</p>
            @if($newCompaniesThisMonth > 0)
                <p class="text-[11px] font-bold mt-1.5 flex items-center gap-1 text-[#157A5F]">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 15l-6-6-6 6"/></svg>
                    {{ $newCompaniesThisMonth }} مورد جدید این ماه
                </p>
            @endif
        </div>
    </div>

    {{-- بدنه اصلی --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-[18px] items-start">

        {{-- ستون چپ --}}
        <div>
            {{-- پایپ‌لاین --}}
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px] mb-[18px]">
                <p class="text-[15px] font-bold m-0 mb-1">پایپ‌لاین فروش</p>
                <p class="text-xs text-[#9AA1AC] m-0 mb-5">ارزش معاملات به تفکیک مرحله</p>

                @php
                    $stageMeta = [
                        'new'         => ['label' => 'جدید', 'color' => '#94A3B8'],
                        'contacted'   => ['label' => 'تماس گرفته‌شده', 'color' => '#60A5FA'],
                        'negotiation' => ['label' => 'مذاکره', 'color' => '#C98A2E'],
                        'won'         => ['label' => 'برنده', 'color' => '#1F9D7C'],
                        'lost'        => ['label' => 'باخته', 'color' => '#E15B4F'],
                    ];
                @endphp

                @foreach($pipeline as $row)
                    @php
                        $meta = $stageMeta[$row['stage']];
                        $widthPercent = $row['value'] > 0
                            ? max(round(($row['value'] / $maxStageValue) * 100), 8)
                            : 2;
                    @endphp
                    <div class="flex items-center gap-3.5 mb-4 last:mb-0">
                        <div class="w-[110px] shrink-0 text-[12.5px] font-semibold text-[#5B6472] flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $meta['color'] }}"></span>
                            {{ $meta['label'] }}
                        </div>
                        <div class="flex-1 h-[26px] bg-[#F1EFE9] rounded-lg overflow-hidden">
                            <div class="h-full rounded-lg flex items-center px-2.5 transition-all" style="width:{{ $widthPercent }}%;background:{{ $meta['color'] }}">
                                <span class="text-[11px] font-bold text-white whitespace-nowrap font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ number_format($row['value']) }}</span>
                            </div>
                        </div>
                        <div class="w-[60px] shrink-0 text-xs font-bold text-[#1B2333] font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $row['count'] }} معامله</div>
                    </div>
                @endforeach
            </div>

            {{-- مشتریان برتر --}}
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-1">مشتریان برتر</p>
                <p class="text-xs text-[#9AA1AC] m-0 mb-4">بر اساس مجموع ارزش معاملات</p>

                @forelse($topCustomers as $index => $customer)
                    <div class="flex items-center justify-between py-2.5 border-b border-[#E7E4DC] last:border-b-0">
                        <div class="flex items-center gap-2.5">
                            <span class="w-[22px] h-[22px] rounded-[7px] bg-[#EEF0F5] text-[#5B6472] text-[11px] font-extrabold flex items-center justify-center">{{ $index + 1 }}</span>
                            <span class="text-[13px] font-semibold">{{ $customer->name }}</span>
                        </div>
                        <span class="text-[13px] font-bold font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ number_format($customer->deals_sum_value ?? 0) }} تومان</span>
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">هنوز معامله‌ای ثبت نشده.</p>
                @endforelse
            </div>
        </div>

        {{-- ستون راست --}}
        <div>
            {{-- دونات --}}
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px] mb-[18px]">
                <p class="text-[15px] font-bold m-0 mb-1">ترکیب مخاطبین</p>
                <p class="text-xs text-[#9AA1AC] m-0 mb-5">نسبت مشتری فعال به سرنخ</p>

                @php
                    $circumference = 2 * pi() * 48;
                    $activeArcLength = ($activePercent / 100) * $circumference;
                @endphp

                <div class="flex items-center gap-6">
                    <svg width="120" height="120" viewBox="0 0 120 120" class="shrink-0">
                        <circle cx="60" cy="60" r="48" fill="none" stroke="#FBF0DF" stroke-width="16"/>
                        <circle cx="60" cy="60" r="48" fill="none" stroke="#1F9D7C" stroke-width="16"
                                stroke-dasharray="{{ $activeArcLength }} {{ $circumference }}"
                                stroke-linecap="round"
                                transform="rotate(-90 60 60)"/>
                        <text x="60" y="56" text-anchor="middle" font-size="20" font-weight="800" fill="#1B2333" font-family="JetBrains Mono">{{ $activePercent }}٪</text>
                        <text x="60" y="74" text-anchor="middle" font-size="9" fill="#9AA1AC">مشتری فعال</text>
                    </svg>
                    <div class="flex-1">
                        <div class="flex items-center justify-between py-2.5 border-b border-[#E7E4DC]">
                            <span class="text-[12.5px] text-[#5B6472] flex items-center"><span class="w-[9px] h-[9px] rounded-full inline-block ml-2" style="background:#1F9D7C"></span>مشتری فعال</span>
                            <span class="text-[13px] font-bold font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $activeCustomerCount }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-[12.5px] text-[#5B6472] flex items-center"><span class="w-[9px] h-[9px] rounded-full inline-block ml-2" style="background:#C98A2E"></span>سرنخ</span>
                            <span class="text-[13px] font-bold font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $leadCount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- تسک‌های پیش‌رو --}}
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px] mb-[18px]">
                <p class="text-[15px] font-bold m-0 mb-1">تسک‌های پیش‌رو</p>
                <p class="text-xs text-[#9AA1AC] m-0 mb-4">امروز و فردا</p>

                @forelse($upcomingTasks as $task)
                    @php $isToday = \Illuminate\Support\Carbon::parse($task->due_date)->isToday(); @endphp
                    <div class="flex items-center gap-2.5 py-2.5 border-b border-[#E7E4DC] last:border-b-0">
                        <div class="w-[19px] h-[19px] rounded-md border-2 border-[#E7E4DC] shrink-0"></div>
                        <div class="flex-1">
                            <p class="text-[13px] font-semibold m-0 mb-0.5">{{ $task->title }}</p>
                            <p class="text-[11px] text-[#9AA1AC] m-0">{{ $task->customer->name ?? '—' }}</p>
                        </div>
                        <span class="text-[10.5px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap {{ $isToday ? 'bg-[#FBEAE8] text-[#B23A2F]' : 'bg-[#FBF0DF] text-[#96650F]' }}">
                            {{ $isToday ? 'امروز' : 'فردا' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">تسکی برای امروز و فردا نیست 🎉</p>
                @endforelse
            </div>

            {{-- فید فعالیت --}}
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-1">فعالیت‌های اخیر</p>
                <p class="text-xs text-[#9AA1AC] m-0 mb-4">آخرین رویدادها در سراسر سیستم</p>

                @php
                    $feedIcons = [
                        'note'     => ['bg' => '#FBF0DF', 'icon' => '📝'],
                        'deal'     => ['bg' => '#EFF6FF', 'icon' => '＋'],
                        'customer' => ['bg' => '#E4F5F0', 'icon' => '✓'],
                    ];
                @endphp

                @forelse($activityFeed as $item)
                    @php $ic = $feedIcons[$item['type']]; @endphp
                    <div class="flex gap-3 mb-4 last:mb-0">
                        <div class="w-[30px] h-[30px] rounded-[9px] flex items-center justify-center text-xs shrink-0" style="background:{{ $ic['bg'] }}">{{ $ic['icon'] }}</div>
                        <div>
                            <p class="text-[12.5px] leading-[1.7] m-0 mb-0.5">{{ $item['text'] }}</p>
                            <p class="text-[11px] text-[#9AA1AC] m-0">{{ $item['time']->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">هنوز فعالیتی ثبت نشده.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
