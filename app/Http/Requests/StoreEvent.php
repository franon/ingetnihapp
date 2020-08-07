<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name'=>'required',
            'event_date'=>'required | date_format:Y-m-d',
            'event_detail'=>'nullable',
            'event_date_end'=>'date_format:Y-m-d',
            'event_time'=>'nullable',
            'tag_id'=>'nullable',
            'views' => 'required',

        ];
    }
}
