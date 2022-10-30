<?php

namespace App\Dao\Entities;

use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\WorkType;

trait WorkSheetEntity
{
    public static function field_primary()
    {
        return 'work_sheet_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'work_sheet_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_status()
    {
        return 'work_sheet_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{$this->field_status()};
    }

    public static function field_description()
    {
        return 'work_sheet_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_check()
    {
        return 'work_sheet_check';
    }

    public function getFieldCheckAttribute()
    {
        return $this->{$this->field_check()};
    }

    public static function field_result()
    {
        return 'work_sheet_result';
    }

    public function getFieldResultAttribute()
    {
        return $this->{$this->field_result()};
    }

    public static function field_reported_at()
    {
        return 'work_sheet_reported_at';
    }

    public function getFieldReportedAtAttribute()
    {
        return $this->{$this->field_reported_at()};
    }

    public static function field_updated_at()
    {
        return 'work_sheet_updated_at';
    }

    public function getFieldUpdatedAtAttribute()
    {
        return $this->{$this->field_updated_at()};
    }

    public static function field_reported_by()
    {
        return 'work_sheet_reported_by';
    }

    public function getFieldReportedByAttribute()
    {
        return $this->{$this->field_reported_by()};
    }

    public static function field_finished_at()
    {
        return 'work_sheet_finished_at';
    }

    public function getFieldFinishedAtAttribute()
    {
        return $this->{$this->field_finished_at()};
    }

    public static function field_finished_by()
    {
        return 'work_sheet_finished_by';
    }

    public function getFieldFinishedByAttribute()
    {
        return $this->{$this->field_finished_by()};
    }

    public static function field_ticket_code()
    {
        return 'work_sheet_ticket_code';
    }

    public function getFieldTicketCodeAttribute()
    {
        return $this->{$this->field_ticket_code()};
    }

    public static function field_type_id()
    {
        return 'work_sheet_type_id';
    }

    public function getFieldTypeNameAttribute()
    {
        return $this->{WorkType::field_name()};
    }

    public static function field_product_id()
    {
        return 'work_sheet_product_id';
    }

    public function getFieldProductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_location_id()
    {
        return 'work_sheet_location_id';
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public static function field_vendor_id()
    {
        return 'work_sheet_vendor_id';
    }

    public function getFieldVendorIdAttribute()
    {
        return $this->{$this->field_vendor_id()};
    }

    public function getFieldVendorNameAttribute()
    {
        return $this->{Supplier::field_name()};
    }

    public static function field_contract()
    {
        return 'work_sheet_contract';
    }

    public function getFieldContractAttribute()
    {
        return $this->{$this->field_contract()};
    }

    public function getFieldContractNameAttribute()
    {
        return $this->{$this->field_contract()};
    }

    public static function field_implement_at()
    {
        return 'work_sheet_implement_at';
    }

    public function getFieldImplementAtAttribute()
    {
        return $this->{$this->field_implement_at()};
    }

    public static function field_implement_by()
    {
        return 'work_sheet_implement_by';
    }

    public function getFieldImplementByAttribute()
    {
        return $this->{$this->field_implement_by()};
    }

    public static function field_implementor()
    {
        return 'work_sheet_implementor';
    }

    public function getFieldImplementorAttribute()
    {
        return $this->{$this->field_implementor()};
    }

    public static function field_picture()
    {
        return 'work_sheet_picture';
    }

    public function getFieldPictureAttribute()
    {
        return $this->{$this->field_picture()};
    }
}
