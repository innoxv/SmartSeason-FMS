<?php

namespace App\Livewire\Agent\Fields;

use App\Models\Field;
use Livewire\Component;
use Livewire\WithPagination;

class MyFields extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void { $this->resetPage(); }

    public function render()
    {
        $fields = Field::where('agent_id', auth()->id())
            ->with(['observations'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'ilike', "%{$this->search}%")
                  ->orWhere('crop_type', 'ilike', "%{$this->search}%");
            }))
            ->latest()
            ->paginate(10);

        return view('livewire.agent.fields.my-fields', compact('fields'))
            ->layout('layouts.app', ['header' => 'My Fields']);
    }
}
