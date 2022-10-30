<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class ProductStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Good          =  1;
    const Critical      =  2;
    const Defect        =  3;
    const Maintained    =  4;
}
