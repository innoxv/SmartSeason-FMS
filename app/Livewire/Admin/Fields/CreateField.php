<?php

namespace App\Livewire\Admin\Fields;

use App\Enums\FieldStage;
use App\Models\Field;
use App\Models\User;
use Livewire\Component;

class CreateField extends Component
{
    public string $name = '';
    public string $crop_type = '';
    public string $planting_date = '';
    public string $stage = 'planted';
    public string $agent_id = '';
    public string $location = '';
    public string $area_hectares = '';
    public string $description = '';

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
        $data['created_by'] = auth()->id();

        Field::create($data);

        session()->flash('success', 'Field created successfully.');
        return $this->redirect(route('admin.fields.index'), navigate: true);
    }

    public function render()
    {
        $agents = User::where('role', 'agent')->orderBy('name')->get();
        $stages = FieldStage::options();

        return view('livewire.admin.fields.create-field', compact('agents', 'stages'))
            ->layout('layouts.app', ['header' => 'Create New Field']);
    }
}
