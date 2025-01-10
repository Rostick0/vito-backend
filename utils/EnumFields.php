<?php

namespace app\utils;

class EnumFields
{
    public static function getColumn($enum): array
    {
        return array_column($enum::cases(), 'value');
    }

    public static function mutationValues(array $arr, ?string $before_value = '', ?string $after_value = '')
    {
        return array_map(fn($item) => $before_value . $item . $after_value, $arr);
    }

    public static function getValidateValues($enum, string $before_value = '', string $after_value = ''): string
    {
        return implode(
            ',',
            self::mutationValues(
                self::getColumn($enum),
                $before_value,
                $after_value
            )
        );
    }
}
