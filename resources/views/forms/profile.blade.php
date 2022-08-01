<form id="edit-profile" method="post" action="/user/{{ $user->id }}/profile" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m4 l3 center-align">
            @if ($profile->headshotImage)
                <img src={{ $profile->headshotImage->getURL('medium') }} style="width: 80%; max-width: 150px; border-radius: 50%;" />
            @else
                <i class="material-icons large">person</i>
            @endif
            <div class="row">
                <div class="col s12 center-align">
                    <div class="file-field input-field very-small">
                        <div class="btn white black-text">
                            <span>Edit<span class="hide-on-small-only"> Headshot</span></span>
                            <input type="file" name="headshot_url" value="{{ old('headshot_url') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="headshot_url_text" value="{{ old('headshot_url_text') }}">
                        </div>
                        <span for="headshot_url" class="filesize-error sbs-red-text hidden">Files cannot be larger than 1.5MB</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m8 l9">
            <div class="row">
                <div class="input-field col s12 m6 {{ $errors->has('email') ? 'invalid' : '' }}">
                    <input id="email" name="email" type="text" value="{{ $user->email }}">
                    <label for="email" class="active">Email <span class="sbs-red-text">*</span></label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="phone" type="text" name="phone" value="{{ old('phone') ?: $profile->phone ?: "" }}"/>
                    <label for="phone">Phone <span class="sbs-red-text">*</span></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 {{ $errors->has('secondary_email') ? 'invalid' : '' }}">
                    <input id="secondary_email" name="secondary_email" type="text" value="{{ $profile->secondary_email }}">
                    <label for="secondary_email" class="active">Secondary Email</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="secondary_phone" type="text" name="secondary_phone" value="{{ old('secondary_phone') ?: $profile->secondary_phone ?: "" }}" />
                    <label for="secondary_phone">Secondary Phone</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 {{ $errors->has('linkedin') ? 'invalid' : '' }}">
                    <input id="linkedin" name="linkedin" type="text" value="{{ $profile->linkedin }}">
                    <label for="linkedin" class="active" style="width: 95%">
			LinkedIn Profile URL
                	@if (!$profile->linkedin)
                	    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                	@endif
		    </label>
                </div>
                <div class="input-field col s12 m6">
			&nbsp;
                </div>
            </div>
            <div class="row">
                <div class="file-field input-field col s12 m4">
                    @if ($profile->resume_url)
                        <a href="{{ Storage::disk('local')->url($profile->resume_url) }}" class="btn sbs-red white-text" style="width: 100%">View Resume</a>
                    @else
                        <a href="#" class="btn disabled">No Resume</a>
                    @endif
                </div>
                <div class="col s12 m8">
                    <div class="file-field input-field">
                        <div class="btn white black-text">
                            <span>Upload<span class="hide-on-small-only"> Resume</span></span>
                            <input type="file" name="resume_url" value="{{ old('resume_url') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="resume_url_text" value="{{ old('resume_url_text') }}">
                        </div>
                        <span for="resume_url" class="filesize-error sbs-red-text hidden">Files cannot be larger than 1.5MB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card blue lighten-4 blue-text text-darken-4">
                <div class="card-content">
                    <p style="font-size: 16px; font-weight: 300;">Complete your profile so we can get you more of the information you want and keep you in mind for future jobs and events in sports.</p>
                </div>
            </div>
        </div>
    </div>
    <ul class="collapsible" data-collapsible="accordion">
        <li class="form-section"> <!-- Personal Information -->
            <div class="collapsible-header">
                <i class="material-icons">person</i>Personal Information
                @if ($profile->isPersonalComplete())
                    <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                @else
                    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                @endif
                <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
                        <input id="first_name" name="first_name" type="text" value="{{ $user->first_name}}">
                        <label for="first_name" class="active">First Name</label>
                    </div>
                    <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
                        <input id="last_name" name="last_name" type="text" value="{{ $user->last_name}}">
                        <label for="last_name" class="active">Last Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        @php
                            $dob = old('date_of_birth') ?: $profile->date_of_birth ?: "";
                            if ($dob != "") {
                                $dob = new \DateTime($dob);
                                $dob = $dob->format("j F, Y");
                            }
                        @endphp
                        <input class="datepicker" default-year="1985" default-month="01" default-day="01" id="date-of-birth" type="text" name="date_of_birth" value="{{ $dob }}" />
                        <label for="date-of-birth">Date of birth</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="gender">
                            <option value="" {{ is_null(old('gender')) ? ($profile->gender == "" ? "selected" : "") : (old("gender") == "" ? "selected" : "") }} disabled>Please select</option>
                            @foreach(App\Profile::getGenders() as $gender => $label)
                                <option value="{{ $gender }}" {{ is_null(old('gender')) ? ($profile->gender == $gender ? "selected" : "") : (old("gender") == $gender ? "selected" : "") }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="ethnicity">
                            <option value="" {{ is_null(old('ethnicity')) ? ($profile->ethnicity == "" ? "selected" : "") : (old("ethnicity") == "" ? "selected" : "") }} disabled>Please select</option>
                            @foreach(App\Profile::getEthnicities() as $ethnicity => $label)
                                <option value="{{ $ethnicity }}" {{ is_null(old('ethnicity')) ? ($profile->ethnicity == $ethnicity ? "selected" : "") : (old("ethnicity") == $ethnicity ? "selected" : "") }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-section"> <!-- Address -->
            <div class="collapsible-header">
                <i class="material-icons">home</i>Address
                @if ($profile->isAddressComplete())
                    <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                @else
                    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                @endif
                <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="line1" name="line1" type="text" value="{{ old('line1') ?: $address->line1 ?: "" }}">
                        <label for="line1">Line 1</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="line2" name="line2" type="text" value="{{ old('line2') ?: $address->line2 ?: "" }}">
                        <label for="line2">Line 2</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="city" name="city" type="text" value="{{ old('city') ?: $address->city ?: "" }}">
                        <label for="city">City <span class="sbs-red-text">*</span></label>
                    </div>
                    <div class="input-field col s12 m2">
                        <label for="state" class="active">State/Province <span class="sbs-red-text">*</span></label>
                        <select class="statesDropdown form-control" name="state">
                            @if ($address->state)
                                <option value="{{ $address->state }}" selected>{{ $address->state }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="input-field col s12 m3">
                        <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') ?: $address->postal_code ?: "" }}">
                        <label for="postal_code">Postal code</label>
                    </div>
                    <div class="input-field col s12 m3">
                        <input id="country" name="country" type="text" value="{{ old('country') ?: $address->country ?: "" }}">
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="container mt-3">

                </div>

            </div>
        </li>
        <li class="form-section"> <!-- Job-seeking Preferences -->
            <div class="collapsible-header">
                <i class="material-icons">settings</i>Job-seeking Preferences
                @if ($profile->isJobPreferencesComplete())
                    <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                @else
                    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                @endif
                <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">Job title seeking <span class="sbs-red-text">*</span></label>
                        <select class="browser-default" name="job_seeking_type">
                            <option value="" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "" ? "selected" : "") : (old("job_seeking_type") == "" ? "selected" : "") }} disabled>Please select</option>
                            @foreach(App\Profile::getJobSeekingTypes() as $type => $label)
                                <option value="{{ $type }}" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == $type ? "selected" : "") : (old("job_seeking_type") == $type ? "selected" : "") }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">Which region are you most interested in working in?</label>
                        <select class="browser-default" name="job_seeking_region">
                            <option value="" {{ is_null(old('job_seeking_region')) ? ($profile->job_seeking_region == "" ? "selected" : "") : (old("job_seeking_region") == "" ? "selected" : "") }} disabled>Please select</option>
                            @foreach(App\Profile::getJobSeekingRegions() as $region => $label)
                                <option value="{{ $region }}" {{ is_null(old('job_seeking_region')) ? ($profile->job_seeking_type == $region ? "selected" : "") : (old("job_seeking_type") == $region ? "selected" : "") }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>What departments are you most interested in? <i>We use these to send you notification about new job postings. To opt out, check your Email Preferences below</i></p>
                    </div>
                    @foreach($job_tags as $tag)
                        <div class="input-field col s12 m6 l4">
                            <input id="email_preference_job_{{$tag->id}}" type="checkbox" name="email_preference_job_{{$tag->id}}" value="1" {{ $profile->emailPreferenceTagTypes->contains('id', $tag->id) ? "checked" : "" }} />
                            <label for="email_preference_job_{{$tag->id}}">{{$tag->tag_name}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>When making a decision on your next job in sports which of the following are most important?</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input class="sbs-toggle-group" sbs-toggle-group="job_factors_money" type="checkbox" name="job_factors_money" id="job_factors_money" value="1" {{ is_null(old('job_factors_money')) ? ($profile->job_factors_money ? "checked" : "") : (old('job_factors_money') ? "checked" : "") }} />
                                <label for="job_factors_money">Money</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input class="sbs-toggle-group" sbs-toggle-group="job_factors_title" type="checkbox" name="job_factors_title" id="job_factors_title" value="1" {{ is_null(old('job_factors_title')) ? ($profile->job_factors_title ? "checked" : "") : (old('job_factors_title') ? "checked" : "") }} />
                                <label for="job_factors_title">Title</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="job_factors_location" id="job_factors_location" value="1" {{ is_null(old('job_factors_location')) ? ($profile->job_factors_location ? "checked" : "") : (old('job_factors_location') ? "checked" : "") }} />
                                <label for="job_factors_location">Location</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input class="sbs-toggle-group" sbs-toggle-group="job_factors_organization" type="checkbox" name="job_factors_organization" id="job_factors_organization" value="1" {{ is_null(old('job_factors_organization')) ? ($profile->job_factors_organization ? "checked" : "") : (old('job_factors_organization') ? "checked" : "") }} />
                                <label for="job_factors_organization">Organization</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="job_factors_benefits" id="job_factors_benefits" value="1" {{ is_null(old('job_factors_benefits')) ? ($profile->job_factors_benefits ? "checked" : "") : (old('job_factors_benefits') ? "checked" : "") }} />
                                <label for="job_factors_benefits">Benefits</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="text" name="job_factors_other" value="{{ old('job_factors_other') ?: $profile->job_factors_other ?: '' }}" />
                                <label for="job_factors_other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div sbs-group="job_factors_money" class="row {{ is_null(old('job_factors_money')) ? ($profile->job_factors_money ? "" : "hidden") : (old('job_factors_money') ? "" : "hidden") }}">
                    <div class="col s12">
                        <p><i>Because you answered, "Money is an important factor":</i></p>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="job_seeking_income" {{ is_null(old('job_factors_money')) ? ($profile->job_factors_money ? "" : "disabled") : (old('job_factors_money') ? "" : "disabled") }}>
                            <option value="" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "" ? "selected" : "") : (old("job_seeking_income") == "" ? "selected" : "") }} disabled>What is your desired annual income?</option>
                            <option value="below_30" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "below_30" ? "selected" : "") : (old("job_seeking_income") == "below_30" ? "selected" : "") }}>Below $30,000</option>
                            <option value="30_to_50" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "30_to_50" ? "selected" : "") : (old("job_seeking_income") == "30_to_50" ? "selected" : "") }}>$30,000 to $50,000</option>
                            <option value="50_to_80" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "50_to_80" ? "selected" : "") : (old("job_seeking_income") == "nw" ? "selected" : "") }}>$50,000 to $80,000</option>
                            <option value="80_to_120" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "80_to_120" ? "selected" : "") : (old("job_seeking_income") == "80_to_120" ? "selected" : "") }}>$80,000 to $120,000</option>
                            <option value="120_above" {{ is_null(old('job_seeking_income')) ? ($profile->job_seeking_income == "120_above" ? "selected" : "") : (old("job_seeking_salary") == "120_above" ? "selected" : "") }}>Greater than $120,000</option>
                        </select>
                    </div>
                </div>
                <div sbs-group="job_factors_title" class="row {{ is_null(old('job_factors_title')) ? ($profile->job_factors_title ? "" : "hidden") : (old('job_factors_title') ? "" : "hidden") }}">
                    <div class="col s12">
                        <p><i>Because you answered, "Title is an important factor":</i></p>
                    </div>
                    <div class="input-field col s12">
                        <input id="job_seeking_title" type="text" name="job_seeking_title" value="{{ old('job_seeking_title') ?: $profile->job_seeking_title ?: null }}" {{ is_null(old('job_factors_title')) ? ($profile->job_factors_title ? "" : "disabled") : (old('job_factors_title') ? "" : "disabled") }}>
                        <label for="job_seeking_title">What is your desired title?</label>
                    </div>
                </div>
                <div sbs-group="job_factors_organization" class="row {{ is_null(old('job_factors_organization')) ? ($profile->job_factors_organization ? "" : "hidden") : (old('job_factors_organization') ? "" : "hidden") }}">
                    <div class="col s12">
                        <p><i>Because you answered, "Organization is an important factor":</i></p>
                    </div>
                    <div class="input-field col s12">
                        <input id="job_seeking_organizations" type="text" name="job_seeking_organizations" value="{{ old('job_seeking_organizations') ?: $profile->job_seeking_organizations ?: null }}" {{ is_null(old('job_factors_organization')) ? ($profile->job_factors_organization ? "" : "disabled") : (old('job_factors_organization') ? "" : "disabled") }}>
                        <label for="job_seeking_organizations">Which organization(s) interest you most?</label>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-section"> <!-- Employment History -->
            <div class="collapsible-header">
                <i class="material-icons">work</i>Employment History
                @if ($profile->isEmploymentComplete())
                    <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                @else
                    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                @endif
                <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <p>Do you currently work in sports?</p>
                        <p>
                          <input name="works_in_sports" id="works_in_sports_yes" type="radio" value="1" {{ is_null(old('works_in_sports')) ? ($profile->works_in_sports ? "checked" : "") : (old('works_in_sports') ? "checked" : "") }} />
                          <label for="works_in_sports_yes">Yes</label>
                        </p>
                        <p>
                          <input name="works_in_sports" id="works_in_sports_no" type="radio" value="0" {{ is_null(old('works_in_sports')) ? ($profile->works_in_sports ? "" : "checked") : (old('works_in_sports') ? "" : "checked") }} />
                          <label for="works_in_sports_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="current_organization" class="organization-autocomplete" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}" />
                        <label for="current_organization">What organization do you currently work for?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">How many years have you been with your current organization?</label>
                        <select class="browser-default" name="current_organization_years">
                            <option value="" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "" ? "selected" : "") : (old("current_organization_years") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="less_1" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "less_1" ? "selected" : "") : (old("current_organization_years") == "less_1" ? "selected" : "") }}>Less than 1 year</option>
                            <option value="1_to_3" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "1_to_3" ? "selected" : "") : (old("current_organization_years") == "1_to_3" ? "selected" : "") }}>1-3 years</option>
                            <option value="3_to_6" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "3_to_6" ? "selected" : "") : (old("current_organization_years") == "3_to_6" ? "selected" : "") }}>3-6 years</option>
                            <option value="6_more" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "6_more" ? "selected" : "") : (old("current_organization_years") == "6_more" ? "selected" : "") }}>6 or more years</option>
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <input id="current_title" type="text" name="current_title" value="{{ old('current_title') ?: $profile->current_title ?: null }}" />
                        <label for="current_title">What is your title?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">How many years have you had your current title?</label>
                        <select class="browser-default" name="current_title_years">
                            <option value="" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "" ? "selected" : "") : (old("current_title_years") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="less_1" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "less_1" ? "selected" : "") : (old("current_title_years") == "less_1" ? "selected" : "") }}>Less than 1 year</option>
                            <option value="1_to_3" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "1_to_3" ? "selected" : "") : (old("current_title_years") == "1_to_3" ? "selected" : "") }}>1-3 years</option>
                            <option value="3_to_6" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "3_to_6" ? "selected" : "") : (old("current_title_years") == "3_to_6" ? "selected" : "") }}>3-6 years</option>
                            <option value="6_more" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "6_more" ? "selected" : "") : (old("current_title_years") == "6_more" ? "selected" : "") }}>6 or more years</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">Which region do you currently work in?</label>
                        <select class="browser-default" name="current_region">
                            <option value="" {{ is_null(old('current_region')) ? ($profile->current_region == "" ? "selected" : "") : (old("current_region") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="mw" {{ is_null(old('current_region')) ? ($profile->current_region == "mw" ? "selected" : "") : (old("current_region") == "mw" ? "selected" : "") }}>Midwest</option>
                            <option value="ne" {{ is_null(old('current_region')) ? ($profile->current_region == "ne" ? "selected" : "") : (old("current_region") == "ne" ? "selected" : "") }}>Northeast</option>
                            <option value="nw" {{ is_null(old('current_region')) ? ($profile->current_region == "nw" ? "selected" : "") : (old("current_region") == "nw" ? "selected" : "") }}>Northwest</option>
                            <option value="se" {{ is_null(old('current_region')) ? ($profile->current_region == "se" ? "selected" : "") : (old("current_region") == "se" ? "selected" : "") }}>Southeast</option>
                            <option value="sw" {{ is_null(old('current_region')) ? ($profile->current_region == "sw" ? "selected" : "") : (old("current_region") == "sw" ? "selected" : "") }}>Southwest</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>Which department(s) do you have experience in?</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_arena_ops" id="department_experience_arena_ops" value="1" {{ is_null(old('department_experience_arena_ops')) ? ($profile->department_experience_arena_ops ? "checked" : "") : (old('department_experience_arena_ops') ? "checked" : "") }} />
                                <label for="department_experience_arena_ops">Arena Operations</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_event_ops" id="department_experience_event_ops" value="1" {{ is_null(old('department_experience_event_ops')) ? ($profile->department_experience_event_ops ? "checked" : "") : (old('department_experience_event_ops') ? "checked" : "") }} />
                                <label for="department_experience_event_ops">Building & Event Operations</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_analytics" id="department_experience_analytics" value="1" {{ is_null(old('department_experience_analytics')) ? ($profile->department_experience_analytics ? "checked" : "") : (old('department_experience_analytics') ? "checked" : "") }} />
                                <label for="department_experience_analytics">Business Analytics, CRM & Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_pr" id="department_experience_pr" value="1" {{ is_null(old('department_experience_pr')) ? ($profile->department_experience_pr ? "checked" : "") : (old('department_experience_pr') ? "checked" : "") }} />
                                <label for="department_experience_pr">Communications/PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_cr" id="department_experience_cr" value="1" {{ is_null(old('department_experience_cr')) ? ($profile->department_experience_cr ? "checked" : "") : (old('department_experience_cr') ? "checked" : "") }} />
                                <label for="department_experience_cr">Community Relations</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_sponsorship_activation" id="department_experience_sponsorship_activation" value="1" {{ is_null(old('department_experience_sponsorship_activation')) ? ($profile->department_experience_sponsorship_activation ? "checked" : "") : (old('department_experience_sponsorship_activation') ? "checked" : "") }} />
                                <label for="department_experience_sponsorship_activation">Corporate Partnerships Sales & Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_database" id="department_experience_database" value="1" {{ is_null(old('department_experience_database')) ? ($profile->department_experience_database ? "checked" : "") : (old('department_experience_database') ? "checked" : "") }} />
                                <label for="department_experience_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_social_media" id="department_experience_social_media" value="1" {{ is_null(old('department_experience_social_media')) ? ($profile->department_experience_social_media ? "checked" : "") : (old('department_experience_social_media') ? "checked" : "") }} />
                                <label for="department_experience_social_media">Digital/Social Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_finance" id="department_experience_finance" value="1" {{ is_null(old('department_experience_finance')) ? ($profile->department_experience_finance ? "checked" : "") : (old('department_experience_finance') ? "checked" : "") }} />
                                <label for="department_experience_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_entertainment" id="department_experience_entertainment" value="1" {{ is_null(old('department_experience_entertainment')) ? ($profile->department_experience_entertainment ? "checked" : "") : (old('department_experience_entertainment') ? "checked" : "") }} />
                                <label for="department_experience_entertainment">Game Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_hr" id="department_experience_hr" value="1" {{ is_null(old('department_experience_hr')) ? ($profile->department_experience_hr ? "checked" : "") : (old('department_experience_hr') ? "checked" : "") }} />
                                <label for="department_experience_hr">Human Resources</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_legal" id="department_experience_legal" value="1" {{ is_null(old('department_experience_legal')) ? ($profile->department_experience_legal ? "checked" : "") : (old('department_experience_legal') ? "checked" : "") }} />
                                <label for="department_experience_legal">Legal Finance Accounting & IT</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_marketing" id="department_experience_marketing" value="1" {{ is_null(old('department_experience_marketing')) ? ($profile->department_experience_marketing ? "checked" : "") : (old('department_experience_marketing') ? "checked" : "") }} />
                                <label for="department_experience_marketing">Marketing, Digital, & Social Media"</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_player_ops" id="department_experience_player_ops" value="1" {{ is_null(old('department_experience_player_ops')) ? ($profile->department_experience_player_ops ? "checked" : "") : (old('department_experience_player_ops') ? "checked" : "") }} />
                                <label for="department_experience_player_ops">Player Operations</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_premium_sales" id="department_experience_premium_sales" value="1" {{ is_null(old('department_experience_premium_sales')) ? ($profile->department_experience_premium_sales ? "checked" : "") : (old('department_experience_premium_sales') ? "checked" : "") }} />
                                <label for="department_experience_premium_sales">Premium Sales & Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_service" id="department_experience_service" value="1" {{ is_null(old('department_experience_service')) ? ($profile->department_experience_service ? "checked" : "") : (old('department_experience_service') ? "checked" : "") }} />
                                <label for="department_experience_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_sponsorship_sales" id="department_experience_sponsorship_sales" value="1" {{ is_null(old('department_experience_sponsorship_sales')) ? ($profile->department_experience_sponsorship_sales ? "checked" : "") : (old('department_experience_sponsorship_sales') ? "checked" : "") }} />
                                <label for="department_experience_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_experience_ticket_sales" id="department_experience_ticket_sales" value="1" {{ is_null(old('department_experience_ticket_sales')) ? ($profile->department_experience_ticket_sales ? "checked" : "") : (old('department_experience_ticket_sales') ? "checked" : "") }} />
                                <label for="department_experience_ticket_sales">Ticket Sales & Service</label>
                            </div>
                            <div class="input-field col s12" style="margin-top: 1.5rem;">
                                <input type="text" name="department_experience_other" id="department_experience_other" value="{{ old('department_experience_other') ?: $profile->department_experience_other ?: '' }}" />
                                <label for="department_experience_other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="form-section"> <!-- Education History -->
            <div class="collapsible-header">
                <i class="material-icons">school</i>Educational History
                @if ($profile->isEducationComplete())
                    <span class="progress-icon progress-complete green-text text-darken-2" style="float: right;"><i class="material-icons">check_circle</i></span>
                @else
                    <span class="progress-icon progress-incomplete yellow-text text-darken-2" style="float: right;"><i class="material-icons">warning</i></span>
                @endif
                <span class="progress-icon progress-unsaved blue-text text-darken-2 hidden" style="float: right;"><i class="material-icons">save</i></span>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="col s12">
                        <label style="font-size: 14px; color: #000; font-weight: 300;">Which is your highest completed level of education?</label>
                        <select class="browser-default" name="education_level">
                            <option value="" {{ is_null(old('education_level')) ? ($profile->education_level == "" ? "selected" : "") : (old("education_level") == "" ? "selected" : "") }} disabled>Please select</option>
                            <option value="high_school" {{ is_null(old('education_level')) ? ($profile->education_level == "high_school" ? "selected" : "") : (old("education_level") == "high_school" ? "selected" : "") }}>High School</option>
                            <option value="associate" {{ is_null(old('education_level')) ? ($profile->education_level == "associate" ? "selected" : "") : (old("education_level") == "associate" ? "selected" : "") }}>Associate degree</option>
                            <option value="bachelor" {{ is_null(old('education_level')) ? ($profile->education_level == "bachelor" ? "selected" : "") : (old("education_level") == "bachelor" ? "selected" : "") }}>Bachelor's degree</option>
                            <option value="master" {{ is_null(old('education_level')) ? ($profile->education_level == "master" ? "selected" : "") : (old("education_level") == "master" ? "selected" : "") }}>Master's degree</option>
                            <option value="doctor" {{ is_null(old('education_level')) ? ($profile->education_level == "doctor" ? "selected" : "") : (old("education_level") == "doctor" ? "selected" : "") }}>Doctorate (PhD, MD, JD, etc.)</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('college') ? 'invalid' : '' }}">
                        <input id="college_name" type="text" name="college_name" value="{{ old('college_name') ?: $profile->college_name ?: null }}">
                        <label for="college_name">What college did/do you attend?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('graduation_year') ? 'invalid' : '' }}">
                        <input id="college_graduation_year" type="text" name="college_graduation_year" value="{{ old('college_graduation_year') ?: $profile->college_graduation_year ?: null }}">
                        <label for="college_graduation_year">What year did/will you graduate?</label>
                    </div>
                </div>
            </div>
        </li>
        <!-- Email preferences -->
        <li class="form-section">
            <div class="collapsible-header"><i class="material-icons">email</i>Email Preferences</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <p><strong>Clubhouse Introductions</strong> <i>(Get emails on how to make the most of your Clubhouse PRO experience)</i></p>
                        <input id="email_preference_marketing_opt_out" type="checkbox" name="email_preference_marketing_opt_out" value="1" {{(old('email_preference_marketing_opt_out') ?? $profile->email_preference_marketing) ? "" : "checked" }}/>
                        <label for="email_preference_marketing_opt_out"><strong>Opt out</strong> of all clubhouse introduction emails</label>
                    </div>
                    <div class="input-field col s12">
                        <p><strong>Weekly updates on new Clubhouse content</strong></p>
                        <input id="email_preference_new_content_all" type="checkbox" value="1" {{((old('email_preference_new_content_webinars') ?? $profile->email_preference_new_content_webinars) || (old('email_preference_new_content_blogs') ?? $profile->email_preference_new_content_blogs) || (old('email_preference_new_content_mentors') ?? $profile->email_preference_new_content_mentors)|| (old('email_preference_new_content_training_videos') ?? $profile->email_preference_new_content_training_videos)) ? "" : "checked" }}/>
                        <label for="email_preference_new_content_all"><strong>Opt out</strong> of the weekly new Clubhouse content emails</label>
                    </div>
                    <div class="input-field col s12">
                        <p>Or show me the following new content every week:
                            <input id="email_preference_new_content_webinars" type="checkbox" name="email_preference_new_content_webinars" value="1" {{ is_null(old('email_preference_new_content_webinars')) ? ($profile->email_preference_new_content_webinars ? "checked" : "") : (old('email_preference_new_content_webinars') ? "checked" : "") }} />
                            <label for="email_preference_new_content_webinars" style="margin:0px 10px;">Webinars</label>
                            <input id="email_preference_new_content_blogs" type="checkbox" name="email_preference_new_content_blogs" value="1" {{ is_null(old('email_preference_new_content_blogs')) ? ($profile->email_preference_new_content_blogs ? "checked" : "") : (old('email_preference_new_content_blogs') ? "checked" : "") }} />
                            <label for="email_preference_new_content_blogs" style="margin:0px 10px;">Blogs</label>
                            <input id="email_preference_new_content_mentors" type="checkbox" name="email_preference_new_content_mentors" value="1" {{ is_null(old('email_preference_new_content_mentors')) ? ($profile->email_preference_new_content_mentors ? "checked" : "") : (old('email_preference_new_content_mentors') ? "checked" : "") }} />
                            <label for="email_preference_new_content_mentors" style="margin:0px 10px;">Mentors</label>
                            <input id="email_preference_new_content_training_videos" type="checkbox" name="email_preference_new_content_training_videos" value="1" {{ is_null(old('email_preference_new_content_training_videos')) ? ($profile->email_preference_new_content_training_videos ? "checked" : "") : (old('email_preference_new_content_training_videos') ? "checked" : "") }} />
                            <label for="email_preference_new_content_training_videos" style="margin:0px 10px;">Sales Vault Videos</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <p><strong>New job posting emails</strong> <i>(If you'd like to change which jobs you get notifications for, update your Job-seeking Preferences above)</i></p>
                        <input id="email_preference_new_job_opt_out" type="checkbox" name="email_preference_new_job_opt_out" value="1" {{ is_null(old('email_preference_new_job_opt_out')) ? ($profile->email_preference_new_job ? "" : "checked") : (old('email_preference_new_job_opt_out') ? "checked" : "") }} />
                        <label for="email_preference_new_job_opt_out"><strong>Opt out</strong> of all new job posting emails</label>
                    </div>
                    <div class="input-field col s12">
                        <p><strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> newsletter</strong></p>
                        <input id="email_preference_newsletter_opt_out" type="checkbox" name="email_preference_newsletter_opt_out" value="1" {{ is_null(old('email_preference_newsletter_opt_out')) ? ($profile->user->mailchimp_subscriber_hash ? "" : "checked") : (old('email_preference_newsletter_opt_out') ? "checked" : "") }} />
                        <label for="email_preference_newsletter_opt_out"><strong>Opt out</strong> of receiving <span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> newsletter</label>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn sbs-red">Save profile</button>
        </div>
    </div>
</form>
