<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div>
    <div class="card p-8 mb-4">
        <div class="mb-7">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Sign in to your account</h2>
            <p class="text-sm text-gray-500 mt-1">Enter your credentials to continue</p>
        </div>

        <form wire:submit="login" class="space-y-5">
            <div>
                <label for="email" class="form-label">Email address</label>
                <input wire:model="email" id="email" type="email" autocomplete="username" class="form-input" placeholder="you@example.com" autofocus>
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="form-label mb-0">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-emerald-400 hover:text-emerald-300">Forgot password?</a>
                    @endif
                </div>
                <input wire:model="password" id="password" type="password" autocomplete="current-password" class="form-input" placeholder="••••••••">
                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input wire:model="remember" id="remember" type="checkbox" class="w-4 h-4 rounded bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 text-emerald-500 focus:ring-emerald-500/50 focus:ring-1">
                <label for="remember" class="text-sm text-gray-400">Remember me</label>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3" wire:loading.attr="disabled">
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                Sign In
            </button>
        </form>

        @if (Route::has('register'))
        <p class="text-center text-sm text-gray-600 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-medium">Register</a>
        </p>
        @endif
    </div>

    {{-- Demo credentials --}}
    <div class="p-4 border border-gray-200 dark:border-gray-800 rounded-2xl bg-white dark:bg-gray-900/50">
        <p class="text-xs text-gray-500 font-medium mb-2">Demo Credentials</p>
        <div class="space-y-1 text-xs text-gray-600">
            <p><span class="text-gray-400">Admin:</span> admin@smartseason.com / password</p>
            <p><span class="text-gray-400">Agent 1:</span> agent1@smartseason.com / password</p>
            <p><span class="text-gray-400">Agent 2:</span> agent2@smartseason.com / password</p>
        </div>
    </div>
</div>
