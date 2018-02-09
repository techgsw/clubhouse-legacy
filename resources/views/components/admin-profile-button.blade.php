@if (!$user)
    <button type="button" class="flat-button small gray" disabled>Not a user</button>
@elseif ($user->profile)
    @if ($user->hasCompleteProfile())
        <a href="/user/{{ $user->id }}/profile" class="flat-button small green">Complete profile</a>
    @else
        <a href="/user/{{ $user->id }}/profile" class="flat-button small yellow">Incomplete profile</a>
    @endif
@else
    <button type="button" class="flat-button small gray" disabled>No profile</button>
@endif
