<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-extrabold mb-1.5">بیا شروع کنیم 🚀</h1>
        <p class="text-[13px] text-[#5B6472]">یه حساب کاربری رایگان بساز و اولین مشتری‌تو اضافه کن</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <div>
            <x-input-label for="name" value="نام و نام خانوادگی" />
            <x-text-input
                wire:model="name"
                id="name"
                type="text"
                name="name"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="ایمیل" />
            <x-text-input
                wire:model="email"
                id="email"
                type="email"
                name="email"
                dir="ltr"
                class="text-right font-['JetBrains_Mono']"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="password" value="رمز عبور" />
            <x-text-input
                wire:model="password"
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="تکرار رمز عبور" />
            <x-text-input
                wire:model="password_confirmation"
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('login') }}" wire:navigate
               class="text-[13px] font-semibold text-[#5B6472] hover:text-[#1B2333] transition-colors">
                قبلاً ثبت‌نام کردی؟
            </a>

            <x-primary-button>
                ثبت‌نام
            </x-primary-button>
        </div>
    </form>
</div>
