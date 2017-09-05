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
                <option value="" {{old('gender') == "" ? "selected" : "" }} disabled>N/A</option>
                <option value="female" {{old('gender') == "female" ? 'selected' : $profile->gender == "female" ? 'selected' : '' }}>Female</option>
                <option value="male" {{old('gender') == "male" ? 'selected' : $profile->gender == "male" ? 'selected' : '' }}>Male</option>
                <option value="non-binary" {{old('gender') == "non-binary" ? 'selected' : $profile->gender == "non-binary" ? 'selected' : '' }}>Non-binary</option>
            </select>
        </div>
        <div class="input-field col s12 m6">
            <select class="browser-default" name="ethnicity">
                <option value="" {{old('ethnicity') == "" ? "selected" : "" }} disabled>N/A</option>
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
    <h4>Job Preferences</h4>
    <div class="row">
        <div class="input-field col s12 m4">
            <select class="browser-default" name="employment_status">
                <option value="" {{old('employment_status') == "" ? "selected" : "" }} disabled>Employment Status</option>
                <option value="full-time" {{old('employment_status') == "full-time" ? 'selected' : $profile->employment_status == "full-time" ? 'selected' : '' }}>Employed full-time</option>
                <option value="part-time" {{old('employment_status') == "part-time" ? 'selected' : $profile->employment_status == "part-time" ? 'selected' : '' }}>Employed part-time</option>
                <option value="none" {{old('employment_status') == "none" ? 'selected' : $profile->employment_status == "none" ? 'selected' : '' }}>Unemployed</option>
            </select>
        </div>
        <div class="input-field col s12 m4">
            <select class="browser-default" name="job_seeking_status">
                <option value="" {{old('job_seeking_status') == "" ? "selected" : "" }} disabled>Job Seeking Status</option>
                <option value="active" {{old('job_seeking_status') == "active" ? 'selected' : $profile->job_seeking_status == "active" ? 'selected' : '' }}>Actively looking</option>
                <option value="passive" {{old('job_seeking_status') == "passive" ? 'selected' : $profile->job_seeking_status == "passive" ? 'selected' : '' }}>Happy where I am but open to good opportunities</option>
                <option value="not" {{old('job_seeking_status') == "not" ? 'selected' : $profile->job_seeking_status == "not" ? 'selected' : '' }}>Happy where I am and not open to anything new</option>
            </select>
        </div>
    </div>
    <div class="row">
        <input id="receives-job-notifications" type="checkbox" name="receives_job_notifications" value="{{ old('receives_job_notifications') ?: $profile->receives_job_notifications ?: null }}" />
        <label for="receives-job-notifications">Do you want to be considered for future jobs in the sports industry?</label>
    </div>
    <!-- If yes, check all departments that interest you -->
    <div class="row">
        <div class="input-field col s8 offset-m1">
            <div class="col s6">
                <input id="ticket-sales" type="checkbox" name="ticket_sales" value="{{ old('ticket_sales') ?: $profile->department_interests ?: null }}" />
                <label for="ticket-sales">Ticket Sales</label>
            </div>
            <div class="col s6">
                <input id="sponsorship-sales" type="checkbox" name="sponsorship_sales" value="{{ old('sponsorship_sales') ?: $profile->department_interests ?: null }}" />
                <label for="sponsorship-sales">Sponsorship Sales</label>
            </div>
            <div class="col s6">
                <input id="service" type="checkbox" name="service" value="{{ old('service') ?: $profile->department_interests ?: null }}" />
                <label for="service">Service</label>
            </div>
            <div class="col s6">
                <input id="premium-sales" type="checkbox" name="premium_sales" value="{{ old('premium_sales') ?: $profile->department_interests ?: null }}" />
                <label for="premium-sales">Premium Sales</label>
            </div>
            <div class="col s6">
                <input id="marketing" type="checkbox" name="marketing" value="{{ old('marketing') ?: $profile->department_interests ?: null }}" />
                <label for="marketing">Marketing</label>
            </div>
            <div class="col s6">
                <input id="sponsorship-activation" type="checkbox" name="sponsorship-activation" value="{{ old('sponsorship-activation') ?: $profile->department_interests ?: null }}" />
                <label for="sponsorship-activation">Sponsorship Activation</label>
            </div>
            <div class="col s6">
                <input id="hr" type="checkbox" name="hr" value="{{ old('hr') ?: $profile->department_interests ?: null }}" />
                <label for="hr">HR</label>
            </div>
            <div class="col s6">
                <input id="analytics" type="checkbox" name="analytics" value="{{ old('analytics') ?: $profile->department_interests ?: null }}" />
                <label for="analytics">Analytics</label>
            </div>
            <div class="col s6">
                <input id="cr" type="checkbox" name="cr" value="{{ old('cr') ?: $profile->department_interests ?: null }}" />
                <label for="cr">CR</label>
            </div>
            <div class="col s6">
                <input id="pr" type="checkbox" name="pr" value="{{ old('pr') ?: $profile->department_interests ?: null }}" />
                <label for="pr">PR</label>
            </div>
            <div class="col s6">
                <input id="database" type="checkbox" name="database" value="{{ old('database') ?: $profile->department_interests ?: null }}" />
                <label for="database">Database</label>
            </div>
            <div class="col s6">
                <input id="finance" type="checkbox" name="finance" value="{{ old('finance') ?: $profile->department_interests ?: null }}" />
                <label for="finance">Finance</label>
            </div>
            <div class="col s6">
                <input id="arena-ops" type="checkbox" name="arena-ops" value="{{ old('arena-ops') ?: $profile->department_interests ?: null }}" />
                <label for="arena-ops">Arena Ops</label>
            </div>
            <div class="col s6">
                <input id="player-ops" type="checkbox" name="player-ops" value="{{ old('player-ops') ?: $profile->department_interests ?: null }}" />
                <label for="player-ops">Player Ops</label>
            </div>
            <div class="col s6">
                <input id="event-ops" type="checkbox" name="event-ops" value="{{ old('event-ops') ?: $profile->department_interests ?: null }}" />
                <label for="event-ops">Event Ops</label>
            </div>
            <div class="col s6">
                <input id="social-media" type="checkbox" name="social-media" value="{{ old('social-media') ?: $profile->department_interests ?: null }}" />
                <label for="social-media">Digital/Social Media</label>
            </div>
            <div class="col s6">
                <input id="entertainment" type="checkbox" name="entertainment" value="{{ old('entertainment') ?: $profile->department_interests ?: null }}" />
                <label for="entertainment">Game Entertainment</label>
            </div>
            <div class="col s6">
                <input id="legal" type="checkbox" name="legal" value="{{ old('legal') ?: $profile->department_interests ?: null }}" />
                <label for="legal">Legal</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <p>When making a decision on your next job in sports which of the following are most important?</p>
            <select multiple>
                <option value="" {{old('job_decision_factors') == "" ? "selected" : "" }} disabled>Choose three</option>
                <option value="active" {{old('job_decision_factors') == "active" ? 'selected' : $profile->job_seeking_status == "active" ? 'selected' : '' }}>Temp 1</option>
                <option value="passive" {{old('job_decision_factors') == "passive" ? 'selected' : $profile->job_seeking_status == "passive" ? 'selected' : '' }}>Temp 2</option>
                <option value="passive" {{old('job_decision_factors') == "passive" ? 'selected' : $profile->job_seeking_status == "passive" ? 'selected' : '' }}>Temp 3</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="employed-in-sports-sales" type="checkbox" name="employed_in_sports_sales" value="{{ old('employed_in_sports_sales') ?: $profile->employed_in_sports_sales ?: null }}" />
            <label for="employed-in-sports-sales">Are you currently employed in sports sales?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="continuing-sports-sales" type="checkbox" name="continuing_sports_sales" value="{{ old('continuing_sports_sales') ?: $profile->continuing_sports_sales ?: null }}" />
            <label for="continuing-sports-sales">Do you want to continue your career in sports sales?</label>
        </div>
        <!-- If yes, which sports sales job is the next step for you? -->
        <div class="input-field col s8 offset-m1">
            <select class="browser-default" name="next_sales_job">
                <option value="" {{old('next_sales_job') == "" ? "selected" : "" }} disabled>Which sports sales job is the next step for you?</option>
                <option value="inside-sales" {{old('next_sales_job') == "inside-sales" ? 'selected' : $profile->next_sales_job == "inside-sales" ? 'selected' : '' }}>Inside Sales – Entry level sales</option>
                <option value="executive-sales" {{old('next_sales_job') == "executive-sales" ? 'selected' : $profile->next_sales_job == "executive-sales" ? 'selected' : '' }}>Account Executive, Group or Season Sales – Mid level sales</option>
                <option value="executive-service" {{old('next_sales_job') == "executive-service" ? 'selected' : $profile->next_sales_job == "executive-service" ? 'selected' : '' }}>Account Executive, Service and Retention – Mid level service</option>
                <option value="premium-sales" {{old('next_sales_job') == "premium-sales" ? 'selected' : $profile->next_sales_job == "premium-sales" ? 'selected' : '' }}>Premium Sales – Advanced sales</option>
                <option value="sponsorship-sales" {{old('next_sales_job') == "sponsorship-sales" ? 'selected' : $profile->next_sales_job == "sponsorship-sales" ? 'selected' : '' }}>Sponsorship Sales – Sr. and Exec. level sales</option>
                <option value="manager" {{old('next_sales_job') == "manager" ? 'selected' : $profile->next_sales_job == "manager" ? 'selected' : '' }}>Inside Sales – Managing entry level sales team</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="is-sports-sales-manager" type="checkbox" name="is_sports_sales_manager" value="{{ old('is_sports_sales_manager') ?: $profile->is_sports_sales_manager ?: null }}" />
            <label for="is-sports-sales-manager">Are you a sports sales manager?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="continuing-management" type="checkbox" name="continuing_management" value="{{ old('continuing_management') ?: $profile->continuing_management ?: null }}" />
            <label for="continuing-management">Do you want to continue your career in sports sales leadership?</label>
        </div>
        <!-- If yes, what management job is the next step for you? -->
        <div class="input-field col s8 offset-m1">
            <select class="browser-default" name="next_management_job">
                <option value="" {{old('next_management_job') == "" ? "selected" : "" }} disabled>What management job is the next step for you?</option>
                <option value="manager-entry" {{old('next_management_job') == "manager-entry" ? 'selected' : $profile->next_executive == "manager-entry" ? 'selected' : '' }}>Manager – Inside Sales – Managing entry level team</option>
                <option value="manager-mid" {{old('next_management_job') == "manager-mid" ? 'selected' : $profile->next_executive == "manager-mid" ? 'selected' : '' }}>Manager - Season, Premium, Group, Service, Sponsorship, Activation – Managing mid level team</option>
                <option value="director" {{old('next_management_job') == "director" ? 'selected' : $profile->next_executive == "director" ? 'selected' : '' }}>Director - Seasons, Premium, Group, Service, Sponsorship, Activation – Running strategy for your team</option>
                <option value="sr-director" {{old('next_management_job') == "sr-director" ? 'selected' : $profile->next_executive == "sr-director" ? 'selected' : '' }}>Sr. Director – Running strategy for multiple departments and managing managers v. Vice President – Ticket Sales, Service and Retention, Sponsorship – Running the whole operation</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="is-executive" type="checkbox" name="is_executive" value="{{ old('is_executive') ?: $profile->is_executive ?: null }}" />
            <label for="is-executive">Are you an executive in sports business?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="continuing-executive" type="checkbox" name="continuing_executive" value="{{ old('continuing_executive') ?: $profile->continuing_executive ?: null }}" />
            <label for="continuing-executive">Do you want to continue your career as a sports executive?</label>
        </div>
        <!-- If yes, which is the next step for you? -->
        <div class="input-field col s8 offset-m1">
            <select class="browser-default" name="next_executive">
                <option value="" {{old('next_executive') == "" ? "selected" : "" }} disabled>Which is the next step for you?</option>
                <option value="vp" {{old('next_executive') == "vp" ? 'selected' : $profile->next_executive == "vp" ? 'selected' : '' }}>VP</option>
                <option value="svp" {{old('next_executive') == "svp" ? 'selected' : $profile->next_executive == "svp" ? 'selected' : '' }}>SVP</option>
                <option value="evp" {{old('next_executive') == "evp" ? 'selected' : $profile->next_executive == "evp" ? 'selected' : '' }}>EVP</option>
                <option value="cro" {{old('next_executive') == "cro" ? 'selected' : $profile->next_executive == "cro" ? 'selected' : '' }}>CRO</option>
                <option value="cmo" {{old('next_executive') == "cmo" ? 'selected' : $profile->next_executive == "cmo" ? 'selected' : '' }}>CMO</option>
                <option value="c" {{old('next_executive') == "c" ? 'selected' : $profile->next_executive == "c" ? 'selected' : '' }}>C Level</option>
            </select>
        </div>
    </div>

    <div class="row">
        <h4>Employment History</h4>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="works-in-sports" type="checkbox" name="works_in_sports" value="{{ old('works_in_sports') ?: $profile->works_in_sports ?: null }}" />
            <label for="works-in-sports">Are you currently working in sports?</label>
        </div>
        <!-- If yes, how many years have you worked in sports? -->
        <div class="input-field col s4 offset-m1 {{ $errors->has('years_in_sports') ? 'invalid' : '' }}">
            <input id="years-in-sports" type="text" name="years_in_sports" value="{{ old('years_in_sports') ?: $profile->years_in_sports ?: null }}">
            <label for="years-in-sports">How many years have you worked in sports?</label>
        </div>
        <!-- If yes, which organization? -->
        <div class="input-field col s8 offset-m1 {{ $errors->has('current_organization') ? 'invalid' : '' }}">
            <input id="current-organization" type="text" name="current_organization" value="{{ old('current_organization') ?: $profile->current_organization ?: null }}">
            <label for="current-organization">Which organization?</label>
        </div>
        <!-- If yes, which region? -->
        <div class="input-field col s8 offset-m1">
            <select class="browser-default" name="current_region">
                <option value="" {{old('current_region') == "" ? "selected" : "" }} disabled>What geographic region do you work in?</option>
                <option value="mw" {{old('current_region') == "mw" ? 'selected' : $profile->current_region == "mw" ? 'selected' : '' }}>Midwest</option>
                <option value="ne" {{old('current_region') == "ne" ? 'selected' : $profile->current_region == "ne" ? 'selected' : '' }}>Northeast</option>
                <option value="nw" {{old('current_region') == "nw" ? 'selected' : $profile->current_region == "nw" ? 'selected' : '' }}>Northwest</option>
                <option value="se" {{old('current_region') == "se" ? 'selected' : $profile->current_region == "se" ? 'selected' : '' }}>Southeast</option>
                <option value="sw" {{old('current_region') == "sw" ? 'selected' : $profile->current_region == "sw" ? 'selected' : '' }}>Southwest</option>
            </select>
        </div>
        <!-- If yes, which department? -->
        <div class="input-field col s8 offset-m1">
            <select class="browser-default" name="current_department">
                <option value="" {{old('current_department') == "" ? "selected" : "" }} disabled>What department do you work in?</option>
                <option value="ticket-sales" {{old('current_department') == "ticket-sales" ? 'selected' : $profile->current_department == "ticket-sales" ? 'selected' : '' }}>Ticket Sales</option>
                <option value="sponsorship-sales" {{old('current_department') == "sponsorship-sales" ? 'selected' : $profile->current_department == "sponsorship-sales" ? 'selected' : '' }}>Sponsorship Sales</option>
                <option value="service" {{old('current_department') == "service" ? 'selected' : $profile->current_department == "service" ? 'selected' : '' }}>Service</option>
                <option value="premium-sales" {{old('current_department') == "premium-sales" ? 'selected' : $profile->current_department == "premium-sales" ? 'selected' : '' }}>Premium Sales</option>
                <option value="marketing" {{old('current_department') == "marketing" ? 'selected' : $profile->current_department == "marketing" ? 'selected' : '' }}>Marketing</option>
                <option value="sponsorship-activation" {{old('current_department') == "sponsorship-activation" ? 'selected' : $profile->current_department == "sponsorship-activation" ? 'selected' : '' }}>Sponsorship Activation</option>
                <option value="hr" {{old('current_department') == "hr" ? 'selected' : $profile->current_department == "hr" ? 'selected' : '' }}>HR</option>
                <option value="cr" {{old('current_department') == "cr" ? 'selected' : $profile->current_department == "cr" ? 'selected' : '' }}>CR</option>
                <option value="pr" {{old('current_department') == "pr" ? 'selected' : $profile->current_department == "pr" ? 'selected' : '' }}>PR</option>
                <option value="database" {{old('current_department') == "database" ? 'selected' : $profile->current_department == "database" ? 'selected' : '' }}>Database</option>
                <option value="finance" {{old('current_department') == "finance" ? 'selected' : $profile->current_department == "finance" ? 'selected' : '' }}>Finance</option>
                <option value="arena-ops" {{old('current_department') == "arena-ops" ? 'selected' : $profile->current_department == "arena-ops" ? 'selected' : '' }}>Arena Ops</option>
                <option value="player-ops" {{old('current_department') == "player-ops" ? 'selected' : $profile->current_department == "player-ops" ? 'selected' : '' }}>Player Ops</option>
                <option value="event-ops" {{old('current_department') == "event-ops" ? 'selected' : $profile->current_department == "event-ops" ? 'selected' : '' }}>Event Ops</option>
                <option value="social-media" {{old('current_department') == "social-media" ? 'selected' : $profile->current_department == "social-media" ? 'selected' : '' }}>Digital/Social Media</option>
                <option value="entertainment" {{old('current_department') == "entertainment" ? 'selected' : $profile->current_department == "entertainment" ? 'selected' : '' }}>Game Entertainment</option>
                <option value="legal" {{old('current_department') == "legal" ? 'selected' : $profile->current_department == "legal" ? 'selected' : '' }}>Legal</option>
            </select>
        </div>
        <!-- If yes, what is your title? -->
        <div class="input-field col s8 offset-m1 {{ $errors->has('current_title') ? 'invalid' : '' }}">
            <input id="current-title" type="text" name="current_title" value="{{ old('current_title') ?: $profile->current_title ?: null }}">
            <label for="current-title">Title</label>
        </div>
        <!-- If yes, how many years have you been with your current organization? -->
        <div class="input-field col s8 offset-m1 {{ $errors->has('years_current_organization') ? 'invalid' : '' }}">
            <input id="years-current-organization" type="text" name="years_current_organization" value="{{ old('years_current_organization') ?: $profile->years_current_organization ?: null }}">
            <label for="years-current-organization">How many years have you been with your current organization?</label>
        </div>
        <!-- If yes, how many years have you been in your current role? -->
        <div class="input-field col s8 offset-m1 {{ $errors->has('years_current_role') ? 'invalid' : '' }}">
            <input id="years-current-role" type="text" name="years_current_role" value="{{ old('years_current_role') ?: $profile->years_current_role ?: null }}">
            <label for="years-current-role">How many years have you been in your current role?</label>
        </div>
    </div>
    <div class="row">
        <input id="receives-job-notifications" type="checkbox" name="receives_job_notifications" value="{{ old('receives_job_notifications') ?: $profile->receives_job_notifications ?: null }}" />
        <label for="receives-job-notifications">Do you want to be considered for future jobs in the sports industry?</label>
    </div>
    <!-- If yes, check all departments that interest you -->
    <div class="row">
        <div class="col s11 offset-m1">
            <p>In sports, which departments do you have experience in? Check all that apply:</p>
            <div class="row">
                <div class="input-field col s6">
                    <input id="ticket-sales" type="checkbox" name="department_experience['ticket_sales']" value="{{ old("department_experience['ticket_sales']") ?: $profile->department_experience ?: null }}" />
                    <label for="ticket-sales">Ticket Sales</label>
                </div>
                <div class="input-field col s6">
                    <input id="sponsorship-sales" type="checkbox" name="department_experience['sponsorship_sales']" value="{{ old("department_experience['sponsorship_sales']") ?: $profile->department_experience ?: null }}" />
                    <label for="sponsorship-sales">Sponsorship Sales</label>
                </div>
                <div class="input-field col s6">
                    <input id="service" type="checkbox" name="department_experience['service']" value="{{ old("department_experience['service']") ?: $profile->department_experience ?: null }}" />
                    <label for="service">Service</label>
                </div>
                <div class="input-field col s6">
                    <input id="premium-sales" type="checkbox" name="department_experience['premium_sales']" value="{{ old("department_experience['premium_sales']") ?: $profile->department_experience ?: null }}" />
                    <label for="premium-sales">Premium Sales</label>
                </div>
                <div class="input-field col s6">
                    <input id="marketing" type="checkbox" name="department_experience['marketing']" value="{{ old("department_experience['marketing']") ?: $profile->department_experience ?: null }}" />
                    <label for="marketing">Marketing</label>
                </div>
                <div class="input-field col s6">
                    <input id="sponsorship-activation" type="checkbox" name="department_experience['sponsorship_activation']" value="{{ old("department_experience['sponsorship_activation']") ?: $profile->department_experience ?: null }}" />
                    <label for="sponsorship-activation">Sponsorship Activation</label>
                </div>
                <div class="input-field col s6">
                    <input id="hr" type="checkbox" name="department_experience['hr']" value="{{ old("department_experience['hr']") ?: $profile->department_experience ?: null }}" />
                    <label for="hr">HR</label>
                </div>
                <div class="input-field col s6">
                    <input id="analytics" type="checkbox" name="department_experience['analytics']" value="{{ old("department_experience['analytics']") ?: $profile->department_experience ?: null }}" />
                    <label for="analytics">Analytics</label>
                </div>
                <div class="input-field col s6">
                    <input id="cr" type="checkbox" name="department_experience['cr']" value="{{ old("department_experience['cr']") ?: $profile->department_experience ?: null }}" />
                    <label for="cr">CR</label>
                </div>
                <div class="input-field col s6">
                    <input id="pr" type="checkbox" name="department_experience['pr']" value="{{ old("department_experience['pr']") ?: $profile->department_experience ?: null }}" />
                    <label for="pr">PR</label>
                </div>
                <div class="input-field col s6">
                    <input id="database" type="checkbox" name="department_experience['database']" value="{{ old("department_experience['database']") ?: $profile->department_experience ?: null }}" />
                    <label for="database">Database</label>
                </div>
                <div class="input-field col s6">
                    <input id="finance" type="checkbox" name="department_experience['finance']" value="{{ old("department_experience['finance']") ?: $profile->department_experience ?: null }}" />
                    <label for="finance">Finance</label>
                </div>
                <div class="input-field col s6">
                    <input id="arena-ops" type="checkbox" name="department_experience['arena_ops']" value="{{ old("department_experience['arena_ops']") ?: $profile->department_experience ?: null }}" />
                    <label for="arena-ops">Arena Ops</label>
                </div>
                <div class="input-field col s6">
                    <input id="player-ops" type="checkbox" name="department_experience['player_ops']" value="{{ old("department_experience['player_ops']") ?: $profile->department_experience ?: null }}" />
                    <label for="player-ops">Player Ops</label>
                </div>
                <div class="input-field col s6">
                    <input id="event-ops" type="checkbox" name="department_experience['event_ops']" value="{{ old("department_experience['event_ops']") ?: $profile->department_experience ?: null }}" />
                    <label for="event-ops">Event Ops</label>
                </div>
                <div class="input-field col s6">
                    <input id="social-media" type="checkbox" name="department_experience['social_media']" value="{{ old("department_experience['social_media']") ?: $profile->department_experience ?: null }}" />
                    <label for="social-media">Digital/Social Media</label>
                </div>
                <div class="input-field col s6">
                    <input id="entertainment" type="checkbox" name="department_experience['entertainment']" value="{{ old("department_experience['entertainment']") ?: $profile->department_experience ?: null }}" />
                    <label for="entertainment">Game Entertainment</label>
                </div>
                <div class="input-field col s6">
                    <input id="legal" type="checkbox" name="department_experience['legal']" value="{{ old("department_experience['legal']") ?: $profile->department_experience ?: null }}" />
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
    <!-- Employment history
        // What departments do you have experience in? Check all that apply:
        // Phone sales
        // door to door sales
        // territory management
        // B2B sales
        // customer service
        // sponsorship,
        // High level business development
        // marketing
        // analytics
        // BI
        // database
        // digital
        // web design
        // social media
        // HR
        // finance
        // accounting
        // organizational development
        // communications
        // PR
        // media relations
        // legal
        // IT
        // TODO Other:
    -->
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
    <h4>Educational History</h4>
    <div class="row">
        <div class="input-field col s6">
            <select class="browser-default" name="education-level">
                <option value="" {{old('education_level') == "" ? "selected" : "" }} disabled>Highest education level completed</option>
                <option value="high-school" {{old('education_level') == "high-school" ? 'selected' : $profile->education_level == "high-school" ? 'selected' : '' }}>High School</option>
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
            <input id="has-school-plans" type="checkbox" name="has_school_plans" value="{{ old('has_school_plans') ?: $profile->has_school_plans ?: null }}" />
            <label for="has-school-plans">Do you plan to attend more school in the future?</label>
        </div>
    </div>
    <div class="row">
        <h4>Email Preferences</h4>
    </div>
    <div class="row">
        <label for="email_preference">Select which email updates you'd like to receive:</label>
        <div class="input-field col s12">
            <input id="entry-job" type="checkbox" name="email_preference['entry_job']" value="{{ old('entry_job') ?: $profile->email_preference ?: null }}" />
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
