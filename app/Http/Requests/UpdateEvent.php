<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name'=>'nullable',
            'event_date'=>'nullable | date_format:Y-m-d',
            'event_date_end'=>'nullable|date_format:Y-m-d',
            'event_detail'=>'nullable',
            'event_time'=>'nullable',
            'views' => 'nullable'
        ];
    }
}
