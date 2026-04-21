<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="page-title">My Fields</h2>
            <p class="page-subtitle">All fields assigned to you</p>
        </div>
        <div class="w-full sm:w-72">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search fields..." class="form-input">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($fields as $field)
        <a wire:navigate href="{{ route('agent.fields.show', $field) }}" class="card block hover:border-emerald-500/30 transition-all duration-300 group">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-emerald-300 transition-colors">{{ $field->name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $field->location }}</p>
                    </div>
                    <span class="{{ $field->status->badgeClass() }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $field->status->label() }}
                    </span>
                </div>

                <div class="flex items-center gap-2 mb-4">
                    <span class="badge badge-{{ $field->stage->value }}">{{ $field->stage->label() }}</span>
                    <span class="text-xs text-gray-600">·</span>
                    <span class="text-xs text-gray-500">{{ $field->crop_type }}</span>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="bg-gray-100 dark:bg-gray-800/60 rounded-xl py-2">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $field->days_in_field }}</p>
                        <p class="text-xs text-gray-600">Days</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800/60 rounded-xl py-2">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $field->area_hectares ?? '—' }}</p>
                        <p class="text-xs text-gray-600">Ha</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800/60 rounded-xl py-2">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $field->observations->count() }}</p>
                        <p class="text-xs text-gray-600">Notes</p>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-300 dark:border-gray-800 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Planted {{ $field->planting_date->format('d M Y') }}</span>
                    <svg class="w-4 h-4 text-gray-600 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            No fields assigned to you yet.
        </div>
        @endforelse
    </div>
</div>
