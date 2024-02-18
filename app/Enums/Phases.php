<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Phases: string implements HasLabel, HasColor
{

    case Saponification = "10";
    case Lye = "20";
    case Additives = "30";
    
    public function getLabel(): string
    // This is the method that will be called to get the label of the enum
    {
        return match ($this) {

            self::Saponification => 'Huiles Saponifiées',
            self::Lye => 'Milieux Réactionnel',
            self::Additives => 'Additifs',
        };
    }

    // This is ithe method that will be called to get the color of the enum
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Saponification => 'gray',
            self::Lye => 'warning',
            self::Additives => 'info',
        };
    }
}
