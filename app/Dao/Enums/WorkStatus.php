<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class WorkStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Open                  =  1;
    const Progress              =  2;
    const Sparepart              =  3;
    const Vendor              =  4;
    const Warehouse              =  5;
    const Close                 =  6;

    public static function getDescription($value): string
    {
        if ($value === self::Open) {
            return 'Baru';
        }
        else if ($value === self::Progress) {
            return 'Proses';
        }
        else if ($value === self::Close) {
            return 'Selesai';
        }
        else if ($value === self::Close) {
            return 'Digudangkan';
        }
        else if ($value === self::Sparepart) {
            return 'Suku Cadang';
        }
        else if ($value === self::Vendor) {
            return 'Perbaikan Vendor';
        }

        return parent::getDescription($value);
    }
}
