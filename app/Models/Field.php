<?php

namespace App\Models;

use App\Enums\FieldStage;
use App\Enums\FieldStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'crop_type',
        'planting_date',
        'stage',
        'agent_id',
        'created_by',
        'description',
        'area_hectares',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'planting_date' => 'date',
            'stage'         => FieldStage::class,
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function observations()
    {
        return $this->hasMany(Observation::class)->latest();
    }

    // ─── Status Logic ───────────────────────────────────────────────
    //
    // Status is computed from stage + risk flags on observations:
    //  - Completed  → stage is 'harvested'
    //  - At Risk    → any observation has is_risk_flag = true (and not yet harvested)
    //  - Active     → default for all others
    //

    public function getStatusAttribute(): FieldStatus
    {
        if ($this->stage === FieldStage::Harvested) {
            return FieldStatus::Completed;
        }

        if ($this->observations()->where('is_risk_flag', true)->exists()) {
            return FieldStatus::AtRisk;
        }

        return FieldStatus::Active;
    }

    public function getDaysInFieldAttribute(): int
    {
        return (int) \Carbon\Carbon::parse($this->planting_date)->diffInDays(now());
    }
}
