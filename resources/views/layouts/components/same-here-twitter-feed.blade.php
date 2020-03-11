<div class="twitter-samehere-feed" style="display:flex;">
    @foreach ($feed as $status)
       <div style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 20%; padding: 20px 30px;">
           <a class="no-underline" href="https://twitter.com/web/status/{{ $status->id }}">
               <h5 style="display: inline-flex;"><img src="{{ $status->user->profile_image_url_https }}" style="max-width: 30px; border-radius: 50%;" />
                   &nbsp;&nbsp;{{ '@'.$status->user->screen_name }}
               </h5>
               <p style="text-align: justify;text-align-last: center;"><i>{{$status->text}}</i></p>
           </a>
       </div>
    @endforeach
</div>
