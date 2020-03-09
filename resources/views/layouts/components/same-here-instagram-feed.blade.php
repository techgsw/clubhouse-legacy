<div class="instagram-feed">
    @foreach ($feed as $i => $image)
        <a href="{{ $image['url'] }}"><img style="margin:0px 15px;" src="{{ $image['src'] }}" alt=""></a>
    @endforeach
</div>
