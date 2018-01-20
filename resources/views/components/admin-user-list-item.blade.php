<div class="row user-admin">
    <div class="col s3 m2">
        <a href="/user/{{$user->id}}" class="no-underline">
            @if ($user->profile->headshot_url)
                <img src={{ Storage::disk('local')->url($user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" class="no-border">
            @else
                <i class="material-icons large">person</i>
            @endif
        </a>
    </div>
    <div class="col s9 m10">
        <a href="/user/{{$user->id}}">
            <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
        </a>
        <p class="small">{{ $user->email }}</p>
        <p class="small heavy" style="padding-top: 6px;">
            <button class="view-profile-notes-btn flat-button small grey" user-id="{{ $user->id }}">{{ $user->noteCount() }} <i class="fa fa-comments"></i></button>
        </p>
    </div>
</div>
