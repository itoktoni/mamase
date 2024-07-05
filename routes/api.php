<?php

use App\Dao\Enums\NotificationStatus;
use App\Dao\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Plugins\WhatsApp;

Route::get('job', function(){

    $data_wa = Notification::where(Notification::field_status(), NotificationStatus::Create)->limit(env('WA_LIMIT', 1))->get();
        if ($data_wa) {
            foreach ($data_wa as $data) {
                $status = WhatsApp::send($data->field_phone, $data->field_description);

                if (isset($wa['status']) && $wa['status']) {
                    $data->{Notification::field_status()} = NotificationStatus::Sent;
                    $data->{Notification::field_error()} = json_encode($status);
                    $data->{Notification::field_etd()} = date('Y-m-d H:i:s');
                    $data->save();
                } else {
                    $data->{Notification::field_status()} = NotificationStatus::Failed;
                    $data->{Notification::field_error()} = json_encode($status);
                    $data->{Notification::field_etd()} = date('Y-m-d H:i:s');
                    $data->save();
                }
                sleep(env('WA_DELAY', 5));
            }
        }

});