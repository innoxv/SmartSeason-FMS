<?php

namespace App\Enums;

enum FieldStatus: string
{
    case Active    = 'active';
    case AtRisk    = 'at_risk';
    case Completed = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Active    => 'Active',
            self::AtRisk    => 'At Risk',
            self::Completed => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Active    => 'emerald',
            self::AtRisk    => 'red',
            self::Completed => 'gray',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Active    => 'badge-active',
            self::AtRisk    => 'badge-risk',
            self::Completed => 'badge-completed',
        };
    }
}
