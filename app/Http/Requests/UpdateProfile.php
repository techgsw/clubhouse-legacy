<?php

namespace App\Http\Requests;

use App\Profile;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = (int)$this->route('id');
        $user = User::find($id);
        return $this->user()->can('edit-profile', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::find($this->route('id'));
        return [
            'college_graduation_year' => 'nullable|integer',
            'college_gpa' => 'nullable|numeric',
            'headshot_url' => 'image|mimes:jpg,jpeg,png,gif|max:1500',
            'resume_url' => 'mimes:pdf,doc,docx|max:1500',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user')->ignore($user->id)
            ]
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
            'college_graduation_year.integer' => 'Please enter a valid year (and only the year) of your college graduation.',
            'college_gpa.numeric' => 'Please enter a number (only) for your college GPA.',
            'headshot_url.image' => 'Headshot must be a valid image.',
            'headshot_url.mimes' => 'Please upload a headshot that is a jpg, png, or gif.',
            'headshot_url.max' => 'Maximum allowed file size for a headshot image is 2MB.',
            'resume_url.mimes' => 'Resume is an invalid type. Please upload a valid PDF or DOC.',
            'resume_url.max' => 'Maximum allowed file size for a resume is 2MB.',
            'email.required' => 'E-mail is required',
            'email.email' => 'E-mail address must be valid',
            'email.unique' => 'Email is already taken'
        ];
    }
}
