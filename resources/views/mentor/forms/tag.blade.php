<!--
Place this in the mentor form:
<input type="hidden" id="mentor-tags-json" name="mentor_tags_json">
-->
<form id="create-tag" action="/tag" method="post" class="compact">
    {{ csrf_field() }}
    <div class="row">
        <div class="col">
            <label for="tag-autocomplete-input">Tags</label>
            <input type="text" id="tag-autocomplete-input" class="tag-autocomplete" target-input-id="mentor-tags-json" target-view-id="mentor-tags">
        </div>
        <div id="mentor-tags" class="col mentor-tags" style="padding-top: 20px;">
            @foreach ($mentor->tags as $tag)
                <span class="flat-button gray small tag">
                    <button type="button" name="button" class="x remove-tag" tag-name="{{ $tag->name }}" target-input-id="mentor-tags-json">&times;</button>{{ $tag->name }}
                </span>
            @endforeach
        </div>
    </div>
</form>
