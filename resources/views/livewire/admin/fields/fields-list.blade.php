<div class="flex flex-col h-full">
    {{-- Header row --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="page-title">Fields</h2>
            <p class="page-subtitle">Manage and monitor all registered fields</p>
        </div>
        <a wire:navigate href="{{ route('admin.fields.create') }}" class="btn-primary whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Field
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-6">
        <div class="card-body flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name, crop or location..." class="form-input w-full">
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

    {{-- Table Card --}}
    <div class="card flex flex-col flex-1 min-h-0 w-full max-w-full">
        <div class="card-body p-6 flex-1 min-w-0 overflow-hidden">
            <div class="w-full max-w-full overflow-x-auto overflow-y-auto max-h-[60vh]">
                <table class="data-table table-fixed min-w-[900px]">
                    <thead class="sticky top-0 bg-white dark:bg-gray-900 z-10">
                        <tr>
                            <th class="text-left">Field</th>
                            <th class="text-left hidden sm:table-cell">Crop</th>
                            <th class="text-left hidden md:table-cell">Planted</th>
                            <th class="text-left hidden lg:table-cell">Days</th>
                            <th class="text-left">Stage</th>
                            <th class="text-left">Status</th>
                            <th class="text-left hidden xl:table-cell">Agent</th>
                            <th class="text-center hidden lg:table-cell">Obs.</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fields as $field)
                        <tr>
                            <td class="align-top">
                                <p class="font-medium text-gray-900 dark:text-white whitespace-normal break-words">{{ $field->name }}</p>
                                <p class="text-xs text-gray-500 whitespace-normal break-words">{{ $field->location }}</p>
                            </td>
                            <td class="align-top whitespace-nowrap hidden sm:table-cell">{{ $field->crop_type }}</td>
                            <td class="align-top whitespace-nowrap text-gray-400 text-xs hidden md:table-cell">{{ $field->planting_date->format('d M Y') }}</td>
                            <td class="align-top whitespace-nowrap text-gray-400 text-xs hidden lg:table-cell">{{ $field->days_in_field }}d</td>
                            <td class="align-top">
                                <span class="badge badge-{{ $field->stage->value }} whitespace-nowrap">{{ $field->stage->label() }}</span>
                            </td>
                            <td class="align-top">
                                <span class="{{ $field->status->badgeClass() }} whitespace-nowrap">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current inline-block"></span>
                                    {{ $field->status->label() }}
                                </span>
                            </td>
                            <td class="align-top hidden xl:table-cell text-gray-400 whitespace-nowrap">{{ $field->agent?->name ?? '—' }}</td>
                            <td class="align-top text-center hidden lg:table-cell text-gray-400">{{ $field->observations->count() }}</td>
                            <td class="align-top text-right whitespace-nowrap">
                                <a wire:navigate href="{{ route('admin.fields.edit', $field) }}" class="btn-secondary text-xs py-1.5 px-3 inline-block">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-12">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-700 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                No fields found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($fields->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 mt-auto">
            {{ $fields->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>