@if ($post->user->id === 1 && is_null($post->authored_by))
    @include('post.signatures.bob-hamer')
@elseif ($post->user->id === 7 && is_null($post->authored_by))
    @include('post.signatures.mike-rudner')
@else
    <div class="container">
        <div class="row">
            <div class="col s6">
                <h5><a href="/about">{{$post->authored_by ?: $post->user->getName() }}</a></h5>
                <p style="margin-top: 0; margin-bottom: 0;">{{ __('general.company_name') }}</p>
                <p style="margin-top: 5px;">
                    <a target="_blank" href="https://facebook.com/sportsbusinesssolutions"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a target="_blank" href="https://twitter.com/SportsBizSol"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a target="_blank" href="https://instagram.com/sportsbizsol"><i class="fa fa-instagram fa-16x" aria-hidden="true"></i></a>
                    <a target="_blank" href="https://www.linkedin.com/company/sports-business-solutions"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                </p>
            </div>
        </div>
    </div>
@endif
