<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="page-title">Edit Field</h2>
        <p class="page-subtitle">Update details for <span class="text-emerald-400">{{ $field->name }}</span></p>
    </div>

    <form wire:submit="save" class="card">
        <div class="card-body space-y-5">
            @if(session('success'))
                <div class="px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label">Field Name *</label>
                    <input wire:model="name" type="text" class="form-input">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Crop Type *</label>
                    <input wire:model="crop_type" type="text" class="form-input">
                    @error('crop_type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Planting Date *</label>
                    <input wire:model="planting_date" type="date" class="form-input">
                    @error('planting_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Stage *</label>
                    <select wire:model="stage" class="form-select">
                        @foreach($stages as $s)
                        <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
                        @endforeach
                    </select>
                    @error('stage') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Assign to Agent *</label>
                    <select wire:model="agent_id" class="form-select">
                        <option value="">Select agent...</option>
                        @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </select>
                    @error('agent_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Area (hectares)</label>
                    <input wire:model="area_hectares" type="number" step="0.1" class="form-input">
                    @error('area_hectares') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Location</label>
                    <input wire:model="location" type="text" class="form-input">
                    @error('location') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea wire:model="description" rows="3" class="form-textarea"></textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-800 flex items-center gap-3">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                Save Changes
            </button>
            <a wire:navigate href="{{ route('admin.fields.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
