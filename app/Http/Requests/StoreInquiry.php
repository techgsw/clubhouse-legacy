<?php

namespace App\Http\Requests;

use App\Inquiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreInquiry extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create-inquiry');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'resume' => 'required|mimes:pdf,doc,docx,odt,ott|max:2000',
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
            'name.required' => 'Name is a required field',
            'email.required' => 'Email address is a required field',
            'resume.required' => 'Resume is a required field',
            'resume.mimes' => 'Resume must be a PDF or Word Doc',
        ];
    }
}
