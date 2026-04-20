<?php

namespace App\Enums;

enum FieldStage: string
{
    case Planted   = 'planted';
    case Growing   = 'growing';
    case Ready     = 'ready';
    case Harvested = 'harvested';

    public function label(): string
    {
        return match($this) {
            self::Planted   => 'Planted',
            self::Growing   => 'Growing',
            self::Ready     => 'Ready to Harvest',
            self::Harvested => 'Harvested',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Planted   => 'blue',
            self::Growing   => 'emerald',
            self::Ready     => 'amber',
            self::Harvested => 'gray',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
