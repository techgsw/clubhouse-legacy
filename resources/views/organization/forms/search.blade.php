<form id="organization-search" action="/admin/organization" method="get">
    <div class="row">
        <div class="col s12 input-field" style="display: flex; flex-flow: row;">
            <div style="flex: 1 1 auto;">
                <input id="term" name="term" type="text" value="{{ request('term') }}" autofocus />
                <label for="term">Enter a name or city</label>
            </div>
            <div style="flex: 0 0 auto;">
                <button type="submit" class="btn sbs-red">Search</button>
                <a href="/admin/organization" type="button" class="btn white black-text">Clear</a>
            </div>
        </div>
    </div>
</form>
