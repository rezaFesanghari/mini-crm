<div>
    @if(session('message'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex items-end justify-between mb-[22px] flex-wrap gap-3.5">
        <div>
            <h1 class="text-2xl font-extrabold m-0 mb-1 text-[#1B2333]">تسک‌ها</h1>
            <p class="text-[13.5px] text-[#5B6472] m-0">{{ $pendingCount }} تسک در انتظار</p>
        </div>
        <button wire:click="openCreateModal"
                class="bg-[#1B2333] hover:bg-[#2A3450] text-white border-0 rounded-[10px] px-[18px] py-[11px] text-sm font-semibold cursor-pointer flex items-center gap-2 transition-colors">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            افزودن تسک
        </button>
    </div>

    <div class="flex gap-2 mb-2 flex-wrap">
        <div wire:click="setFilter('all')" class="px-[14px] py-[7px] rounded-full text-[12.5px] font-bold cursor-pointer {{ $filter === 'all' ? 'bg-[#1B2333] text-white' : 'bg-white border border-[#E7E4DC] text-[#5B6472]' }}">همه</div>
        <div wire:click="setFilter('pending')" class="px-[14px] py-[7px] rounded-full text-[12.5px] font-bold cursor-pointer {{ $filter === 'pending' ? 'bg-[#1B2333] text-white' : 'bg-white border border-[#E7E4DC] text-[#5B6472]' }}">در انتظار</div>
        <div wire:click="setFilter('done')" class="px-[14px] py-[7px] rounded-full text-[12.5px] font-bold cursor-pointer {{ $filter === 'done' ? 'bg-[#1B2333] text-white' : 'bg-white border border-[#E7E4DC] text-[#5B6472]' }}">انجام‌شده</div>
    </div>

    @php
        $groupMeta = [
            'overdue'  => ['title' => 'سررسیدگذشته', 'dot' => '#E15B4F', 'text' => '#B23A2F'],
            'today'    => ['title' => 'امروز',        'dot' => '#C98A2E', 'text' => '#96650F'],
            'tomorrow' => ['title' => 'فردا',          'dot' => '#2563EB', 'text' => '#2563EB'],
            'later'    => ['title' => 'بعداً',         'dot' => '#9AA1AC', 'text' => '#5B6472'],
        ];
    @endphp

    @php $anyTasks = false; @endphp

    @foreach($groupMeta as $key => $meta)
        @if($grouped[$key]->isNotEmpty())
            @php $anyTasks = true; @endphp

            <div class="flex items-center gap-2.5 mt-7 mb-3 first:mt-0">
                <span class="w-2 h-2 rounded-full" style="background:{{ $meta['dot'] }}"></span>
                <span class="text-[13.5px] font-extrabold" style="color:{{ $meta['text'] }}">{{ $meta['title'] }}</span>
                <span class="text-[11px] font-bold bg-[#EEF0F5] text-[#5B6472] px-2 py-0.5 rounded-full">{{ $grouped[$key]->count() }}</span>
            </div>

            @foreach($grouped[$key] as $task)
                <div wire:key="task-{{ $task->id }}"
                     class="bg-white border border-[#E7E4DC] rounded-xl px-4 py-3.5 flex items-center gap-3 mb-2 {{ $key === 'overdue' ? 'border-[#F3CFC9]' : '' }}">
                    <div
                        wire:click="toggleTask({{ $task->id }})"
                        class="w-5 h-5 rounded-md border-2 shrink-0 cursor-pointer flex items-center justify-center text-[10px] {{ $task->status === 'done' ? 'bg-[#1F9D7C] border-[#1F9D7C] text-white' : 'border-[#E7E4DC]' }}"
                    >
                        @if($task->status === 'done') ✓ @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13.5px] font-semibold m-0 mb-0.5 {{ $task->status === 'done' ? 'line-through text-[#9AA1AC]' : '' }}">{{ $task->title }}</p>
                        @if($task->customer)
                            <p class="text-[11.5px] text-[#9AA1AC] m-0 flex items-center gap-1.5">
                            <span class="w-4 h-4 rounded-md flex items-center justify-center text-white text-[8px] font-bold shrink-0"
                                  style="background:linear-gradient(135deg,{{ $task->customer->status === 'customer' ? '#1F9D7C,#14735c' : '#C98A2E,#9c6a1e' }})">
                                {{ mb_substr($task->customer->name, 0, 1) }}
                            </span>
                                {{ $task->customer->name }}
                            </p>
                        @endif
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap"
                          style="background:{{ $key === 'overdue' ? '#FBEAE8' : ($key === 'today' ? '#FBF0DF' : ($key === 'tomorrow' ? '#EFF6FF' : '#EEF0F5')) }};color:{{ $meta['text'] }}">
                        @if($key === 'overdue')
                            {{ \Illuminate\Support\Carbon::parse($task->due_date)->diffForHumans(null, true) }} گذشته
                        @elseif($key === 'today')
                            امروز
                        @elseif($key === 'tomorrow')
                            فردا
                        @else
                            {{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y/m/d') : 'بدون تاریخ' }}
                        @endif
                    </span>
                </div>
            @endforeach
        @endif
    @endforeach

    @if(!$anyTasks)
        <div class="text-center py-16">
            <p class="text-sm text-[#9AA1AC]">هیچ تسکی با این فیلتر پیدا نشد 🎉</p>
        </div>
    @endif

    {{-- مودال افزودن تسک --}}
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,18,28,.5)" wire:click.self="closeCreateModal">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl border border-[#E7E4DC]">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#1B2333]">افزودن تسک جدید</h2>
                    <button wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-700">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">مشتری</label>
                        <select wire:model="customer_id" class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] bg-white">
                            <option value="">انتخاب مشتری…</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">عنوان تسک</label>
                        <input type="text" wire:model="title" placeholder="مثلاً تماس پیگیری قرارداد"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">تاریخ سررسید (اختیاری)</label>
                        <input type="date" wire:model="due_date"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('due_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button wire:click="closeCreateModal" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#1B2333] disabled:opacity-60">
                        <span wire:loading.remove wire:target="save">ثبت تسک</span>
                        <span wire:loading wire:target="save">در حال ذخیره...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
