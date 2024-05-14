<?php

namespace App\Dao\Entities;

use App\Dao\Models\Brand;
use App\Dao\Models\Category;
use App\Dao\Models\ProductType;
use App\Dao\Models\Unit;

trait ModelEntity
{
    public static function field_primary()
    {
        return 'model_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'model_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_description()
    {
        return 'model_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_image()
    {
        return 'model_image';
    }

    public function getFieldImageAttribute()
    {
        return $this->{$this->field_image()};
    }

    public static function field_group()
    {
        return 'model_group';
    }

    public function getFieldGroupAttribute()
    {
        return $this->{$this->field_group()};
    }

    public static function field_category_id()
    {
        return 'model_category_id';
    }

    public function getFieldCategoryIdAttribute()
    {
        return $this->{self::field_category_id()};
    }

    public function getFieldCategoryNameAttribute()
    {
        return $this->{Category::field_name()};
    }

    public static function field_brand_id()
    {
        return 'model_brand_id';
    }

    public function getFieldBrandIdAttribute()
    {
        return $this->{self::field_brand_id()};
    }

    public function getFieldBrandNameAttribute()
    {
        return $this->{Brand::field_name()};
    }

    public static function field_type_id()
    {
        return 'model_type_id';
    }

    public function getFieldTypeIdAttribute()
    {
        return $this->{self::field_type_id()};
    }

    public function getFieldTypeNameAttribute()
    {
        return $this->{ProductType::field_name()};
    }

    public static function field_unit_id()
    {
        return 'model_unit_id';
    }

    public function getFieldUnitIdAttribute()
    {
        return $this->{self::field_unit_id()};
    }

    public function getFieldUnitNameAttribute()
    {
        return $this->{Unit::field_name()};
    }
}
