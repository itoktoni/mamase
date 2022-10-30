<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class MovementStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Approve = 1;
    const Pending = 2;
    const Reject = 3;
}
