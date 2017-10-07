@if ($phone && strlen($phone) == 10)
    {{"(".substr($phone, 0, 3).")".substr($phone, 3, 3)."-".substr($phone, 6, 4)}}</span>
@else
    {{$phone}}
@endif
