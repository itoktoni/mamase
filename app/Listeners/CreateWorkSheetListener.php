<?php

namespace App\Listeners;

use App\Dao\Models\User;
use App\Events\CreateWorkSheetEvent;
use App\Mail\CreateWorkSheetEmail;
use Illuminate\Support\Facades\Mail;

class CreateWorkSheetListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CreateWorkSheetEvent $event)
    {
        $report_from = auth()->user()->{User::field_email()} ?? false;
        $report_to = $event->data->has_reported_by->field_email ?? false;
        $type = $event->data->has_work_type->field_name ?? '';

        // if ($report_to) {
        //     Mail::to([$report_from, $report_to])->send(new CreateWorkSheetEmail($event->data, $type));
        // }
    }
}
