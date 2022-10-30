<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class ScheduleEvery extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Day = 1;
    const Week  = 2;
    const Month  = 3;
    const ThreeMonth  = 4;
    const SixMonth  = 5;
    const Year  = 6;
}
