<?php

namespace App\Dao\Enums;

use App\Dao\Traits\StatusTrait;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as Enum;

class RoleType extends Enum implements LocalizedEnum
{
    use StatusTrait;

    const Admin = 'admin';
    const User = 'user';
    const Pengawas = 'pengawas';
    const Pelaksana = 'pelaksana';
}
