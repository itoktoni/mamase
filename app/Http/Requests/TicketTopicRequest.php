<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TicketTopicRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'ticket_topic_name' => 'required|unique:ticket_topic',
        ];
    }
}
