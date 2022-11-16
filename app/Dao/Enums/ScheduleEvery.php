<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class ScheduleEvery extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Hari = 1;
    const Minggu  = 2;
    const Bulan  = 3;
    const Tahun  = 4;
}
