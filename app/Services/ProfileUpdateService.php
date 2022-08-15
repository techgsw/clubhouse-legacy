<?php

namespace App\Services;

use App\Http\Requests\UpdateProfile;
use App\Message;
use App\Profile;
use App\Providers\ImageServiceProvider;
use App\Providers\MailchimpServiceProvider;
use App\State;
use App\TagType;
use App\User;
use Exception;
use Illuminate\Support\Facades\Log;

class ProfileUpdateService
{
    /**
     * @param UpdateProfile $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function update(UpdateProfile $request, User $user)
    {
        $profile = $user->profile;
        if (!$profile) {
            return abort(404);
        }
        $address = $user->profile->address[0];
        if (!$address) {
            return abort(404);
        }
        $contact = $user->contact;
        if (!$contact) {
            return abort(404);
        }

        $image_error = false;
        try {
            if ($headshot = request()->file('headshot_url')) {
                $image = ImageServiceProvider::saveFileAsImage(
                    $headshot,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $user->first_name.'-'.$user->last_name)).'-SportsBusinessSolutions',
                    $directory = 'headshot/'.$user->id,
                    $options = [
                        'cropFromCenter' => true,
                        'update' => $profile->headshotImage ?: null
                    ]
                );

                $profile->headshot_image_id = $image->id;
                $profile->save();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $image_error = true;
        }

        try {
            $resume = request()->file('resume_url');
            if ($resume) {
                $r = $resume->store('resume', 'public');
            } else {
                $r = null;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        // Only allow users to change email to one that is not being used by another user
        $email = request('email');
        $user->email = $email;
        if (!is_null(request('first_name')) && request('first_name') !== '') {
            $user->first_name = request('first_name');
        }
        if (!is_null(request('last_name')) && request('last_name') !== '') {
            $user->last_name = request('last_name');
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return $this->processError($request,
                'There was an error saving your profile. Please check your submission and try again.',
                'warning',
                'warning',
                true
            );
        }

        $profile->secondary_email = request('secondary_email');

        $profile->phone = request('phone')
            ? preg_replace("/[^\d]/", "", request('phone'))
            : null;
        $profile->secondary_phone = request('secondary_phone')
            ? preg_replace("/[^\d]/", "", request('secondary_phone'))
            : null;
        $profile->linkedin = request('linkedin');
        $profile->resume_url = $r ?: $profile->resume_url;

        // Personal Information
        $birthday = new \DateTime(request('date_of_birth'));
        $profile->date_of_birth = $birthday->format('Y-m-d');
        $profile->ethnicity = request('ethnicity');
        $profile->gender = request('gender');

        // Address
        $this->setProfileAddress($address);

        // Job-seeking status
        $this->setJobSeekingStatus($profile);
        // Experience
        $this->setDepartmentExperience($profile);

        // Employment history
        $this->setEmploymentHistory($profile);

        // Education history
        $this->setEducationHistory($profile);

        // Email preferences
        $mailchimp_error = $this->setEmailPrefernces($profile, $request);

        // Timestamp(s)
        $profile->updated_at = new \DateTime('NOW');

        $profile_update_error = false;
        try {
            $profile->save();
        } catch (\Exception $e) {
            $profile_update_error = true;
            Log::error($e->getMessage());
        }

        // Contact
        $contact_error = $this->setContactInformation($contact);

        // Address
        $address_save_error = $this->setContactAddress($contact);

        switch (true) {
            case $address_save_error:
            case $contact_error:
                return $this->processError($request,
                    'There was an error saving your address. Please check your submission and try again.',
                    'warning',
                    'warning',
                    true
                );
            case $profile_update_error:
                return $this->processError($request,
                    'There was an error saving your profile. Please check your submission and try again.',
                    'warning',
                    'warning',
                    true
                );
            case $image_error:
                $this->processError($request,
                    'Sorry, your profile image failed to upload. Please try a different image.',
                    'danger',
                    'error'
                );
                break;
            case $mailchimp_error:
                $this->processError($request,
                    'We were unable to update your newsletter preferences. Please try again or contact ' . __('email.info_address') . ' for assistance.',
                    'warning',
                    'warning'
                );
                break;
            default:
                $request->session()->flash('message', new Message(
                    "Profile saved",
                    "success",
                    $code = null,
                    $icon = "check_circle"
                ));
                break;
        }

        return redirect()->action('ProfileController@edit', [$user]);
    }

    /**
     * @param UpdateProfile $request
     * @param $message
     * @param $type
     * @param $icon
     * @param false $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function processError(UpdateProfile $request, $message, $type, $icon, $redirect = false)
    {
        $request->session()->flash('message', new Message(
            $message,
            $type,
            null,
            $icon
        ));

        if ($redirect) {
            return redirect()->back()->withInput();
        }
    }

    protected function setCountry($state, $country)
    {
        $state = State::where('abbrev', $state)->first();

        if ($country && ! $state) {
            return $country;
        }

        return $state ? $state->country : '';
    }

    protected function setDepartmentExperience(Profile $profile)
    {
        collect(Profile::getExperienceDepartments())->each(function ($label, $key) use ($profile) {
            $profile->$key = (bool)request($key);
        });
    }

    protected function setJobSeekingStatus(Profile $profile)
    {
        $profile->job_seeking_status = request('job_seeking_status');
        $profile->job_seeking_type = request('job_seeking_type');
        $profile->job_seeking_region = request('job_seeking_region');
        $profile->job_factors_money = request('job_factors_money') ? true : false;
        $profile->job_seeking_income = request('job_seeking_income');
        $profile->job_factors_title = request('job_factors_title') ? true : false;
        $profile->job_seeking_title = request('job_seeking_title');
        $profile->job_factors_location = request('job_factors_location') ? true : false;
        $profile->job_factors_organization = request('job_factors_organization') ? true : false;
        $profile->job_seeking_organizations = request('job_seeking_organizations');
        $profile->job_factors_other = request('job_factors_other');

    }

    /**
     * @param $profile
     */
    protected function setEmploymentHistory($profile)
    {
        $profile->works_in_sports = request('works_in_sports') ? true : false;
        $profile->current_organization = request('current_organization');
        $profile->current_title = request('current_title');
        $profile->current_region = request('current_region');
        $profile->current_organization_years = request('current_organization_years');
        $profile->current_title_years = request('current_title_years');
    }

    /**
     * @param $profile
     */
    protected function setEducationHistory($profile)
    {
        $profile->education_level = request('education_level');
        $profile->college_name = request('college_name');
        $profile->college_graduation_year = request('college_graduation_year');
        $profile->college_gpa = request('college_gpa');
        $profile->college_organizations = request('college_organizations');
        $profile->college_sports_clubs = request('college_sports_clubs');
        $profile->has_school_plans = request('has_school_plans');
    }

    /**
     * @param $profile
     * @param UpdateProfile $request
     * @return bool
     */
    protected function setEmailPrefernces($profile, UpdateProfile $request)
    {
        $profile->email_preference_new_content_webinars = request('email_preference_new_content_webinars') ? true : false;
        $profile->email_preference_new_content_blogs = request('email_preference_new_content_blogs') ? true : false;
        $profile->email_preference_new_content_mentors = request('email_preference_new_content_mentors') ? true : false;
        $profile->email_preference_new_content_training_videos = request('email_preference_new_content_training_videos') ? true : false;
        $profile->email_preference_new_job = request('email_preference_new_job_opt_out') ? false : true;
        $profile->email_preference_marketing = request('email_preference_marketing_opt_out') ? false : true;
        $email_preference_tag_type_ids = [];

        foreach ($request->all() as $key => $datum) {
            if (strpos($key, 'email_preference_job_') !== false && $datum) {
                try {
                    $tag_type_id = intval(explode('email_preference_job_', $key)[1]);
                    if (TagType::find($tag_type_id) !== null) {
                        $email_preference_tag_type_ids[] = $tag_type_id;
                    }
                } catch (\Throwable $t) {
                    Log::error($t);
                }
            }
        }
        $profile->emailPreferenceTagTypes()->sync($email_preference_tag_type_ids);

        // Mailchimp newsletter email preference
        $mailchimp_error = false;
        try {
            if (!request('email_preference_newsletter_opt_out') && is_null($profile->user->mailchimp_subscriber_hash)) {
                MailchimpServiceProvider::addToMailchimp($profile->user);
            } else if (request('email_preference_newsletter_opt_out') && !is_null($profile->user->mailchimp_subscriber_hash)) {
                MailchimpServiceProvider::deleteFromMailchimp($profile->user);
            }
        } catch (\Throwable $t) {
            Log::error($t->getMessage());
            $mailchimp_error = true;
        }

        return $mailchimp_error;
    }

    /**
     * @param $contact
     */
    protected function setContactInformation($contact)
    {
        // Fill in fields if they are not set
        if (is_null($contact->phone)) {
            $contact->phone = request('phone')
                ? preg_replace("/[^\d]/", "", request('phone'))
                : null;
        }
        if (is_null($contact->secondary_phone)) {
            $contact->secondary_phone = request('secondary_phone')
                ? preg_replace("/[^\d]/", "", request('secondary_phone'))
                : null;
        }
        if (is_null($contact->secondary_email)) {
            $contact->secondary_email = request('secondary_email');
        }
        if (is_null($contact->title)) {
            $contact->title = request('current_title');
        }
        if (is_null($contact->organization)) {
            $contact->organization = request('current_organization');
        }
        if (is_null($contact->job_seeking_type)) {
            $contact->job_seeking_type = request('job_seeking_type');
        }
        if (is_null($contact->job_seeking_status)) {
            $contact->job_seeking_status = request('job_seeking_status');
        }
        try {
            $contact->save();
        } catch (\Exception $e) {
            // return $contact_error
            return true;
        }

        return false;
    }

    /**
     * @param $contact
     */
    protected function setContactAddress($contact)
    {
        if (is_null($contact->address[0]->line1)) {
            $contact->address[0]->line1 = request('line1');
        }
        if (is_null($contact->address[0]->line2)) {
            $contact->address[0]->line2 = request('line2');
        }
        if (is_null($contact->address[0]->city)) {
            $contact->address[0]->city = request('city');
        }
        if (is_null($contact->address[0]->state)) {
            $contact->address[0]->state = request('state');
        }
        if (is_null($contact->address[0]->postal_code)) {
            $contact->address[0]->postal_code = request('postal_code');
        }
        if (is_null($contact->address[0]->country)) {
            $contact->address[0]->country = request('country');
        }

        try {
            $contact->address[0]->save();
        } catch (\Exception $e) {
            // return $address_save_error
            return true;
        }

        return false;
    }

    /**
     * @param $address
     */
    protected function setProfileAddress($address)
    {
        $address->line1 = request('line1');
        $address->line2 = request('line2');
        $address->city = request('city');
        $address->state = request('state');
        $address->postal_code = request('postal_code');
        $address->country = $this->setCountry(request('state'), request('country'));
        $address->updated_at = new \DateTime('NOW');
        $address->save();
    }
}
