<?php

namespace App\Livewire\Admin\Agents;

use App\Models\User;
use Livewire\Component;

class AgentsList extends Component
{
    public function render()
    {
        $agents = User::where('role', 'agent')
            ->withCount('assignedFields')
            ->with(['assignedFields' => fn($q) => $q->with('observations')])
            ->orderBy('name')
            ->get();

        return view('livewire.admin.agents.agents-list', compact('agents'))
            ->layout('layouts.app', ['header' => 'Field Agents']);
    }
}
