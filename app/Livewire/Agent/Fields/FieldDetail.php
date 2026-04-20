<?php

namespace App\Livewire\Agent\Fields;

use App\Enums\FieldStage;
use App\Models\Field;
use App\Models\Observation;
use Livewire\Component;

class FieldDetail extends Component
{
    public Field $field;

    // Stage update
    public string $newStage = '';

    // New observation
    public string $notes = '';
    public bool $is_risk_flag = false;

    public function mount(Field $field): void
    {
        // Ensure agent can only view their own fields
        if ($field->agent_id !== auth()->id()) {
            abort(403);
        }

        $this->field    = $field;
        $this->newStage = $field->stage->value;
    }

    public function updateStage(): void
    {
        $this->validate(['newStage' => 'required|in:planted,growing,ready,harvested']);

        $this->field->update(['stage' => $this->newStage]);
        $this->field->refresh();

        session()->flash('stage_success', 'Stage updated successfully.');
    }

    public function addObservation(): void
    {
        $this->validate([
            'notes'        => 'required|string|min:5',
            'is_risk_flag' => 'boolean',
        ]);

        Observation::create([
            'field_id'      => $this->field->id,
            'user_id'       => auth()->id(),
            'notes'         => $this->notes,
            'is_risk_flag'  => $this->is_risk_flag,
            'stage_at_time' => $this->field->stage->value,
        ]);

        $this->notes        = '';
        $this->is_risk_flag = false;
        $this->field->refresh();

        session()->flash('obs_success', 'Observation recorded.');
    }

    public function render()
    {
        $stages       = FieldStage::options();
        $observations = $this->field->observations()->with('user')->get();

        return view('livewire.agent.fields.field-detail', compact('stages', 'observations'))
            ->layout('layouts.app', ['header' => $this->field->name]);
    }
}
