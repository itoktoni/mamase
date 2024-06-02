<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class TicketStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Open                  =  1;
    const Progress              =  3;
    const Recall                =  2;
    const Finish                =  4;

    public static function getDescription($value): string
    {
        if ($value === self::Open) {
            return 'Baru';
        }
        else if ($value === self::Progress) {
            return 'Proses';
        }
        else if ($value === self::Finish) {
            return 'Selesai';
        }
        else if ($value === self::Recall) {
            return 'Kirim ulang';
        }

        return parent::getDescription($value);
    }
}
