<form method="post" action="/user/{{ $user->id }}/profile" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m4 l3 center-align">
            @if ($profile->headshot_url)
                <img src={{ Storage::disk('local')->url($profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%;" />
            @else
                <i class="material-icons large">person</i>
            @endif
            <div class="row">
                <div class="col s12 center-align">
                    <div class="file-field input-field very-small">
                        <div class="btn white black-text">
                            <span>Edit</span>
                            <input type="file" name="headshot_url" value="{{ old('headshot_url') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="headshot_url_text" value="{{ old('headshot_url_text') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m8 l9">
            <div class="row">
                <div class="input-field col s12 m6">
                    <input id="email" disabled value="{{ $user->email }}" />
                    <label for="email" class="active">Email</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="phone" type="text" name="phone" value="{{ old('phone') ?: $profile->phone ?: "" }}" />
                    <label for="phone">Phone</label>
                </div>
            </div>
            <div class="row">
                <div class="file-field input-field col s12 m4">
                    @if ($profile->resume_url)
                        <a href="{{ Storage::disk('local')->url($profile->resume_url) }}" class="btn sbs-red white-text" style="width: 100%">View Resume</a>
                    @else
                        <a href="#" class="btn grey black-text disabled">No Resume</a>
                    @endif
                </div>
                <div class="col s12 m8">
                    <div class="file-field input-field">
                        <div class="btn white black-text">
                            <span>Upload</span>
                            <input type="file" name="resume_url" value="{{ old('resume_url') }}">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" name="resume_url_text" value="{{ old('resume_url_text') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="collapsible" data-collapsible="accordion">
        <li> <!-- Personal Information -->
            <div class="collapsible-header"><i class="material-icons">person</i>Personal Information</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        @php
                            $dob = old('date_of_birth') ?: $profile->date_of_birth ?: "";
                            if ($dob != "") {
                                $dob = new \DateTime($dob);
                                $dob = $dob->format("j F, Y");
                            }
                        @endphp
                        <input class="datepicker" id="date-of-birth" type="text" name="date_of_birth" value="{{ $dob }}" />
                        <label for="date-of-birth">Date of birth</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="gender">
                            <option value="" {{ old('gender') == "" ? "selected" : $profile->gender == "" ? "selected" : "" }} disabled>Gender</option>
                            <option value="female" {{ old('gender') == "female" ? "selected" : $profile->gender == "female" ? "selected" : "" }}>Female</option>
                            <option value="male" {{ old('gender') == "male" ? "selected" : $profile->gender == "male" ? "selected" : "" }}>Male</option>
                            <option value="non-binary" {{ old('gender') == "non-binary" ? "selected" : $profile->gender == "non-binary" ? "selected" : "" }}>Non-binary</option>
                            <option value="na" {{old('gender') == "na" ? 'selected' : $profile->gender == "na" ? 'selected' : '' }}>Prefer not to answer</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="ethnicity">
                            <option value="" {{old('ethnicity') == "" ? "selected" : "" }} disabled>Ethnicity</option>
                            <option value="asian" {{old('ethnicity') == "asian" ? 'selected' : $profile->ethnicity == "asian" ? 'selected' : '' }}>Asian or Pacific Islander</option>
                            <option value="black" {{old('ethnicity') == "black" ? 'selected' : $profile->ethnicity == "black" ? 'selected' : '' }}>Black or African American</option>
                            <option value="hispanic" {{old('ethnicity') == "hispanic" ? 'selected' : $profile->ethnicity == "hispanic" ? 'selected' : '' }}>Hispanic</option>
                            <option value="native" {{old('ethnicity') == "native" ? 'selected' : $profile->ethnicity == "native" ? 'selected' : '' }}>Native American</option>
                            <option value="white" {{old('ethnicity') == "white" ? 'selected' : $profile->ethnicity == "white" ? 'selected' : '' }}>White or Caucasian</option>
                            <option value="na" {{old('ethnicity') == "na" ? 'selected' : $profile->ethnicity == "na" ? 'selected' : '' }}>Prefer not to answer</option>
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li> <!-- Address -->
            <div class="collapsible-header"><i class="material-icons">home</i>Address</div>
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
                        <label for="city">City</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="state" name="state" type="text" value="{{ old('state') ?: $address->state ?: "" }}">
                        <label for="state">State/Province</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') ?: $address->postal_code ?: "" }}">
                        <label for="postal_code">Postal code</label>
                    </div>
                </div>
            </div>
        </li>
        <li> <!-- Job-seeking Preferences -->
            <div class="collapsible-header"><i class="material-icons">settings</i>Job-seeking Preferences</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="job_seeking_status">
                            <option value="" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "" ? "selected" : "") : (old("job_seeking_status") == "" ? "selected" : "") }} disabled>Job-seeking status</option>
                            <option value="unemployed" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "unemployed" ? "selected" : "") : (old("job_seeking_status") == "unemployed" ? "selected" : "") }}>Unemployed, actively seeking a new job</option>
                            <option value="employed_active" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "employed_active" ? "selected" : "") : (old("job_seeking_status") == "employed_active" ? "selected" : "") }}>Employed, actively seeking a new job</option>
                            <option value="employed_passive" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "employed_passive" ? "selected" : "") : (old("job_seeking_status") == "employed_passive" ? "selected" : "") }}>Employed, passively exploring new opportunities</option>
                            <option value="employed_future" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "employed_future" ? "selected" : "") : (old("job_seeking_status") == "employed_future" ? "selected" : "") }}>Employed, only open to future opportunities</option>
                            <option value="employed_not" {{ is_null(old('job_seeking_status')) ? ($profile->job_seeking_status == "employed_not" ? "selected" : "") : (old("job_seeking_status") == "employed_not" ? "selected" : "") }}>Employed, currently have my dream job</option>
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="job_seeking_type">
                            <option value="" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "" ? "selected" : "") : (old("job_seeking_type") == "" ? "selected" : "") }} disabled>Which type most closely fits your next goal?</option>
                            <option value="junior" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "junior" ? "selected" : "") : (old("job_seeking_type") == "junior" ? "selected" : "") }}>Junior-level</option>
                            <option value="senior" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "senior" ? "selected" : "") : (old("job_seeking_type") == "senior" ? "selected" : "") }}>Senior-level</option>
                            <option value="management" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "management" ? "selected" : "") : (old("job_seeking_type") == "management" ? "selected" : "") }}>Management</option>
                            <option value="executive" {{ is_null(old('job_seeking_type')) ? ($profile->job_seeking_type == "executive" ? "selected" : "") : (old("job_seeking_type") == "executive" ? "selected" : "") }}>Executive</option>
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="job_seeking_location">
                            <option value="" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "" ? "selected" : "") : (old("job_seeking_location") == "" ? "selected" : "") }} disabled>Which region are you most interested in working in?</option>
                            <option value="mw" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "mw" ? "selected" : "") : (old("job_seeking_location") == "mw" ? "selected" : "") }}>Midwest</option>
                            <option value="ne" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "ne" ? "selected" : "") : (old("job_seeking_location") == "ne" ? "selected" : "") }}>Northeast</option>
                            <option value="nw" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "nw" ? "selected" : "") : (old("job_seeking_location") == "nw" ? "selected" : "") }}>Northwest</option>
                            <option value="se" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "se" ? "selected" : "") : (old("job_seeking_location") == "se" ? "selected" : "") }}>Southeast</option>
                            <option value="sw" {{ is_null(old('job_seeking_location')) ? ($profile->job_seeking_location == "sw" ? "selected" : "") : (old("job_seeking_location") == "sw" ? "selected" : "") }}>Southwest</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_ticket_sales" id="department_goals_ticket_sales" value="1" {{ is_null(old('department_goals_ticket_sales')) ? ($profile->department_goals_ticket_sales ? "checked" : "") : (old('department_goals_ticket_sales') ? "checked" : "") }} />
                        <label for="department_goals_ticket_sales">Ticket Sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_sponsorship_sales" id="department_goals_sponsorship_sales" value="1" {{ is_null(old('department_goals_sponsorship_sales')) ? ($profile->department_goals_sponsorship_sales ? "checked" : "") : (old('department_goals_sponsorship_sales') ? "checked" : "") }} />
                        <label for="department_goals_sponsorship_sales">Sponsorship Sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_service" id="department_goals_service" value="1" {{ is_null(old('department_goals_service')) ? ($profile->department_goals_service ? "checked" : "") : (old('department_goals_service') ? "checked" : "") }} />
                        <label for="department_goals_service">Service</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_premium_sales" id="department_goals_premium_sales" value="1" {{ is_null(old('department_goals_premium_sales')) ? ($profile->department_goals_premium_sales ? "checked" : "") : (old('department_goals_premium_sales') ? "checked" : "") }} />
                        <label for="department_goals_premium_sales">Premium Sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_marketing" id="department_goals_marketing" value="1" {{ is_null(old('department_goals_marketing')) ? ($profile->department_goals_marketing ? "checked" : "") : (old('department_goals_marketing') ? "checked" : "") }} />
                        <label for="department_goals_marketing">Marketing</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_sponsorship_activation" id="department_goals_sponsorship_activation" value="1" {{ is_null(old('department_goals_sponsorship_activation')) ? ($profile->department_goals_sponsorship_activation ? "checked" : "") : (old('department_goals_sponsorship_activation') ? "checked" : "") }} />
                        <label for="department_goals_sponsorship_activation">Sponsorship Activation</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_hr" id="department_goals_hr" value="1" {{ is_null(old('department_goals_hr')) ? ($profile->department_goals_hr ? "checked" : "") : (old('department_goals_hr') ? "checked" : "") }} />
                        <label for="department_goals_hr">HR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_analytics" id="department_goals_analytics" value="1" {{ is_null(old('department_goals_analytics')) ? ($profile->department_goals_analytics ? "checked" : "") : (old('department_goals_analytics') ? "checked" : "") }} />
                        <label for="department_goals_analytics">Analytics</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_cr" id="department_goals_cr" value="1" {{ is_null(old('department_goals_cr')) ? ($profile->department_goals_cr ? "checked" : "") : (old('department_goals_cr') ? "checked" : "") }} />
                        <label for="department_goals_cr">CR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_pr" id="department_goals_pr" value="1" {{ is_null(old('department_goals_pr')) ? ($profile->department_goals_pr ? "checked" : "") : (old('department_goals_pr') ? "checked" : "") }} />
                        <label for="department_goals_pr">PR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_database" id="department_goals_database" value="1" {{ is_null(old('department_goals_database')) ? ($profile->department_goals_database ? "checked" : "") : (old('department_goals_database') ? "checked" : "") }} />
                        <label for="department_goals_database">Database</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_finance" id="department_goals_finance" value="1" {{ is_null(old('department_goals_finance')) ? ($profile->department_goals_finance ? "checked" : "") : (old('department_goals_finance') ? "checked" : "") }} />
                        <label for="department_goals_finance">Finance</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_arena_ops" id="department_goals_arena_ops" value="1" {{ is_null(old('department_goals_arena_ops')) ? ($profile->department_goals_arena_ops ? "checked" : "") : (old('department_goals_arena_ops') ? "checked" : "") }} />
                        <label for="department_goals_arena_ops">Arena Ops</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_player_ops" id="department_goals_player_ops" value="1" {{ is_null(old('department_goals_player_ops')) ? ($profile->department_goals_player_ops ? "checked" : "") : (old('department_goals_player_ops') ? "checked" : "") }} />
                        <label for="department_goals_player_ops">Player Ops</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_event_ops" id="department_goals_event_ops" value="1" {{ is_null(old('department_goals_event_ops')) ? ($profile->department_goals_event_ops ? "checked" : "") : (old('department_goals_event_ops') ? "checked" : "") }} />
                        <label for="department_goals_event_op">Event Ops</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_social_media" id="department_goals_social_media" value="1" {{ is_null(old('department_goals_social_media')) ? ($profile->department_goals_social_media ? "checked" : "") : (old('department_goals_social_media') ? "checked" : "") }} />
                        <label for="department_goals_social_media">Digital/Social Media</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_entertainment" id="department_goals_entertainment" value="1" {{ is_null(old('department_goals_entertainment')) ? ($profile->department_goals_entertainment ? "checked" : "") : (old('department_goals_entertainment') ? "checked" : "") }} />
                        <label for="department_goals_entertainment">Game Entertainment</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" name="department_goals_legal" id="department_goals_legal" value="1" {{ is_null(old('department_goals_legal')) ? ($profile->department_goals_legal ? "checked" : "") : (old('department_goals_legal') ? "checked" : "") }} />
                        <label for="department_goals_legal">Legal</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="text" name="department_goals_other" id="department_goals_other" value="{{ old('department_goals_other') ?: $profile->department_goals_other ?: '' }}" />
                        <label for="department_goals_other">Other</label>
                    </div>
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
        <li> <!-- Employment History -->
            <div class="collapsible-header"><i class="material-icons">work</i>Employment History</div>
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
                        <input id="current_organization" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}" />
                        <label for="current_organization">What organization do you currently work for?</label>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="current_organization_years">
                            <option value="" {{ is_null(old('current_organization_years')) ? ($profile->current_organization_years == "" ? "selected" : "") : (old("current_organization_years") == "" ? "selected" : "") }} disabled>How many years have you been with your current organization?</option>
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
                    <div class="input-field col s12">
                        <select class="browser-default" name="current_title_years">
                            <option value="" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "" ? "selected" : "") : (old("current_title_years") == "" ? "selected" : "") }} disabled>How many years have you had your current title?</option>
                            <option value="less_1" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "less_1" ? "selected" : "") : (old("current_title_years") == "less_1" ? "selected" : "") }}>Less than 1 year</option>
                            <option value="1_to_3" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "1_to_3" ? "selected" : "") : (old("current_title_years") == "1_to_3" ? "selected" : "") }}>1-3 years</option>
                            <option value="3_to_6" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "3_to_6" ? "selected" : "") : (old("current_title_years") == "3_to_6" ? "selected" : "") }}>3-6 years</option>
                            <option value="6_more" {{ is_null(old('current_title_years')) ? ($profile->current_title_years == "6_more" ? "selected" : "") : (old("current_title_years") == "6_more" ? "selected" : "") }}>6 or more years</option>
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="current_region">
                            <option value="" {{ is_null(old('current_region')) ? ($profile->current_region == "" ? "selected" : "") : (old("current_region") == "" ? "selected" : "") }} disabled>Which region do you currently work in?</option>
                            <option value="mw" {{ is_null(old('current_region')) ? ($profile->current_region == "mw" ? "selected" : "") : (old("current_region") == "mw" ? "selected" : "") }}>Midwest</option>
                            <option value="ne" {{ is_null(old('current_region')) ? ($profile->current_region == "ne" ? "selected" : "") : (old("current_region") == "ne" ? "selected" : "") }}>Northeast</option>
                            <option value="nw" {{ is_null(old('current_region')) ? ($profile->current_region == "nw" ? "selected" : "") : (old("current_region") == "nw" ? "selected" : "") }}>Northwest</option>
                            <option value="se" {{ is_null(old('current_region')) ? ($profile->current_region == "se" ? "selected" : "") : (old("current_region") == "se" ? "selected" : "") }}>Southeast</option>
                            <option value="sw" {{ is_null(old('current_region')) ? ($profile->current_region == "sw" ? "selected" : "") : (old("current_region") == "sw" ? "selected" : "") }}>Southwest</option>
                        </select>
                    </div>
                    <div class="col s12">
                        <p>Which department(s) do you have experience in?</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_ticket_sales" id="department_experience_ticket_sales" type="checkbox" {{ is_null(old('department_experience_ticket_sales')) ? ($profile->department_experience_ticket_sales ? "checked" : "") : (old('department_experience_ticket_sales') ? "checked" : "") }} value="1" />
                                <label for="department_experience_ticket_sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_sponsorship_sales" id="department_experience_sponsorship_sales" type="checkbox" {{ is_null(old('department_experience_sponsorship_sales')) ? ($profile->department_experience_sponsorship_sales ? "checked" : "") : (old('department_experience_sponsorship_sales') ? "checked" : "") }} value="1" />
                                <label for="department_experience_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_service" id="department_experience_service" type="checkbox" {{ is_null(old('department_experience_service')) ? ($profile->department_experience_service ? "checked" : "") : (old('department_experience_service') ? "checked" : "") }} value="1" />
                                <label for="department_experience_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_premium_sales" id="department_experience_premium_sales" type="checkbox" {{ is_null(old('department_experience_premium_sales')) ? ($profile->department_experience_premium_sales ? "checked" : "") : (old('department_experience_premium_sales') ? "checked" : "") }} value="1" />
                                <label for="department_experience_premium_sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_marketing" id="department_experience_marketing" type="checkbox" {{ is_null(old('department_experience_marketing')) ? ($profile->department_experience_marketing ? "checked" : "") : (old('department_experience_marketing') ? "checked" : "") }} value="1" />
                                <label for="department_experience_marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_sponsorship_activation" id="department_experience_sponsorship_activation" type="checkbox" {{ is_null(old('department_experience_sponsorship_activation')) ? ($profile->department_experience_sponsorship_activation ? "checked" : "") : (old('department_experience_sponsorship_activation') ? "checked" : "") }} value="1" />
                                <label for="department_experience_sponsorship_activation">Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_hr" id="department_experience_hr" type="checkbox" {{ is_null(old('department_experience_hr')) ? ($profile->department_experience_hr ? "checked" : "") : (old('department_experience_hr') ? "checked" : "") }} value="1" />
                                <label for="department_experience_hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_cr" id="department_experience_cr" type="checkbox" {{ is_null(old('department_experience_cr')) ? ($profile->department_experience_cr ? "checked" : "") : (old('department_experience_cr') ? "checked" : "") }} value="1" />
                                <label for="department_experience_cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_pr" id="department_experience_pr" type="checkbox" {{ is_null(old('department_experience_pr')) ? ($profile->department_experience_pr ? "checked" : "") : (old('department_experience_pr') ? "checked" : "") }} value="1" />
                                <label for="department_experience_pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_database" id="department_experience_database" type="checkbox" {{ is_null(old('department_experience_database')) ? ($profile->department_experience_database ? "checked" : "") : (old('department_experience_database') ? "checked" : "") }} value="1" />
                                <label for="department_experience_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_finance" id="department_experience_finance" type="checkbox" {{ is_null(old('department_experience_finance')) ? ($profile->department_experience_finance ? "checked" : "") : (old('department_experience_finance') ? "checked" : "") }} value="1" />
                                <label for="department_experience_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_arena_ops" id="department_experience_arena_ops" type="checkbox" {{ is_null(old('department_experience_arena_ops')) ? ($profile->department_experience_arena_ops ? "checked" : "") : (old('department_experience_arena_ops') ? "checked" : "") }} value="1" />
                                <label for="department_experience_arena_ops">Arena Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_player_ops" id="department_experience_player_ops" type="checkbox" {{ is_null(old('department_experience_player_ops')) ? ($profile->department_experience_player_ops ? "checked" : "") : (old('department_experience_player_ops') ? "checked" : "") }} value="1" />
                                <label for="department_experience_player_ops">Player Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_event_ops" id="department_experience_event_ops" type="checkbox" {{ is_null(old('department_experience_event_ops')) ? ($profile->department_experience_event_ops ? "checked" : "") : (old('department_experience_event_ops') ? "checked" : "") }} value="1" />
                                <label for="department_experience_event_ops">Event Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_social_media" id="department_experience_social_media" type="checkbox" {{ is_null(old('department_experience_social_media')) ? ($profile->department_experience_social_media ? "checked" : "") : (old('department_experience_social_media') ? "checked" : "") }} value="1" />
                                <label for="department_experience_social_media">Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_entertainment" id="department_experience_entertainment" type="checkbox" {{ is_null(old('department_experience_entertainment')) ? ($profile->department_experience_entertainment ? "checked" : "") : (old('department_experience_entertainment') ? "checked" : "") }} value="1" />
                                <label for="department_experience_entertainment">Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_legal" id="department_experience_legal" type="checkbox" {{ is_null(old('department_experience_legal')) ? ($profile->department_experience_legal ? "checked" : "") : (old('department_experience_legal') ? "checked" : "") }} value="1" />
                                <label for="department_experience_legal">Legal</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="department_experience_other" id="department_experience_other" type="text" value="{{ old('department_experience_other') ?: $profile->department_experience_other ?: '' }}" />
                                <label for="department_experience_other">Other</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li> <!-- Education History -->
            <div class="collapsible-header"><i class="material-icons">school</i>Educational History</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="education_level">
                            <option value="" {{ is_null(old('education_level')) ? ($profile->education_level == "" ? "selected" : "") : (old("education_level") == "" ? "selected" : "") }} disabled>Which is your highest completed level of education?</option>
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
                    <div class="input-field col s12 m6 {{ $errors->has('graduation_year') ? 'invalid' : '' }}">
                        <input id="college_graduation_year" type="text" name="college_graduation_year" value="{{ old('college_graduation_year') ?: $profile->college_graduation_year ?: null }}">
                        <label for="college_graduation_year">What year did/will you graduate?</label>
                    </div>
                    <div class="input-field col s12 m6 {{ $errors->has('gpa') ? 'invalid' : '' }}">
                        <input id="college_gpa" type="text" name="college_gpa" value="{{ old('college_gpa') }}">
                        <label for="college_gpa">What was/is your undergraduate GPA?</label>
                    </div>
                </div>
                <div class="input-field">
                    <textarea id="college_organizations" class="materialize-textarea" name="college_organizations">{{ old('college_organizations') ?: $profile->college_organizations ?: null }}</textarea>
                    <label for="college_organizations">What collegiate organizations did/do you belong to? List any leadership positions you held.</label>
                </div>
                <div class="input-field">
                    <textarea id="college_sports_clubs" class="materialize-textarea" name="college_sports_clubs">{{ old('college_sports_clubs') ?: $profile->college_sports_clubs ?: null }}</textarea>
                    <label for="college_sports_clubs">What sports business clubs or in your athletic department(s) were you involved in? List any leadership positions you held.</label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Do you plan to attend more school in the future?</p>
                        <p>
                          <input name="has_school_plans" id="has_school_plans_yes" type="radio" value="1" {{ is_null(old('has_school_plans')) ? ($profile->has_school_plans ? "checked" : "") : (old('has_school_plans') ? "checked" : "") }} />
                          <label for="has_school_plans_yes">Yes</label>
                        </p>
                        <p>
                          <input name="has_school_plans" id="has_school_plans_no" type="radio" value="0" {{ is_null(old('has_school_plans')) ? ($profile->has_school_plans ? "" : "checked") : (old('has_school_plans') ? "" : "checked") }} />
                          <label for="has_school_plans_no">No</label>
                        </p>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">email</i>Email Preferences</div>
            <div class="collapsible-body">
                <div class="row">
                    <p>Select which email updates you'd like to receive:</p>
                    <div class="input-field col s12">
                        <input id="email_preference_entry_job" type="checkbox" name="email_preference_entry_job" value="1" {{ is_null(old('email_preference_entry_job')) ? ($profile->email_preference_entry_job ? "checked" : "") : (old("email_preference_entry_job") ? "checked" : "") }} />
                        <label for="email_preference_entry_job">Getting an entry level job in sports</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_new_job" type="checkbox" name="email_preference_new_job" value="1" {{ is_null(old('email_preference_new_job')) ? ($profile->email_preference_new_job ? "checked" : "") : (old("email_preference_new_job") ? "checked" : "") }} />
                        <label for="email_preference_new_job">New job openings in sports</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_ticket_sales" type="checkbox" name="email_preference_ticket_sales" value="1" {{ is_null(old('email_preference_ticket_sales')) ? ($profile->email_preference_ticket_sales ? "checked" : "") : (old("email_preference_ticket_sales") ? "checked" : "") }} />
                        <label for="email_preference_ticket_sales">Ticket sales tips and tricks</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_leadership" type="checkbox" name="email_preference_leadership" value="1" {{ is_null(old('email_preference_leadership')) ? ($profile->email_preference_leadership ? "checked" : "") : (old("email_preference_leadership") ? "checked" : "") }} />
                        <label for="email_preference_leadership">Sales Leadership/management/strategy</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_best_practices" type="checkbox" name="email_preference_best_practices" value="1" {{ is_null(old('email_preference_best_practices')) ? ($profile->email_preference_best_practices ? "checked" : "") : (old("email_preference_best_practices") ? "checked" : "") }} />
                        <label for="email_preference_best_practices">Industry best practices and sports business articles</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_career_advice" type="checkbox" name="email_preference_career_advice" value="1" {{ is_null(old('email_preference_career_advice')) ? ($profile->email_preference_career_advice ? "checked" : "") : (old("email_preference_career_advice") ? "checked" : "") }} />
                        <label for="email_preference_career_advice">Advice on how to grow your career in sports business</label>
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
