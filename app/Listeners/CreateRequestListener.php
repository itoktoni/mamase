<?php

namespace App\Listeners;

use App\Dao\Enums\KontrakType;
use App\Dao\Enums\NotificationStatus;
use App\Dao\Enums\WorkStatus;
use App\Dao\Models\Notification as ModelsNotification;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\User;
use App\Dao\Models\WorkSheet;
use App\Events\CreateRequestEvent;
use Carbon\Carbon;

class CreateRequestListener
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
    public function handle(CreateRequestEvent $event)
    {
        $data = $event->data;
        $report_to = $data->has_approval ?? false;
        $email_from = $receive_handphone = false;
        $description = '';

        if (env('WA_ENABLE', false)) {
            $receive_handphone = $report_to->field_phone ?? false;
        }

        if ($receive_handphone) {
            $description = $description. 'Ada request dari '.$data->request_name.PHP_EOL;
            $description = $description. ' untuk kebutuhan : '.$data->request_description.PHP_EOL;

            $this->saveNotification($data->request_name, $description, $receive_handphone, NotificationStatus::Create, null);
        }
    }

    private function saveNotification($pelapor, $description, $phone, $type, $picture = null)
    {
        ModelsNotification::create([
            ModelsNotification::field_name() => $pelapor,
            ModelsNotification::field_description() => $description,
            ModelsNotification::field_status() => NotificationStatus::Create,
            ModelsNotification::field_phone() => $phone,
            ModelsNotification::field_eta() => Carbon::today(),
            ModelsNotification::field_type() => $type,
            ModelsNotification::field_image() => $picture ? asset('storage/ticket/' . $picture) : null,
        ]);
    }
}
