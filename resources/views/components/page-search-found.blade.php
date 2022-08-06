<div style="margin: 12px 0; border-radius: 4px; background: #F2F2F2; padding: 10px 14px;">
    @if (request('tag') && is_null($not_found))
        Sorry, we couldn't find any tags named <b>{{request('tag')}}</b>
        <a href="{{ $base_url }}" style="float: right;">Go Back</a>
    @else
        <b>{{ $items->total() }}</b> result{{ count($items) > 1 || count($items) == 0 ? "s" : "" }}
        @if (request('search'))
            searching for <b>{{ request('search') }}</b>
        @endif
        @if (request('tag') && isset($active_tag))
            tagged <b>{{ $active_tag->name }}</b>
        @endif
        <a href="{{ $base_url }}" style="float: right;">Clear</a>
    @endif
</div>
