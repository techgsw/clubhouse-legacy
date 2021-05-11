@php
    $notes = App\Note::contact($contact->id);
    $last_note = null;
    if (count($notes) > 0) {
        $last_note = reset($notes);
    }
    $today = (new \DateTime('now'))->format('Y-m-d 00:00:00');
@endphp
<div class="row admin-user-list-item">
    <div class="col s12 m6">
        <a href="/contact/{{$contact->id}}">
            <p class="name">{{ $contact->first_name }} {{ $contact->last_name }}</p>
            <p class="email">
                <a class="no-underline" href="mailto::{{ $contact->email }}">{{ $contact->email }}</a>
            </p>
            <p class="phone">@component('components.phone', ['phone' => $contact->profile ? $contact->profile->phone : null])@endcomponent</p>
            <p class="title">{{ $contact->getTitle() }}</p>
        </a>
    </div>
    <div class="col s12 m6">
        <div style="margin: 4px 0;">
            <button class="view-contact-notes-btn flat-button small"
                contact-id="{{ $contact->id }}"
                contact-name="{{ $contact->getName() }}"
                contact-follow-up="{{ $contact->follow_up_date ? $contact->follow_up_date->format('Y-m-d') : '' }}">
                {{ $contact->getNoteCount() }} <i class="fa fa-comments"></i>
            </button>
            <button class="view-contact-job-assignment-btn flat-button small {{ $contact->do_not_contact ? 'gray' : '' }}" {{ $contact->do_not_contact ? 'disabled' : '' }} contact-id="{{ $contact->id }}">
                <i class="fa fa-id-card"></i> Assign to job
            </button>
            @if ($contact->follow_up_date)
                <button class="view-contact-notes-btn flat-button small {{ $contact->follow_up_date == $today ? 'green' : ($contact->follow_up_date < $today ? 'red' : '') }}"
                    contact-id="{{ $contact->id }}"
                    contact-name="{{ $contact->getName() }}"
                    contact-follow-up="{{ $contact->follow_up_date->format('Y-m-d') }}">
                    <i class="fa fa-calendar"></i> {{ $contact->follow_up_date->format('m/d/y') }}
                </button>
            @endif
            @if ($contact->resume_url)
                @component('components.admin-resume-button', ['url' => $contact->resume_url, 'type' => 'contact'])@endcomponent
            @elseif ($contact->user)
                @component('components.admin-resume-button', ['url' => $contact->user->profile->resume_url, 'type' => 'profile'])@endcomponent
            @else
                @component('components.admin-resume-button', ['url' => null, 'type' => null])@endcomponent
            @endif
            @component('components.admin-profile-button', ['user' => $contact->user])@endcomponent
            @if ($contact->do_not_contact)
                <button type="button" class="flat-button small red" disabled>Do not contact</button>
            @endif
        </div>
        @if ($last_note)
            <p class="small italic">{{ $last_note->create_user_name }} {{ $last_note->created_at->format('n/j/Y') }}</p>
        @endif
        @if ($contact->user)
            <p class="small">Last Login: {{is_null($contact->last_login_at) ? (is_null($contact->user->last_login_at) ? '' : $contact->user->last_login_at->format('n/j/Y')) : (new DateTime($contact->last_login_at))->format('n/j/Y')}}</p>
            <p class="small">Last Profile Update: {{ $contact->user->profile->updated_at->format('n/j/Y') }}</p>
        @endif
    </div>
</div>
