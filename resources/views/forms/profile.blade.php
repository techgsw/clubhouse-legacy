<form method="post" action="/user/{{ $user->id }}/profile">
    {{ csrf_field() }}
    <h4>Personal Information</h4>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('phone') ? 'invalid' : '' }}">
            <input id="phone" type="text" name="phone" value="{{ old('phone') ?: $profile->phone ?: null }}" required>
            <label for="phone">Phone</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('date_of_birth') ? 'invalid' : '' }}">
            <input class="datepicker" id="date-of-birth" type="text" name="date_of_birth" value="{{ old('date_of_birth') ?: $profile->date_of_birth ?: null }}" required  >
            <label for="date-of-birth">Birthday</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6">
            <select class="browser-default" name="gender">
                <option value="" {{old('gender') == "" ? "selected" : "" }} disabled>Gender</option>
                <option value="female" {{old('gender') == "female" ? 'selected' : $profile->gender == "female" ? 'selected' : '' }}>Female</option>
                <option value="male" {{old('gender') == "male" ? 'selected' : $profile->gender == "male" ? 'selected' : '' }}>Male</option>
                <option value="non-binary" {{old('gender') == "non-binary" ? 'selected' : $profile->gender == "non-binary" ? 'selected' : '' }}>Non-binary</option>
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
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Upload Headshot</span>
                    <input type="file" name="headshot_url" value="{{ old('headshot_url') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" name="headshot_url_text" value="{{ old('headshot_url_text') }}">
                </div>
            </div>
        </div>
    </div>
    <div style="padding-top: 20px;"></div>
    <h4>Address</h4>
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
    <div style="padding-top: 20px;"></div>
    <h4>Job Preferences</h4>
    <div class="row">
        <div class="input-field col s12 m6">
            <select class="browser-default" name="employment_status">
                <option value="" {{old('employment_status') == "" ? "selected" : "" }} disabled>Employment Status</option>
                <option value="full-time" {{old('employment_status') == "full-time" ? 'selected' : $profile->employment_status == "full-time" ? 'selected' : '' }}>Employed full-time</option>
                <option value="part-time" {{old('employment_status') == "part-time" ? 'selected' : $profile->employment_status == "part-time" ? 'selected' : '' }}>Employed part-time</option>
                <option value="none" {{old('employment_status') == "none" ? 'selected' : $profile->employment_status == "none" ? 'selected' : '' }}>Unemployed</option>
            </select>
        </div>
        <div class="input-field col s12 m6">
            <select class="browser-default" name="job_seeking_status">
                <option value="" {{old('job_seeking_status') == "" ? "selected" : "" }} disabled>Job Seeking Status</option>
                <option value="active" {{old('job_seeking_status') == "active" ? 'selected' : $profile->job_seeking_status == "active" ? 'selected' : '' }}>Actively looking</option>
                <option value="passive" {{old('job_seeking_status') == "passive" ? 'selected' : $profile->job_seeking_status == "passive" ? 'selected' : '' }}>Happy where I am but open to good opportunities</option>
                <option value="not" {{old('job_seeking_status') == "not" ? 'selected' : $profile->job_seeking_status == "not" ? 'selected' : '' }}>Happy where I am and not open to anything new</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>Do you want to be considered for future jobs in the sports industry?</p>
            <p>
              <input name="receives_job_notifications" type="radio" value="1" {{ old('receives_job_notifications') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="receives_job_notifications" type="radio" value="0" {{ old('receives_job_notifications') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>If yes, check all departments that interest you:</p>
            <div class="row">
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_ticket_sales" value="{{ old('department_interest_ticket_sales') ?: $profile->department_interest_ticket_sales ?: null }}" />
                    <label for="ticket-sales">Ticket Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_sponsorship_sales" value="{{ old('department_interest_sponsorship_sales') ?: $profile->department_interest_sponsorship_sales ?: null }}" />
                    <label for="sponsorship-sales">Sponsorship Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_service" value="{{ old('department_interest_service') ?: $profile->department_interest_service ?: null }}" />
                    <label for="service">Service</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_premium_sales" value="{{ old('department_interest_premium_sales') ?: $profile->department_interest_premium_sales ?: null }}" />
                    <label for="premium-sales">Premium Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_marketing" value="{{ old('department_interest_marketing') ?: $profile->department_interest_marketing ?: null }}" />
                    <label for="marketing">Marketing</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_sponsorship_activation" value="{{ old('department_interest_sponsorship_activation') ?: $profile->department_interest_sponsorship_activation ?: null }}" />
                    <label for="sponsorship-activation">Sponsorship Activation</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_hr" value="{{ old('department_interest_hr') ?: $profile->department_interest_hr ?: null }}" />
                    <label for="hr">HR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_analytics" value="{{ old('department_interest_analytics') ?: $profile->department_interest_analytics ?: null }}" />
                    <label for="analytics">Analytics</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_cr" value="{{ old('department_interest_cr') ?: $profile->department_interest_cr ?: null }}" />
                    <label for="cr">CR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_pr" value="{{ old('department_interest_pr') ?: $profile->department_interest_pr ?: null }}" />
                    <label for="pr">PR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_database" value="{{ old('department_interest_database') ?: $profile->department_interest_database ?: null }}" />
                    <label for="database">Database</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_finance" value="{{ old('department_interest_finance') ?: $profile->department_interest_finance ?: null }}" />
                    <label for="finance">Finance</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_arena_ops" value="{{ old('department_interest_arena_ops') ?: $profile->department_interest_arena_ops ?: null }}" />
                    <label for="arena-ops">Arena Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_player_ops" value="{{ old('department_interest_player_ops') ?: $profile->department_interest_player_ops ?: null }}" />
                    <label for="player-ops">Player Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_event_ops" value="{{ old('department_interest_event_ops') ?: $profile->department_interest_event_ops ?: null }}" />
                    <label for="event-ops">Event Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_social_media" value="{{ old('department_interest_social_media') ?: $profile->department_interest_social_media ?: null }}" />
                    <label for="social-media">Digital/Social Media</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_entertainment" value="{{ old('department_interest_entertainment') ?: $profile->department_interest_entertainment ?: null }}" />
                    <label for="entertainment">Game Entertainment</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="department_interest_legal" value="{{ old('department_interest_legal') ?: $profile->department_interest_legal ?: null }}" />
                    <label for="legal">Legal</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>When making a decision on your next job in sports which of the following are most important?</p>
            <div class="row">
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="job_decision_factors_1" id="job_decision_factors_1" value="" />
                    <label for="job_decision_factors_1">Factor 1</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="checkbox" name="job_decision_factors_2" id="job_decision_factors_2" value="" />
                    <label for="job_decision_factors_2">Factor 2</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input type="text" name="job_decision_factors_other" value="{{ old('job_decision_factors_other') ?: $profile->job_decision_factors_other ?: '' }}" />
                    <label for="job_decision_factors_other">Other</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Are you currently employed in sports sales?</p>
            <p>
              <input name="employed_in_sports_sales" type="radio" value="1" {{ old('employed_in_sports_sales') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="employed_in_sports_sales" type="radio" value="0" {{ old('employed_in_sports_sales') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Do you want to continue your career in sports sales?</p>
            <p>
              <input name="continuing_sports_sales" type="radio" value="1" {{ old('continuing_sports_sales') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="continuing_sports_sales" type="radio" value="0" {{ old('continuing_sports_sales') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select class="browser-default" name="next_sales_job">
                <option value="" {{old('next_sales_job') == "" ? "selected" : "" }} disabled>If yes, which sports sales job is the next step for you?</option>
                <option value="inside_sales" {{old('next_sales_job') == "inside_sales" ? 'selected' : $profile->next_sales_job == "inside_sales" ? 'selected' : '' }}>Inside Sales – Entry level sales</option>
                <option value="executive_sales" {{old('next_sales_job') == "executive_sales" ? 'selected' : $profile->next_sales_job == "executive_sales" ? 'selected' : '' }}>Account Executive, Group or Season Sales – Mid level sales</option>
                <option value="executive_service" {{old('next_sales_job') == "executive_service" ? 'selected' : $profile->next_sales_job == "executive_service" ? 'selected' : '' }}>Account Executive, Service and Retention – Mid level service</option>
                <option value="premium_sales" {{old('next_sales_job') == "premium_sales" ? 'selected' : $profile->next_sales_job == "premium_sales" ? 'selected' : '' }}>Premium Sales – Advanced sales</option>
                <option value="sponsorship_sales" {{old('next_sales_job') == "sponsorship_sales" ? 'selected' : $profile->next_sales_job == "sponsorship_sales" ? 'selected' : '' }}>Sponsorship Sales – Sr. and Exec. level sales</option>
                <option value="manager" {{old('next_sales_job') == "manager" ? 'selected' : $profile->next_sales_job == "manager" ? 'selected' : '' }}>Inside Sales – Managing entry level sales team</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Are you a sports sales manager?</p>
            <p>
              <input name="is_sports_sales_manager" type="radio" value="1" {{ old('is_sports_sales_manager') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="is_sports_sales_manager" type="radio" value="0" {{ old('is_sports_sales_manager') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Do you want to continue your career in sports sales leadership?</p>
            <p>
              <input name="continuing_management" type="radio" value="1" {{ old('continuing_management') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="continuing_management" type="radio" value="0" {{ old('continuing_management') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select class="browser-default" name="next_management_job">
                <option value="" {{old('next_management_job') == "" ? "selected" : "" }} disabled>If yes, what management job is the next step for you?</option>
                <option value="manager_entry" {{old('next_management_job') == "manager_entry" ? 'selected' : $profile->next_management_job == "manager_entry" ? 'selected' : '' }}>Manager – Inside Sales – Managing entry level team</option>
                <option value="manager_mid" {{old('next_management_job') == "manager_mid" ? 'selected' : $profile->next_management_job == "manager_mid" ? 'selected' : '' }}>Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team</option>
                <option value="director" {{old('next_management_job') == "director" ? 'selected' : $profile->next_management_job == "director" ? 'selected' : '' }}>Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team</option>
                <option value="sr_director" {{old('next_management_job') == "sr_director" ? 'selected' : $profile->next_management_job == "sr_director" ? 'selected' : '' }}>Sr. Director – Running strategy for multiple departments and managing managers v. Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Are you an executive in sports business?</p>
            <p>
              <input name="is_executive" type="radio" value="1" {{ old('is_executive') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="is_executive" type="radio" value="0" {{ old('is_executive') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Do you want to continue your career as a sports executive?</p>
            <p>
              <input name="continuing_executive" type="radio" value="1" {{ old('continuing_executive') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="continuing_executive" type="radio" value="0" {{ old('continuing_executive') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select class="browser-default" name="next_executive_job">
                <option value="" {{old('next_executive_job') == "" ? "selected" : "" }} disabled>If yes, which is the next step for you?</option>
                <option value="vp" {{old('next_executive_job') == "vp" ? 'selected' : $profile->next_executive_job == "vp" ? 'selected' : '' }}>VP</option>
                <option value="svp" {{old('next_executive_job') == "svp" ? 'selected' : $profile->next_executive_job == "svp" ? 'selected' : '' }}>SVP</option>
                <option value="evp" {{old('next_executive_job') == "evp" ? 'selected' : $profile->next_executive_job == "evp" ? 'selected' : '' }}>EVP</option>
                <option value="cro" {{old('next_executive_job') == "cro" ? 'selected' : $profile->next_executive_job == "cro" ? 'selected' : '' }}>CRO</option>
                <option value="cmo" {{old('next_executive_job') == "cmo" ? 'selected' : $profile->next_executive_job == "cmo" ? 'selected' : '' }}>CMO</option>
                <option value="c" {{old('next_executive_job') == "c" ? 'selected' : $profile->next_executive_job == "c" ? 'selected' : '' }}>C Level</option>
            </select>
        </div>
    </div>
    <div style="padding-top: 20px;"></div>
    <h4>Employment History</h4>
    <div class="row">
        <div class="input-field col s12">
            <p>Are you currently working in sports?</p>
            <p>
              <input name="works_in_sports" type="radio" value="1" {{ old('works_in_sports') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="works_in_sports" type="radio" value="0" {{ old('works_in_sports') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
        <div class="input-field col s12 {{ $errors->has('years_in_sports') ? 'invalid' : '' }}">
            <input id="years-in-sports" type="text" name="years_in_sports" value="{{ old('years_in_sports') ?: $profile->years_in_sports ?: null }}">
            <label for="years-in-sports">If yes, how many years have you worked in sports?</label>
        </div>
        <div class="input-field col s12 {{ $errors->has('current_organization') ? 'invalid' : '' }}">
            <input id="current-organization" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}">
            <label for="current-organization">If yes, which organization?</label>
        </div>
        <div class="input-field col s12">
            <select class="browser-default" name="current_region">
                <option value="" {{old('current_region') == "" ? "selected" : "" }} disabled>If yes, which region do you work in?</option>
                <option value="mw" {{old('current_region') == "mw" ? 'selected' : $profile->current_region == "mw" ? 'selected' : '' }}>Midwest</option>
                <option value="ne" {{old('current_region') == "ne" ? 'selected' : $profile->current_region == "ne" ? 'selected' : '' }}>Northeast</option>
                <option value="nw" {{old('current_region') == "nw" ? 'selected' : $profile->current_region == "nw" ? 'selected' : '' }}>Northwest</option>
                <option value="se" {{old('current_region') == "se" ? 'selected' : $profile->current_region == "se" ? 'selected' : '' }}>Southeast</option>
                <option value="sw" {{old('current_region') == "sw" ? 'selected' : $profile->current_region == "sw" ? 'selected' : '' }}>Southwest</option>
            </select>
        </div>
        <div class="col s12">
            <p>If yes, which department(s)?</p>
            <div class="row">
                <div class="col s12 m6 l4">
                    <input name="current_department_ticket_sales" id="current_department_ticket_sales" type="checkbox" {{ old('current_department_ticket_sales') ? "checked" : "" }} />
                    <label for="current_department_ticket_sales">Sales</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_sponsorship_sales" id="current_department_sponsorship_sales" type="checkbox" {{ old('current_department_sponsorship_sales') ? "checked" : "" }} />
                    <label for="current_department_sponsorship_sales">Sales</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_service" id="current_department_service" type="checkbox" {{ old('current_department_service') ? "checked" : "" }} />
                    <label for="current_department_service">Service</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_premium_sales" id="current_department_premium_sales" type="checkbox" {{ old('current_department_premium_sales') ? "checked" : "" }} />
                    <label for="current_department_premium_sales">Sales</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_marketing" id="current_department_marketing" type="checkbox" {{ old('current_department_marketing') ? "checked" : "" }} />
                    <label for="current_department_marketing">Marketing</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_sponsorship_activation" id="current_department_sponsorship_activation" type="checkbox" {{ old('current_department_sponsorship_activation') ? "checked" : "" }} />
                    <label for="current_department_sponsorship_activation">Activation</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_hr" id="current_department_hr" type="checkbox" {{ old('current_department_hr') ? "checked" : "" }} />
                    <label for="current_department_hr">HR</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_cr" id="current_department_cr" type="checkbox" {{ old('current_department_cr') ? "checked" : "" }} />
                    <label for="current_department_cr">CR</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_pr" id="current_department_pr" type="checkbox" {{ old('current_department_pr') ? "checked" : "" }} />
                    <label for="current_department_pr">PR</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_database" id="current_department_database" type="checkbox" {{ old('current_department_database') ? "checked" : "" }} />
                    <label for="current_department_database">Database</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_finance" id="current_department_finance" type="checkbox" {{ old('current_department_finance') ? "checked" : "" }} />
                    <label for="current_department_finance">Finance</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_arena_ops" id="current_department_arena_ops" type="checkbox" {{ old('current_department_arena_ops') ? "checked" : "" }} />
                    <label for="current_department_arena_ops">Ops</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_player_ops" id="current_department_player_ops" type="checkbox" {{ old('current_department_player_ops') ? "checked" : "" }} />
                    <label for="current_department_player_ops">Ops</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_event_ops" id="current_department_event_ops" type="checkbox" {{ old('current_department_event_ops') ? "checked" : "" }} />
                    <label for="current_department_event_ops">Ops</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_social_media" id="current_department_social_media" type="checkbox" {{ old('current_department_social_media') ? "checked" : "" }} />
                    <label for="current_department_social_media">Media</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_entertainment" id="current_department_entertainment" type="checkbox" {{ old('current_department_entertainment') ? "checked" : "" }} />
                    <label for="current_department_entertainment">Entertainment</label>
                </div>
                <div class="col s12 m6 l4">
                    <input name="current_department_legal" id="current_department_legal" type="checkbox" {{ old('current_department_legal') ? "checked" : "" }} />
                    <label for="current_department_legal">Legal</label>
                </div>
            </div>
        </div>
        <div class="input-field col s12 {{ $errors->has('current_title') ? 'invalid' : '' }}">
            <input id="current-title" type="text" name="current_title" value="{{ old('current_title') ?: $profile->current_title ?: null }}">
            <label for="current-title">If yes, what is your title</label>
        </div>
        <div class="input-field col s12 {{ $errors->has('years_current_organization') ? 'invalid' : '' }}">
            <input id="years-current-organization" type="text" name="years_current_organization" value="{{ old('years_current_organization') ?: $profile->years_current_organization ?: null }}">
            <label for="years-current-organization">If yes, how many years have you been with your current organization?</label>
        </div>
        <div class="input-field col s12 {{ $errors->has('years_current_role') ? 'invalid' : '' }}">
            <input id="years-current-role" type="text" name="years_current_role" value="{{ old('years_current_role') ?: $profile->years_current_role ?: null }}">
            <label for="years-current-role">If yes, how many years have you been in your current role?</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>If yes, which departments do you have experience in? Check all that apply:</p>
            <div class="row">
                <div class="input-field col s12 m6 l4">
                    <input id="ticket-sales" type="checkbox" name="department_experience_ticket_sales" value="{{ old("department_experience_ticket_sales") ?: $profile->department_experience_ticket_sales ?: null }}" />
                    <label for="ticket-sales">Ticket Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="sponsorship-sales" type="checkbox" name="department_experience_sponsorship_sales" value="{{ old("department_experience_sponsorship_sales") ?: $profile->department_experience_sponsorship_sales ?: null }}" />
                    <label for="sponsorship-sales">Sponsorship Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="service" type="checkbox" name="department_experience_service" value="{{ old("department_experience_service") ?: $profile->department_experience_service ?: null }}" />
                    <label for="service">Service</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="premium-sales" type="checkbox" name="department_experience_premium_sales" value="{{ old("department_experience_premium_sales") ?: $profile->department_experience_premium_sales ?: null }}" />
                    <label for="premium-sales">Premium Sales</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="marketing" type="checkbox" name="department_experience_marketing" value="{{ old("department_experience_marketing") ?: $profile->department_experience_marketing ?: null }}" />
                    <label for="marketing">Marketing</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="sponsorship-activation" type="checkbox" name="department_experience_sponsorship_activation" value="{{ old("department_experience_sponsorship_activation") ?: $profile->department_experience_sponsorship_activation ?: null }}" />
                    <label for="sponsorship-activation">Sponsorship Activation</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="hr" type="checkbox" name="department_experience_hr" value="{{ old("department_experience_hr") ?: $profile->department_experience_hr ?: null }}" />
                    <label for="hr">HR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="analytics" type="checkbox" name="department_experience_analytics" value="{{ old("department_experience_analytics") ?: $profile->department_experience_analytics ?: null }}" />
                    <label for="analytics">Analytics</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="cr" type="checkbox" name="department_experience_cr" value="{{ old("department_experience_cr") ?: $profile->department_experience_cr ?: null }}" />
                    <label for="cr">CR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="pr" type="checkbox" name="department_experience_pr" value="{{ old("department_experience_pr") ?: $profile->department_experience_pr ?: null }}" />
                    <label for="pr">PR</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="database" type="checkbox" name="department_experience_database" value="{{ old("department_experience_database") ?: $profile->department_experience_database ?: null }}" />
                    <label for="database">Database</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="finance" type="checkbox" name="department_experience_finance" value="{{ old("department_experience_finance") ?: $profile->department_experience_finance ?: null }}" />
                    <label for="finance">Finance</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="arena-ops" type="checkbox" name="department_experience_arena_ops" value="{{ old("department_experience_arena_ops") ?: $profile->department_experience_arena_ops ?: null }}" />
                    <label for="arena-ops">Arena Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="player-ops" type="checkbox" name="department_experience_player_ops" value="{{ old("department_experience_player_ops") ?: $profile->department_experience_player_ops ?: null }}" />
                    <label for="player-ops">Player Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="event-ops" type="checkbox" name="department_experience_event_ops" value="{{ old("department_experience_event_ops") ?: $profile->department_experience_event_ops ?: null }}" />
                    <label for="event-ops">Event Ops</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="social-media" type="checkbox" name="department_experience_social_media" value="{{ old("department_experience_social_media") ?: $profile->department_experience_social_media ?: null }}" />
                    <label for="social-media">Digital/Social Media</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="entertainment" type="checkbox" name="department_experience_entertainment" value="{{ old("department_experience_entertainment") ?: $profile->department_experience_entertainment ?: null }}" />
                    <label for="entertainment">Game Entertainment</label>
                </div>
                <div class="input-field col s12 m6 l4">
                    <input id="legal" type="checkbox" name="department_experience_legal" value="{{ old("department_experience_legal") ?: $profile->department_experience_legal ?: null }}" />
                    <label for="legal">Legal</label>
                </div>
            </div>
        </div>
    </div>
    <!-- If not, where do you work now? -->
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('if_not_organization') ? 'invalid' : '' }}">
            <input id="if-not-organization" type="text" name="if_not_organization" value="{{ old('if_not_organization') ?: $profile->if_not_organization ?: null }}">
            <label for="if-not-organization">If not, where do you work now?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('if_not_department') ? 'invalid' : '' }}">
            <input id="if-not-department" type="text" name="if_not_department" value="{{ old('if_not_department') ?: $profile->if_not_department ?: null }}">
            <label for="if-not-department">What department do you work in?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('if_not_title') ? 'invalid' : '' }}">
            <input id="if-not-title" type="text" name="if_not_title" value="{{ old('if_not_title') ?: $profile->if_not_title ?: null }}">
            <label for="if-not-title">What is your title?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('if_not_years_current_organization') ? 'invalid' : '' }}">
            <input id="if-not-years-current-organization" type="text" name="if_not_years_current_organization" value="{{ old('if_not_years_current_organization') ?: $profile->if_not_years_current_organization ?: null }}">
            <label for="if-not-years-current-organization">How long have you been with your current organization?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('if_not_years_current_role') ? 'invalid' : '' }}">
            <input id="if-not-years-current-role" type="text" name="if_not_years_current_role" value="{{ old('if_not_years_current_role') ?: $profile->if_not_years_current_role ?: null }}">
            <label for="if-not-years-current-role">How long have you been in your current role?</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>If not, which departments do you have experience in? Check all that apply:</p>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_phone_sales" name="if_not_department_experience_phone_sales" />
            <label for="if_not_department_experience_phone_sales">Phone sales</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_door_to_door_sales" name="if_not_department_experience_door_to_door_sales" />
            <label for="if_not_department_experience_door_to_door_sales">Door-to-door sales</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_territory_management" name="if_not_department_experience_territory_management" />
            <label for="if_not_department_experience_territory_management">Territory managements</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_b2b_sales" name="if_not_department_experience_b2b_sales" />
            <label for="if_not_department_experience_b2b_sales">Business-to-business sales</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_customer_service" name="if_not_department_experience_customer_service" />
            <label for="if_not_department_experience_customer_service">Customer service</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_sponsorship" name="if_not_department_experience_sponsorship" />
            <label for="if_not_department_experience_sponsorship">Sponsorship</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_high_level_business_development" name="if_not_department_experience_high_level_business_development" />
            <label for="if_not_department_experience_high_level_business_development">High level business development</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_marketing" name="if_not_department_experience_marketing" />
            <label for="if_not_department_experience_marketing">Marketing</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_analytics" name="if_not_department_experience_analytics" />
            <label for="if_not_department_experience_analytics">Analytics</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_bi" name="if_not_department_experience_bi" />
            <label for="if_not_department_experience_bi">B.I.</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_database" name="if_not_department_experience_database" />
            <label for="if_not_department_experience_database">Database</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_digital" name="if_not_department_experience_digital" />
            <label for="if_not_department_experience_digital">Digital</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_web_design" name="if_not_department_experience_web_design" />
            <label for="if_not_department_experience_web_design">Web design</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_social_media" name="if_not_department_experience_social_media" />
            <label for="if_not_department_experience_social_media">Social media</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_hr" name="if_not_department_experience_hr" />
            <label for="if_not_department_experience_hr">HR</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_finance" name="if_not_department_experience_finance" />
            <label for="if_not_department_experience_finance">Finance</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_accounting" name="if_not_department_experience_accounting" />
            <label for="if_not_department_experience_accounting">Accounting</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_organizational_development" name="if_not_department_experience_organizational_development" />
            <label for="if_not_department_experience_organizational_development">Organizational development</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_communications" name="if_not_department_experience_communications" />
            <label for="if_not_department_experience_communications">Communications</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_pr" name="if_not_department_experience_pr" />
            <label for="if_not_department_experience_pr">PR</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_media_relations" name="if_not_department_experience_media_relations" />
            <label for="if_not_department_experience_media_relations">Media relations</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_legal" name="if_not_department_experience_legal" />
            <label for="if_not_department_experience_legal">Legal</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="checkbox" id="if_not_department_experience_it" name="if_not_department_experience_it" />
            <label for="if_not_department_experience_it">IT</label>
        </div>
        <div class="input-field col s12 m6 l4">
            <input type="text" id="if_not_department_experience_other" name="if_not_department_experience_other" />
            <label for="if_not_department_experience_other">Other</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Upload Resume</span>
                    <input type="file" name="resume_url" value="{{ old('resume_url') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" name="resume_url_text" value="{{ old('resume_url_text') }}">
                </div>
            </div>
        </div>
    </div>
    <div style="padding-top: 20px;"></div>
    <h4>Educational History</h4>
    <div class="row">
        <div class="input-field col s6">
            <select class="browser-default" name="education_level">
                <option value="" {{old('education_level') == "" ? "selected" : "" }} disabled>Which is your highest completed level of education?</option>
                <option value="high_school" {{old('education_level') == "high_school" ? 'selected' : $profile->education_level == "high_school" ? 'selected' : '' }}>High School</option>
                <option value="associate" {{old('education_level') == "associate" ? 'selected' : $profile->education_level == "associate" ? 'selected' : '' }}>Associate degree</option>
                <option value="bachelor" {{old('education_level') == "bachelor" ? 'selected' : $profile->education_level == "bachelor" ? 'selected' : '' }}>Bachelor's degree</option>
                <option value="master" {{old('education_level') == "master" ? 'selected' : $profile->education_level == "master" ? 'selected' : '' }}>Master's degree</option>
                <option value="doctor" {{old('education_level') == "doctor" ? 'selected' : $profile->education_level == "doctor" ? 'selected' : '' }}>Doctorate (PhD, MD, JD, etc.)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('college') ? 'invalid' : '' }}">
            <input id="college" type="text" name="college" value="{{ old('college') ?: $profile->college ?: null }}">
            <label for="college">What college did/do you attend?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('graduation_year') ? 'invalid' : '' }}">
            <input id="graduation-year" type="text" name="graduation_year" value="{{ old('graduation_year') ?: $profile->graduation_year ?: null }}">
            <label for="graduation-year">What year did/will you graduate?</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('gpa') ? 'invalid' : '' }}">
            <input id="gpa" type="text" name="gpa" value="{{ old('gpa') ?: $profile->gpa ?: null }}">
            <label for="gpa">What was/is your undergraduate GPA?</label>
        </div>
    </div>
    <div class="input-field">
        <textarea id="college-organizations" class="materialize-textarea {{ $errors->has('college_organizations') ? 'invalid' : '' }}" name="college_organizations"> {{ old('college_organizations') ?: $profile->college_organizations ?: null }}</textarea>
        <label for="college-organizations">What collegiate organizations did/do you belong to? List any leadership positions you held.</label>
    </div>
    <div class="input-field">
        <textarea id="college-sports-clubs" class="materialize-textarea {{ $errors->has('college_sports_clubs') ? 'invalid' : '' }}" name="college_sports_clubs"> {{ old('college_sports_clubs') ?: $profile->college_sports_clubs ?: null }}</textarea>
        <label for="college-sports-clubs">What sports business clubs or in your athletic department(s) were you involved in? List any leadership positions you held.</label>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>Do you plan to attend more school in the future?</p>
            <p>
              <input name="has_school_plans" type="radio" value="1" {{ old('has_school_plans') ? "checked" : "" }} />
              <label>Yes</label>
            </p>
            <p>
              <input name="has_school_plans" type="radio" value="0" {{ old('has_school_plans') ? "" : "checked" }} />
              <label>No</label>
            </p>
        </div>
    </div>
    <div class="row">
        <div style="padding-top: 20px;"></div>
        <h4>Email Preferences</h4>
    </div>
    <div class="row">
        <p>Select which email updates you'd like to receive:</p>
        <div class="input-field col s12">
            <input id="entry-job" type="checkbox" name="email_preference_entry_job" value="{{ old('entry_job') ?: $profile->email_preference ?: null }}" />
            <label for="entry-job">Getting an entry level job in sports</label>
        </div>
        <div class="input-field col s12">
            <input id="new-job" type="checkbox" name="new_job" value="{{ old('new_job') ?: $profile->department_interests ?: null }}" />
            <label for="new-job">New job openings in sports</label>
        </div>
        <div class="input-field col s12">
            <input id="ticket-sales" type="checkbox" name="ticket_sales" value="{{ old('ticket_sales') ?: $profile->email_preference ?: null }}" />
            <label for="ticket-sales">Ticket sales tips and tricks</label>
        </div>
        <div class="input-field col s12">
            <input id="leadership" type="checkbox" name="leadership" value="{{ old('leadership') ?: $profile->email_preference ?: null }}" />
            <label for="leadership">Sales Leadership/management/strategy</label>
        </div>
        <div class="input-field col s12">
            <input id="best-practices" type="checkbox" name="best_practices" value="{{ old('best_practices') ?: $profile->email_preference ?: null }}" />
            <label for="best-practices">Industry best practices and sports business articles</label>
        </div>
        <div class="input-field col s12">
            <input id="career-advice" type="checkbox" name="career_advice" value="{{ old('career_advice') ?: $profile->email_preference ?: null }}" />
            <label for="career-advice">Advice on how to grow your career in sports business</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn sbs-red">Save</button>
        </div>
    </div>
</form>
