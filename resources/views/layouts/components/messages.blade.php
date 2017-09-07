@if (count(Session::get('message')) > 0)
    <div class="row">
        <div class="col s12">
            @php
                // TODO Need to do multiples
                $messages = [Session::get('message')];
            @endphp
            @foreach ($messages as $message)
                @php
                    switch ($message->getType()) {
                        case "success":
                            $msg_class = "alert card-panel green lighten-4 green-text text-darken-4";
                            break;
                        case "danger":
                            $msg_class = "alert card-panel red lighten-4 red-text text-darken-4";
                            break;
                        default:
                            $msg_class = "alert card-panel";
                            break;
                    }
                @endphp
                @if ($message->getURL())
                    <a href="{{ $message->getURL() }}">
                @endif
                    <div class="{{$msg_class}}">
                        @if ($message->getIcon())
                            <i class="material-icons" style="float: left; padding-right: 12px;">{{ $message->getIcon() }}</i>
                        @endif
                        {{$message->getMessage()}}
                    </div>
                @if ($message->getURL())
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endif
