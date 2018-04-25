@component('emails.layout')
    @slot('body')
        <p>{{ $inquiries->count() }} job inquiries submitted between {{ $start->format('m/d/Y H:i:s') }} and {{ $end->format('m/d/Y H:i:s') }}</p>
        <ul>
            @foreach ($jobs as $job)
                <li>{{ $job->inquiry_count }} for <a href="{{ config('app.url') }}/job/{{ $job->id }}">{{ $job->organization }}: {{ $job->title }}</a></li>
            @endforeach
        </ul>
    @endslot
@endcomponent
