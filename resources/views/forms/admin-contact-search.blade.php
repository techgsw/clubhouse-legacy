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
                        <li><b><code>gender:</code></b> Search by contact's gender
                            <ul style="margin-left:50px;">
                                <li><code>male</code></li>
                                <li><code>female</code></li>
                                <li><code>non-binary</code></li>
                                <li><code>na</code> (prefer not to answer)</li>
                            </ul>
                        </li>
                        <li><b><code>ethnicity:</code></b> Search by contact's ethnicity
                            <ul style="margin-left:50px;">
                                <li><code>white</code></li>
                                <li><code>black</code></li>
                                <li><code>asian</code></li>
                                <li><code>hispanic</code></li>
                                <li><code>native</code></li>
                                <li><code>na</code> (prefer not to answer)</li>
                            </ul>
                        </li>
                        <li><b><code>id:</code></b> Search by contact's database ID</li>
                        <li><b><code>organization:</code></b> Search by contact's current organization</li>
                        <li><b><code>title:</code></b> Search by job title of contact</li>
                        <li><b><code>email:</code></b> Search by contact's primary email</li>
                        <li><b><code>secondary_email:</code></b> Search by contact's secondary email</li>
                        <li><b><code>owner:</code></b> Search by the name of the user that owns the contact's account, if applicable</li>
                        <li><b><code>note:</code></b> Search by the contents of the contact's notes</li>
                        <li><b><code>location:</code></b> Search by parts of the contact's address</li>
                        <li><b><code>job_seeking_type:</code></b> Search by the "goal", or type of job the contact is seeking.
                            <ul style="margin-left:50px;">
                                <li><code>internship</code></li>
                                <li><code>entry_level</code></li>
                                <li><code>mid_level</code></li>
                                <li><code>entry_level_management</code></li>
                                <li><code>mid_level_management</code></li>
                                <li><code>executive</code></li>
                            </ul>
                        </li>
                        <li><b><code>job_seeking_status:</code></b> Search by the contact's current job & job seeking status.
                            <ul style="margin-left:50px;">
                                <li><code>unemployed</code></li>
                                <li><code>employed_active</code> (actively seeking)</li>
                                <li><code>employed_passive</code> (passively seeking)</li>
                                <li><code>employed_future</code> (maybe later)</li>
                                <li><code>employed_not</code> (not seeking)</li>
                            </ul>
                        </li>
                        <li><b><code>job_seeking_region:</code></b> Search by the contact's preferred job region
                            <ul style="margin-left:50px;">
                                <li><code>southwest</code></li>
                                <li><code>southeast</code></li>
                                <li><code>northwest</code></li>
                                <li><code>northeast</code></li>
                                <li><code>midwest</code></li>
                            </ul>
                        </li>
                        <li><b><code>job_discipline_preference:</code></b> Search by the contact's preference for job disicplines. <a target="_blank" rel="noopener" href="/admin/job/disciplines">Click here to see a list of all current job disciplines.</a></li>
                    </ul>
                    <p>Remember to use quotes if a single search term is more than one word. For example, <code>organization:"SBS Consulting"</code> will search for an organization of "SBS Consulting", but <code>organization:SBS Consulting</code> will search for an organization of "SBS" and a contact name of "Consulting".</p>
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
                <option value="last-profile-update-date-desc" {{ request('sort') == "last-profile-update-date-desc" ? "selected" : "" }}>Last Profile Update Date (last to first)</option>
            </select>
        </div>
        <div class="col s6 m3 center-align input-field">
            <button type="submit" name="submit" class="btn sbs-red" style="width: 100%;">Search</button>
        </div>
    </div>
</form>
