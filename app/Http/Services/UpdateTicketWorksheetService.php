<?php

namespace App\Http\Services;

use App\Dao\Enums\TicketContract;
use App\Dao\Enums\WorkStatus;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkSheet;
use App\Dao\Models\WorkType;
use Plugins\Alert;

class UpdateTicketWorksheetService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $check = TicketSystem::find($code);
        $type = WorkType::find($data->get('type'));
        if ($check) {
            $kontrak = $data->get('contract');
            $values = [
                WorkSheet::field_description() => $check->field_description,
                WorkSheet::field_ticket_code() => $code,
                WorkSheet::field_status() => WorkStatus::Open,
                WorkSheet::field_type_id() => $type->field_primary ?? null,
                WorkSheet::field_name() => $data->get('name') ?? null,
                WorkSheet::field_contract() => $data->get('contract') ?? null,
                WorkSheet::field_product_id() => $data->get('product') ?? null,
                WorkSheet::field_location_id() => $check->{TicketSystem::field_location_id()} ?? null,
                WorkSheet::field_reported_at() => date('Y-m-d H:i:s'),
                WorkSheet::field_reported_by() => $check->field_reported_by ?? null,
            ];
            // if ($kontrak == TicketContract::Kontrak) {
            //     $vendor = $data->get('vendor') ?? null;
            //     $values = array_merge($values, [
            //         WorkSheet::field_vendor_id() => $vendor,
            //         WorkSheet::field_implement_by() => $vendor,
            //     ]);
            // } else {
            //     $implementor = $data->get('implementor') ?? null;
            //     $values = array_merge($values, [
            //         WorkSheet::field_implementor() => json_encode($implementor),
            //         WorkSheet::field_implement_by() => $implementor[0] ?? null,
            //     ]);
            // }
            WorkSheet::create($values);
            Alert::update();
        } else {
            Alert::error($check);
        }
        return $check;
    }
}
