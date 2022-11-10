<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class NotificationStatus extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Create = 1;
    const Sent = 2;
    const Failed = 3;
    const Cancel = 4;
    const Schedule = 5;
}
