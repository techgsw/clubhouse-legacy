<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            html {
                font-family: "Roboto", "Helvetica", sans-serif;
            }
        </style>
    </head>
    <body>
        @if (!is_null($request->interested_in))
            <p><i>Interested in {{ $request->interested_in }}</i></p>
        @endif
        <p>{!! nl2br(e($request->body)) !!}</p>
        <p>
            {{ $request->first_name }} {{ $request->last_name }}<br/>
            @if (!is_null($request->organization))
                {{ $request->organization }}<br/>
            @endif
            {{ $request->email }}<br/>
            {{ $request->phone }}
        </p>
    </body>
</html>
