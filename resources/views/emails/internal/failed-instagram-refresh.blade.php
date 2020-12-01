@component('emails.layout')
    @slot('body')
        <p>The instagram token failed to refresh for env <code>{{$env_name}}</code></p>
        <p>This process is run by <code>Commands\RefreshInstagramTokens</code> and should log exceptions to the error log</p>
        <p>Exception: <pre>{{$exception->getMessage()}}<pre><p>
    @endslot
@endcomponent

