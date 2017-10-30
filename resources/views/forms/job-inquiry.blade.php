<form method="POST" action="/job/{{ $job->id }}/inquire" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="name" value="{{ Auth::user()->getName() }}" />
    <input type="hidden" name="email" value="{{ Auth::user()->email }}" />
    <input type="hidden" name="phone" value="{{ Auth::user()->profile->phone }}" />
    <h5>Apply for this job</h5>
    <div class="row">
        <div class="col s4 m3 center-align">
            @if (Auth::user()->profile->headshot_url)
                <img src={{ Storage::disk('local')->url(Auth::user()->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" />
            @else
                <i class="material-icons large">person</i>
            @endif
        </div>
        <div class="col s8 m9">
            <div style="margin-top: 16px;"></div>
            <p style="margin: 6px 0;">{{ Auth::user()->getName() }}</p>
            <p style="margin: 6px 0;">{{ Auth::user()->email }}</p>
            <p style="margin: 6px 0;">@component('components.phone', [ 'phone'=> Auth::user()->profile->phone ]) @endcomponent</p>
            <div>
                <input type="checkbox" name="use_profile_resume" id="use_profile_resume" value="1" checked />
                <label for="use_profile_resume">Use résumé from profile <a href="{{ Storage::disk('local')->url(Auth::user()->profile->resume_url) }}" target="_blank"><i class="tiny material-icons">open_in_new</i></a></label>
            </div>
            <div id="upload-resume" class="file-field input-field hidden">
                <div class="btn white black-text">
                    <span>Upload Resume</span>
                    <input type="file" name="resume" value="{{ old('resume') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" name="resume_text" value="{{ old('resume_text') }}">
                </div>
            </div>
            <div class="input-field">
                <button class="btn sbs-red" type="submit" name="button">Apply</button>
            </div>
            <div class="input-field">
                <p class="small italic">Update this information&mdash;including your default résumé&mdash;by visiting <a href="/user/{{ Auth::user()->id }}/edit-profile">your profile</a>.</p>
            </div>
        </div>
    </div>
</form>
