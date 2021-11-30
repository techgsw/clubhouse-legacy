@extends('layouts.clubhouse')
@section('title', 'Unsubscribe')
@section('content')
<div class="container" style="margin:70px auto;">
    @php
        $email_preference_new_content = $profile->email_preference_new_content_blogs || $profile->email_preference_new_content_webinars || $profile->email_preference_new_content_mentors || $profile->email_preference_new_content_training_videos;
    @endphp
    @if (!$email_preference_new_content && !$profile->email_preference_marketing && !$profile->email_preference_new_job)
        <p>You have been unsubscribed from all content notificatioins.</p>
    @else
        <p>You have been unsubscribed from the following notifications:
            <ul>
                @if (!$profile->email_preference_marketing)
                    <li>Clubhouse introductions</li>
                @endif
                @if (!$email_preference_new_content)
                    <li>Weekly updates on new Clubhouse content</li>
                @endif
                @if (!$profile->email_preference_new_job)
                    <li>New job posting emails</li>
                @endif
            </ul>
    @endif
    <p>If you change your mind, you can <a href="/user/self/edit-profile">edit your email preferences</a> at any time.</p>
</div>
@endsection
