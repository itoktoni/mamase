<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class CategoryRequestType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Tiket                     =  1;
    const Sparepart                 =  2;
    const Peralatan                 =  3;
}
