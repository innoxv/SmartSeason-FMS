<?php

namespace App\Livewire\Agent;

use App\Enums\FieldStatus;
use App\Models\Field;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $fields = Field::where('agent_id', auth()->id())
            ->with(['observations'])
            ->get();

        $stats = [
            'total'     => $fields->count(),
            'active'    => $fields->filter(fn($f) => $f->status === FieldStatus::Active)->count(),
            'at_risk'   => $fields->filter(fn($f) => $f->status === FieldStatus::AtRisk)->count(),
            'completed' => $fields->filter(fn($f) => $f->status === FieldStatus::Completed)->count(),
        ];

        $recentObservations = \App\Models\Observation::whereHas('field', fn($q) => $q->where('agent_id', auth()->id()))
            ->with(['field', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.agent.dashboard', compact('fields', 'stats', 'recentObservations'))
            ->layout('layouts.app', ['header' => 'My Dashboard']);
    }
}
