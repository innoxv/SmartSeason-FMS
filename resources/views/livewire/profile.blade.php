<div class="max-w-xl space-y-6">
    <div class="mb-6">
        <h2 class="page-title">My Profile</h2>
        <p class="page-subtitle">Update your account information</p>
    </div>

    {{-- Profile Info --}}
    <div class="card">
        <div class="card-header">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Account Details</h3>
        </div>
        <div class="card-body space-y-4">
            @if(session('profile_success'))
                <div class="px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">{{ session('profile_success') }}</div>
            @endif
            <div>
                <label class="form-label">Full Name</label>
                <input wire:model="name" type="text" class="form-input">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Email Address</label>
                <input wire:model="email" type="email" class="form-input">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Role</label>
                <p class="form-input bg-gray-100 dark:bg-gray-800/50 text-gray-500 cursor-not-allowed">{{ auth()->user()->role->label() }}</p>
            </div>
            <button wire:click="updateProfile" class="btn-primary">Save Changes</button>
        </div>
    </div>

    {{-- Password --}}
    <div class="card">
        <div class="card-header">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Change Password</h3>
        </div>
        <div class="card-body space-y-4">
            @if(session('password_success'))
                <div class="px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">{{ session('password_success') }}</div>
            @endif
            <div>
                <label class="form-label">Current Password</label>
                <input wire:model="current_password" type="password" class="form-input">
                @error('current_password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">New Password</label>
                <input wire:model="new_password" type="password" class="form-input">
                @error('new_password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label">Confirm New Password</label>
                <input wire:model="new_password_confirmation" type="password" class="form-input">
            </div>
            <button wire:click="updatePassword" class="btn-primary">Update Password</button>
        </div>
    </div>
</div>
