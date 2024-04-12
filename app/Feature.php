<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

enum Feature: int implements Arrayable
{
    case Friday = 1;
    case Saturday = 2;
    case Sunday = 4;
    case Backstage = 8;
    case Food = 16;
    case SoftDrinks = 32;
    case Alcohol = 64;
    case TShirt = 128;

    public function description(): string
    {
        return match ($this) {
            self::Friday => 'Access to the Friday program.',
            self::Saturday => 'Access to the Saturday program.',
            self::Sunday => 'Access to the Sunday program.',
            self::Backstage => 'Backstage access with a chance to hang out with the stars of the show.',
            self::Food => 'Breakfast, dinner and evening meal provided on site.',
            self::SoftDrinks => 'Unlimited branded soft drinks throughout the conference.',
            self::Alcohol => 'Unlimited branded alcoholic beverages throughout the conference.',
            self::TShirt => 'An awesome themed T-Shirt to take home with you.',
        };
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'description' => $this->description(),
        ];
    }

    public static function collect(): Collection
    {
        return collect(self::cases());
    }
}
