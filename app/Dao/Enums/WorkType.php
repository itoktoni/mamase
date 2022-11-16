<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class WorkType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Preventif              =  1;
    const Korektif               =  2;
}
