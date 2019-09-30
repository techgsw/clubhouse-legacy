<?php

namespace App\Http\Requests\Organization;

use App\Organization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class Update extends FormRequest
{
    public function authorize()
    {
        $organization = Organization::find($this->route('id'));
        return $this->user()->can('edit-organization', $organization);
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
