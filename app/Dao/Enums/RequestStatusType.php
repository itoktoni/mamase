<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class RequestStatusType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Dibuat                 =  1;
    const Diajuakan                 =  2;
    const Disetujui                 =  3;
    const Diterima                 =  4;
    const Selesai                 =  5;
}
