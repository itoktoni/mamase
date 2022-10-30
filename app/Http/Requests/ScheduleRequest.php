<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    use ValidationTrait;

    public function validation() : array
    {
        return [
            'schedule_name' => 'required',
            'schedule_description' => 'required',
            'schedule_every' => 'required',
            'schedule_start_date' => 'required',
            'schedule_number' => 'required',
        ];
    }
}
