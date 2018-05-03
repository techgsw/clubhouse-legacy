<?php

namespace App\Http\Requests\League;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Store extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create-league');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is a required field',
            'code.required' => 'Name is a required field'
        ];
    }
}
