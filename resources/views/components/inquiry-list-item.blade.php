<div class="col s12 m9 offset-m3 job-inquiry">
    <div class="row">
        <div class="col s3 center-align">
            @if ($inquiry->user->profile->headshot_url)
                <img src={{ Storage::disk('local')->url($inquiry->user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" />
            @else
                <i class="material-icons large">person</i>
            @endif
        </div>
        <div class="col s9">
            <p><a href="/user/{{ $inquiry->user->id }}/profile">{{ $inquiry->name}}</a></p>
            <p class="small">applied on {{ $inquiry->created_at->format('F j, Y') }}</p>
            <p class="hide-on-small-only"><a href="{{ Storage::disk('local')->url($inquiry->resume) }}">Résumé</a> | <a href="mailto:{{ $inquiry->email}}">{{ $inquiry->email}}</a> | @component('components.phone', [ 'phone'=> $inquiry->phone ]) @endcomponent</p>
            @can ('edit-inquiry', $inquiry)
                <p>
                    <a href="/inquiry/{{ $inquiry->id }}/rate-up" class="flat-button small blue {{ $inquiry->rating > 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-up"></i></a>
                    <a href="/inquiry/{{ $inquiry->id }}/rate-maybe" class="flat-button small blue {{ $inquiry->rating === 0 ? "inverse" : "" }}"><i class="fa fa-question-circle"></i></a>
                    <a href="/inquiry/{{ $inquiry->id }}/rate-down" class="flat-button small blue {{ $inquiry->rating < 0 ? "inverse" : "" }}"><i class="fa fa-thumbs-down"></i></a>
                    @if (!is_null($inquiry->rating))
                        <span class="small spaced">{{ $inquiry->updated_at->format('F j, Y') }}</span>
                    @endif
                </p>
            @endcan
        </div>
    </div>
</div>
