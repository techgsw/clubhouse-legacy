@if ($contact->user->profile)
    @if ($contact->user->hasCompleteProfile())
        <a href="/user/{{ $contact->user->id }}/profile" class="flat-button small green">Complete profile</a>
    @else
        <a href="/user/{{ $contact->user->id }}/profile" class="flat-button small yellow">Incomplete profile</a>
    @endif
@else
    <button type="button" class="flat-button small gray" disabled>No profile</button>
@endif
