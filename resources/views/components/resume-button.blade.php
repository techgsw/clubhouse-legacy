@if ($url)
    <button class="pdf-modal-trigger flat-button small" modal-id="#pdf-view-modal" pdf-src="{{ Storage::disk('local')->url($url) }}">{{ substr($url, -4) == ".pdf" ? "View" : "Download" }} resume</button>
@else
    <button type="button" class="flat-button small gray small" disabled>No resume</button>
@endif
