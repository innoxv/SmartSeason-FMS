<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'user_id',
        'notes',
        'is_risk_flag',
        'stage_at_time',
    ];

    protected function casts(): array
    {
        return [
            'is_risk_flag' => 'boolean',
        ];
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
