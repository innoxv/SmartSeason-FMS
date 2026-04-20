<div>
    {{-- Header row --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="page-title">Fields</h2>
            <p class="page-subtitle">Manage and monitor all registered fields</p>
        </div>
        <a href="{{ route('admin.fields.create') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Field
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-6">
        <div class="card-body flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, crop or location..." class="form-input">
            </div>
            <select wire:model.live="stageFilter" class="form-select sm:w-44">
                <option value="">All Stages</option>
                <option value="planted">Planted</option>
                <option value="growing">Growing</option>
                <option value="ready">Ready</option>
                <option value="harvested">Harvested</option>
            </select>
            <select wire:model.live="statusFilter" class="form-select sm:w-44">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="at_risk">At Risk</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Crop</th>
                        <th>Planted</th>
                        <th>Days</th>
                        <th>Stage</th>
                        <th>Status</th>
                        <th>Agent</th>
                        <th>Obs.</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fields as $field)
                    <tr>
                        <td>
                            <p class="font-medium text-white">{{ $field->name }}</p>
                            <p class="text-xs text-gray-500">{{ $field->location }}</p>
                        </td>
                        <td>{{ $field->crop_type }}</td>
                        <td class="text-gray-400 text-xs">{{ $field->planting_date->format('d M Y') }}</td>
                        <td class="text-gray-400 text-xs">{{ $field->days_in_field }}d</td>
                        <td>
                            <span class="badge badge-{{ $field->stage->value }}">{{ $field->stage->label() }}</span>
                        </td>
                        <td>
                            <span class="{{ $field->status->badgeClass() }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $field->status->label() }}
                            </span>
                        </td>
                        <td class="text-gray-400">{{ $field->agent?->name ?? '—' }}</td>
                        <td class="text-gray-400 text-center">{{ $field->observations->count() }}</td>
                        <td>
                            <a href="{{ route('admin.fields.edit', $field) }}" class="btn-secondary text-xs py-1.5 px-3">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-gray-500 py-12">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            No fields found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fields->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $fields->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>
