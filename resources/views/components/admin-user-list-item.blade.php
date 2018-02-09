@php
    $notes = App\Note::contact($contact->id);
    $last_note = null;
    if (count($notes) > 0) {
        $last_note = array_shift($notes);
    }
@endphp
<div class="row admin-user-list-item">
    <div class="col s12 m4">
        <a href="/contact/{{$contact->id}}">
            <p class="name">{{ $contact->first_name }} {{ $contact->last_name }}</p>
            <p class="title">{{ $contact->getTitle() }}</p>
        </a>
    </div>
    <div class="col s12 m4">
        <p class="email">
            <a class="no-underline" href="mailto::{{ $contact->email }}">{{ $contact->email }}</a>
        </p>
        <p class="phone">@component('components.phone', ['phone' => $contact->profile ? $contact->profile->phone : null])@endcomponent</p>
    </div>
    <div class="col s12 m4">
        <div style="margin: 4px 0;">
            <button class="view-contact-notes-btn flat-button small" contact-id="{{ $contact->id }}">{{ $contact->getNoteCount() }} <i class="fa fa-comments"></i></button>
            @component('components.resume-button', ['url' => $contact->profile ? $contact->profile->resume_url : null])@endcomponent
            @component('components.admin-profile-button', ['user' => $contact->user])@endcomponent
        </div>
        @if ($last_note)
            <p class="small italic">{{ $last_note->create_user_name }} {{ $last_note->created_at->format('m/d/Y') }}</p>
        @endif
    </div>
</div>
