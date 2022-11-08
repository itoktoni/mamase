<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class RoleType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const User = 1;
    const Pelaksana = 2;
    const Pengawas = 3;
    const Admin = 4;
}
