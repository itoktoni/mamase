<?php

namespace App\Listeners;

use App\Dao\Entities\TicketSystemEntity;
use App\Dao\Enums\NotificationStatus;
use App\Dao\Models\Notification as ModelsNotification;
use App\Dao\Models\TicketSystem;
use App\Dao\Models\WorkType;
use App\Events\CreateTicketEvent;
use App\Mail\CreateTicketEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Plugins\WhatsApp;

class CreateTicketListener
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
    public function handle(CreateTicketEvent $event)
    {
        $data = $event->data;
        $report_from = $data->has_reported ?? false;
        $report_to = $data->has_category->has_user ?? false;

        $email_from = $phone_from = false;

        if(env('MAIL_ENABLE', false)){
            $email_from = $report_from->field_email ?? false;
            $email_to = $report_to->field_email ?? false;
        }

        if($email_from){
            $email = $email_to ? array_merge([$email_from], [$email_to]) : $email_from;
            Mail::to([$email])->send(new CreateTicketEmail($event->data));
        }

        if(env('WA_ENABLE', false)){
            $phone_from = $report_from->field_phone ?? false;
        }

        if($phone_from){
            $description = '';
            if($event->data->has_type){
                $tipe = $event->data->has_type->field_name ?? '';
                $description = $description.'Type : '.$tipe.PHP_EOL;
            }

            if($report_from){
                $pelapor = $report_from->field_reported_name ?? $report_from->field_name ?? '';
                $description = $description.'Pelapor : '.$pelapor.PHP_EOL;
            }

            if($event->data->has_location){
                $location = $event->data->has_location->field_name ?? '';
                $description = $description.'Lokasi : '.$location.PHP_EOL;
            }

            $description = $description.'Deskripsi : '.$event->data->field_description.PHP_EOL;
            $description = $description.'Link : '.route(env('TICKET_ROUTE').'.getUpdate', ['code' => $event->data->field_primary]);

            /*
            WhatsApp::send(env('WA_ADMIN'), $description, asset('storage/ticket/'.$event->data->field_picture));
            if($phone_from){
                WhatsApp::send($phone_from, $description, asset('storage/ticket/'.$event->data->field_picture));
            }
            */

            $this->saveNotification($pelapor, $description, $phone_from, $data->field_category_id, $data->field_picture);

            if($report_to->count() > 0){
                foreach($report_to as $teknisi){
                    $this->saveNotification($teknisi->field_name, $description, $teknisi->field_phone, $data->field_category_id, $data->field_picture);
                }
            }
        }
    }

    private function saveNotification($pelapor, $description, $phone, $type, $picture = null){

        ModelsNotification::create([
            ModelsNotification::field_name() =>  $pelapor,
            ModelsNotification::field_description() => $description,
            ModelsNotification::field_status() => NotificationStatus::Create,
            ModelsNotification::field_phone() => $phone,
            ModelsNotification::field_eta() => Carbon::today(),
            ModelsNotification::field_type() => $type,
            ModelsNotification::field_image() => $picture ? asset('storage/ticket/'.$picture) : null,
        ]);
    }
}
