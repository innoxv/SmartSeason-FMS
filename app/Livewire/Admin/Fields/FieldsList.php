<?php

namespace App\Livewire\Admin\Fields;

use App\Enums\FieldStatus;
use App\Models\Field;
use Livewire\Component;
use Livewire\WithPagination;

class FieldsList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $stageFilter = '';
    public string $statusFilter = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStageFilter(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    public function render()
    {
        $fields = Field::with(['agent', 'observations'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'ilike', "%{$this->search}%")
                  ->orWhere('crop_type', 'ilike', "%{$this->search}%")
                  ->orWhere('location', 'ilike', "%{$this->search}%");
            }))
            ->when($this->stageFilter, fn($q) => $q->where('stage', $this->stageFilter))
            ->latest()
            ->paginate(10);

        // apply status filter in PHP (computed attribute)
        if ($this->statusFilter) {
            $filtered = $fields->getCollection()->filter(
                fn($f) => $f->status->value === $this->statusFilter
            );
            $fields->setCollection($filtered);
        }

        return view('livewire.admin.fields.fields-list', compact('fields'))
            ->layout('layouts.app', ['header' => 'All Fields']);
    }
}
