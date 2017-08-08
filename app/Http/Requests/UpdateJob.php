<?php

namespace App\Http\Requests;

use App\Job;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateJob extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = Job::find($this->route('id'));
        return $this->user()->can('edit-job', $job);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'organization' => 'required',
            'city' => 'required',
            'state' => 'required',
            'document' => 'mimes:pdf|max:2000',
            //'image_url' => 'image|mimes:jpg,jpeg,png|max:2000',
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
            'title.required' => 'Title is a required field',
            'description.required' => 'Description is a required field',
            'organization.required' => 'Organization is a required field',
            'city.required' => 'City is a required field',
            'state.required' => 'State is a required field',
            'document.mimes' => 'Document must be a PDF',
            'image_url.required' => 'Image is a required field',
            'image_url.image' => 'File must be a valid image',
            'image_url.mimes' => 'Image must have file extension .jpg or .png',
        ];
    }
}
