<?php

namespace App\Livewire\Admin;

use App\Enums\FieldStatus;
use App\Models\Field;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $fields = Field::with(['agent', 'observations'])->get();

        $stats = [
            'total'     => $fields->count(),
            'active'    => $fields->filter(fn($f) => $f->status === FieldStatus::Active)->count(),
            'at_risk'   => $fields->filter(fn($f) => $f->status === FieldStatus::AtRisk)->count(),
            'completed' => $fields->filter(fn($f) => $f->status === FieldStatus::Completed)->count(),
        ];

        $recentObservations = \App\Models\Observation::with(['field', 'user'])
            ->latest()
            ->take(8)
            ->get();

        $agents = User::where('role', 'agent')
            ->withCount('assignedFields')
            ->get();

        return view('livewire.admin.dashboard', compact('fields', 'stats', 'recentObservations', 'agents'))
            ->layout('layouts.app', ['header' => 'Admin Dashboard']);
    }
}
