@if (count(Session::get('message')) > 0)
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
        <div class="{{$msg_class}}">{{$message->getMessage()}}</div>
    @endforeach
@endif
