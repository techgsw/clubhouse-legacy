<form id="admin-contact-search" action="/admin/contact" method="get">
    <div class="row">
        <div class="col s11 input-field">
            <input id="search_term" type="text" name="search" value="{{ request('search') }}">
            <label for="search_term">Search for</label>
        </div>
        <div class="col s1 center-align input-field">
            <a href="#search-syntax-info" class="btn-floating red">
                <i class="material-icons">info_outline</i>
            </a>
            <div id="search-syntax-info" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h3>Contact Search Syntax</h3>
                    <p>The following labels may be used to search by specific fields. If no label is specified, search will default to <code>name:</code>.</p>
                    <ul class="left-align">
                        <li><b><code>name:</code></b> Search by contact's name</li>
                        <li><b><code>id:</code></b> Search by contact's database ID</li>
                        <li><b><code>organization:</code></b> Search by contact's current organization</li>
                        <li><b><code>title:</code></b> Search by job title of contact</li>
                        <li><b><code>email:</code></b> Search by contact's email</li>
                        <li><b><code>owner:</code></b> Search by the name of the user that owns the contact's account, if applicable</li>
                        <li><b><code>note:</code></b> Search by the contents of the contact's notes</li>
                        <li><b><code>location:</code></b> Search by parts of the contact's address</li>
                        <li><b><code>job_seeking_type:</code></b> Search by the "goal", or type of job the contact is seeking. Possible options are <code>internship</code>, <code>entry_level</code>, <code>mid_level</code>, <code>entry_level_management</code>, <code>mid_level_management</code> or <code>executive></code></li>
                        <li><b><code>job_seeking_status:</code></b> Search by the contact's current job & job seeking status. Possible options are <code>unemployed</code>, <code>employed_active</code> (actively seeking), <code>employed_passive</code> (passively seeking), <code>employed_future</code> (maybe later) or <code>employed_not</code> (not seeking)</li>
                    </ul>
                    <p>The first word or "quoted phrase" after the label will be used by that label. For example, <code>organization:"Sports Business Solutions"</code> will search for an organization of "Sports Business Solutions", but <code>organization:Sports Business Solutions</code> will search for an organization of "Sports", a name with "Business" and a name with "Solutions" in it.</p>
                    <p>You can also use <code>AND</code> and <code>OR</code> to chain searches together. By default, any labels, words, or phrases next to each other will default to <code>AND</code>.</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-close btn-flat">Close</a>
                </div>
            </div>
        </div>
        <div class="col s6 m3 center-align input-field">
            <select class="browser-default" name="job_seeking_type" style="margin-top: 0; height: 36px;">
                <option value="all" {{ request('job_seeking_type') == "all" ? "selected" : "" }}>All goals</option>
                <option value="internship" {{ request('job_seeking_type') == "internship" ? "selected" : "" }}>Internship</option>
                <option value="entry_level" {{ request('job_seeking_type') == "entry_level" ? "selected" : "" }}>Entry-level</option>
                <option value="mid_level" {{ request('job_seeking_type') == "mid_level" ? "selected" : "" }}>Mid-level</option>
                <option value="entry_level_management" {{ request('job_seeking_type') == "entry_level_management" ? "selected" : "" }}>Entry-level management</option>
                <option value="mid_level_management" {{ request('job_seeking_type') == "mid_level_management" ? "selected" : "" }}>Mid-level management</option>
                <option value="executive" {{ request('job_seeking_type') == "executive" ? "selected" : "" }}>Executive team</option>
            </select>
        </div>
        <div class="col s6 m3 center-align input-field">
            <select class="browser-default" name="job_seeking_status" style="margin-top: 0; height: 36px;">
                <option value="all" {{ request('job_seeking_status') == "all" ? "selected" : "" }}>All statuses</option>
                <option value="unemployed" {{ request('job_seeking_status') == "unemployed" ? "selected" : "" }}>Unemployed</option>
                <option value="employed_active" {{ request('job_seeking_status') == "employed_active" ? "selected" : "" }}>Employed, actively seeking</option>
                <option value="employed_passive" {{ request('job_seeking_status') == "employed_passive" ? "selected" : "" }}>Employed, passively seeking</option>
                <option value="employed_future" {{ request('job_seeking_status') == "employed_future" ? "selected" : "" }}>Employed, maybe later</option>
                <option value="employed_not" {{ request('job_seeking_status') == "employed_not" ? "selected" : "" }}>Employed, not seeking</option>
            </select>
        </div>
        <div class="col s6 m3 center-align input-field">
            <select class="browser-default" name="sort" style="margin-top: 0; height: 36px;">
                <option value="id-desc" {{ request('sort') == "id-desc" ? "selected" : "" }}>ID (high to low)</option>
                <option value="id-asc" {{ request('sort') == "id-asc" ? "selected" : "" }}>ID (low to high)</option>
                <option value="email-asc" {{ request('sort') == "email-asc" ? "selected" : "" }}>Email (A to Z)</option>
                <option value="email-desc" {{ request('sort') == "email-desc" ? "selected" : "" }}>Email (Z to A)</option>
                <option value="name-asc" {{ request('sort') == "name-asc" ? "selected" : "" }}>Name (A to Z)</option>
                <option value="name-desc" {{ request('sort') == "name-desc" ? "selected" : "" }}>Name (Z to A)</option>
                <option value="creation-date-desc" {{ request('sort') == "creation-date-desc" ? "selected" : "" }}>Contact Created (last to first)</option>
                <option value="last-login-date-desc" {{ request('sort') == "last-login-date-desc" ? "selected" : "" }}>Last Login (last to first)</option>
            </select>
        </div>
        <div class="col s6 m3 center-align input-field">
            <button type="submit" name="submit" class="btn sbs-red" style="width: 100%;">Search</button>
        </div>
    </div>
</form>
