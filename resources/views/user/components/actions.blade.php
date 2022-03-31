@can ('view-contact-notes')
    <button type="button" class="view-contact-notes-btn flat-button black"
        contact-id="{{ $user->contact->id }}"
        contact-name="{{ $user->contact->getName() }}"
        contact-follow-up="{{ $user->contact->follow_up_date ? $user->contact->follow_up_date->format('Y-m-d') : '' }}">
        {{ $user->contact->getNoteCount() }} <i class="fa fa-comments"></i>
    </button>
@endif
@if ($user->profile->resume_url)
    <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
@else
    @can ('edit-profile', $user)
        <a href="/user/{{ $user->id }}/edit-profile" class="flat-button green disabled">Upload Resume</a>
    @endcan
@endif
@if ($user->profile->linkedin)
    <a href="{{ $user->profile->linkedin }}" class="flat-button black">View LinkedIn</a>
@endif
@can ('edit-profile', $user)
    <a href="/user/{{ $user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
@endcan
@can ('view-admin-jobs', $user)
    <button class="view-contact-job-assignment-btn flat-button" contact-id="{{ $user->contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
    @if ($user->contact->do_not_contact)
        <button type="button" class="flat-button red" disabled>Do not contact</button>
    @endif
@elsecan ('create-job', $user)
    <a href="/job/create" class="flat-button"><i class="fa fa-id-card"></i> Create Job Posting</a>
@endcan
