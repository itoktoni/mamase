<?php

namespace App\Dao\Entities;

use App\Dao\Enums\TicketPriority;
use App\Dao\Enums\WorkType as EnumsWorkType;
use App\Dao\Models\TicketTopic;
use App\Dao\Models\Department;
use App\Dao\Models\Location;
use App\Dao\Models\Product;
use App\Dao\Models\Schedule;
use App\Dao\Models\Supplier;
use App\Dao\Models\User;
use App\Dao\Models\WorkType;

trait TicketSystemEntity
{
    public static function field_primary()
    {
        return 'ticket_system_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'ticket_system_name';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_status()
    {
        return 'ticket_system_status';
    }

    public function getFieldStatusAttribute()
    {
        return $this->{$this->field_status()};
    }

    public static function field_description()
    {
        return 'ticket_system_description';
    }

    public function getFieldDescriptionAttribute()
    {
        return $this->{$this->field_description()};
    }

    public static function field_check()
    {
        return 'ticket_system_check';
    }

    public function getFieldCheckAttribute()
    {
        return $this->{$this->field_check()};
    }

    public static function field_action()
    {
        return 'ticket_system_action';
    }

    public function getFieldActionAttribute()
    {
        return $this->{$this->field_action()};
    }

    public static function field_result()
    {
        return 'ticket_system_result';
    }

    public function getFieldResultAttribute()
    {
        return $this->{$this->field_result()};
    }

    public static function field_priority()
    {
        return 'ticket_system_priority';
    }

    public function getFieldPriorityAttribute()
    {
        return TicketPriority::getDescription($this->{$this->field_priority()});
    }

    public static function field_reported_at()
    {
        return 'ticket_system_reported_at';
    }

    public function getFieldReportedAtAttribute()
    {
        return $this->{$this->field_reported_at()};
    }

    public static function field_created_at()
    {
        return 'ticket_system_created_at';
    }

    public function getFieldCreatedAtAttribute()
    {
        return $this->{$this->field_created_at()};
    }

    public static function field_reported_by()
    {
        return 'ticket_system_reported_by';
    }

    public function getFieldReportedByAttribute()
    {
        return $this->{$this->field_reported_by()};
    }

    public static function field_reported_name()
    {
        return 'ticket_system_reported_name';
    }

    public function getFieldReportedNameAttribute()
    {
        return $this->{self::field_reported_name()};
    }

    public function getFieldReportedByNameAttribute()
    {
        return $this->{User::field_name()};
    }

    public static function field_reported_by_name()
    {
        return User::field_name();
    }

    public static function field_finished_at()
    {
        return 'ticket_system_finished_at';
    }

    public function getFieldFinishedAtAttribute()
    {
        return $this->{$this->field_finished_at()};
    }

    public static function field_finished_by()
    {
        return 'ticket_system_finished_by';
    }

    public function getFieldFinishedByAttribute()
    {
        return $this->{$this->field_finished_by()};
    }

    public static function field_topic_id()
    {
        return 'ticket_system_topic_id';
    }

    public function getFieldCategoryIdAttribute()
    {
        return $this->{self::field_topic_id()};
    }

    public function getFieldCategoryNameAttribute()
    {
        return $this->{TicketTopic::field_name()};
    }

    public function getFieldTopicNameAttribute()
    {
        return $this->{TicketTopic::field_name()};
    }

    public static function field_department_id()
    {
        return 'ticket_system_department_id';
    }

    public function getFieldDepartmentNameAttribute()
    {
        return $this->{Department::field_name()};
    }

    public static function field_location_id()
    {
        return 'ticket_system_location_id';
    }

    public function getFieldLocationNameAttribute()
    {
        return $this->{Location::field_name()};
    }

    public function getFieldBuildingNameAttribute()
    {
        return $this->has_location->has_bulding->field_name ?? '';
    }

    public function getFieldFloorNameAttribute()
    {
        return $this->{$this->field_picture()};
    }

    public static function field_product_id()
    {
        return 'ticket_system_product_id';
    }

    public function getFieldProductNameAttribute()
    {
        return $this->{Product::field_name()};
    }

    public static function field_work_type_id()
    {
        return 'ticket_system_work_type_id';
    }

    public function getFieldWorkTypeIdAttribute()
    {
        return $this->{self::field_work_type_id()};
    }

    public function getFieldWorkTypeNameAttribute()
    {
        return EnumsWorkType::getDescription($this->{self::field_work_type_id()});
    }

    public static function field_schedule_id()
    {
        return 'ticket_system_schedule_id';
    }

    public function getFieldScheduleNameAttribute()
    {
        return $this->{Schedule::field_name()};
    }

    public static function field_implementor()
    {
        return 'ticket_system_implementor';
    }

    public function getFieldImplementorAttribute()
    {
        return json_decode($this->{self::field_implementor()});
    }

    public static function field_picture()
    {
        return 'ticket_system_picture';
    }

    public function getFieldPictureAttribute()
    {
        return $this->{$this->field_picture()};
    }

    public static function field_assigned_at()
    {
        return 'ticket_system_assigned_at';
    }

    public function getFieldAssignedAtAttribute()
    {
        return $this->{$this->field_assigned_at()};
    }

    public static function field_assigned_by()
    {
        return 'ticket_system_assigned_by';
    }

    public function getFieldAssignedByAttribute()
    {
        return $this->{$this->field_assigned_by()};
    }

    public static function field_checked_at()
    {
        return 'ticket_system_checked_at';
    }

    public function getFieldCheckedAtAttribute()
    {
        return $this->{$this->field_checked_at()};
    }

    public static function field_checked_by()
    {
        return 'ticket_system_checked_by';
    }

    public function getFieldCheckedByAttribute()
    {
        return $this->{$this->field_checked_by()};
    }
}
