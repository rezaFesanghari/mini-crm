<div>
    @if(session('message'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex items-end justify-between mb-[26px] flex-wrap gap-3.5">
        <div>
            <h1 class="text-2xl font-extrabold m-0 mb-1 text-[#1B2333]">شرکت‌ها</h1>
            <p class="text-[13.5px] text-[#5B6472] m-0">{{ $totalCount }} شرکت ثبت‌شده</p>
        </div>
        <button
            wire:click="openCreateModal"
            class="bg-[#1B2333] hover:bg-[#2A3450] text-white border-0 rounded-[10px] px-[18px] py-[11px] text-sm font-semibold cursor-pointer flex items-center gap-2 transition-colors"
        >
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            افزودن شرکت
        </button>
    </div>

    <div class="relative mb-[22px] max-w-[420px]">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="جستجو بر اساس نام شرکت…"
            class="w-full pr-[40px] pl-[14px] py-[10px] rounded-[10px] border border-[#E7E4DC] bg-white text-[13.5px] outline-none focus:border-[#9AA1AC]"
        >
        <svg class="absolute right-[14px] top-1/2 -translate-y-1/2 w-[15px] h-[15px] text-[#9AA1AC] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[18px]">
        @forelse($companies as $company)

            <a href="{{ route('companies.show', $company) }}"
            wire:navigate
            class="bg-white border border-[#E7E4DC] rounded-[14px] p-5 block no-underline text-inherit relative transition-all hover:shadow-[0_8px_22px_rgba(27,35,51,0.07)] hover:-translate-y-0.5 hover:border-[#D8D3C6]"
            >
            <div class="w-[46px] h-[46px] rounded-xl bg-[linear-gradient(135deg,#1B2333,#2A3450)] flex items-center justify-center text-white mb-3.5">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            </div>

            <p class="text-[15px] font-bold m-0 mb-0.5 text-[#1B2333]">{{ $company->name }}</p>
            @if($company->website)
                <p class="text-xs text-[#1F9D7C] m-0 mb-3.5 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $company->website }}</p>
            @else
                <p class="text-xs text-[#9AA1AC] m-0 mb-3.5">—</p>
            @endif

            @if($company->phone)
                <div class="flex items-center gap-2 text-[12.5px] text-[#5B6472] mb-[7px]">
                    <svg class="w-[14px] h-[14px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.98.36 1.94.68 2.86a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.22-1.25a2 2 0 012.11-.45c.92.32 1.88.55 2.86.68A2 2 0 0122 16.92z"/></svg>
                    <span class="font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate] text-[#1B2333] font-medium">{{ $company->phone }}</span>
                </div>
            @endif

            @if($company->address)
                <div class="flex items-center gap-2 text-[12.5px] text-[#5B6472] mb-[7px]">
                    <svg class="w-[14px] h-[14px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="text-[#1B2333] font-medium">{{ $company->address }}</span>
                </div>
            @endif

            <div class="flex items-center justify-between mt-[14px] pt-3 border-t border-[#E7E4DC]">
                <div class="flex items-center gap-1.5 text-xs font-bold text-[#157A5F] bg-[#E4F5F0] px-2.5 py-1 rounded-full">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a4 4 0 014-4h6a4 4 0 014 4v2"/></svg>
                    {{ $company->customers_count }} مشتری
                </div>

            </div>
            </a>
        @empty
            <p class="text-[#5B6472] col-span-full text-sm">
                هنوز شرکتی ثبت نشده. با دکمه‌ی «افزودن شرکت» شروع کن.
            </p>
        @endforelse
    </div>

    {{-- مودال افزودن/ویرایش شرکت --}}
    @if($showCreateModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background:rgba(15,18,28,.5)"
            wire:click.self="closeCreateModal"
        >
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl border border-[#E7E4DC]">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#1B2333]">
                        {{ $editingCompanyId ? 'ویرایش شرکت' : 'افزودن شرکت جدید' }}
                    </h2>
                    <button wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-700">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">نام شرکت</label>
                        <input type="text" wire:model="name" placeholder="مثلاً فروشگاه دیجی‌کالا"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">وب‌سایت</label>
                        <input type="text" wire:model="website" placeholder="example.com" dir="ltr"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('website') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">تلفن</label>
                        <input type="text" wire:model="phone" placeholder="021 1234 5678" dir="ltr"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">آدرس</label>
                        <input type="text" wire:model="address" placeholder="آدرس (اختیاری)"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button wire:click="closeCreateModal" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">
                        انصراف
                    </button>
                    <button
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#1B2333] disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="save">{{ $editingCompanyId ? 'ذخیره تغییرات' : 'ثبت شرکت' }}</span>
                        <span wire:loading wire:target="save">در حال ذخیره...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- مودال تایید حذف --}}
    @if($companyIdToDelete)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background:rgba(15,18,28,.5)"
            wire:click.self="cancelDelete"
        >
            <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl border border-[#E7E4DC] text-center">
                <div class="w-14 h-14 rounded-full bg-[#FBEAE8] flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#E15B4F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <h2 class="text-base font-bold text-[#1B2333] mb-2">حذف این شرکت؟</h2>
                <p class="text-[13px] text-[#5B6472] mb-6">
                    مشتری‌های وابسته به این شرکت حذف نمی‌شن، فقط ارتباطشون با این شرکت قطع میشه.
                </p>
                <div class="flex gap-2">
                    <button wire:click="cancelDelete" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">
                        انصراف
                    </button>
                    <button
                        wire:click="deleteCompany"
                        wire:loading.attr="disabled"
                        wire:target="deleteCompany"
                        class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#E15B4F] disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="deleteCompany">بله، حذف کن</span>
                        <span wire:loading wire:target="deleteCompany">در حال حذف...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
