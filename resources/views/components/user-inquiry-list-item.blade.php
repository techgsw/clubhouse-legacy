<div class="row user-inquiry-list-item">
    <div class="col s3 m2">
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <img src={{ $inquiry->job->image->getURL('small') }} class="no-border job-image">
        </a>
    </div>
    <div class="col s9 m10 info">
        <a href="/job/{{ $inquiry->job->id }}" class="no-underline">
            <h6>{{ $inquiry->job->title }}</h6>
            <p><span class="heavy">{{ $inquiry->job->organization_name }}</span> in {{ $inquiry->job->city }}, {{ $inquiry->job->state }}</p>
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
        width: 80px;
        max-width: 100%;
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
