<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold mb-1.5">خوش اومدی 👋</h1>
        <p class="text-[13px] text-[#5B6472]">برای ادامه وارد حساب کاربری‌ت شو</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input
                wire:model="form.email"
                id="email"
                type="email"
                name="email"
                dir="ltr"
                class="text-right font-['JetBrains_Mono']"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('form.email')" />
        </div>

        <div>
            <x-input-label for="password" value="رمز عبور" />
            <x-text-input
                wire:model="form.password"
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('form.password')" />
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                   class="rounded border-[#E7E4DC] text-[#1F9D7C] focus:ring-[#1F9D7C]">
            <span class="text-[13px] text-[#5B6472]">من رو به خاطر بسپار</span>
        </label>

        <div class="flex items-center justify-between pt-2">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate
                   class="text-[13px] font-semibold text-[#5B6472] hover:text-[#1B2333] transition-colors">
                    رمزتو فراموش کردی؟
                </a>
            @endif

            <x-primary-button>
                ورود
            </x-primary-button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="text-center text-[13px] text-[#5B6472] mt-6 pt-6 border-t border-[#E7E4DC]">
            حساب کاربری نداری؟
            <a href="{{ route('register') }}" wire:navigate class="font-bold text-[#1B2333] hover:text-[#1F9D7C]">
                همین الان ثبت‌نام کن
            </a>
        </p>
    @endif
</div>
