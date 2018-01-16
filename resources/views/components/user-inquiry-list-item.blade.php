<div class="row user-inquiry-list-item">
    <div class="col s3 m2">
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <img src={{ Storage::disk('local')->url($inquiry->job->image_url) }} class="no-border job-image">
        </a>
    </div>
    <div class="col s9 m10 info">
        @can ('edit-inquiry', $inquiry)
            <div class="float-right controls">
                <button type="button" class="flat-button small blue view-inquiry-notes-btn" inquiry-id="{{ $inquiry->id }}">{{ count($inquiry->notes) }} <i class="fa fa-comments"></i></button>
                <button type="button" action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="1" class="flat-button small blue {{ $inquiry->rating > 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-up"></i></button>
                <button type="button" action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="0" class="flat-button small blue {{ $inquiry->rating === 0 ? "inverse" : "" }}"><i class="fa fa-question-circle"></i></button>
                <button type="button" action="inquiry-rate" inquiry-id="{{ $inquiry->id }}" rating="-1" class="flat-button small blue {{ $inquiry->rating < 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-down"></i></button>
                @if (!is_null($inquiry->rating))
                    <p class="small right-align">{{ $inquiry->updated_at->format('F j, Y') }}</p>
                @endif
            </div>
        @endcan
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <h6>{{ $inquiry->job->title }}</h6>
            <p><span class="heavy">{{ $inquiry->job->organization }}</span> in {{ $inquiry->job->city }}, {{ $inquiry->job->state }}</p>
            <p class="small">submitted {{ $inquiry->created_at->format('F j, Y g:ia') }}</p>
        </a>
    </div>
</div>
<style media="screen">
    .user-inquiry-list-item {
        display: block;
        padding: 10px 16px;
        border-bottom: 1px solid #EEE;
        margin: 0;
    }
    .user-inquiry-list-item img.job-image {
        max-height: 80px;
        max-width: 80px;
    }
    .user-inquiry-list-item .info p {
        margin: 4px 0px;
    }
    a.user-inquiry-list-item {}
    a.user-inquiry-list-item:hover {
        background-color: #FAFAFA;
        border-bottom: 1px solid #EB2935;
    }
</style>
