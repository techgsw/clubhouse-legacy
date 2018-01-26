<div class="row admin-user-list-item">
    <div class="col s12 m4">
        <a href="/user/{{$user->id}}">
            <p class="name">{{ $user->first_name }} {{ $user->last_name }}</p>
            <p class="title">{{ $user->getTitle() }}</p>
        </a>
    </div>
    <div class="col s12 m4">
        <p class="email">
            <a class="no-underline" href="mailto::{{ $user->email }}">{{ $user->email }}</a>
        </p>
        <p class="phone">@component('components.phone', ['phone' => $user->profile ? $user->profile->phone : null])@endcomponent</p>
    </div>
    <div class="col s12 m4">
        <div style="margin: 4px 0;">
            <button class="view-profile-notes-btn flat-button small" user-id="{{ $user->id }}">{{ $user->noteCount() }} <i class="fa fa-comments"></i></button>
            @component('components.resume-button', ['url' => $user->profile ? $user->profile->resume_url : null])@endcomponent
        </div>
    </div>
</div>
