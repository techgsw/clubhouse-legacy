<form action="/admin/contact" method="get">
    <div class="row">
        <div class="col s5 m7 input-field">
            <input id="search_term" type="text" name="term" value="{{ request('term') }}">
            <label for="search_term">Search for</label>
        </div>
        <div class="col s5 m3 center-align input-field">
            <select name="index">
                <option value="name" {{ request('index') == "name" ? "selected" : "" }}>by name</option>
                <option value="title" {{ request('index') == "title" ? "selected" : "" }}>by title</option>
                <option value="organization" {{ request('index') == "organization" ? "selected" : "" }}>by organization</option>
                <option value="email" {{ request('index') == "email" ? "selected" : "" }}>by email</option>
                <option value="id" {{ request('index') == "id" ? "selected" : "" }}>by ID</option>
            </select>
        </div>
        <div class="col s2 center-align input-field">
            <button type="submit" name="submit" class="btn sbs-red" style="width: 100%;">Search</button>
        </div>
    </div>
</form>
