<form id="mentor-search" action="/mentor" method="get">
    <div class="col s6 m3 input-field">
        <label class="active">Discipline</label>
        <select name="tag" class="">
            <option value="" {{ request('tag') ? "" : "selected" }}>All</option>
            @foreach ($options as $tag)
                <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? "selected" : "" }}>{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col s6 m3 input-field">
        <label class="active">League</label>
        <select name="league" class="">
            <option value="" {{ request('league') ? "" : "selected" }}>All</option>
            @foreach ($leagues as $league)
                <option value="{{ $league->abbreviation }}" {{ request('league') == $league->abbreviation ? "selected" : "" }}>{{ $league->abbreviation }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-field col s6 m4">
        <input id="term" name="term" type="text" value="{{ request('term') }}" autofocus />
        <label for="term">Name</label>
    </div>
    <div class="col s6 m2 input-field center-align">
        <button type="submit" class="btn sbs-red" style="margin-bottom: 12px;">Search</button>
    </div>
</form>
