<a href="" target="_blank" rel="noopener">
    <div class="card large blog-card">
        <div class="card-content" style="height: 100%; padding: .5rem;">
            <div class="col s12 center" style="align-items: flex-start; padding-top: 1rem;">
                @if (!is_null($post->images->first()))
                    <a href="/post/{{ $post->title_url}}" target="_blank" rel="noopener" class="no-underline blog-list-hover">
                        <img src="{{ $post->images->first()->getURL('share') }}" style="width: 100%;"/>
                    </a>
                @endif
            </div>
            <div class="col s12">
                <a href="/post/{{ $post->title_url}}" target="_blank" rel="noopener" class="no-underline blog-list-hover">
                    <h5 style="margin-top: 0; margin-bottom: 0; font-weight: 600;">{{ $post->title }}</h5>

                    <p class="small light" style="margin-top: 3px;">
                        By <span style="text-transform: uppercase;">{{(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)}}</span>
                    </p>

                    <div class="blog-blurb">{{ strip_tags($post->blurb) }}</div>
                </a>
            </div>
            <div class="col s12" style="height: 40px;">
                <div style="position: absolute; bottom: 10px; padding-right: 10px;">
                    @foreach($post->tags as $tag)
                        <a href="{{ $url . " tag=" . urlencode($tag->slug) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</a>
