<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumValuesTrait
{
    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        $values = array_column(self::cases(), 'value');
        sort($values);

        return $values;
    }
}
