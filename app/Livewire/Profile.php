<?php

namespace App\Livewire;

use Livewire\Component;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $this->name  = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name'  => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('profile_success', 'Profile updated.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password'          => 'required|current_password',
            'new_password'              => 'required|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => $this->new_password]);

        $this->current_password          = '';
        $this->new_password              = '';
        $this->new_password_confirmation = '';

        session()->flash('password_success', 'Password updated.');
    }

    public function render()
    {
        return view('livewire.profile')
            ->layout('layouts.app', ['header' => 'My Profile']);
    }
}
