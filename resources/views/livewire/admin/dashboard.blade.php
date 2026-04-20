<div>
    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Fields</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">All registered fields</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Active</p>
            <p class="text-3xl font-bold text-emerald-400">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Growing normally</p>
        </div>
        <div class="stat-card border-red-500/20">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">At Risk</p>
            <p class="text-3xl font-bold text-red-400">{{ $stats['at_risk'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Flagged by agents</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Completed</p>
            <p class="text-3xl font-bold text-gray-400">{{ $stats['completed'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Harvested this season</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:max-h-[calc(100vh-200px)] xl:overflow-hidden">
        {{-- Fields Table --}}
    <div class="xl:col-span-2 card flex flex-col">
            <div class="card-header">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">All Fields</h2>
                    <p class="text-xs text-gray-500">Live overview across all agents</p>
                </div>
                <a wire:navigate href="{{ route('admin.fields.create') }}" class="btn-primary text-xs py-2 px-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Field
                </a>
            </div>
            <div class="flex-1 overflow-auto overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Crop</th>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Agent</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fields->take(8) as $field)
                        <tr>
                            <td>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $field->name }}</p>
                                <p class="text-xs text-gray-500">{{ $field->location }}</p>
                            </td>
                            <td>{{ $field->crop_type }}</td>
                            <td>
                                <span class="badge badge-{{ $field->stage->value }}">
                                    {{ $field->stage->label() }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $field->status->badgeClass() }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $field->status->label() }}
                                </span>
                            </td>
                            <td class="text-gray-400">{{ $field->agent?->name ?? '—' }}</td>
                            <td>
                                <a wire:navigate href="{{ route('admin.fields.edit', $field) }}" class="text-emerald-400 hover:text-emerald-300 text-xs font-medium">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">No fields yet. <a wire:navigate href="{{ route('admin.fields.create') }}" class="text-emerald-400 hover:underline">Create one</a>.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($fields->count() > 8)
            <div class="px-6 py-3 border-t border-gray-800">
                <a wire:navigate href="{{ route('admin.fields.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300">View all {{ $fields->count() }} fields →</a>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
    <div class="flex flex-col space-y-6 xl:col-span-1">
            {{-- Agents Overview --}}
            <div class="card flex flex-col">
                <div class="card-header">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Field Agents</h2>
                    <a wire:navigate href="{{ route('admin.agents.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300">View all</a>
                </div>
                <div class="divide-y divide-gray-800 flex-1 overflow-auto pr-2">
                    @forelse($agents as $agent)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                                <span class="text-emerald-400 text-xs font-bold">{{ strtoupper(substr($agent->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $agent->name }}</p>
                                <p class="text-xs text-gray-500">{{ $agent->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">{{ $agent->assigned_fields_count }} field{{ $agent->assigned_fields_count !== 1 ? 's' : '' }}</span>
                    </div>
                    @empty
                    <p class="px-5 py-4 text-sm text-gray-500">No agents yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Observations --}}
            <div class="card flex flex-col">
                <div class="card-header">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Recent Updates</h2>
                </div>
                <div class="divide-y divide-gray-800 flex-1 overflow-auto pr-2">
                    @forelse($recentObservations as $obs)
                    <div class="px-5 py-3">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <p class="text-xs font-medium text-gray-900 dark:text-white">{{ $obs->field->name }}</p>
                            @if($obs->is_risk_flag)
                            <span class="badge-risk text-xs">⚠ Risk</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 line-clamp-2">{{ $obs->notes }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $obs->user->name }} · {{ $obs->created_at->diffForHumans() }}</p>
                    </div>
                    @empty
                    <p class="px-5 py-4 text-sm text-gray-500">No observations yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
