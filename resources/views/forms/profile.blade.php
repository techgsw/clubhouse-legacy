<form method="post" action="/user/{{ $user->id }}/profile">
    {{ csrf_field() }}
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
            @if ($profile->resume)
                <a href="#" class="btn sbs-red white-text">View Resume</a>
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
    <ul class="collapsible" data-collapsible="accordion">
        <li> <!-- Personal Information -->
            <div class="collapsible-header"><i class="material-icons">person</i>Personal Information</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <input class="datepicker" id="date-of-birth" type="text" name="date_of_birth" value="{{ old('date_of_birth') ?: $profile->date_of_birth ?: "" }}" />
                        <label for="date-of-birth">Birthday</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="gender">
                            <option value="" {{ old('gender') == "" ? "selected" : $profile->gender == "" ? "selected" : "" }} disabled>Gender</option>
                            <option value="female" {{ old('gender') == "female" ? "selected" : $profile->gender == "female" ? "selected" : "" }}>Female</option>
                            <option value="male" {{ old('gender') == "male" ? "selected" : $profile->gender == "male" ? "selected" : "" }}>Male</option>
                            <option value="non-binary" {{ old('gender') == "non-binary" ? "selected" : $profile->gender == "non-binary" ? "selected" : "" }}>Non-binary</option>
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
        <li> <!-- Employment Preferences -->
            <div class="collapsible-header"><i class="material-icons">settings</i>Employment Preferences</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="employment_status">
                            <option value="" {{ is_null(old('employment_status')) ? ($profile->employment_status == "" ? "selected" : "") : (old("employment_status") == "" ? "selected" : "") }} disabled>Employment status</option>
                            <option value="full_time" {{ is_null(old('employment_status')) ? ($profile->employment_status == "full_time" ? "selected" : "") : (old("employment_status") == "full_time" ? "selected" : "") }}>Employed full-time</option>
                            <option value="part_time" {{ is_null(old('employment_status')) ? ($profile->employment_status == "part_time" ? "selected" : "") : (old("employment_status") == "part_time" ? "selected" : "") }}>Employed part-time</option>
                            <option value="unemployed" {{ is_null(old('employment_status')) ? ($profile->employment_status == "unemployed" ? "selected" : "") : (old("employment_status") == "unemployed" ? "selected" : "") }}>Unemployed</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <select class="browser-default" name="job_seeking_status">
                            <option value="" {{ old('job_seeking_status') == "" ? "selected" : "" }} disabled>Job-seeking status</option>
                            <option value="active" {{ old('job_seeking_status') == "active" ? 'selected' : $profile->job_seeking_status == "active" ? 'selected' : '' }}>Actively looking</option>
                            <option value="passive" {{ old('job_seeking_status') == "passive" ? 'selected' : $profile->job_seeking_status == "passive" ? 'selected' : '' }}>Happy where I am but open to good opportunities</option>
                            <option value="not" {{ old('job_seeking_status') == "not" ? 'selected' : $profile->job_seeking_status == "not" ? 'selected' : '' }}>Happy where I am and not open to anything new</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>Do you want to be considered for future jobs in the sports industry?</p>
                        <p>
                          <input name="receives_job_notifications" id="receives_job_notifications_yes" type="radio" value="1" {{ is_null(old('receives_job_notifications')) ? ($profile->receives_job_notifications ? "checked" : "") : (old('receives_job_notifications') ? "checked" : "") }} />
                          <label for="receives_job_notifications_yes">Yes</label>
                        </p>
                        <p>
                          <input name="receives_job_notifications" id="receives_job_notifications_no" type="radio" value="0" {{ is_null(old('receives_job_notifications')) ? ($profile->receives_job_notifications ? "" : "checked") : (old('receives_job_notifications') ? "" : "checked") }} />
                          <label for="receives_job_notifications_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>If yes, check all departments that interest you:</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_ticket_sales" id="department_interests_ticket_sales" value="1" {{ is_null(old('department_interests_ticket_sales')) ? ($profile->department_interests_ticket_sales ? "checked" : "") : (old('department_interests_ticket_sales') ? "checked" : "") }}/>
                                <label for="department_interests_ticket_sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_sponsorship_sales" id="department_interests_sponsorship_sales" value="1" {{ is_null(old('department_interests_sponsorship_sales')) ? ($profile->department_interests_sponsorship_sales ? "checked" : "") : (old('department_interests_sponsorship_sales') ? "checked" : "") }}/>
                                <label for="department_interests_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_service" id="department_interests_service" value="1" {{ is_null(old('department_interests_service')) ? ($profile->department_interests_service ? "checked" : "") : (old('department_interests_service') ? "checked" : "") }}/>
                                <label for="department_interests_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_premium_sales" id="department_interests_premium_sales" value="1" {{ is_null(old('department_interests_premium_sales')) ? ($profile->department_interests_premium_sales ? "checked" : "") : (old('department_interests_premium_sales') ? "checked" : "") }}/>
                                <label for="department_interests_premium_sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_marketing" id="department_interests_marketing" value="1" {{ is_null(old('department_interests_marketing')) ? ($profile->department_interests_marketing ? "checked" : "") : (old('department_interests_marketing') ? "checked" : "") }}/>
                                <label for="department_interests_marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_sponsorship_activation" id="department_interests_sponsorship_activation" value="1" {{ is_null(old('department_interests_sponsorship_activation')) ? ($profile->department_interests_sponsorship_activation ? "checked" : "") : (old('department_interests_sponsorship_activation') ? "checked" : "") }}/>
                                <label for="department_interests_sponsorship_activation">Sponsorship Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_hr" id="department_interests_hr" value="1" {{ is_null(old('department_interests_hr')) ? ($profile->department_interests_hr ? "checked" : "") : (old('department_interests_hr') ? "checked" : "") }}/>
                                <label for="department_interests_hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_analytics" id="department_interests_analytics" value="1" {{ is_null(old('department_interests_analytics')) ? ($profile->department_interests_analytics ? "checked" : "") : (old('department_interests_analytics') ? "checked" : "") }}/>
                                <label for="department_interests_analytics">Analytics</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_cr" id="department_interests_cr" value="1" {{ is_null(old('department_interests_cr')) ? ($profile->department_interests_cr ? "checked" : "") : (old('department_interests_cr') ? "checked" : "") }}/>
                                <label for="department_interests_cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_pr" id="department_interests_pr" value="1" {{ is_null(old('department_interests_pr')) ? ($profile->department_interests_pr ? "checked" : "") : (old('department_interests_pr') ? "checked" : "") }}/>
                                <label for="department_interests_pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_database" id="department_interests_database" value="1" {{ is_null(old('department_interests_database')) ? ($profile->department_interests_database ? "checked" : "") : (old('department_interests_database') ? "checked" : "") }}/>
                                <label for="department_interests_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_finance" id="department_interests_finance" value="1" {{ is_null(old('department_interests_finance')) ? ($profile->department_interests_finance ? "checked" : "") : (old('department_interests_finance') ? "checked" : "") }}/>
                                <label for="department_interests_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_arena_ops" id="department_interests_arena_ops" value="1" {{ is_null(old('department_interests_arena_ops')) ? ($profile->department_interests_arena_ops ? "checked" : "") : (old('department_interests_arena_ops') ? "checked" : "") }}/>
                                <label for="department_interests_arena_ops">Arena Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_player_ops" id="department_interests_player_ops" value="1" {{ is_null(old('department_interests_player_ops')) ? ($profile->department_interests_player_ops ? "checked" : "") : (old('department_interests_player_ops') ? "checked" : "") }}/>
                                <label for="department_interests_player_ops">Player Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_event_ops" id="department_interests_event_ops" value="1" {{ is_null(old('department_interests_event_ops')) ? ($profile->department_interests_event_ops ? "checked" : "") : (old('department_interests_event_ops') ? "checked" : "") }}/>
                                <label for="department_interests_event_op">Event Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_social_media" id="department_interests_social_media" value="1" {{ is_null(old('department_interests_social_media')) ? ($profile->department_interests_social_media ? "checked" : "") : (old('department_interests_social_media') ? "checked" : "") }}/>
                                <label for="department_interests_social_media">Digital/Social Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_entertainment" id="department_interests_entertainment" value="1" {{ is_null(old('department_interests_entertainment')) ? ($profile->department_interests_entertainment ? "checked" : "") : (old('department_interests_entertainment') ? "checked" : "") }}/>
                                <label for="department_interests_entertainment">Game Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="department_interests_legal" id="department_interests_legal" value="1" {{ is_null(old('department_interests_legal')) ? ($profile->department_interests_legal ? "checked" : "") : (old('department_interests_legal') ? "checked" : "") }}/>
                                <label for="department_interests_legal">Legal</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>When making a decision on your next job in sports which of the following are most important?</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="job_decision_factors_1" id="job_decision_factors_1" value="1" {{ is_null(old('job_decisions_factors_1') ? ($profile->job_decisions_factors_1 ? "checked" : "") : (old('job_decisions_factors_1') ? "checked" : "")) }} />
                                <label for="job_decision_factors_1">Factor 1</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input type="checkbox" name="job_decision_factors_2" id="job_decision_factors_2" value="1" {{ is_null(old('job_decisions_factors_2') ? ($profile->job_decisions_factors_2 ? "checked" : "") : (old('job_decisions_factors_2') ? "checked" : "")) }} />
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
                          <input name="employed_in_sports_sales" id="employed_in_sports_sales_yes" type="radio" value="1" {{ is_null(old('employed_in_sports_sales')) ? ($profile->employed_in_sports_sales ? "checked" : "") : (old('employed_in_sports_sales') ? "checked" : "") }} />
                          <label for="employed_in_sports_sales_yes">Yes</label>
                        </p>
                        <p>
                          <input name="employed_in_sports_sales" id="employed_in_sports_sales_no" type="radio" value="0" {{ is_null(old('employed_in_sports_sales')) ? ($profile->employed_in_sports_sales ? "" : "checked") : (old('employed_in_sports_sales') ? "" : "checked") }} />
                          <label for="employed_in_sports_sales_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Do you want to continue your career in sports sales?</p>
                        <p>
                          <input name="continuing_sports_sales" id="continuing_sports_sales_yes" type="radio" value="1" {{ is_null(old('continuing_sports_sales')) ? ($profile->continuing_sports_sales ? "checked" : "") : (old('continuing_sports_sales') ? "checked" : "") }} />
                          <label for="continuing_sports_sales_yes">Yes</label>
                        </p>
                        <p>
                          <input name="continuing_sports_sales" id="continuing_sports_sales_no" type="radio" value="0" {{ is_null(old('continuing_sports_sales')) ? ($profile->continuing_sports_sales ? "" : "checked") : (old('continuing_sports_sales') ? "" : "checked") }} />
                          <label for="continuing_sports_sales_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="next_sales_job">
                            <option value="" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "" ? "selected" : "") : (old('next_sales_job') == "" ? "selected" : "") }} disabled>If yes, which sports sales job is the next step for you?</option>
                            <option value="inside_sales" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "inside_sales" ? "selected" : "") : (old("next_sales_job") == "inside_sales" ? "selected" : "") }}>Inside Sales – Entry level sales</option>
                            <option value="executive_sales" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "executive_sales" ? "selected" : "") : (old("next_sales_job") == "executive_sales" ? "selected" : "") }}>Account Executive, Group or Season Sales – Mid level sales</option>
                            <option value="executive_service" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "executive_service" ? "selected" : "") : (old("next_sales_job") == "executive_service" ? "selected" : "") }}>Account Executive, Service and Retention – Mid level service</option>
                            <option value="premium_sales" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "premium_sales" ? "selected" : "") : (old("next_sales_job") == "premium_sales" ? "selected" : "") }}>Premium Sales – Advanced sales</option>
                            <option value="sponsorship_sales" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "sponsorship_sales" ? "selected" : "") : (old("next_sales_job") == "sponsorship_sales" ? "selected" : "") }}>Sponsorship Sales – Sr. and Exec. level sales</option>
                            <option value="manager" {{ is_null(old('next_sales_job')) ? ($profile->next_sales_job == "manager" ? "selected" : "") : (old("next_sales_job") == "manager" ? "selected" : "") }}>Inside Sales – Managing entry level sales team</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Are you a sports sales manager?</p>
                        <p>
                          <input name="is_sports_sales_manager" id="is_sports_sales_manager_yes" type="radio" value="1" {{ is_null(old('is_sports_sales_manager')) ? ($profile->is_sports_sales_manager ? "checked" : "") : (old('is_sports_sales_manager') ? "checked" : "") }} />
                          <label for="is_sports_sales_manager_yes">Yes</label>
                        </p>
                        <p>
                          <input name="is_sports_sales_manager" id="is_sports_sales_manager_no" type="radio" value="0" {{ is_null(old('is_sports_sales_manager')) ? ($profile->is_sports_sales_manager ? "" : "checked") : (old('is_sports_sales_manager') ? "" : "checked") }} />
                          <label for="is_sports_sales_manager_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Do you want to continue your career in sports sales leadership?</p>
                        <p>
                          <input name="continuing_management" id="continuing_management_yes" type="radio" value="1" {{ is_null(old('continuing_management')) ? ($profile->continuing_management ? "checked" : "") : (old('continuing_management') ? "checked" : "") }} />
                          <label for="continuing_management_yes">Yes</label>
                        </p>
                        <p>
                          <input name="continuing_management" id="continuing_management_no" type="radio" value="0" {{ is_null(old('continuing_management')) ? ($profile->continuing_management ? "" : "checked") : (old('continuing_management') ? "" : "checked") }} />
                          <label for="continuing_management_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="next_management_job">
                            <option value="" {{ is_null(old('next_management_job')) ? ($profile->next_management_job == "" ? "selected" : "") : (old("next_management_job") == "" ? "selected" : "") }} disabled>If yes, what management job is the next step for you?</option>
                            <option value="manager_entry" {{ is_null(old('next_management_job')) ? ($profile->next_management_job == "manager_entry" ? "selected" : "") : (old("next_management_job") == "manager_entry" ? "selected" : "") }}>Manager – Inside Sales – Managing entry level team</option>
                            <option value="manager_mid" {{ is_null(old('next_management_job')) ? ($profile->next_management_job == "manager_mid" ? "selected" : "") : (old("next_management_job") == "manager_mid" ? "selected" : "") }}>Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team</option>
                            <option value="director" {{ is_null(old('next_management_job')) ? ($profile->next_management_job == "director" ? "selected" : "") : (old("next_management_job") == "director" ? "selected" : "") }}>Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team</option>
                            <option value="sr_director" {{ is_null(old('next_management_job')) ? ($profile->next_management_job == "sr_director" ? "selected" : "") : (old("next_management_job") == "sr_director" ? "selected" : "") }}>Sr. Director – Running strategy for multiple departments and managing managers v. Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Are you an executive in sports business?</p>
                        <p>
                          <input name="is_executive" id="is_executive_yes" type="radio" value="1" {{ is_null(old('is_executive')) ? ($profile->is_executive ? "checked" : "") : (old('is_executive') ? "checked" : "") }} />
                          <label for="is_executive_yes">Yes</label>
                        </p>
                        <p>
                          <input name="is_executive" id="is_executive_no" type="radio" value="0" {{ is_null(old('is_executive')) ? ($profile->is_executive ? "" : "checked") : (old('is_executive') ? "" : "checked") }} />
                          <label for="is_executive_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <p>Do you want to continue your career as a sports executive?</p>
                        <p>
                          <input name="continuing_executive" id="continuing_executive_yes" type="radio" value="1" {{ is_null(old('continuing_executive')) ? ($profile->continuing_executive ? "checked" : "") : (old('continuing_executive') ? "checked" : "") }} />
                          <label for="continuing_executive_yes">Yes</label>
                        </p>
                        <p>
                          <input name="continuing_executive" id="continuing_executive_no" type="radio" value="0" {{ is_null(old('continuing_executive')) ? ($profile->continuing_executive ? "" : "checked") : (old('continuing_executive') ? "" : "checked") }} />
                          <label for="continuing_executive_no">No</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select class="browser-default" name="next_executive_job">
                            <option value="" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "" ? "selected" : "") : (old("next_executive_job") == "" ? "selected" : "") }} disabled>If yes, which is the next step for you?</option>
                            <option value="vp" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "vp" ? "selected" : "") : (old("next_executive_job") == "vp" ? "selected" : "") }}>VP</option>
                            <option value="svp" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "svp" ? "selected" : "") : (old("next_executive_job") == "svp" ? "selected" : "") }}>SVP</option>
                            <option value="evp" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "evp" ? "selected" : "") : (old("next_executive_job") == "evp" ? "selected" : "") }}>EVP</option>
                            <option value="cro" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "cro" ? "selected" : "") : (old("next_executive_job") == "cro" ? "selected" : "") }}>CRO</option>
                            <option value="cmo" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "cmo" ? "selected" : "") : (old("next_executive_job") == "cmo" ? "selected" : "") }}>CMO</option>
                            <option value="c" {{ is_null(old('next_executive_job')) ? ($profile->next_executive_job == "c" ? "selected" : "") : (old("next_executive_job") == "c" ? "selected" : "") }}>C Level</option>
                        </select>
                    </div>
                </div>
            </div>
        </li>
        <li> <!-- Employment History -->
            <div class="collapsible-header"><i class="material-icons">work</i>Employment History</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12">
                        <p>Are you currently working in sports?</p>
                        <p>
                          <input name="works_in_sports" id="works_in_sports_yes" type="radio" value="1" {{ is_null(old('works_in_sports')) ? ($profile->works_in_sports ? "checked" : "") : (old('works_in_sports') ? "checked" : "") }} />
                          <label for="works_in_sports_yes">Yes</label>
                        </p>
                        <p>
                          <input name="works_in_sports" id="works_in_sports_no" type="radio" value="0" {{ is_null(old('works_in_sports')) ? ($profile->works_in_sports ? "" : "checked") : (old('works_in_sports') ? "" : "checked") }} />
                          <label for="works_in_sports_no">No</label>
                        </p>
                    </div>
                    <div class="input-field col s12">
                        <input id="years-in-sports" type="text" name="years_in_sports" value="{{ old('years_in_sports') ?: $profile->years_in_sports ?: null }}">
                        <label for="years-in-sports">If yes, how many years have you worked in sports?</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="current-organization" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}">
                        <label for="current-organization">If yes, which organization?</label>
                    </div>
                    <div class="input-field col s12">
                        <select class="browser-default" name="current_region">
                            <option value="" {{ is_null(old('current_region')) ? ($profile->current_region == "" ? "selected" : "") : (old("current_region") == "" ? "selected" : "") }} disabled>If yes, which region do you work in?</option>
                            <option value="mw" {{ is_null(old('current_region')) ? ($profile->current_region == "mw" ? "selected" : "") : (old("current_region") == "mw" ? "selected" : "") }}>Midwest</option>
                            <option value="ne" {{ is_null(old('current_region')) ? ($profile->current_region == "ne" ? "selected" : "") : (old("current_region") == "ne" ? "selected" : "") }}>Northeast</option>
                            <option value="nw" {{ is_null(old('current_region')) ? ($profile->current_region == "nw" ? "selected" : "") : (old("current_region") == "nw" ? "selected" : "") }}>Northwest</option>
                            <option value="se" {{ is_null(old('current_region')) ? ($profile->current_region == "se" ? "selected" : "") : (old("current_region") == "se" ? "selected" : "") }}>Southeast</option>
                            <option value="sw" {{ is_null(old('current_region')) ? ($profile->current_region == "sw" ? "selected" : "") : (old("current_region") == "sw" ? "selected" : "") }}>Southwest</option>
                        </select>
                    </div>
                    <div class="col s12">
                        <p>If yes, which department(s)?</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_ticket_sales" id="current_department_ticket_sales" type="checkbox" {{ is_null(old('current_department_ticket_sales')) ? ($profile->current_department_ticket_sales ? "checked" : "") : (old('current_department_ticket_sales') ? "checked" : "") }} value="1" />
                                <label for="current_department_ticket_sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_sponsorship_sales" id="current_department_sponsorship_sales" type="checkbox" {{ is_null(old('current_department_sponsorship_sales')) ? ($profile->current_department_sponsorship_sales ? "checked" : "") : (old('current_department_sponsorship_sales') ? "checked" : "") }} value="1" />
                                <label for="current_department_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_service" id="current_department_service" type="checkbox" {{ is_null(old('current_department_service')) ? ($profile->current_department_service ? "checked" : "") : (old('current_department_service') ? "checked" : "") }} value="1" />
                                <label for="current_department_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_premium_sales" id="current_department_premium_sales" type="checkbox" {{ is_null(old('current_department_premium_sales')) ? ($profile->current_department_premium_sales ? "checked" : "") : (old('current_department_premium_sales') ? "checked" : "") }} value="1" />
                                <label for="current_department_premium_sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_marketing" id="current_department_marketing" type="checkbox" {{ is_null(old('current_department_marketing')) ? ($profile->current_department_marketing ? "checked" : "") : (old('current_department_marketing') ? "checked" : "") }} value="1" />
                                <label for="current_department_marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_sponsorship_activation" id="current_department_sponsorship_activation" type="checkbox" {{ is_null(old('current_department_sponsorship_activation')) ? ($profile->current_department_sponsorship_activation ? "checked" : "") : (old('current_department_sponsorship_activation') ? "checked" : "") }} value="1" />
                                <label for="current_department_sponsorship_activation">Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_hr" id="current_department_hr" type="checkbox" {{ is_null(old('current_department_hr')) ? ($profile->current_department_hr ? "checked" : "") : (old('current_department_hr') ? "checked" : "") }} value="1" />
                                <label for="current_department_hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_cr" id="current_department_cr" type="checkbox" {{ is_null(old('current_department_cr')) ? ($profile->current_department_cr ? "checked" : "") : (old('current_department_cr') ? "checked" : "") }} value="1" />
                                <label for="current_department_cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_pr" id="current_department_pr" type="checkbox" {{ is_null(old('current_department_pr')) ? ($profile->current_department_pr ? "checked" : "") : (old('current_department_pr') ? "checked" : "") }} value="1" />
                                <label for="current_department_pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_database" id="current_department_database" type="checkbox" {{ is_null(old('current_department_database')) ? ($profile->current_department_database ? "checked" : "") : (old('current_department_database') ? "checked" : "") }} value="1" />
                                <label for="current_department_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_finance" id="current_department_finance" type="checkbox" {{ is_null(old('current_department_finance')) ? ($profile->current_department_finance ? "checked" : "") : (old('current_department_finance') ? "checked" : "") }} value="1" />
                                <label for="current_department_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_arena_ops" id="current_department_arena_ops" type="checkbox" {{ is_null(old('current_department_arena_ops')) ? ($profile->current_department_arena_ops ? "checked" : "") : (old('current_department_arena_ops') ? "checked" : "") }} value="1" />
                                <label for="current_department_arena_ops">Arena Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_player_ops" id="current_department_player_ops" type="checkbox" {{ is_null(old('current_department_player_ops')) ? ($profile->current_department_player_ops ? "checked" : "") : (old('current_department_player_ops') ? "checked" : "") }} value="1" />
                                <label for="current_department_player_ops">Player Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_event_ops" id="current_department_event_ops" type="checkbox" {{ is_null(old('current_department_event_ops')) ? ($profile->current_department_event_ops ? "checked" : "") : (old('current_department_event_ops') ? "checked" : "") }} value="1" />
                                <label for="current_department_event_ops">Event Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_social_media" id="current_department_social_media" type="checkbox" {{ is_null(old('current_department_social_media')) ? ($profile->current_department_social_media ? "checked" : "") : (old('current_department_social_media') ? "checked" : "") }} value="1" />
                                <label for="current_department_social_media">Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_entertainment" id="current_department_entertainment" type="checkbox" {{ is_null(old('current_department_entertainment')) ? ($profile->current_department_entertainment ? "checked" : "") : (old('current_department_entertainment') ? "checked" : "") }} value="1" />
                                <label for="current_department_entertainment">Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_legal" id="current_department_legal" type="checkbox" {{ is_null(old('current_department_legal')) ? ($profile->current_department_legal ? "checked" : "") : (old('current_department_legal') ? "checked" : "") }} value="1" />
                                <label for="current_department_legal">Legal</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_other" id="current_department_other" type="text" />
                                <label for="current_department_other">Other</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-field col s12">
                        <input id="current-title" type="text" name="current_title" value="{{ old('current_title') ?: $profile->current_title ?: null }}">
                        <label for="current-title">If yes, what is your title</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="years-current-organization" type="text" name="years_current_organization" value="{{ old('years_current_organization') ?: $profile->years_current_organization ?: null }}">
                        <label for="years-current-organization">If yes, how many years have you been with your current organization?</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="years-current-role" type="text" name="years_current_role" value="{{ old('years_current_role') ?: $profile->years_current_role ?: null }}">
                        <label for="years-current-role">If yes, how many years have you been in your current role?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>If yes, which departments do you have experience in? Check all that apply:</p>
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_ticket_sales" type="checkbox" name="department_experience_ticket_sales" value="1" {{ is_null(old("department_experience_ticket_sales")) ? ($profile->department_experience_ticket_sales ? "checked" : "") : (old("department_experience_ticket_sales") ? "checked" : "") }} />
                                <label for="department_experience_ticket_sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_sponsorship_sales" type="checkbox" name="department_experience_sponsorship_sales" value="1" {{ is_null(old("department_experience_sponsorship_sales")) ? ($profile->department_experience_sponsorship_sales ? "checked" : "") : (old("department_experience_sponsorship_sales") ? "checked" : "") }} />
                                <label for="department_experience_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_service" type="checkbox" name="department_experience_service" value="1" {{ is_null(old("department_experience_service")) ? ($profile->department_experience_service ? "checked" : "") : (old("department_experience_service") ? "checked" : "") }} />
                                <label for="department_experience_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_premium_sales" type="checkbox" name="department_experience_premium_sales" value="1" {{ is_null(old("department_experience_premium_sales")) ? ($profile->department_experience_premium_sales ? "checked" : "") : (old("department_experience_premium_sales") ? "checked" : "") }} />
                                <label for="department_experience_premium_sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_marketing" type="checkbox" name="department_experience_marketing" value="1" {{ is_null(old("department_experience_marketing")) ? ($profile->department_experience_marketing ? "checked" : "") : (old("department_experience_marketing") ? "checked" : "") }} />
                                <label for="department_experience_marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_sponsorship_activation" type="checkbox" name="department_experience_sponsorship_activation" value="1" {{ is_null(old("department_experience_sponsorship_activation")) ? ($profile->department_experience_sponsorship_activation ? "checked" : "") : (old("department_experience_sponsorship_activation") ? "checked" : "") }} />
                                <label for="department_experience_sponsorship_activation">Sponsorship Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_hr" type="checkbox" name="department_experience_hr" value="1" {{ is_null(old("department_experience_hr")) ? ($profile->department_experience_hr ? "checked" : "") : (old("department_experience_hr") ? "checked" : "") }} />
                                <label for="department_experience_hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_analytics" type="checkbox" name="department_experience_analytics" value="1" {{ is_null(old("department_experience_analytics")) ? ($profile->department_experience_analytics ? "checked" : "") : (old("department_experience_analytics") ? "checked" : "") }} />
                                <label for="department_experience_analytics">Analytics</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_cr" type="checkbox" name="department_experience_cr" value="1" {{ is_null(old("department_experience_cr")) ? ($profile->department_experience_cr ? "checked" : "") : (old("department_experience_cr") ? "checked" : "") }} />
                                <label for="department_experience_cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_pr" type="checkbox" name="department_experience_pr" value="1" {{ is_null(old("department_experience_pr")) ? ($profile->department_experience_pr ? "checked" : "") : (old("department_experience_pr") ? "checked" : "") }} />
                                <label for="department_experience_pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_database" type="checkbox" name="department_experience_database" value="1" {{ is_null(old("department_experience_database")) ? ($profile->department_experience_database ? "checked" : "") : (old("department_experience_database") ? "checked" : "") }} />
                                <label for="department_experience_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_finance" type="checkbox" name="department_experience_finance" value="1" {{ is_null(old("department_experience_finance")) ? ($profile->department_experience_finance ? "checked" : "") : (old("department_experience_finance") ? "checked" : "") }} />
                                <label for="department_experience_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_arena_ops" type="checkbox" name="department_experience_arena_ops" value="1" {{ is_null(old("department_experience_arena_ops")) ? ($profile->department_experience_arena_ops ? "checked" : "") : (old("department_experience_arena_ops") ? "checked" : "") }} />
                                <label for="department_experience_arena_ops">Arena Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_player_ops" type="checkbox" name="department_experience_player_ops" value="1" {{ is_null(old("department_experience_player_ops")) ? ($profile->department_experience_player_ops ? "checked" : "") : (old("department_experience_player_ops") ? "checked" : "") }} />
                                <label for="department_experience_player_ops">Player Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_event_ops" type="checkbox" name="department_experience_event_ops" value="1" {{ is_null(old("department_experience_event_ops")) ? ($profile->department_experience_event_ops ? "checked" : "") : (old("department_experience_event_ops") ? "checked" : "") }} />
                                <label for="department_experience_event_ops">Event Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_social_media" type="checkbox" name="department_experience_social_media" value="1" {{ is_null(old("department_experience_social_media")) ? ($profile->department_experience_social_media ? "checked" : "") : (old("department_experience_social_media") ? "checked" : "") }} />
                                <label for="department_experience_social_media">Digital/Social Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_entertainment" type="checkbox" name="department_experience_entertainment" value="1" {{ is_null(old("department_experience_entertainment")) ? ($profile->department_experience_entertainment ? "checked" : "") : (old("department_experience_entertainment") ? "checked" : "") }} />
                                <label for="department_experience_entertainment">Game Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="department_experience_legal" type="checkbox" name="department_experience_legal" value="1" {{ is_null(old("department_experience_legal")) ? ($profile->department_experience_legal ? "checked" : "") : (old("department_experience_legal") ? "checked" : "") }} />
                                <label for="department_experience_legal">Legal</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_organization') ? 'invalid' : '' }}">
                        <input id="if_not_organization" type="text" name="if_not_organization" value="{{ old('if_not_organization') ?: $profile->if_not_organization ?: null }}">
                        <label for="if_not_organization">If not, where do you work now?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_department') ? 'invalid' : '' }}">
                        <input id="if_not_department" type="text" name="if_not_department" value="{{ old('if_not_department') ?: $profile->if_not_department ?: null }}">
                        <label for="if_not_department">If not, what department do you work in?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="if_not_title" type="text" name="if_not_title" value="{{ old('if_not_title') ?: $profile->if_not_title ?: null }}">
                        <label for="if_not_title">If not, what is your title?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="if_not_years_current_organization" type="text" name="if_not_years_current_organization" value="{{ old('if_not_years_current_organization') ?: $profile->if_not_years_current_organization ?: null }}">
                        <label for="if_not_years_current_organization">If not, how long have you been with your current organization?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="if_not_years_current_role" type="text" name="if_not_years_current_role" value="{{ old('if_not_years_current_role') ?: $profile->if_not_years_current_role ?: null }}">
                        <label for="if_not_years_current_role">If not, how long have you been in your current role?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>If not, which departments do you have experience in? Check all that apply:</p>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_phone_sales" name="if_not_department_experience_phone_sales" value="1" {{ is_null(old("if_not_department_experience_phone_sales")) ? ($profile->if_not_department_experience_phone_sales ? "checked" : "") : (old("if_not_department_experience_phone_sales") ? "checked" : "") }} />
                        <label for="if_not_department_experience_phone_sales">Phone sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_door_to_door_sales" name="if_not_department_experience_door_to_door_sales" value="1" {{ is_null(old("if_not_department_experience_door_to_door_sales")) ? ($profile->if_not_department_experience_door_to_door_sales ? "checked" : "") : (old("if_not_department_experience_door_to_door_sales") ? "checked" : "") }} />
                        <label for="if_not_department_experience_door_to_door_sales">Door-to-door sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_territory_management" name="if_not_department_experience_territory_management" value="1" {{ is_null(old("if_not_department_experience_territory_management")) ? ($profile->if_not_department_experience_territory_management ? "checked" : "") : (old("if_not_department_experience_territory_management") ? "checked" : "") }} />
                        <label for="if_not_department_experience_territory_management">Territory managements</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_b2b_sales" name="if_not_department_experience_b2b_sales" value="1" {{ is_null(old("if_not_department_experience_b2b_sales")) ? ($profile->if_not_department_experience_b2b_sales ? "checked" : "") : (old("if_not_department_experience_b2b_sales") ? "checked" : "") }} />
                        <label for="if_not_department_experience_b2b_sales">Business-to-business sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_customer_service" name="if_not_department_experience_customer_service" value="1" {{ is_null(old("if_not_department_experience_customer_service")) ? ($profile->if_not_department_experience_customer_service ? "checked" : "") : (old("if_not_department_experience_customer_service") ? "checked" : "") }} />
                        <label for="if_not_department_experience_customer_service">Customer service</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_sponsorship" name="if_not_department_experience_sponsorship" value="1" {{ is_null(old("if_not_department_experience_sponsorship")) ? ($profile->if_not_department_experience_sponsorship ? "checked" : "") : (old("if_not_department_experience_sponsorship") ? "checked" : "") }} />
                        <label for="if_not_department_experience_sponsorship">Sponsorship</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_high_level_business_development" name="if_not_department_experience_high_level_business_development" value="1" {{ is_null(old("if_not_department_experience_high_level_business_development")) ? ($profile->if_not_department_experience_high_level_business_development ? "checked" : "") : (old("if_not_department_experience_high_level_business_development") ? "checked" : "") }} />
                        <label for="if_not_department_experience_high_level_business_development">High level business development</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_marketing" name="if_not_department_experience_marketing" value="1" {{ is_null(old("if_not_department_experience_marketing")) ? ($profile->if_not_department_experience_marketing ? "checked" : "") : (old("if_not_department_experience_marketing") ? "checked" : "") }} />
                        <label for="if_not_department_experience_marketing">Marketing</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_analytics" name="if_not_department_experience_analytics" value="1" {{ is_null(old("if_not_department_experience_analytics")) ? ($profile->if_not_department_experience_analytics ? "checked" : "") : (old("if_not_department_experience_analytics") ? "checked" : "") }} />
                        <label for="if_not_department_experience_analytics">Analytics</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_bi" name="if_not_department_experience_bi" value="1" {{ is_null(old("if_not_department_experience_bi")) ? ($profile->if_not_department_experience_bi ? "checked" : "") : (old("if_not_department_experience_bi") ? "checked" : "") }} />
                        <label for="if_not_department_experience_bi">B.I.</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_database" name="if_not_department_experience_database" value="1" {{ is_null(old("if_not_department_experience_database")) ? ($profile->if_not_department_experience_database ? "checked" : "") : (old("if_not_department_experience_database") ? "checked" : "") }} />
                        <label for="if_not_department_experience_database">Database</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_digital" name="if_not_department_experience_digital" value="1" {{ is_null(old("if_not_department_experience_digital")) ? ($profile->if_not_department_experience_digital ? "checked" : "") : (old("if_not_department_experience_digital") ? "checked" : "") }} />
                        <label for="if_not_department_experience_digital">Digital</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_web_design" name="if_not_department_experience_web_design" value="1" {{ is_null(old("if_not_department_experience_web_design")) ? ($profile->if_not_department_experience_web_design ? "checked" : "") : (old("if_not_department_experience_web_design") ? "checked" : "") }} />
                        <label for="if_not_department_experience_web_design">Web design</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_social_media" name="if_not_department_experience_social_media" value="1" {{ is_null(old("if_not_department_experience_social_media")) ? ($profile->if_not_department_experience_social_media ? "checked" : "") : (old("if_not_department_experience_social_media") ? "checked" : "") }} />
                        <label for="if_not_department_experience_social_media">Social media</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_hr" name="if_not_department_experience_hr" value="1" {{ is_null(old("if_not_department_experience_hr")) ? ($profile->if_not_department_experience_hr ? "checked" : "") : (old("if_not_department_experience_hr") ? "checked" : "") }} />
                        <label for="if_not_department_experience_hr">HR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_finance" name="if_not_department_experience_finance" value="1" {{ is_null(old("if_not_department_experience_finance")) ? ($profile->if_not_department_experience_finance ? "checked" : "") : (old("if_not_department_experience_finance") ? "checked" : "") }} />
                        <label for="if_not_department_experience_finance">Finance</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_accounting" name="if_not_department_experience_accounting" value="1" {{ is_null(old("if_not_department_experience_accounting")) ? ($profile->if_not_department_experience_accounting ? "checked" : "") : (old("if_not_department_experience_accounting") ? "checked" : "") }} />
                        <label for="if_not_department_experience_accounting">Accounting</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_organizational_development" name="if_not_department_experience_organizational_development" value="1" {{ is_null(old("if_not_department_experience_organizational_development")) ? ($profile->if_not_department_experience_organizational_development ? "checked" : "") : (old("if_not_department_experience_organizational_development") ? "checked" : "") }} />
                        <label for="if_not_department_experience_organizational_development">Organizational development</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_communications" name="if_not_department_experience_communications" value="1" {{ is_null(old("if_not_department_experience_communications")) ? ($profile->if_not_department_experience_communications ? "checked" : "") : (old("if_not_department_experience_communications") ? "checked" : "") }} />
                        <label for="if_not_department_experience_communications">Communications</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_pr" name="if_not_department_experience_pr" value="1" {{ is_null(old("if_not_department_experience_pr")) ? ($profile->if_not_department_experience_pr ? "checked" : "") : (old("if_not_department_experience_pr") ? "checked" : "") }} />
                        <label for="if_not_department_experience_pr">PR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_media_relations" name="if_not_department_experience_media_relations" value="1" {{ is_null(old("if_not_department_experience_media_relations")) ? ($profile->if_not_department_experience_media_relations ? "checked" : "") : (old("if_not_department_experience_media_relations") ? "checked" : "") }} />
                        <label for="if_not_department_experience_media_relations">Media relations</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_legal" name="if_not_department_experience_legal" value="1" {{ is_null(old("if_not_department_experience_legal")) ? ($profile->if_not_department_experience_legal ? "checked" : "") : (old("if_not_department_experience_legal") ? "checked" : "") }} />
                        <label for="if_not_department_experience_legal">Legal</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_it" name="if_not_department_experience_it" value="1" {{ is_null(old("if_not_department_experience_it")) ? ($profile->if_not_department_experience_it ? "checked" : "") : (old("if_not_department_experience_it") ? "checked" : "") }} />
                        <label for="if_not_department_experience_it">IT</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="text" id="if_not_department_experience_other" name="if_not_department_experience_other" {{ is_null(old("if_not_department_experience_other")) ? ($profile->if_not_department_experience_other ? "checked" : "") : (old("if_not_department_experience_other") ? "checked" : "") }} />
                        <label for="if_not_department_experience_other">Other</label>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">school</i>Educational History</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s6">
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
                        <input id="gpa" type="text" name="gpa" value="{{ old('gpa') }}">
                        <label for="gpa">What was/is your undergraduate GPA?</label>
                    </div>
                </div>
                <div class="input-field">
                    <textarea id="college-organizations" class="materialize-textarea" name="college_organizations">{{ old('college_organizations') ?: $profile->college_organizations ?: null }}</textarea>
                    <label for="college-organizations">What collegiate organizations did/do you belong to? List any leadership positions you held.</label>
                </div>
                <div class="input-field">
                    <textarea id="college-sports-clubs" class="materialize-textarea" name="college_sports_clubs">{{ old('college_sports_clubs') ?: $profile->college_sports_clubs ?: null }}</textarea>
                    <label for="college-sports-clubs">What sports business clubs or in your athletic department(s) were you involved in? List any leadership positions you held.</label>
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
