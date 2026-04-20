<div>
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">My Fields</p>
            <p class="text-3xl font-bold text-white">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Assigned to you</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Active</p>
            <p class="text-3xl font-bold text-emerald-400">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Growing normally</p>
        </div>
        <div class="stat-card border-red-500/20">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">At Risk</p>
            <p class="text-3xl font-bold text-red-400">{{ $stats['at_risk'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Needs attention</p>
        </div>
        <div class="stat-card">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Completed</p>
            <p class="text-3xl font-bold text-gray-400">{{ $stats['completed'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Harvested</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Fields --}}
        <div class="xl:col-span-2 card">
            <div class="card-header">
                <div>
                    <h2 class="text-sm font-semibold text-white">My Assigned Fields</h2>
                    <p class="text-xs text-gray-500">Fields you are responsible for</p>
                </div>
                <a href="{{ route('agent.fields.index') }}" class="text-xs text-emerald-400 hover:text-emerald-300">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Crop</th>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Days</th>
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
                            <td>
                                <span class="badge badge-{{ $field->stage->value }}">{{ $field->stage->label() }}</span>
                            </td>
                            <td>
                                <span class="{{ $field->status->badgeClass() }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $field->status->label() }}
                                </span>
                            </td>
                            <td class="text-gray-400 text-xs">{{ $field->days_in_field }}d</td>
                            <td>
                                <a href="{{ route('agent.fields.show', $field) }}" class="btn-primary text-xs py-1.5 px-3">Update</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-10">No fields assigned yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="card">
            <div class="card-header">
                <h2 class="text-sm font-semibold text-white">Recent Activity</h2>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse($recentObservations as $obs)
                <div class="px-5 py-3">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-xs font-medium text-white">{{ $obs->field->name }}</p>
                        @if($obs->is_risk_flag)
                        <span class="badge-risk">⚠ Risk</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 line-clamp-2">{{ $obs->notes }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $obs->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <p class="px-5 py-6 text-sm text-gray-500">No activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
