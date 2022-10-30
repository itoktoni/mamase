<?php

namespace App\Listeners;

use App\Dao\Models\WorkType;
use App\Events\CreateTicketEvent;
use App\Mail\CreateTicketEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $report_from = $event->data->has_reported ?? false;
        $report_to = $event->data->has_department->has_user ?? false;

        $email_from = $phone_from = false;

        if(env('MAIL_ENABLE', false)){
            $email_from = $report_from->field_email ?? false;
            $email_to = $report_to->field_email ?? false;
        }

        if(env('WA_ENABLE', false)){
            $phone_from = $report_from->field_phone ?? false;
            $phone_to = $report_to->field_phone ?? false;
        }

        if($email_from){
            $email = $email_to ? array_merge([$email_from], [$email_to]) : $email_from;
            Mail::to([$email])->send(new CreateTicketEmail($event->data));
        }

        if($phone_from){
            $description = '';
            if($event->data->has_type){
                $tipe = $event->data->has_type->field_name ?? '';
                $description = $description.'Type : '.$tipe.PHP_EOL;
            }

            if($report_from){
                $pelapor = $report_from->field_name ?? '';
                $description = $description.'Pelapor : '.$pelapor.PHP_EOL;
            }

            if($event->data->has_location){
                $location = $event->data->has_location->field_name ?? '';
                $description = $description.'Lokasi : '.$location.PHP_EOL;
            }

            $description = $description.'Deskripsi : '.$event->data->field_description.PHP_EOL;
            $description = $description.'Link : '.route(env('TICKET_ROUTE').'.getUpdate', ['code' => $event->data->field_primary]);

            WhatsApp::send(env('WA_ADMIN'), $description, asset('storage/ticket/'.$event->data->field_picture));
            if($phone_from){
                WhatsApp::send($phone_from, $description, asset('storage/ticket/'.$event->data->field_picture));
            }
        }
    }
}
