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
            //'city' => 'required',
            //'state' => 'required',
            'document' => 'mimes:pdf|max:2000',
            'external_job_link' => 'nullable|url',
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
            'city.required' => 'City is a required field',
            'state.required' => 'State is a required field',
            'document.mimes' => 'Document must be a PDF',
            'image_url.required' => 'Image is a required field',
            'image_url.image' => 'Image must be a valid image',
            'external_job_link.url' => 'External job link must be a valid URL or blank. (Make sure it starts with http:// or https://)',
        ];
    }
}
