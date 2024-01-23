<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'event_type_id' => 'required|exists:event_types,id',
            'url' => 'required|url',
            'start_date' => 'required|date_format:Y-m-d\TH:i|after_or_equal:'. now()->addHour(),
        ];
    }

    public function messages()
    {
        return [
            'start_date.date_format' => 'The start date does not match the format: ex. 2022-01-01T12:00',
            'start_date.after_or_equal' => 'You can not schedule an event in the past',
        ];
    }
}
