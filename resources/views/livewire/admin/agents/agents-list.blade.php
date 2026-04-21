<div>
    <div class="mb-6">
        <h2 class="page-title">Field Agents</h2>
        <p class="page-subtitle">Overview of all assigned field agents and their workload</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($agents as $agent)
        @php
            $atRisk = $agent->assignedFields->filter(fn($f) => $f->status->value === 'at_risk')->count();
        @endphp
        <div class="card hover:border-emerald-500/30 transition-all duration-300">
            <div class="card-body">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                        <span class="text-emerald-400 text-lg font-bold">{{ strtoupper(substr($agent->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $agent->name }}</p>
                        <p class="text-xs text-gray-500">{{ $agent->email }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-gray-100 dark:bg-gray-800/60 rounded-xl p-2.5">
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $agent->assigned_fields_count }}</p>
                        <p class="text-xs text-gray-500">Fields</p>
                    </div>
                    <div class="bg-red-500/10 rounded-xl p-2.5">
                        <p class="text-xl font-bold text-red-400">{{ $atRisk }}</p>
                        <p class="text-xs text-gray-500">At Risk</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800/60 rounded-xl p-2.5">
                        <p class="text-xl font-bold text-gray-300">{{ $agent->assignedFields->sum(fn($f) => $f->observations->count()) }}</p>
                        <p class="text-xs text-gray-500">Updates</p>
                    </div>
                </div>
                @if($agent->assignedFields->isNotEmpty())
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-800">
                    <p class="text-xs text-gray-500 mb-2">Assigned Fields</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($agent->assignedFields->take(4) as $field)
                        <span class="text-xs px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 rounded-lg">{{ $field->name }}</span>
                        @endforeach
                        @if($agent->assignedFields->count() > 4)
                        <span class="text-xs px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 rounded-lg">+{{ $agent->assignedFields->count() - 4 }} more</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            No agents registered.
        </div>
        @endforelse
    </div>
</div>
