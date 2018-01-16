<div class="row user-admin">
    <div class="col s3 m2">
        <a href="/user/{{$user->id}}" class="no-underline">
            <img src={{ Storage::disk('local')->url($user->image_url) }} class="no-border">
        </a>
    </div>
    <div class="col s9 m10">
        <a href="/user/{{$user->id}}">
            <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
        </a>
        <p class="small">{{ $user->email }}</p>
        <p class="small heavy" style="padding-top: 6px;">
            <button class="view-profile-notes-btn flat-button small grey" user-id="{{ $user->id }}">{{ count($user->profile->notes) }} <i class="fa fa-comments"></i></button>
        </p>
    </div>
</div>
