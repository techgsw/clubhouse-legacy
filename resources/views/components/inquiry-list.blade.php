<div class="row" style="margin-bottom: 0;">
    <div class="col s12 m9 offset-m3 job-inquire">
        <h5>Applications</h5>
    </div>
    @foreach ($inquiries as $inquiry)
        @include('components.inquiry-list-item', ['inquiry' => $inquiry])
    @endforeach
    @if ($inquiries->total() > 8)
        <div class="row">
            <div class="col s12 center-align">
                {{ $inquiries->links('components.pagination') }}
            </div>
        </div>
    @endif
</div>
