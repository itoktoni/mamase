<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class TicketPriority extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Low                  =  1;
    const Medium               =  2;
    const High                 =  3;
}
