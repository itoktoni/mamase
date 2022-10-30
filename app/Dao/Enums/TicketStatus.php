<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class TicketStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Open                  =  1;
    const Approve               =  2;
    const Progress              =  3;
    const Finish                =  4;
    const Close                 =  5;
}
