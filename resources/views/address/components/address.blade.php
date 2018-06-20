<address>
    <p>
    @if ($address->name)
        {{ $address->name }}<br/>
    @endif
    @if ($address->line1)
        {{ $address->line1 }}<br/>
    @endif
    @if ($address->line2)
        {{ $address->line2 }}<br/>
    @endif
    {{ $address->city ? $address->city . ", " : '' }}{{ $address->state }} {{ $address->postal_code }} {{ $address->country }}
    </p>
</address>
