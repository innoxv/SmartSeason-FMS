<?php

namespace App\Livewire\Admin\Fields;

use App\Enums\FieldStage;
use App\Models\Field;
use App\Models\User;
use Livewire\Component;

class EditField extends Component
{
    public Field $field;
    public string $name = '';
    public string $crop_type = '';
    public string $planting_date = '';
    public string $stage = '';
    public string $agent_id = '';
    public string $location = '';
    public string $area_hectares = '';
    public string $description = '';

    public function mount(Field $field): void
    {
        $this->field         = $field;
        $this->name          = $field->name;
        $this->crop_type     = $field->crop_type;
        $this->planting_date = $field->planting_date->format('Y-m-d');
        $this->stage         = $field->stage->value;
        $this->agent_id      = (string)($field->agent_id ?? '');
        $this->location      = $field->location ?? '';
        $this->area_hectares = $field->area_hectares ? (string)$field->area_hectares : '';
        $this->description   = $field->description ?? '';
    }

    protected function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'crop_type'     => 'required|string|max:255',
            'planting_date' => 'required|date',
            'stage'         => 'required|in:planted,growing,ready,harvested',
            'agent_id'      => 'required|exists:users,id',
            'location'      => 'nullable|string|max:255',
            'area_hectares' => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
        ];
    }

    public function save()
    {
        $data = $this->validate();
        $this->field->update($data);

        session()->flash('success', 'Field updated successfully.');
        return $this->redirect(route('admin.fields.index'), navigate: true);
    }

    public function render()
    {
        $agents = User::where('role', 'agent')->orderBy('name')->get();
        $stages = FieldStage::options();

        return view('livewire.admin.fields.edit-field', compact('agents', 'stages'))
            ->layout('layouts.app', ['header' => 'Edit Field: ' . $this->field->name]);
    }
}
