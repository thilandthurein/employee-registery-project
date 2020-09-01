<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee_name' => 'required|max:100',
            'email' =>  'email:rfc,dns|unique:employees',
            'dob' => 'date_format:Y/m/d',
            'password' => 'required',
            'gender'=>'required'
        ];
    }
}
