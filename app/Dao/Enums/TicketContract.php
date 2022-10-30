<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Enum as Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

class TicketContract extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Kontrak                   =  1;
    const TidakKontrak              =  0;
}
