<?php

namespace App\Http\Services;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\TicketStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkSheet;
use App\Dao\Models\WorkType;
use App\Events\CreateWorkSheetEvent;
use Plugins\Alert;

class UpdateTicketWorksheetService
{
    public function update(CrudInterface $repository, $data, $code)
    {
        $ticket = TicketSystem::find($code);
        $ticket->{TicketSystem::field_assigned_at()} = date('Y-m-d H:i:s');
        $ticket->{TicketSystem::field_assigned_by()} = auth()->user()->id;
        $ticket->{TicketSystem::field_status()} = TicketStatus::Approve;

        $ticket->save();

        $type = WorkType::find($data->get('type'));
        if ($ticket) {
            $values = [
                WorkSheet::field_description() => $ticket->field_description,
                WorkSheet::field_ticket_code() => $code,
                WorkSheet::field_status() => WorkStatus::Open,
                WorkSheet::field_type_id() => $type->field_primary ?? null,
                WorkSheet::field_name() => $data->get('name') ?? null,
                WorkSheet::field_contract() => $data->get('contract') ?? null,
                WorkSheet::field_product_id() => $data->get('product') ?? null,
                WorkSheet::field_vendor_id() => $data->get('work_sheet_vendor_id') ?? null,
                WorkSheet::field_implementor() => json_encode($data->get('implementor')) ?? null,
                WorkSheet::field_location_id() => $ticket->{TicketSystem::field_location_id()} ?? null,
                WorkSheet::field_reported_at() => date('Y-m-d H:i:s'),
                WorkSheet::field_reported_by() => $ticket->field_reported_by ?? null,
                WorkSheet::field_reported_name() => $ticket->field_reported_name ?? $ticket->field_reported_by_name ?? null,
            ];

            $works = WorkSheet::create($values);
            event(new CreateWorkSheetEvent($works));

            Alert::update();
        } else {
            Alert::error($ticket);
        }
        return $ticket;
    }
}
