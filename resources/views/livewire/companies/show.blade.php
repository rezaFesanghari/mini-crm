<div>
    @if(session('message'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('companies.index') }}" wire:navigate
       class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#5B6472] no-underline mb-[18px]">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7 7-7M3 12h18"/></svg>
        بازگشت به لیست شرکت‌ها
    </a>

    {{-- هدر --}}
    <div class="bg-white border border-[#E7E4DC] rounded-2xl p-6 flex items-center justify-between gap-5 flex-wrap mb-[22px]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-[linear-gradient(135deg,#1B2333,#2A3450)] flex items-center justify-center text-white shrink-0">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
            </div>
            <div>
                <p class="text-xl font-extrabold m-0 mb-1 text-[#1B2333]">{{ $company->name }}</p>
                <p class="text-[13px] text-[#5B6472] m-0 flex items-center gap-2 flex-wrap">
                    @if($company->website)
                        <span class="text-[#1F9D7C] font-medium font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $company->website }}</span>
                        <span>·</span>
                    @endif
                    <span>ثبت‌شده در <span class="font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $company->created_at->format('Y/m/d') }}</span></span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            @if($company->phone)
                <a href="tel:{{ $company->phone }}" class="flex items-center gap-1.5 px-[15px] py-2 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#1B2333] no-underline">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.98.36 1.94.68 2.86a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.22-1.25a2 2 0 012.11-.45c.92.32 1.88.55 2.86.68A2 2 0 0122 16.92z"/></svg>
                    تماس
                </a>
            @endif
            <button wire:click="openEditModal" class="flex items-center gap-1.5 px-[15px] py-2 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#1B2333]">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                ویرایش
            </button>
            <button wire:click="confirmDelete" class="flex items-center gap-1.5 px-[15px] py-2 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#5B6472] hover:text-[#E15B4F] hover:border-[#E15B4F]">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg>
                حذف
            </button>
        </div>
    </div>

    @if($company->address)
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5 mb-[22px] flex items-center gap-2.5 text-[13px]">
            <svg class="w-[15px] h-[15px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="text-[#1B2333] font-medium">{{ $company->address }}</span>
        </div>
    @endif

    {{-- آمار --}}
    <div class="grid grid-cols-3 gap-3.5 mb-[22px]">
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">کل مخاطبین</p>
            <p class="text-xl font-extrabold m-0">{{ $customerCount }}</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">مشتری فعال</p>
            <p class="text-xl font-extrabold m-0 text-[#157A5F]">{{ $activeCount }}</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">سرنخ</p>
            <p class="text-xl font-extrabold m-0 text-[#96650F]">{{ $leadCount }}</p>
        </div>
    </div>

    {{-- لیست مشتری‌های این شرکت --}}
    <div class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
        <p class="text-[15px] font-bold m-0 mb-4">مخاطبین این شرکت</p>

        @forelse($customers as $customer)

            href="{{ route('customers.show', $customer) }}"
            wire:navigate
            class="flex items-center justify-between py-3 border-b border-[#E7E4DC] last:border-b-0 no-underline text-inherit"
            >
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-[10px] flex items-center justify-center text-white text-xs font-bold shrink-0"
                     style="background:linear-gradient(135deg,{{ $customer->status === 'customer' ? '#1F9D7C,#14735c' : '#C98A2E,#9c6a1e' }})">
                    {{ mb_substr($customer->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-[13.5px] font-semibold m-0 text-[#1B2333]">{{ $customer->name }}</p>
                    @if($customer->email)
                        <p class="text-[11.5px] text-[#9AA1AC] m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $customer->email }}</p>
                    @endif
                </div>
            </div>
            <span class="text-[10.5px] font-bold px-2.5 py-1 rounded-md {{ $customer->status === 'customer' ? 'bg-[#E4F5F0] text-[#157A5F]' : 'bg-[#FBF0DF] text-[#96650F]' }}">
                    {{ $customer->status === 'customer' ? 'مشتری' : 'سرنخ' }}
                </span>
            </a>
        @empty
            <p class="text-sm text-[#9AA1AC]">هنوز مشتری‌ای به این شرکت وصل نشده.</p>
        @endforelse
    </div>

    {{-- مودال ویرایش شرکت --}}
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,18,28,.5)" wire:click.self="closeEditModal">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl border border-[#E7E4DC]">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#1B2333]">ویرایش شرکت</h2>
                    <button wire:click="closeEditModal" class="text-gray-400 hover:text-gray-700">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">نام شرکت</label>
                        <input type="text" wire:model="name" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">وب‌سایت</label>
                        <input type="text" wire:model="website" dir="ltr" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('website') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">تلفن</label>
                        <input type="text" wire:model="phone" dir="ltr" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">آدرس</label>
                        <input type="text" wire:model="address" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                    </div>
                </div>
                <div class="flex gap-2 mt-6">
                    <button wire:click="closeEditModal" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="updateCompany" wire:loading.attr="disabled" wire:target="updateCompany"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#1B2333] disabled:opacity-60">
                        <span wire:loading.remove wire:target="updateCompany">ذخیره تغییرات</span>
                        <span wire:loading wire:target="updateCompany">در حال ذخیره...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- مودال تایید حذف --}}
    @if($showDeleteConfirm)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,18,28,.5)" wire:click.self="cancelDelete">
            <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl border border-[#E7E4DC] text-center">
                <div class="w-14 h-14 rounded-full bg-[#FBEAE8] flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-[#E15B4F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <h2 class="text-base font-bold text-[#1B2333] mb-2">حذف این شرکت؟</h2>
                <p class="text-[13px] text-[#5B6472] mb-6">مشتری‌های وابسته حذف نمی‌شن، فقط ارتباطشون با این شرکت قطع میشه.</p>
                <div class="flex gap-2">
                    <button wire:click="cancelDelete" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="deleteCompany" wire:loading.attr="disabled" wire:target="deleteCompany"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#E15B4F] disabled:opacity-60">
                        <span wire:loading.remove wire:target="deleteCompany">بله، حذف کن</span>
                        <span wire:loading wire:target="deleteCompany">در حال حذف...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
