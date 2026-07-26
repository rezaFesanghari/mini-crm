<div x-data="{ tab: 'overview' }">

    {{-- پیام موفقیت --}}
    @if(session('message'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]">
            {{ session('message') }}
        </div>
    @endif

    {{-- بازگشت --}}
    <a href="{{ route('customers.index') }}" wire:navigate
       class="inline-flex items-center gap-1.5 text-[13px] font-semibold text-[#5B6472] no-underline mb-[18px]">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7 7-7M3 12h18"/></svg>
        بازگشت به لیست مشتری‌ها
    </a>

    {{-- هدر --}}
    <div class="bg-white border border-[#E7E4DC] rounded-2xl p-6 flex items-center justify-between gap-5 flex-wrap mb-[22px]">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl shrink-0"
                 style="background:linear-gradient(135deg,{{ $customer->status === 'customer' ? '#1F9D7C,#14735c' : '#C98A2E,#9c6a1e' }})">
                {{ mb_substr($customer->name, 0, 1) }}
            </div>
            <div>
                <p class="text-xl font-extrabold m-0 mb-1 text-[#1B2333]">{{ $customer->name }}</p>
                <p class="text-[13px] text-[#5B6472] m-0 flex items-center gap-2 flex-wrap">
                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-md {{ $customer->status === 'customer' ? 'bg-[#E4F5F0] text-[#157A5F]' : 'bg-[#FBF0DF] text-[#96650F]' }}">
                        {{ $customer->status === 'customer' ? 'مشتری' : 'سرنخ' }}
                    </span>
                    <span>{{ $customer->company->name ?? 'بدون شرکت' }}</span>
                    <span>·</span>
                    <span>عضویت از <span class="font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $customer->created_at->format('Y/m/d') }}</span></span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            @if($customer->phone)
                <a href="tel:{{ $customer->phone }}" class="flex items-center gap-1.5 px-[15px] py-2 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#1B2333] no-underline">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.98.36 1.94.68 2.86a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.22-1.25a2 2 0 012.11-.45c.92.32 1.88.55 2.86.68A2 2 0 0122 16.92z"/></svg>
                    تماس
                </a>
            @endif
            @if($customer->email)
                <a href="mailto:{{ $customer->email }}" class="flex items-center gap-1.5 px-[15px] py-2 rounded-[9px] text-[13px] font-semibold border border-[#E7E4DC] bg-white text-[#1B2333] no-underline">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16v16H4zM22 6l-10 7L2 6"/></svg>
                    ایمیل
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

    {{-- آمار --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 mb-[22px]">
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">مجموع ارزش معاملات</p>
            <p class="text-xl font-extrabold m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">۴۲,۰۰۰,۰۰۰ ت</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">معاملات باز</p>
            <p class="text-xl font-extrabold m-0">۲ معامله</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">تسک‌های در انتظار</p>
            <p class="text-xl font-extrabold m-0">{{ $pendingTasks }} تسک</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">آخرین تعامل</p>
            <p class="text-xl font-extrabold m-0">{{ $lastActivity->diffForHumans() }}</p>
        </div>
    </div>

    {{-- بدنه --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-5 items-start">
        <div>
            {{-- تب‌ها --}}
            <div class="flex gap-1 bg-white border border-[#E7E4DC] rounded-xl p-[5px] mb-4 w-fit">
                <button @click="tab='overview'" :class="tab==='overview' ? 'bg-[#1B2333] text-white' : 'text-[#5B6472]'" class="px-[18px] py-2.5 rounded-lg text-[13.5px] font-semibold">بررسی کلی</button>
                <button @click="tab='deals'" :class="tab==='deals' ? 'bg-[#1B2333] text-white' : 'text-[#5B6472]'" class="px-[18px] py-2.5 rounded-lg text-[13.5px] font-semibold flex items-center gap-1.5">معاملات <span class="text-[10.5px] px-1.5 rounded-full bg-black/10">۲</span></button>
                <button @click="tab='notes'" :class="tab==='notes' ? 'bg-[#1B2333] text-white' : 'text-[#5B6472]'" class="px-[18px] py-2.5 rounded-lg text-[13.5px] font-semibold flex items-center gap-1.5">یادداشت‌ها <span class="text-[10.5px] px-1.5 rounded-full bg-black/10">{{ $notes->count() }}</span></button>
                <button @click="tab='tasks'" :class="tab==='tasks' ? 'bg-[#1B2333] text-white' : 'text-[#5B6472]'" class="px-[18px] py-2.5 rounded-lg text-[13.5px] font-semibold flex items-center gap-1.5">تسک‌ها <span class="text-[10.5px] px-1.5 rounded-full bg-black/10">{{ $tasks->count() }}</span></button>
            </div>

            {{-- بررسی کلی --}}
            <div x-show="tab==='overview'" class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-4">تایم‌لاین فعالیت‌ها</p>

                @forelse($notes as $note)
                    <div class="flex gap-3 mb-[18px]">
                        <div class="w-8 h-8 rounded-[9px] bg-[#E4F5F0] text-[#157A5F] flex items-center justify-center text-xs font-bold shrink-0">📝</div>
                        <div>
                            <div class="text-[13px] leading-[1.8] bg-[#FAF9F6] border border-[#E7E4DC] rounded-[10px] px-3.5 py-2.5 mb-1">{{ $note->body }}</div>
                            <div class="text-[11px] text-[#9AA1AC]">{{ $note->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">هنوز فعالیتی ثبت نشده.</p>
                @endforelse

                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-[9px] bg-[#EEF0F5] text-[#4A5568] flex items-center justify-center text-xs font-bold shrink-0">＋</div>
                    <div>
                        <div class="text-[13px] leading-[1.8] bg-[#FAF9F6] border border-[#E7E4DC] rounded-[10px] px-3.5 py-2.5 mb-1">مشتری به سیستم اضافه شد.</div>
                        <div class="text-[11px] text-[#9AA1AC]">{{ $customer->created_at->format('Y/m/d') }}</div>
                    </div>
                </div>
            </div>

            {{-- معاملات (فعلاً استاتیک) --}}
            <div x-show="tab==='deals'" style="display:none" class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-4">معاملات</p>
                <p class="text-sm text-[#9AA1AC]">این بخش هنوز به دیتابیس وصل نشده — بعد از ساخت ماژول «فرصت‌های فروش» تکمیل می‌شود.</p>
            </div>

            {{-- یادداشت‌ها --}}
            <div x-show="tab==='notes'" style="display:none" class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-4">یادداشت‌ها</p>

                <form wire:submit.prevent="addNote" class="flex gap-2.5 mb-5">
                    <textarea rows="2" wire:model="newNote" placeholder="یادداشت جدید بنویس…"
                              class="flex-1 border border-[#E7E4DC] rounded-[10px] px-3.5 py-2.5 text-[13px] outline-none resize-none"></textarea>
                    <button type="submit" class="bg-[#1B2333] text-white rounded-[10px] px-[18px] font-semibold text-[13px]">ثبت</button>
                </form>
                @error('newNote') <span class="text-xs text-red-500 block mb-3">{{ $message }}</span> @enderror

                @forelse($notes as $note)
                    <div class="flex gap-3 mb-[18px]">
                        <div class="w-8 h-8 rounded-[9px] bg-[#E4F5F0] text-[#157A5F] flex items-center justify-center text-xs font-bold shrink-0">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-[13px] leading-[1.8] bg-[#FAF9F6] border border-[#E7E4DC] rounded-[10px] px-3.5 py-2.5 mb-1">{{ $note->body }}</div>
                            <div class="text-[11px] text-[#9AA1AC]">{{ $note->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">هنوز یادداشتی ثبت نشده.</p>
                @endforelse
            </div>

            {{-- تسک‌ها --}}
            <div x-show="tab==='tasks'" style="display:none" class="bg-white border border-[#E7E4DC] rounded-2xl p-[22px]">
                <p class="text-[15px] font-bold m-0 mb-4">تسک‌ها</p>

                <form wire:submit.prevent="addTask" class="flex gap-2 mb-5">
                    <input type="text" wire:model="newTaskTitle" placeholder="عنوان تسک…"
                           class="flex-1 rounded-[10px] border border-[#E7E4DC] px-3.5 py-2.5 text-sm outline-none">
                    <input type="date" wire:model="newTaskDueDate"
                           class="rounded-[10px] border border-[#E7E4DC] px-3.5 py-2.5 text-sm outline-none">
                    <button type="submit" class="bg-[#1B2333] text-white rounded-[10px] px-4 text-sm font-semibold">افزودن</button>
                </form>
                @error('newTaskTitle') <span class="text-xs text-red-500 block mb-3">{{ $message }}</span> @enderror
                @error('newTaskDueDate') <span class="text-xs text-red-500 block mb-3">{{ $message }}</span> @enderror

                @forelse($tasks as $task)
                    <div class="flex items-center gap-3 py-3 border-b border-[#E7E4DC] last:border-b-0">
                        <div wire:click="toggleTask({{ $task->id }})"
                             class="w-5 h-5 rounded-md border-2 shrink-0 cursor-pointer flex items-center justify-center text-[10px] {{ $task->status === 'done' ? 'bg-[#1F9D7C] border-[#1F9D7C] text-white' : 'border-[#E7E4DC]' }}">
                            @if($task->status === 'done') ✓ @endif
                        </div>
                        <p class="text-[13.5px] font-semibold m-0 {{ $task->status === 'done' ? 'line-through text-[#9AA1AC]' : '' }}">{{ $task->title }}</p>
                        @if($task->due_date)
                            <span class="text-[11px] font-semibold mr-auto font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate] {{ $task->status === 'done' ? 'text-[#9AA1AC]' : 'text-[#E15B4F]' }}">
                                {{ \Illuminate\Support\Carbon::parse($task->due_date)->format('Y/m/d') }}
                            </span>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-[#9AA1AC]">هنوز تسکی ثبت نشده.</p>
                @endforelse
            </div>
        </div>

        {{-- ستون کناری --}}
        <div>
            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5 mb-4">
                <p class="text-[12.5px] font-bold text-[#5B6472] m-0 mb-3.5">اطلاعات تماس</p>
                @if($customer->email)
                    <div class="flex items-center gap-2.5 text-[13px] mb-3">
                        <svg class="w-[15px] h-[15px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 4h16v16H4zM22 6l-10 7L2 6"/></svg>
                        <span class="font-medium font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $customer->email }}</span>
                    </div>
                @endif
                @if($customer->phone)
                    <div class="flex items-center gap-2.5 text-[13px] mb-3">
                        <svg class="w-[15px] h-[15px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.8 19.8 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.8 19.8 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.13.98.36 1.94.68 2.86a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.22-1.25a2 2 0 012.11-.45c.92.32 1.88.55 2.86.68A2 2 0 0122 16.92z"/></svg>
                        <span class="font-medium font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ $customer->phone }}</span>
                    </div>
                @endif
                @if($customer->address)
                    <div class="flex items-center gap-2.5 text-[13px]">
                        <svg class="w-[15px] h-[15px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span class="font-medium">{{ $customer->address }}</span>
                    </div>
                @endif
            </div>

            <div class="bg-white border border-[#E7E4DC] rounded-2xl p-5">
                <p class="text-[12.5px] font-bold text-[#5B6472] m-0 mb-3.5">شرکت</p>
                <div class="flex items-center gap-2.5 text-[13px]">
                    <svg class="w-[15px] h-[15px] text-[#9AA1AC] shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                    <span class="font-medium">{{ $customer->company->name ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- مودال ویرایش --}}
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,18,28,.5)" wire:click.self="closeEditModal">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl border border-[#E7E4DC]">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#1B2333]">ویرایش مشتری</h2>
                    <button wire:click="closeEditModal" class="text-gray-400 hover:text-gray-700">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">نام و نام خانوادگی</label>
                        <input type="text" wire:model="name" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">ایمیل</label>
                        <input type="email" wire:model="email" dir="ltr" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
                    <div>
                        <label class="block text-sm font-medium mb-2 text-[#5B6472]">وضعیت</label>
                        <div class="flex gap-2">
                            <button type="button" wire:click="$set('status', 'lead')"
                                    class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold {{ $status === 'lead' ? 'bg-[#FBF0DF] text-[#96650F] border border-[#C98A2E]' : 'bg-white text-[#5B6472] border border-[#E7E4DC]' }}">
                                سرنخ
                            </button>
                            <button type="button" wire:click="$set('status', 'customer')"
                                    class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold {{ $status === 'customer' ? 'bg-[#E4F5F0] text-[#157A5F] border border-[#1F9D7C]' : 'bg-white text-[#5B6472] border border-[#E7E4DC]' }}">
                                مشتری
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button wire:click="closeEditModal" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="updateCustomer" wire:loading.attr="disabled" wire:target="updateCustomer"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#1B2333] disabled:opacity-60">
                        <span wire:loading.remove wire:target="updateCustomer">ذخیره تغییرات</span>
                        <span wire:loading wire:target="updateCustomer">در حال ذخیره...</span>
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
                <h2 class="text-base font-bold text-[#1B2333] mb-2">حذف این مشتری؟</h2>
                <p class="text-[13px] text-[#5B6472] mb-6">این عمل قابل بازگشت نیست و تمام یادداشت‌ها و تسک‌های مرتبط هم حذف می‌شود.</p>
                <div class="flex gap-2">
                    <button wire:click="cancelDelete" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="deleteCustomer" wire:loading.attr="disabled" wire:target="deleteCustomer"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#E15B4F] disabled:opacity-60">
                        <span wire:loading.remove wire:target="deleteCustomer">بله، حذف کن</span>
                        <span wire:loading wire:target="deleteCustomer">در حال حذف...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
