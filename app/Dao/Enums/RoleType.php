<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class RoleType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Pengguna = 1;
    const Teknisi = 2;
    const Supervisor = 3;
    const Admin = 4;

    const Developer = 5;
}
