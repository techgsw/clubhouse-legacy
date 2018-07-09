<form id="mentor-search" action="/mentor" method="get">
    <div class="row">
        <div class="input-field col s6 m8">
            <input id="term" name="term" type="text" value="{{ request('term') }}" autofocus />
            <label for="term">Search</label>
        </div>
        <div class="input-field col s6 m4">
            <select id="tag" class="browser-default" name="tag">
                <option value="" {{ !request('tag') ? "selected" : "" }}>All tags</option>
                @foreach ($options as $tag)
                    <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? "selected" : "" }}>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn sbs-red">Search</button>
        </div>
    </div>
</form>
