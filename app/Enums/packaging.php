<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Packaging: string implements HasLabel
{
    case Bidon = 'bidon';
    case Seau = 'seau';
    case Carton = 'carton';
    case Fût = 'fût';
    case Flacon = 'flacon';
    case Unitaire  = 'unitaire';
    case Vrac = 'vrac';
    case Sac  = 'sac';

    public function getLabel(): string
    // This is the method that will be called to get the label of the enum
    {
        return match ($this) {
            self::Bidon => 'Bidon',
            self::Seau => 'Seau',
            self::Carton => 'Carton',
            self::Fût => 'Fût',
            self::Flacon => 'Flacon',
            self::Unitaire => 'Unitaire',
            self::Vrac => 'Vrac',
            self::Sac => 'Sac',
        };
    }
}
