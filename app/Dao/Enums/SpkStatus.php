<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class SpkStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Created = 1;
    const Approved = 2;
    const Maintained = 3;
    const Checked = 4;
    const Finished = 5;
}
