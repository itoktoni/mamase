<?php

namespace App\Dao\Entities;

use App\Dao\Enums\ProductStatus;
use App\Dao\Enums\TicketContract;
use App\Dao\Enums\WorkStatus;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Supplier;
use App\Dao\Models\WorkSuggestion;
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
        return WorkStatus::getDescription($this->{$this->field_status()});
    }

    public static function field_product_fisik()
    {
        return 'work_sheet_product_fisik';
    }

    public function getFieldProductFisikAttribute()
    {
        return ProductStatus::getDescription($this->{$this->field_product_fisik()});
    }

    public static function field_product_fungsi()
    {
        return 'work_sheet_product_fungsi';
    }

    public function getFieldProductFungsiAttribute()
    {
        return ProductStatus::getDescription($this->{$this->field_product_fungsi()});
    }

    public static function field_product_description()
    {
        return 'work_sheet_product_description';
    }

    public function getFieldProductDescriptionAttribute()
    {
        return $this->{$this->field_product_description()};
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

    public static function field_action()
    {
        return 'work_sheet_action';
    }

    public function getFieldActionAttribute()
    {
        return $this->{$this->field_action()};
    }

    public static function field_reported_at()
    {
        return 'work_sheet_reported_at';
    }

    public function getFieldReportedAtAttribute()
    {
        return $this->{$this->field_reported_at()};
    }

    public static function field_reported_name()
    {
        return 'work_sheet_reported_name';
    }

    public function getFieldReportedNameAttribute()
    {
        return $this->{$this->field_reported_name()};
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

    public function getFieldProductIdAttribute()
    {
        return $this->{self::field_product_id()};
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

    public static function field_suggestion_id()
    {
        return 'work_sheet_suggestion_id';
    }

    public function getFieldSuggestionIdAttribute()
    {
        return $this->{self::field_suggestion_id()};
    }

    public function getFieldSuggestionNameAttribute()
    {
        return $this->{WorkSuggestion::field_name()};
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
        return TicketContract::getDescription($this->{$this->field_contract()});
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

    public static function field_check_at()
    {
        return 'work_sheet_check_at';
    }

    public function getFieldCheckAtAttribute()
    {
        return $this->{$this->field_check_at()};
    }

    public static function field_check_by()
    {
        return 'work_sheet_check_by';
    }

    public function getFieldCheckByAttribute()
    {
        return $this->{$this->field_check_by()};
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
