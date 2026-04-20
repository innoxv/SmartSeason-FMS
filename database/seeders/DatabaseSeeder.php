<?php

namespace Database\Seeders;

use App\Enums\FieldStage;
use App\Enums\UserRole;
use App\Models\Field;
use App\Models\Observation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin Coordinator',
            'email'    => 'admin@smartseason.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Admin->value,
        ]);

        // ── Field Agents ───────────────────────────────────────────
        $agent1 = User::create([
            'name'     => 'Jane Wanjiku',
            'email'    => 'agent1@smartseason.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Agent->value,
        ]);

        $agent2 = User::create([
            'name'     => 'Brian Ochieng',
            'email'    => 'agent2@smartseason.com',
            'password' => Hash::make('password'),
            'role'     => UserRole::Agent->value,
        ]);

        // ── Fields ─────────────────────────────────────────────────
        $field1 = Field::create([
            'name'          => 'North Block A',
            'crop_type'     => 'Maize',
            'planting_date' => now()->subDays(45),
            'stage'         => FieldStage::Growing->value,
            'agent_id'      => $agent1->id,
            'created_by'    => $admin->id,
            'area_hectares' => 5.5,
            'location'      => 'Nakuru, Rift Valley',
            'description'   => 'Primary maize block on northern slope.',
        ]);

        $field2 = Field::create([
            'name'          => 'South Block B',
            'crop_type'     => 'Wheat',
            'planting_date' => now()->subDays(90),
            'stage'         => FieldStage::Ready->value,
            'agent_id'      => $agent1->id,
            'created_by'    => $admin->id,
            'area_hectares' => 3.0,
            'location'      => 'Nakuru, Rift Valley',
            'description'   => 'Wheat field near the southern irrigation channel.',
        ]);

        $field3 = Field::create([
            'name'          => 'East Paddock',
            'crop_type'     => 'Beans',
            'planting_date' => now()->subDays(20),
            'stage'         => FieldStage::Planted->value,
            'agent_id'      => $agent2->id,
            'created_by'    => $admin->id,
            'area_hectares' => 2.0,
            'location'      => 'Kiambu, Central',
            'description'   => 'Newly planted bean crop.',
        ]);

        $field4 = Field::create([
            'name'          => 'West Greenhouse',
            'crop_type'     => 'Tomatoes',
            'planting_date' => now()->subDays(60),
            'stage'         => FieldStage::Harvested->value,
            'agent_id'      => $agent2->id,
            'created_by'    => $admin->id,
            'area_hectares' => 1.2,
            'location'      => 'Kiambu, Central',
            'description'   => 'Greenhouse tomato crop — cycle complete.',
        ]);

        $field5 = Field::create([
            'name'          => 'Ridge Plot C',
            'crop_type'     => 'Sorghum',
            'planting_date' => now()->subDays(35),
            'stage'         => FieldStage::Growing->value,
            'agent_id'      => $agent1->id,
            'created_by'    => $admin->id,
            'area_hectares' => 4.0,
            'location'      => 'Nakuru, Rift Valley',
            'description'   => 'Sorghum on ridge terrain.',
        ]);

        // ── Observations ───────────────────────────────────────────
        Observation::create([
            'field_id'      => $field1->id,
            'user_id'       => $agent1->id,
            'notes'         => 'Good growth. Uniform germination across the block.',
            'is_risk_flag'  => false,
            'stage_at_time' => FieldStage::Growing->value,
        ]);

        Observation::create([
            'field_id'      => $field2->id,
            'user_id'       => $agent1->id,
            'notes'         => 'Wheat is golden and ready. Recommend harvesting within the week.',
            'is_risk_flag'  => false,
            'stage_at_time' => FieldStage::Ready->value,
        ]);

        Observation::create([
            'field_id'      => $field3->id,
            'user_id'       => $agent2->id,
            'notes'         => 'Signs of aphid infestation on seedlings. Flagging for review.',
            'is_risk_flag'  => true,
            'stage_at_time' => FieldStage::Planted->value,
        ]);

        Observation::create([
            'field_id'      => $field5->id,
            'user_id'       => $agent1->id,
            'notes'         => 'Dry spell noticed on eastern end. Irrigation adjusted.',
            'is_risk_flag'  => true,
            'stage_at_time' => FieldStage::Growing->value,
        ]);
    }
}
