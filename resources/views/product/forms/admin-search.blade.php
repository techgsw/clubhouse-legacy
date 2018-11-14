<form action="/product/admin" method="get" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col s12 m6 input-field">
            <input type="text" name="term" id="term" style="margin-bottom: 6px;" value="{{ request('term') }}">
            <label for="term">Search</label>
        </div>
        <div class="col s6 m3 input-field">
            <label class="active">Category</label>
            <select name="tag" class="browser-default">
                <option value="all" {{ (!request('tag') || request('tag') == 'all') ? "selected" : "" }}>All</option>
                @foreach ($tags as $tag)
                    <option value="{{ urlencode($tag->name) }}" {{ request('tag') == urlencode($tag->name) ? "selected" : urlencode($tag->name) }}>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col s6 m3 input-field">
            <label class="active">Status</label>
            <select name="status" class="browser-default">
                <option value="all" {{ request('status') == "all" ? "selected" : "" }}>All</option>
                <option value="active" {{ request('status') == "" || request('status') == "active" ? "selected" : "" }}>Active</option>
                <option value="inactive" {{ request('status') == "inactive" ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <button type="submit" name="search" class="btn sbs-red">Search</button>
        </div>
    </div>
</form>
