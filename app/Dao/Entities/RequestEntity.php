<?php

namespace App\Dao\Entities;

use App\Dao\Models\User;

trait RequestEntity
{
    public static function field_key()
    {
        return 'request_code';
    }

    public function getFieldKeyAttribute()
    {
        return $this->{$this->field_key()};
    }

    public static function field_primary()
    {
        return 'request_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'request_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_date()
    {
        return 'request_date';
    }

    public function getFieldDateAttribute()
    {
        return $this->{$this->field_date()};
    }


    public static function field_start_date()
    {
        return 'request_start_date';
    }

    public function getFieldStartDateAttribute()
    {
        return $this->{$this->field_start_date()};
    }

    public static function field_end_date()
    {
        return 'request_end_date';
    }

    public function getFieldEndDateAttribute()
    {
        return $this->{$this->field_end_date()};
    }

    public static function field_category()
    {
        return 'request_category';
    }

    public function getFieldCategoryAttribute()
    {
        return $this->{$this->field_category()};
    }

    public static function field_status()
    {
        return 'request_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{$this->field_status()};
    }

    public static function field_description()
    {
        return 'request_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_approval_id()
    {
        return 'request_approval_by';
    }

    public function getFieldApprovalIdAttribute()
    {
        return $this->{$this->field_approval_id()};
    }

    public function getFieldApprovalNameAttribute()
    {
        return $this->{User::field_name()};
    }

    public static function field_created_by()
    {
        return 'request_created_by';
    }

    public function getFieldCreatedByAttribute()
    {
        return $this->{$this->field_created_by()};
    }
}
