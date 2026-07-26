<div>
    <!-- TOPBAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-[#1B2333] tracking-tight">مشتری‌ها</h1>
            <p class="text-xs sm:text-[13.5px] text-[#5B6472] mt-1">
                {{ $totalCount }} مخاطب · {{ $customerCount }} مشتری فعال · {{ $leadCount }} سرنخ در حال پیگیری
            </p>
        </div>
        <button
            wire:click="openCreateModal"
            type="button"
            class="bg-[#1B2333] hover:bg-[#2A3450] text-white rounded-[10px] px-4 py-2.5 text-sm font-semibold flex items-center justify-center gap-2 shadow-sm transition-colors shrink-0 w-full sm:w-auto"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            افزودن مشتری
        </button>
    </div>

    <!-- TOOLBAR & FILTERS -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <!-- Search Box -->
        <div class="flex-1 relative min-w-0">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="جستجو بر اساس نام، ایمیل یا شرکت…"
                class="w-full pr-10 pl-3.5 py-2.5 rounded-[10px] border border-[#E7E4DC] bg-white text-sm text-[#1B2333] outline-none focus:border-[#1F9D7C] focus:ring-1 focus:ring-[#1F9D7C] placeholder:text-[#9AA1AC] transition-all"
            >
            <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9AA1AC] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
        </div>

        <!-- Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 shrink-0">
            <button
                type="button"
                wire:click="setFilter('all')"
                class="px-4 py-2 rounded-full text-xs sm:text-[13px] font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $filter === 'all' ? 'bg-[#1B2333] text-white border-[#1B2333]' : 'bg-white text-[#5B6472] border-[#E7E4DC] hover:border-[#9AA1AC]' }}"
            >
                همه
            </button>

            <button
                type="button"
                wire:click="setFilter('customer')"
                class="px-4 py-2 rounded-full text-xs sm:text-[13px] font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $filter === 'customer' ? 'bg-[#1B2333] text-white border-[#1B2333]' : 'bg-white text-[#5B6472] border-[#E7E4DC] hover:border-[#9AA1AC]' }}"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-[#1F9D7C]"></span> مشتری
            </button>

            <button
                type="button"
                wire:click="setFilter('lead')"
                class="px-4 py-2 rounded-full text-xs sm:text-[13px] font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $filter === 'lead' ? 'bg-[#1B2333] text-white border-[#1B2333]' : 'bg-white text-[#5B6472] border-[#E7E4DC] hover:border-[#9AA1AC]' }}"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-[#C98A2E]"></span> سرنخ
            </button>
        </div>
    </div>

    <!-- CUSTOMERS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-stretch">
        @forelse($customers as $customer)
            <div class="bg-white border border-[#E7E4DC] rounded-[14px] p-4 relative transition-all hover:shadow-[0_8px_22px_rgba(27,35,51,0.07)] hover:-translate-y-0.5 flex flex-col justify-between h-full min-w-0 overflow-hidden">

                <!-- Status Top Indicator -->
                <div class="absolute -top-px right-6 w-9 h-2.5 rounded-b-[6px] {{ $customer->status === 'customer' ? 'bg-[#1F9D7C]' : 'bg-[#C98A2E]' }}"></div>

                <div class="min-w-0 w-full">
                    <!-- Header Info -->
                    <div class="flex items-start justify-between mt-1 mb-3.5 gap-2">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-[11px] flex items-center justify-center font-bold text-sm text-white shrink-0 {{ $customer->status === 'customer' ? 'bg-gradient-to-br from-[#1F9D7C] to-[#14735c]' : 'bg-gradient-to-br from-[#C98A2E] to-[#9c6a1e]' }}">
                                {{ mb_substr($customer->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 overflow-hidden">
                                <p class="text-sm font-bold text-[#1B2333] truncate" title="{{ $customer->name }}">{{ $customer->name }}</p>
                                <p class="text-xs text-[#5B6472] truncate mt-0.5" title="{{ $customer->company->name ?? '' }}">{{ $customer->company->name ?? '—' }}</p>
                            </div>
                        </div>
                        <span class="text-[10.5px] font-bold px-2 py-0.5 rounded-md shrink-0 {{ $customer->status === 'customer' ? 'bg-[#E4F5F0] text-[#157A5F]' : 'bg-[#FBF0DF] text-[#96650F]' }}">
                        {{ $customer->status === 'customer' ? 'مشتری' : 'سرنخ' }}
                    </span>
                    </div>

                    <!-- Contact Details -->
                    <div class="space-y-2 mb-4 w-full">
                        <div class="flex items-center gap-2 text-xs text-[#5B6472] min-w-0">
                            <svg class="w-4 h-4 text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16v16H4zM22 6l-10 7L2 6"/></svg>
                            <span class="font-mono text-left dir-ltr truncate text-[#1B2333] font-medium block w-full" title="{{ $customer->email }}">
                            {{ $customer->email ?: '—' }}
                        </span>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-[#5B6472] min-w-0">
                            <svg class="w-4 h-4 text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.98.36 1.94.68 2.86a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.22-1.25a2 2 0 012.11-.45c.92.32 1.88.55 2.86.68A2 2 0 0122 16.92z"/></svg>
                            <span class="font-mono text-left dir-ltr truncate text-[#1B2333] font-medium block w-full" title="{{ $customer->phone }}">
                            {{ $customer->phone ?: '—' }}
                        </span>
                        </div>
                    </div>
                </div>

                <!-- Footer / Actions -->
                <div class="flex items-center justify-between pt-3 border-t border-[#E7E4DC] mt-auto w-full gap-2">
                <span class="text-[11px] text-[#9AA1AC] shrink-0">
                    ثبت: <span class="font-mono text-[#5B6472] font-semibold">{{ $customer->created_at->diffForHumans() }}</span>
                </span>

                    <div class="flex items-center gap-1.5 shrink-0">
                        <button
                            wire:click="openEditModal({{ $customer->id }})"
                            type="button"
                            title="ویرایش"
                            class="p-1 text-[#9AA1AC] hover:text-[#1B2333] transition-colors rounded hover:bg-gray-100"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>

                        <button
                            wire:click="confirmDelete({{ $customer->id }})"
                            type="button"
                            title="حذف"
                            class="p-1 text-[#9AA1AC] hover:text-[#E15B4F] transition-colors rounded hover:bg-gray-100"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg>
                        </button>

                        <a
                            href="{{ route('customers.show', $customer) }}"
                            wire:navigate
                            class="text-xs font-bold text-[#1B2333] hover:text-[#1F9D7C] transition-colors flex items-center gap-1 ml-1 shrink-0"
                        >
                            مشاهده
                            <!-- فلش چرخانده شده برای RTL -->
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 5l7 7-7 7M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-[#E7E4DC] rounded-[14px] p-8 text-center">
                <p class="text-[#5B6472] text-sm mb-2">هیچ مخاطبی یافت نشد.</p>
                <button wire:click="openCreateModal" class="text-xs font-bold text-[#1F9D7C] hover:underline">
                    افزودن اولین مخاطب
                </button>
            </div>
        @endforelse
    </div>
    <!-- CREATE / EDIT MODAL -->
    @if($showCreateModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F121C]/50 backdrop-blur-sm"
            wire:click.self="closeCreateModal"
        >
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl border border-[#E7E4DC] transition-all">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base sm:text-lg font-bold text-[#1B2333]">
                        {{ $editingCustomerId ? 'ویرایش مشتری' : 'افزودن مشتری جدید' }}
                    </h2>
                    <button wire:click="closeCreateModal" type="button" class="text-[#9AA1AC] hover:text-[#1B2333] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-[#5B6472] mb-1.5">نام و نام خانوادگی</label>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="مثلاً مریم حسینی"
                            class="w-full rounded-[10px] px-3.5 py-2.5 text-sm border border-[#E7E4DC] focus:border-[#1F9D7C] outline-none transition-colors"
                        >
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-[#5B6472] mb-1.5">ایمیل</label>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="example@email.com"
                            class="w-full rounded-[10px] px-3.5 py-2.5 text-sm border border-[#E7E4DC] focus:border-[#1F9D7C] outline-none font-mono dir-ltr text-right transition-colors"
                        >
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-[#5B6472] mb-1.5">تلفن</label>
                        <input
                            type="text"
                            wire:model="phone"
                            placeholder="09123456789"
                            class="w-full rounded-[10px] px-3.5 py-2.5 text-sm border border-[#E7E4DC] focus:border-[#1F9D7C] outline-none font-mono dir-ltr text-right transition-colors"
                        >
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-[#5B6472] mb-1.5">آدرس</label>
                        <input
                            type="text"
                            wire:model="address"
                            placeholder="آدرس (اختیاری)"
                            class="w-full rounded-[10px] px-3.5 py-2.5 text-sm border border-[#E7E4DC] focus:border-[#1F9D7C] outline-none transition-colors"
                        >
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-[#5B6472] mb-2">وضعیت</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="$set('status', 'lead')"
                                class="rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold transition-all {{ $status === 'lead' ? 'bg-[#FBF0DF] text-[#96650F] border border-[#C98A2E]' : 'bg-white text-[#5B6472] border border-[#E7E4DC]' }}"
                            >
                                سرنخ
                            </button>
                            <button
                                type="button"
                                wire:click="$set('status', 'customer')"
                                class="rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold transition-all {{ $status === 'customer' ? 'bg-[#E4F5F0] text-[#157A5F] border border-[#1F9D7C]' : 'bg-white text-[#5B6472] border border-[#E7E4DC]' }}"
                            >
                                مشتری
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-6">
                    <button
                        wire:click="closeCreateModal"
                        type="button"
                        class="flex-1 rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold border border-[#E7E4DC] text-[#5B6472] hover:bg-gray-50 transition-colors"
                    >
                        انصراف
                    </button>
                    <button
                        wire:click="save"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        type="button"
                        class="flex-1 rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold text-white bg-[#1B2333] hover:bg-[#2A3450] transition-colors disabled:opacity-60 flex items-center justify-center"
                    >
                        <span wire:loading.remove wire:target="save">
                            {{ $editingCustomerId ? 'ذخیره تغییرات' : 'ثبت مشتری' }}
                        </span>
                        <span wire:loading wire:target="save">در حال ذخیره...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

    <!-- DELETE CONFIRMATION MODAL -->
    @if($customerIdToDelete)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#0F121C]/50 backdrop-blur-sm"
            wire:click.self="cancelDelete"
        >
            <div class="bg-white rounded-2xl w-full max-w-sm p-6 shadow-2xl border border-[#E7E4DC] text-center">

                <div class="w-12 h-12 rounded-full bg-[#FBEAE8] flex items-center justify-center mx-auto mb-3.5">
                    <svg class="w-6 h-6 text-[#E15B4F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>

                <h2 class="text-base font-bold text-[#1B2333] mb-1.5">حذف این مشتری؟</h2>
                <p class="text-xs sm:text-[13px] text-[#5B6472] mb-6 leading-relaxed">
                    این عمل قابل بازگشت نیست و اطلاعات این مشتری حذف می‌شود.
                </p>

                <div class="flex items-center gap-2">
                    <button
                        wire:click="cancelDelete"
                        type="button"
                        class="flex-1 rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold border border-[#E7E4DC] text-[#5B6472] hover:bg-gray-50 transition-colors"
                    >
                        انصراف
                    </button>
                    <button
                        wire:click="deleteCustomer"
                        wire:loading.attr="disabled"
                        wire:target="deleteCustomer"
                        type="button"
                        class="flex-1 rounded-[10px] py-2.5 text-xs sm:text-sm font-semibold text-white bg-[#E15B4F] hover:bg-[#c94a3e] transition-colors disabled:opacity-60 flex items-center justify-center"
                    >
                        <span wire:loading.remove wire:target="deleteCustomer">بله، حذف کن</span>
                        <span wire:loading wire:target="deleteCustomer">در حال حذف...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
