<?php

namespace App\Http\Services;

use App\Dao\Facades\EnvFacades;
use Plugins\Alert;

class CreateSettingService
{
    public function save($data)
    {
        $check = false;
        try {

            EnvFacades::setValue('APP_NAME', $data->name);
            EnvFacades::setValue('APP_TITLE', $data->title);
            EnvFacades::setValue('APP_DESCRIPTION', $data->description);
            EnvFacades::setValue('APP_LOCAL', $data->language);

            EnvFacades::setValue('TICKET_DEPARTMENT', $data->department);
            EnvFacades::setValue('TICKET_NAME', $data->ticket_name);
            EnvFacades::setValue('TICKET_WORKSHEET', $data->ticket_worksheet);
            EnvFacades::setValue('TICKET_SCHEDULE', $data->ticket_schedule);
            EnvFacades::setValue('TICKET_TOPIC', $data->ticket_topic);
            EnvFacades::setValue('WA_ADMIN', $data->wa_admin);
            EnvFacades::setValue('WA_KEY', $data->wa_key);
            EnvFacades::setValue('WA_DEVICE', $data->wa_device);

            if ($data->has('file_logo')) {
                $file_logo = $data->file('file_logo');
                $extension = $file_logo->getClientOriginalExtension();
                $name = 'logo.' . $extension;
                $file_logo->storeAs('/public/', $name);
                EnvFacades::setValue('APP_LOGO', $name);
            }

            if ($data->has('file_header')) {
                $file_header = $data->file('file_header');
                $extension = $file_header->getClientOriginalExtension();
                $name = 'header.' . $extension;
                $file_header->storeAs('/public/', $name);
                EnvFacades::setValue('APP_HEADER', $name);
            }

            if ($data->has('file_doc')) {
                $file_header = $data->file('file_doc');
                $extension = $file_header->getClientOriginalExtension();
                $name = 'doc.' . $extension;
                $file_header->storeAs('/public/', $name);
                EnvFacades::setValue('APP_DOC', $name);
            }

            Alert::create();

        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return $th->getMessage();
        }

        return $check;
    }
}
