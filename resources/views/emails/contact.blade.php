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
        @if (!is_null($request->body))
            <p>{!! nl2br(e($request->body)) !!}</p>
        @else
            <p>A new client has filled out the Contact Us form and would like to get into contact with you:</p>
        @endif
        <p>
            {{ $request->name }}<br/>
            @if (!is_null($request->organization))
                {{ $request->organization }}<br/>
            @endif
            {{ $request->email }}<br/>
            {{ $request->phone }}
        </p>
    </body>
</html>
