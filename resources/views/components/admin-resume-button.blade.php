@if ($url)
    <button class="pdf-modal-trigger flat-button small" modal-id="#pdf-view-modal" pdf-src="{{ Storage::disk('local')->url($url) }}">
        <span style="font-size: 70%; background: #555; border-radius: 50%; border: none; color: #EEE; display: inline-block; width: 12px; height: 12px;">{{ $type == 'contact' ? "C" : "P" }}</span> {{ substr($url, -4) == ".pdf" ? "View" : "Download" }} resume
    </button>
@else
    <button type="button" class="flat-button small gray small" disabled>No resume</button>
@endif
