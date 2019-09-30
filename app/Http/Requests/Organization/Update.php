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
            'name' => 'required',
            'line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'image_url' => 'mimes:jpg,jpeg,png,gif|max:1500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is a required field',
            'line1.required' => 'Address line 1 is a required field',
            'city.required' => 'City is a required field',
            'state.required' => 'State is a required field',
            'postal_code.required' => 'Postal Code is a required field',
            'country.required' => 'Country is a required field',
            'image_url.mimes' => 'Image must be a .jpg, .jpeg, .png or .gif file',
        ];
    }
}
