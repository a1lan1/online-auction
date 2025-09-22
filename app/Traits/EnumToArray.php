<?php

namespace App\Traits;

trait EnumToArray
{
    public static function list(): array
    {
        $array = [];

        foreach (self::cases() as $case) {
            $array[] = [
                'value' => $case->value,
                'name' => $case->name,
            ];
        }

        return $array;
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
