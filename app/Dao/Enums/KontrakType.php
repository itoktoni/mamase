<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class KontrakType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const TidakKontrak              =  0;
    const Kontrak                   =  1;
}
