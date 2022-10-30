<?php

namespace App\Dao\Entities;

use App\Dao\Models\Roles;
use App\Dao\Models\SystemRole;

trait UserEntity
{
    public static function field_primary()
    {
        return 'id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{self::field_primary()};
    }

    public static function field_name()
    {
        return 'name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{self::field_name()};
    }

    public static function field_phone()
    {
        return 'phone';
    }

    public function getFieldPhoneAttribute()
    {
        return $this->{self::field_phone()};
    }

    public static function field_email()
    {
        return 'email';
    }

    public function getFieldEmailAttribute()
    {
        return $this->{self::field_email()};
    }

    public static function field_username()
    {
        return 'username';
    }

    public function getFieldUsernameAttribute()
    {
        return $this->{self::field_username()};
    }

    public static function field_active()
    {
        return 'active';
    }

    public function getFieldActiveAttribute()
    {
        return $this->{self::field_active()};
    }

    public static function field_role()
    {
        return 'role';
    }

    public function getFieldRoleNameAttribute()
    {
        return $this->{SystemRole::field_name()};
    }
}
