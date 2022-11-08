<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class MovementType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Recall = 1;
    const Pindah = 2;
    const Vendor = 3;
    const Gudangkan = 4;
}
