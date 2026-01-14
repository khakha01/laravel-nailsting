<?php

namespace App\Enums;

enum ProductUnitEnum: string
{
    case LAN = 'lan';
    case MONG = 'mong';
    case BO = 'bo';
    case DOI = 'doi';
    case CAP = 'cap';
    case BO_10_MONG = 'bo_10_mong';
    case BO_GEL = 'bo_gel';

    public static function labels(): array
    {
        return [
            self::LAN->value => 'Lần',
            self::MONG->value => 'Móng',
            self::BO->value => 'Bộ',
            self::DOI->value => 'Đôi',
            self::CAP->value => 'Cặp',
            self::BO_10_MONG->value => 'Bộ 10 móng',
            self::BO_GEL->value => 'Bộ gel',
        ];
    }

    public static function values(): array
    {
        return array_keys(self::labels());
    }

    public static function label(string $value): string
    {
        return self::labels()[$value] ?? $value;
    }
}
