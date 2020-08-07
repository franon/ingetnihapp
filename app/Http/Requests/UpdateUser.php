<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'name'=>'required',
            'email'=>'required|nullable',
            'role_id'=>'required|nullable',
            'phone_number'=>'required|nullable',
            'gender'=>'nullable|nullable',
            'jabatan' => 'required|nullable',
        ];
    }
}
