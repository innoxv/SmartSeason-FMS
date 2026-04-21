<div>
    {{-- Back + Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a wire:navigate href="{{ route('agent.fields.index') }}" class="btn-secondary py-2 px-3">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="page-title">{{ $field->name }}</h2>
            <p class="page-subtitle">{{ $field->crop_type }} · {{ $field->location }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Left: Field Info + Stage Update + Observation Form --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Field Summary --}}
            <div class="card">
                <div class="card-body">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            <span class="{{ $field->status->badgeClass() }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $field->status->label() }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Stage</p>
                            <span class="badge badge-{{ $field->stage->value }}">{{ $field->stage->label() }}</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Days in Field</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $field->days_in_field }} days</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Area</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $field->area_hectares ? $field->area_hectares . ' ha' : '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Planted</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $field->planting_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-span-2 sm:col-span-3">
                            <p class="text-xs text-gray-500 mb-1">Description</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $field->description ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Stage --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Update Stage</h3>
                </div>
                <div class="card-body">
                    @if(session('stage_success'))
                        <div class="mb-4 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">{{ session('stage_success') }}</div>
                    @endif
                    <div class="flex items-end gap-3">
                        <div class="flex-1">
                            <label class="form-label">New Stage</label>
                            <select wire:model="newStage" class="form-select">
                                @foreach($stages as $s)
                                <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
                                @endforeach
                            </select>
                            @error('newStage') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button wire:click="updateStage" class="btn-primary" wire:loading.attr="disabled">
                            <svg wire:loading wire:target="updateStage" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Update
                        </button>
                    </div>
                </div>
            </div>

            {{-- Add Observation --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Add Observation</h3>
                </div>
                <div class="card-body space-y-4">
                    @if(session('obs_success'))
                        <div class="px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">{{ session('obs_success') }}</div>
                    @endif
                    <div>
                        <label class="form-label">Observation Notes *</label>
                        <textarea wire:model="notes" rows="4" class="form-textarea" placeholder="Describe what you observed in the field..."></textarea>
                        @error('notes') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-red-500/5 border border-red-500/10 rounded-xl cursor-pointer" wire:click="$toggle('is_risk_flag')">
                        <div class="w-5 h-5 rounded border-2 flex items-center justify-center transition-all {{ $is_risk_flag ? 'bg-red-500 border-red-500' : 'border-gray-600' }}">
                            @if($is_risk_flag)
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium text-red-400">Flag as At Risk</p>
                            <p class="text-xs text-gray-500">Check this if the field needs urgent admin attention</p>
                        </div>
                    </div>
                    <button wire:click="addObservation" class="btn-primary w-full justify-center" wire:loading.attr="disabled">
                        <svg wire:loading wire:target="addObservation" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Submit Observation
                    </button>
                </div>
            </div>
        </div>

        {{-- Right: Timeline --}}
        <div class="card h-fit">
            <div class="card-header">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Observation History</h3>
                <span class="text-xs text-gray-500">{{ $observations->count() }} total</span>
            </div>
            <div class="divide-y divide-gray-800 max-h-[600px] overflow-y-auto">
                @forelse($observations as $obs)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-500">{{ $obs->user->name }}</p>
                        @if($obs->is_risk_flag)
                        <span class="badge-risk flex-shrink-0">  Risk</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $obs->notes }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="badge badge-{{ $obs->stage_at_time }}">{{ \App\Enums\FieldStage::from($obs->stage_at_time)->label() }}</span>
                        <span class="text-xs text-gray-500">{{ $obs->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                @empty
                <div class="px-5 py-10 text-center">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm text-gray-500">No observations yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
