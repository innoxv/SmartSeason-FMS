<?php

use App\Enums\UserRole;
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
    public string $role = 'agent';

    public function register(): void
    {
        $validated = $this->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:admin,agent'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        event(new Registered($user));

        Auth::login($user);
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="card p-8">
    <div class="mb-7">
        <h2 class="text-lg font-semibold text-white">Create an account</h2>
        <p class="text-sm text-gray-500 mt-1">Join SmartSeason Field Monitoring</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        <div>
            <label for="name" class="form-label">Full Name</label>
            <input wire:model="name" id="name" type="text" autocomplete="name" class="form-input" placeholder="Jane Wanjiku" autofocus>
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="form-label">Email Address</label>
            <input wire:model="email" id="email" type="email" autocomplete="username" class="form-input" placeholder="you@example.com">
            @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="role" class="form-label">Role</label>
            <select wire:model="role" id="role" class="form-select">
                <option value="agent">Field Agent</option>
                <option value="admin">Administrator</option>
            </select>
            @error('role') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input wire:model="password" id="password" type="password" autocomplete="new-password" class="form-input" placeholder="Min. 8 characters">
            @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" autocomplete="new-password" class="form-input" placeholder="Repeat password">
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3" wire:loading.attr="disabled">
            <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            Create Account
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium">Sign in</a>
    </p>
</div>
