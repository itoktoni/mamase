<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TicketSystemRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $this->merge([
            // 'content' => ''
        ]);
    }

    public function validation(): array
    {
        $validation = [
            'ticket_system_description' => 'required',
        ];

        if (env('TICKET_DEPARTMENT', true)) {
            $validation = array_merge($validation, [
                'ticket_system_department_id' => 'required',
            ]);
        }
        if (env('TICKET_TOPIC', true)) {
            $validation = array_merge($validation, [
                'ticket_system_topic_id' => 'required',
            ]);
        }
        if (env('TICKET_NAME', true)) {
            $validation = array_merge($validation, [
                'ticket_system_name' => 'required',
            ]);
        }

        return $validation;
    }
}
