<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Update extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('edit-organization');
    }

    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is a required field'
        ];
    }
}
