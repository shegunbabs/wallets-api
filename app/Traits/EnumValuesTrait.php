<?php

namespace App\Traits;

trait EnumValuesTrait
{
    public static function values(): array
    {
        $values = array_column(self::cases(), 'value');
        sort($values);

        return $values;
    }
}
