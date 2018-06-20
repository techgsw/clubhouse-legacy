<form id="admin-contact-search" action="/admin/contact" method="get">
    <div class="row">
        <div class="col s7 m9 input-field">
            <input id="search_term" type="text" name="term" value="{{ request('term') }}">
            <label for="search_term">Search for</label>
        </div>
        <div class="col s5 m3 center-align input-field">
            <select name="index">
                <option value="name" {{ request('index') == "name" ? "selected" : "" }}>by name</option>
                <option value="title" {{ request('index') == "title" ? "selected" : "" }}>by title</option>
                <option value="email" {{ request('index') == "email" ? "selected" : "" }}>by email</option>
                <option value="id" {{ request('index') == "id" ? "selected" : "" }}>by ID</option>
            </select>
        </div>
        <div class="col s12 input-field">
            <input id="organization_name" type="text" name="organization_name" class="organization-autocomplete" value="{{ request('organization_name') }}">
            <label for="organization_name">Organization</label>
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
            </select>
        </div>
        <div class="col s6 m3 center-align input-field">
            <button type="submit" name="submit" class="btn sbs-red" style="width: 100%;">Search</button>
        </div>
    </div>
</form>
