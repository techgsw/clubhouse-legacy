<div class="row" style="margin-bottom: 0;">
    @foreach ($inquiries as $inquiry)
        @include('components.inquiry-list-item', ['inquiry' => $inquiry, 'contact' => $contact])
    @endforeach
    @if ($inquiries->total() > 8)
        <div class="row">
            <div class="col s12 center-align">
                {{ $inquiries->appends(request()->all())->links('components.pagination') }}
            </div>
        </div>
    @endif
</div>
