<div class="row">
    <div class="col s4">
        <a href="https://instagram.com/{{ $username }}">
            <img class="avatar" src="{{ $avatar }}" alt="">
        </a>
    </div>
    <div class="col s8">
        <a class="username" href="https://instagram.com/{{ $username }}"><span>@</span>{{ $username }}</a>
        <p class="small">{{ $bio }}</p>
    </div>
</div>
<div class="instagram-feed">
    @foreach ($feed as $i => $image)
        @if ($i % 3 == 0)
            <div class="row">
        @endif
        <div class="col s4">
            <a href="{{ $image['url'] }}"><img src="{{ $image['src'] }}" alt=""></a>
        </div>
        @if ($i % 3 == 2)
            </div>
        @endif
    @endforeach
</div>
