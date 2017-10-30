<div class="row" style="margin-bottom: 0;">
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
