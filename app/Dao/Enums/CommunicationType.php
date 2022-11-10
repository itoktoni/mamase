<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class CommunicationType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Ticket = 1;
    const Worksheet = 2;
}
