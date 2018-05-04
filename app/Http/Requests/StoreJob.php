<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreJob extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create-job');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'organization_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'organization' => 'required',
            'city' => 'required',
            'state' => 'required',
            'document' => 'mimes:pdf|max:2000',
            // TODO 'image_url' => 'required|image|mimes:jpg,jpeg,png|max:2000',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'organization_id.required' => 'Organization is required',
            'title.required' => 'Title is a required field',
            'description.required' => 'Description is a required field',
            'organization.required' => 'Organization is a required field',
            'city.required' => 'City is a required field',
            'state.required' => 'State is a required field',
            'document.mimes' => 'Document must be a PDF',
            'image_url.required' => 'Image is a required field',
            'image_url.image' => 'Image must be a valid image',
        ];
    }
}
