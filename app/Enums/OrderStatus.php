<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel, HasColor
{

    case Draft = 'draft';
    case Passed = 'passée';
    case Confirmed = 'confirmée';
    case Delivered = 'livrée';
    case Cancelled = 'annulée';


    public function getLabel(): string
    // This is the method that will be called to get the label of the enum
    {
        return match ($this) {

            self::Draft => 'Draft',
            self::Passed => 'Passée',
            self::Confirmed => 'Confirmée',
            self::Delivered => 'Livrée',
            self::Cancelled => 'Annulée',
        };
    }


    // This is ithe method that will be called to get the color of the enum
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => Color::Slate,
            self::Passed => 'primary',
            self::Confirmed => 'warning',
            self::Delivered => 'success',
            self::Cancelled => 'danger',
        };
    }
}
