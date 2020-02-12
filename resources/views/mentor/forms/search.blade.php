<form id="mentor-search" action="/mentor" method="get">
        <div class="row input-field">
            <select id="tag" class="browser-default" name="tag">
                <option value="" disabled hidden {{ !request('tag') ? "selected" : "" }}>Search by discipline</option>
                <option value="">Show all</option>
                @foreach ($options as $tag)
                    <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? "selected" : "" }}>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
</form>
