<form id="mentor-tag" class="compact">
    {{ csrf_field() }}
    <input type="hidden" id="mentor_id" value="{{ $mentor->id }}" />
    <div class="row">
        <div class="col">
            <label>Tag</label>
            <input type="text" id="tag-autocomplete-input" class="tag-autocomplete compact" tag-target="mentor" mentor-id="{{ $mentor->id }}">
        </div>
        <div class="col mentor-tags" style="padding-top: 20px;">
            @foreach ($mentor->tags as $tag)
                <span class="flat-button gray small tag">
                    <button type="button" name="button" class="x" admin-user-id="{{ $tag->slug }}">&times;</button>{{ $tag->name }}
                </span>
            @endforeach
        </div>
    </div>
</form>
