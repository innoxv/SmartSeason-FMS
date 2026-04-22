<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);


        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="card p-8">
    <div class="mb-7">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Forgot password?</h2>
        <p class="text-sm text-gray-500 mt-1">
            No problem. Let us know your email and we'll send you a link to reset it.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="form-label">Email address</label>
            <input wire:model="email" id="email" type="email" name="email" class="form-input" placeholder="you@example.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3" wire:loading.attr="disabled">
            <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            Email Password Reset Link
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium">Back to sign in</a>
    </p>
</div>
