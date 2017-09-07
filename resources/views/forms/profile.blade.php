<form method="post" action="/user/{{ $user->id }}/profile">
    {{ csrf_field() }}
    <ul class="collapsible" data-collapsible="accordion">
        <li> <!-- Personal Information -->
            <div class="collapsible-header"><i class="material-icons">person</i>Personal Information</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="phone" type="text" name="phone" value="{{ old('phone') ?: $profile->phone ?: "" }}" />
                        <label for="phone">Phone</label>
                    </div>
                    <div class="input-field col s12 m6">
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
                            <option value="" {{ old('employment_status') == "" ? "selected" : "" }} disabled>Employment status</option>
                            <option value="full-time" {{ old('employment_status') == "full-time" ? 'selected' : $profile->employment_status == "full-time" ? 'selected' : '' }}>Employed full-time</option>
                            <option value="part-time" {{ old('employment_status') == "part-time" ? 'selected' : $profile->employment_status == "part-time" ? 'selected' : '' }}>Employed part-time</option>
                            <option value="none" {{ old('employment_status') == "none" ? 'selected' : $profile->employment_status == "none" ? 'selected' : '' }}>Unemployed</option>
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
                          <input name="employed_in_sports_sales" type="radio" value="1" {{ is_null(old('employed_in_sports_sales')) ? ($profile->employed_in_sports_sales ? "checked" : "") : (old('employed_in_sports_sales') ? "checked" : "") }} />
                          <label>Yes</label>
                        </p>
                        <p>
                          <input name="employed_in_sports_sales" type="radio" value="0" {{ is_null(old('employed_in_sports_sales')) ? ($profile->employed_in_sports_sales ? "" : "checked") : (old('employed_in_sports_sales') ? "" : "checked") }} />
                          <label>No</label>
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
                        <!-- TODO -->
                        <select class="browser-default" name="next_sales_job">
                            <option value="" {{ old('next_sales_job') == "" ? "selected" : "" }} disabled>If yes, which sports sales job is the next step for you?</option>
                            <option value="inside_sales" {{ old('next_sales_job') == "inside_sales" ? 'selected' : $profile->next_sales_job == "inside_sales" ? 'selected' : '' }}>Inside Sales – Entry level sales</option>
                            <option value="executive_sales" {{ old('next_sales_job') == "executive_sales" ? 'selected' : $profile->next_sales_job == "executive_sales" ? 'selected' : '' }}>Account Executive, Group or Season Sales – Mid level sales</option>
                            <option value="executive_service" {{ old('next_sales_job') == "executive_service" ? 'selected' : $profile->next_sales_job == "executive_service" ? 'selected' : '' }}>Account Executive, Service and Retention – Mid level service</option>
                            <option value="premium_sales" {{ old('next_sales_job') == "premium_sales" ? 'selected' : $profile->next_sales_job == "premium_sales" ? 'selected' : '' }}>Premium Sales – Advanced sales</option>
                            <option value="sponsorship_sales" {{ old('next_sales_job') == "sponsorship_sales" ? 'selected' : $profile->next_sales_job == "sponsorship_sales" ? 'selected' : '' }}>Sponsorship Sales – Sr. and Exec. level sales</option>
                            <option value="manager" {{ old('next_sales_job') == "manager" ? 'selected' : $profile->next_sales_job == "manager" ? 'selected' : '' }}>Inside Sales – Managing entry level sales team</option>
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
                        <!-- TODO -->
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
                    <!-- TODO -->
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
            </div>
        </li>
        <li>
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
                    <div class="input-field col s12 {{ $errors->has('years_in_sports') ? 'invalid' : '' }}">
                        <input id="years-in-sports" type="text" name="years_in_sports" value="{{ old('years_in_sports') ?: $profile->years_in_sports ?: null }}">
                        <label for="years-in-sports">If yes, how many years have you worked in sports?</label>
                    </div>
                    <div class="input-field col s12 {{ $errors->has('current_organization') ? 'invalid' : '' }}">
                        <input id="current-organization" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}">
                        <label for="current-organization">If yes, which organization?</label>
                    </div>
                    <div class="input-field col s12">
                        <!-- TODO -->
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
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_ticket_sales" id="current_department_ticket_sales" type="checkbox" {{ old('current_department_ticket_sales') ? "checked" : "" }} value="1" />
                                <label for="current_department_ticket_sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_sponsorship_sales" id="current_department_sponsorship_sales" type="checkbox" {{ old('current_department_sponsorship_sales') ? "checked" : "" }} value="1" />
                                <label for="current_department_sponsorship_sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_service" id="current_department_service" type="checkbox" {{ old('current_department_service') ? "checked" : "" }} value="1" />
                                <label for="current_department_service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_premium_sales" id="current_department_premium_sales" type="checkbox" {{ old('current_department_premium_sales') ? "checked" : "" }} value="1" />
                                <label for="current_department_premium_sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_marketing" id="current_department_marketing" type="checkbox" {{ old('current_department_marketing') ? "checked" : "" }} value="1" />
                                <label for="current_department_marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_sponsorship_activation" id="current_department_sponsorship_activation" type="checkbox" {{ old('current_department_sponsorship_activation') ? "checked" : "" }} value="1" />
                                <label for="current_department_sponsorship_activation">Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_hr" id="current_department_hr" type="checkbox" {{ old('current_department_hr') ? "checked" : "" }} value="1" />
                                <label for="current_department_hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_cr" id="current_department_cr" type="checkbox" {{ old('current_department_cr') ? "checked" : "" }} value="1" />
                                <label for="current_department_cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_pr" id="current_department_pr" type="checkbox" {{ old('current_department_pr') ? "checked" : "" }} value="1" />
                                <label for="current_department_pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_database" id="current_department_database" type="checkbox" {{ old('current_department_database') ? "checked" : "" }} value="1" />
                                <label for="current_department_database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_finance" id="current_department_finance" type="checkbox" {{ old('current_department_finance') ? "checked" : "" }} value="1" />
                                <label for="current_department_finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_arena_ops" id="current_department_arena_ops" type="checkbox" {{ old('current_department_arena_ops') ? "checked" : "" }} value="1" />
                                <label for="current_department_arena_ops">Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_player_ops" id="current_department_player_ops" type="checkbox" {{ old('current_department_player_ops') ? "checked" : "" }} value="1" />
                                <label for="current_department_player_ops">Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_event_ops" id="current_department_event_ops" type="checkbox" {{ old('current_department_event_ops') ? "checked" : "" }} value="1" />
                                <label for="current_department_event_ops">Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_social_media" id="current_department_social_media" type="checkbox" {{ old('current_department_social_media') ? "checked" : "" }} value="1" />
                                <label for="current_department_social_media">Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_entertainment" id="current_department_entertainment" type="checkbox" {{ old('current_department_entertainment') ? "checked" : "" }} value="1" />
                                <label for="current_department_entertainment">Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_legal" id="current_department_legal" type="checkbox" {{ old('current_department_legal') ? "checked" : "" }} value="1" />
                                <label for="current_department_legal">Legal</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input name="current_department_other" id="current_department_other" type="text" />
                                <label for="current_department_other">Other</label>
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
                                <input id="ticket-sales" type="checkbox" name="department_experience_ticket_sales" value="{{ old("department_experience_ticket_sales") ?: $profile->department_experience_ticket_sales ?: null }}" value="1" />
                                <label for="ticket-sales">Ticket Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="sponsorship-sales" type="checkbox" name="department_experience_sponsorship_sales" value="{{ old("department_experience_sponsorship_sales") ?: $profile->department_experience_sponsorship_sales ?: null }}" value="1" />
                                <label for="sponsorship-sales">Sponsorship Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="service" type="checkbox" name="department_experience_service" value="{{ old("department_experience_service") ?: $profile->department_experience_service ?: null }}" value="1" />
                                <label for="service">Service</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="premium-sales" type="checkbox" name="department_experience_premium_sales" value="{{ old("department_experience_premium_sales") ?: $profile->department_experience_premium_sales ?: null }}" value="1" />
                                <label for="premium-sales">Premium Sales</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="marketing" type="checkbox" name="department_experience_marketing" value="{{ old("department_experience_marketing") ?: $profile->department_experience_marketing ?: null }}" value="1" />
                                <label for="marketing">Marketing</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="sponsorship-activation" type="checkbox" name="department_experience_sponsorship_activation" value="{{ old("department_experience_sponsorship_activation") ?: $profile->department_experience_sponsorship_activation ?: null }}" value="1" />
                                <label for="sponsorship-activation">Sponsorship Activation</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="hr" type="checkbox" name="department_experience_hr" value="{{ old("department_experience_hr") ?: $profile->department_experience_hr ?: null }}" value="1" />
                                <label for="hr">HR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="analytics" type="checkbox" name="department_experience_analytics" value="{{ old("department_experience_analytics") ?: $profile->department_experience_analytics ?: null }}" value="1" />
                                <label for="analytics">Analytics</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="cr" type="checkbox" name="department_experience_cr" value="{{ old("department_experience_cr") ?: $profile->department_experience_cr ?: null }}" value="1" />
                                <label for="cr">CR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="pr" type="checkbox" name="department_experience_pr" value="{{ old("department_experience_pr") ?: $profile->department_experience_pr ?: null }}" value="1" />
                                <label for="pr">PR</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="database" type="checkbox" name="department_experience_database" value="{{ old("department_experience_database") ?: $profile->department_experience_database ?: null }}" value="1" />
                                <label for="database">Database</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="finance" type="checkbox" name="department_experience_finance" value="{{ old("department_experience_finance") ?: $profile->department_experience_finance ?: null }}" value="1" />
                                <label for="finance">Finance</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="arena-ops" type="checkbox" name="department_experience_arena_ops" value="{{ old("department_experience_arena_ops") ?: $profile->department_experience_arena_ops ?: null }}" value="1" />
                                <label for="arena-ops">Arena Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="player-ops" type="checkbox" name="department_experience_player_ops" value="{{ old("department_experience_player_ops") ?: $profile->department_experience_player_ops ?: null }}" value="1" />
                                <label for="player-ops">Player Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="event-ops" type="checkbox" name="department_experience_event_ops" value="{{ old("department_experience_event_ops") ?: $profile->department_experience_event_ops ?: null }}" value="1" />
                                <label for="event-ops">Event Ops</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="social-media" type="checkbox" name="department_experience_social_media" value="{{ old("department_experience_social_media") ?: $profile->department_experience_social_media ?: null }}" value="1" />
                                <label for="social-media">Digital/Social Media</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="entertainment" type="checkbox" name="department_experience_entertainment" value="{{ old("department_experience_entertainment") ?: $profile->department_experience_entertainment ?: null }}" value="1" />
                                <label for="entertainment">Game Entertainment</label>
                            </div>
                            <div class="input-field col s12 m6 l4">
                                <input id="legal" type="checkbox" name="department_experience_legal" value="{{ old("department_experience_legal") ?: $profile->department_experience_legal ?: null }}" value="1" />
                                <label for="legal">Legal</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_organization') ? 'invalid' : '' }}">
                        <input id="if-not-organization" type="text" name="if_not_organization" value="{{ old('if_not_organization') ?: $profile->if_not_organization ?: null }}">
                        <label for="if-not-organization">If not, where do you work now?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_department') ? 'invalid' : '' }}">
                        <input id="if-not-department" type="text" name="if_not_department" value="{{ old('if_not_department') ?: $profile->if_not_department ?: null }}">
                        <label for="if-not-department">If not, what department do you work in?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_title') ? 'invalid' : '' }}">
                        <input id="if-not-title" type="text" name="if_not_title" value="{{ old('if_not_title') ?: $profile->if_not_title ?: null }}">
                        <label for="if-not-title">If not, what is your title?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_years_current_organization') ? 'invalid' : '' }}">
                        <input id="if-not-years-current-organization" type="text" name="if_not_years_current_organization" value="{{ old('if_not_years_current_organization') ?: $profile->if_not_years_current_organization ?: null }}">
                        <label for="if-not-years-current-organization">If not, how long have you been with your current organization?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 {{ $errors->has('if_not_years_current_role') ? 'invalid' : '' }}">
                        <input id="if-not-years-current-role" type="text" name="if_not_years_current_role" value="{{ old('if_not_years_current_role') ?: $profile->if_not_years_current_role ?: null }}">
                        <label for="if-not-years-current-role">If not, how long have you been in your current role?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>If not, which departments do you have experience in? Check all that apply:</p>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_phone_sales" name="if_not_department_experience_phone_sales" value="1" />
                        <label for="if_not_department_experience_phone_sales">Phone sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_door_to_door_sales" name="if_not_department_experience_door_to_door_sales" value="1" />
                        <label for="if_not_department_experience_door_to_door_sales">Door-to-door sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_territory_management" name="if_not_department_experience_territory_management" value="1" />
                        <label for="if_not_department_experience_territory_management">Territory managements</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_b2b_sales" name="if_not_department_experience_b2b_sales" value="1" />
                        <label for="if_not_department_experience_b2b_sales">Business-to-business sales</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_customer_service" name="if_not_department_experience_customer_service" value="1" />
                        <label for="if_not_department_experience_customer_service">Customer service</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_sponsorship" name="if_not_department_experience_sponsorship" value="1" />
                        <label for="if_not_department_experience_sponsorship">Sponsorship</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_high_level_business_development" name="if_not_department_experience_high_level_business_development" value="1" />
                        <label for="if_not_department_experience_high_level_business_development">High level business development</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_marketing" name="if_not_department_experience_marketing" value="1" />
                        <label for="if_not_department_experience_marketing">Marketing</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_analytics" name="if_not_department_experience_analytics" value="1" />
                        <label for="if_not_department_experience_analytics">Analytics</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_bi" name="if_not_department_experience_bi" value="1" />
                        <label for="if_not_department_experience_bi">B.I.</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_database" name="if_not_department_experience_database" value="1" />
                        <label for="if_not_department_experience_database">Database</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_digital" name="if_not_department_experience_digital" value="1" />
                        <label for="if_not_department_experience_digital">Digital</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_web_design" name="if_not_department_experience_web_design" value="1" />
                        <label for="if_not_department_experience_web_design">Web design</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_social_media" name="if_not_department_experience_social_media" value="1" />
                        <label for="if_not_department_experience_social_media">Social media</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_hr" name="if_not_department_experience_hr" value="1" />
                        <label for="if_not_department_experience_hr">HR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_finance" name="if_not_department_experience_finance" value="1" />
                        <label for="if_not_department_experience_finance">Finance</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_accounting" name="if_not_department_experience_accounting" value="1" />
                        <label for="if_not_department_experience_accounting">Accounting</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_organizational_development" name="if_not_department_experience_organizational_development" value="1" />
                        <label for="if_not_department_experience_organizational_development">Organizational development</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_communications" name="if_not_department_experience_communications" value="1" />
                        <label for="if_not_department_experience_communications">Communications</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_pr" name="if_not_department_experience_pr" value="1" />
                        <label for="if_not_department_experience_pr">PR</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_media_relations" name="if_not_department_experience_media_relations" value="1" />
                        <label for="if_not_department_experience_media_relations">Media relations</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_legal" name="if_not_department_experience_legal" value="1" />
                        <label for="if_not_department_experience_legal">Legal</label>
                    </div>
                    <div class="input-field col s12 m6 l4">
                        <input type="checkbox" id="if_not_department_experience_it" name="if_not_department_experience_it" value="1" />
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
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">school</i>Educational History</div>
            <div class="collapsible-body">
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
                        <input id="gpa" type="text" name="gpa" value="{{ old('gpa') }}">
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
                        <input id="email_preference_entry_job" type="checkbox" name="email_preference_entry_job" value="1" {{ old('email_preference_entry_job') ? "checked" : "" }} />
                        <label for="email_preference_entry_job">Getting an entry level job in sports</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_new_job" type="checkbox" name="email_preference_new_job" value="1" {{ old('email_preference_new_job') ? "checked" : "" }} />
                        <label for="email_preference_new_job">New job openings in sports</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_ticket_sales" type="checkbox" name="email_preference_ticket_sales" value="1" {{ old('email_preference_ticket_sales') ? "checked" : "" }} />
                        <label for="email_preference_ticket_sales">Ticket sales tips and tricks</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_leadership" type="checkbox" name="email_preference_leadership" value="1" {{ old('email_preference_leadership') ? "checked" : "" }} />
                        <label for="email_preference_leadership">Sales Leadership/management/strategy</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_best_practices" type="checkbox" name="email_preference_best_practices" value="1" {{ old('email_preference_best_practices') ? "checked" : "" }} />
                        <label for="email_preference_best_practices">Industry best practices and sports business articles</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email_preference_career_advice" type="checkbox" name="email_preference_career_advice" value="1" {{ old('email_preference_career_advice') ? "checked" : "" }} />
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
