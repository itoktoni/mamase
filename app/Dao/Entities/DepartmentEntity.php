<?php

namespace App\Dao\Entities;

trait DepartmentEntity
{
    public static function field_primary()
    {
        return 'department_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'department_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'department_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_pic()
    {
        return 'department_pic';
    }

    public function getFieldPicAttribute()
    {
        return $this->{$this->field_pic()};
    }

    public static function field_user_id()
    {
        return 'department_user_id';
    }

    public function getFieldUserIdAttribute()
    {
        return $this->{$this->field_user_id()};
    }

    public static function field_user_name()
    {
        return 'name';
    }

    public function getFieldUserNameAttribute()
    {
        return $this->{$this->field_user_name()};
    }

}
