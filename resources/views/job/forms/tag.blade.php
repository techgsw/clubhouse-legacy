<!--
Place this in the job form:
<input type="hidden" id="job-tags-json" name="job_tags_json">
-->
<div class="input-field">
    <label for="tag-autocomplete-input">Job Discipline</label>
    <input type="text" id="tag-autocomplete-input" class="tag-autocomplete jobs no-submit" target-input-id="job-tags-json" target-view-id="job-tags">
</div>
<div id="job-tags" class="col job-tags">
    @if (!is_null($job))
        @foreach ($job->tags as $tag)
            <span class="flat-button gray small tag">
                <button type="button" name="button" class="x remove-tag" tag-name="{{ $tag->name }}" target-input-id="job-tags-json">&times;</button>{{ $tag->name }}
            </span>
        @endforeach
    @endif
</div>
