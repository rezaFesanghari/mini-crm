<div x-data="dealsBoard()" x-init="initBoard()">

    @if(session('message'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-[#E4F5F0] text-[#157A5F]">
            {{ session('message') }}
        </div>
    @endif

    {{-- هدر صفحه --}}
    <div class="flex items-end justify-between mb-5 flex-wrap gap-3.5">
        <div>
            <h1 class="text-2xl font-extrabold m-0 mb-1 text-[#1B2333]">فرصت‌های فروش</h1>
            <p class="text-[13.5px] text-[#5B6472] m-0">پایپ‌لاین فروش شما</p>
        </div>
        <button
            wire:click="openCreateModal"
            class="bg-[#1B2333] hover:bg-[#2A3450] text-white border-0 rounded-[10px] px-[18px] py-[11px] text-sm font-semibold cursor-pointer flex items-center gap-2 transition-colors"
        >
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            افزودن معامله
        </button>
    </div>

    {{-- بنر راهنما --}}
    <div x-data="{ open: true }" x-show="open" x-transition class="flex items-start gap-3 bg-[#EFF6FF] border border-[#BFDBFE] rounded-2xl p-4 mb-6">
        <div class="w-8 h-8 rounded-lg bg-[#DBEAFE] flex items-center justify-center shrink-0 text-[#2563EB]">
            <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
        </div>
        <div class="flex-1">
            <p class="text-[13.5px] font-bold m-0 mb-1 text-[#1B2333]">این صفحه چیکار می‌کنه؟</p>
            <p class="text-[12.5px] text-[#3B4B63] m-0 leading-[1.9]">
                هر ستون یه مرحله از فرآیند فروشه. کارت هر معامله رو بگیر و بکش تو ستون بعدی تا مرحله‌ش عوض بشه —
                مثلاً وقتی با مشتری تماس گرفتی، کارتشو از «جدید» بکش تو «تماس گرفته‌شده». تغییرات فوری ذخیره میشه، نیازی به دکمه‌ی ذخیره نیست.
            </p>
        </div>
        <button @click="open=false" class="text-[#60A5FA] hover:text-[#2563EB] shrink-0">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- آمار خلاصه --}}
    @php
        $allDeals = $dealsByStage->flatten();
        $openValue = $allDeals->whereNotIn('stage', ['won', 'lost'])->sum('value');
        $wonValue = $dealsByStage->get('won', collect())->sum('value');
        $openCount = $allDeals->whereNotIn('stage', ['won', 'lost'])->count();
    @endphp
    <div class="grid grid-cols-3 gap-3.5 mb-6">
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">ارزش معاملات باز</p>
            <p class="text-lg font-extrabold m-0 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ number_format($openValue) }} ت</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">تعداد معاملات باز</p>
            <p class="text-lg font-extrabold m-0">{{ $openCount }} معامله</p>
        </div>
        <div class="bg-white border border-[#E7E4DC] rounded-2xl p-4">
            <p class="text-xs text-[#5B6472] m-0 mb-1.5">ارزش معاملات برنده</p>
            <p class="text-lg font-extrabold m-0 text-[#157A5F] font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">{{ number_format($wonValue) }} ت</p>
        </div>
    </div>

    {{-- کانبان --}}
    <div class="flex gap-4 overflow-x-auto pb-4">
        @php
            $stageColors = [
                'new'         => ['dot' => '#94A3B8', 'bg' => '#F1F5F9', 'text' => '#475569'],
                'contacted'   => ['dot' => '#60A5FA', 'bg' => '#EFF6FF', 'text' => '#2563EB'],
                'negotiation' => ['dot' => '#C98A2E', 'bg' => '#FBF0DF', 'text' => '#96650F'],
                'won'         => ['dot' => '#1F9D7C', 'bg' => '#E4F5F0', 'text' => '#157A5F'],
                'lost'        => ['dot' => '#E15B4F', 'bg' => '#FBEAE8', 'text' => '#B23A2F'],
            ];
        @endphp

        @foreach($stageLabels as $stageKey => $stageLabel)
            @php
                $stageDeals = $dealsByStage->get($stageKey, collect());
                $stageSum = $stageDeals->sum('value');
                $c = $stageColors[$stageKey];
            @endphp

            <div class="w-[290px] shrink-0">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $c['dot'] }}"></span>
                        <span class="text-[13.5px] font-bold text-[#1B2333]">{{ $stageLabel }}</span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full" style="background:{{ $c['bg'] }};color:{{ $c['text'] }}">{{ $stageDeals->count() }}</span>
                    </div>
                </div>
                <p class="text-[11px] text-[#9AA1AC] mb-2.5 px-1 font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">
                    {{ number_format($stageSum) }} تومان
                </p>

                <div
                    class="board-column rounded-2xl p-2.5 min-h-[140px] border-2 border-dashed"
                    style="background:{{ $c['bg'] }}22; border-color:{{ $c['dot'] }}33"
                    data-stage="{{ $stageKey }}"
                >
                    @forelse($stageDeals as $deal)
                        <div
                            wire:key="deal-{{ $deal->id }}"
                            data-deal-id="{{ $deal->id }}"
                            class="deal-card relative bg-white border border-[#E7E4DC] rounded-[12px] p-3.5 pr-4 mb-2.5 cursor-grab active:cursor-grabbing shadow-[0_1px_2px_rgba(27,35,51,0.04)] hover:shadow-[0_6px_16px_rgba(27,35,51,0.08)] transition-shadow"
                        >
                            <span class="absolute right-0 top-3 bottom-3 w-[3px] rounded-full" style="background:{{ $c['dot'] }}"></span>

                            <p class="text-[13px] font-bold m-0 mb-2 text-[#1B2333]">{{ $deal->title }}</p>

                            <div class="flex items-center gap-1.5 mb-2.5">
                                <div class="w-5 h-5 rounded-md flex items-center justify-center text-white text-[9px] font-bold shrink-0"
                                     style="background:linear-gradient(135deg,{{ $deal->customer->status === 'customer' ? '#1F9D7C,#14735c' : '#C98A2E,#9c6a1e' }})">
                                    {{ mb_substr($deal->customer->name, 0, 1) }}
                                </div>
                                <span class="text-[11.5px] text-[#5B6472] truncate">{{ $deal->customer->name }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-[13px] font-bold m-0 text-[#1B2333] font-['JetBrains_Mono'] [direction:ltr] [unicode-bidi:isolate]">
                                    {{ number_format($deal->value) }} ت
                                </p>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-[#C7CCD6]"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <p class="text-[11.5px] text-[#9AA1AC] m-0">معامله‌ای اینجا نیست</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    {{-- مودال افزودن معامله --}}
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,18,28,.5)" wire:click.self="closeCreateModal">
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl border border-[#E7E4DC]">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-[#1B2333]">افزودن معامله جدید</h2>
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
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">عنوان معامله</label>
                        <input type="text" wire:model="title" placeholder="مثلاً تمدید اشتراک سالانه"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC]">
                        @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5 text-[#5B6472]">مبلغ (تومان)</label>
                        <input type="number" wire:model="value" placeholder="0" dir="ltr"
                               class="w-full rounded-[10px] px-3.5 py-2.5 text-sm outline-none border border-[#E7E4DC] text-right font-['JetBrains_Mono']">
                        @error('value') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-2 mt-6">
                    <button wire:click="closeCreateModal" class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold border border-[#E7E4DC] text-[#5B6472]">انصراف</button>
                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                            class="flex-1 rounded-[10px] py-2.5 text-sm font-semibold text-white bg-[#1B2333] disabled:opacity-60">
                        <span wire:loading.remove wire:target="save">ثبت معامله</span>
                        <span wire:loading wire:target="save">در حال ذخیره...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @script
    <script>
        Alpine.data('dealsBoard', () => ({
            initBoard() {
                this.$nextTick(() => {
                    document.querySelectorAll('.board-column').forEach((column) => {
                        new Sortable(column, {
                            group: 'deals',
                            animation: 150,
                            ghostClass: 'opacity-40',
                            onEnd: (evt) => {
                                const dealId = evt.item.dataset.dealId;
                                const newStage = evt.to.dataset.stage;
                                $wire.moveDeal(parseInt(dealId), newStage);
                            }
                        });
                    });
                });
            }
        }));
    </script>
    @endscript
</div>
