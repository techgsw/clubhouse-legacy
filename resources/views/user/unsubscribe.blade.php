@extends('layouts.clubhouse')
@section('title', 'Unsubscribe')
@section('content')
<div class="container" style="margin:70px auto;">
    <h4 class="header">Unsubscribe from email notifications</h4>
    <p>These settings are for <strong>{{preg_replace('/(^..)[^@]*(@.*)/', '$1*****$2', $profile->user->email)}}</strong>. Select which notifications you would like to unsubscribe from:</p>
    @php
        $email_preference_new_content = $profile->email_preference_new_content_webinars || $profile->email_preference_new_content_blogs || $profile->email_preference_new_content_mentors || $profile->email_preference_new_content_training_videos;
    @endphp
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <form id="unsubscribe" method="post" action="/unsubscribe/{{ $profile->email_unsubscribe_token }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            @if (!$email_preference_new_content && !$profile->email_preference_marketing && !$profile->email_preference_new_job)
                <div class="col s12">
                    <p><h5><strong>You are already unsubscribed from all content notifications.</strong></h5> If you are still receiving emails, please forward them to <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a> and we will fix the issue.</p>
                </div>
            @else
                <div class="input-field col s12">
                    <input id="email_unsubscribe_all" type="checkbox" value="1" {{old('email_preference_marketing_opt_out') && old('email_preference_new_content_opt_out') && old('email_preference_new_job_opt_out') ? "checked" : ""}}/>
                    <label for="email_unsubscribe_all" class="black-text"><strong style="text-transform:uppercase;">Unsubscribe from all content notifications</strong></label>
                </div>
            @endif
        </div>
        <div class="row" style="margin:30px 30px 50px 30px;">
            <div class="input-field col s12">
                <p><strong>Clubhouse Introductions</strong> <i>(Get emails on how to make the most of your Clubhouse PRO experience)</i></p>
                <input id="email_preference_marketing_opt_out" type="checkbox" name="email_preference_marketing_opt_out" value="1" {{$profile->email_preference_marketing ? (old('email_preference_marketing_opt_out') ? "checked" : "") : "checked disabled" }}/>
                <label for="email_preference_marketing_opt_out">
                    @if(!$profile->email_preference_marketing)
                        <i><strong>(Already unsubscribed)</strong></i>
                    @endif
                    Unsubscribe from all clubhouse introduction emails
                </label>
            </div>
            <div class="input-field col s12">
                <p><strong>Weekly updates on new Clubhouse content</strong> <i>(You can also change what content you'd like to see by <a href="/user/self/edit-profile">editing your profile's email preferences</a>)</i></p>
                <input id="email_preference_new_content_opt_out" type="checkbox" name="email_preference_new_content_opt_out" value="1" {{$email_preference_new_content ? (old('email_preference_new_content_opt_out') ? "checked" : "") : "checked disabled" }}/>
                <label for="email_preference_new_content_opt_out">
                    @if(!$email_preference_new_content)
                        <i><strong>(Already unsubscribed)</strong></i>
                    @endif
                    Unsubscribe from the weekly new Clubhouse content emails
                </label>
            </div>
            <div class="input-field col s12">
                <p><strong>New job posting emails</strong> <i>(If you'd like to change which jobs you get notifications for, <a href="/user/self/edit-profile">update your profile's Job-seeking Preferences</a>)</i></p>
                <input id="email_preference_new_job_opt_out" type="checkbox" name="email_preference_new_job_opt_out" value="1" {{$profile->email_preference_new_job ? (old('email_preference_new_job_opt_out') ? "checked" : "") : "checked disabled"}}/>
                <label for="email_preference_new_job_opt_out">
                    @if(!$profile->email_preference_new_job)
                        <i><strong>(Already unsubscribed)</strong></i>
                    @endif
                    Unsubscribe from all new job posting emails
                </label>
            </div>
            <div class="input-field col s12">
                <p><strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> newsletter</strong></p>
                <input id="email_preference_newsletter_opt_out" type="checkbox" name="email_preference_newsletter_opt_out" value="1" {{ $profile->user->mailchimp_subscriber_hash ? (old('email_preference_newsletter_opt_out') ? "checked" : "") : "checked disabled" }} />
                <label for="email_preference_newsletter_opt_out">
                    @if(!$profile->user->mailchimp_subscriber_hash)
                        <i><strong>(Already unsubscribed)</strong></i>
                    @endif
                    Unsubscribe from the newsletter
                </label>
            </div>
        </div>
        <div class="row">
            <p>You can opt back in to any of these emails any time by <a href="/user/self/edit-profile">editing your profile's email preferences</a></p>
            @if ($email_preference_new_content || $profile->email_preference_marketing || $profile->email_preference_new_job)
                <div class="col s12 m6">
                    <div class="input-field">
                        <button type="submit" class="btn sbs-red">Submit</button>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
