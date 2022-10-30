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
}
