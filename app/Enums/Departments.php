<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Departments: string implements HasLabel
{
    case Commercial = 'commercial';
    case Management = 'management';
    case Production = 'production';
    case Purchase = 'achats';
    case Marketing = 'marketing';
    case Research = 'recherche';

    public function getLabel(): string
    // This is the method that will be called to get the label of the enum
    {
        return match ($this) {
            self::Commercial => 'Commercial',
            self::Management => 'Direction',
            self::Production => 'Production',
            self::Purchase => 'Achats',
            self::Marketing => 'Marketing',
            self::Research => 'Recherche',
        };
    }
}
