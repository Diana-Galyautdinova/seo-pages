<?php

namespace App\Enum;

enum RoomCountEnum: string
{
    case One = '1';
    case Two = '2';
    case Three = '3';
    case FourAndMore = '4';
    case Studio = 'studio';

    public static function getLabels(): array
    {
        return [
            self::One->value => '1 к.',
            self::Two->value => '2 к.',
            self::Three->value => '3 к.',
            self::FourAndMore->value => '4+ к.',
            self::Studio->value => 'Студия',
        ];
    }

    public function getLabel(): string
    {
        return self::getLabels()[$this->value];
    }
}
