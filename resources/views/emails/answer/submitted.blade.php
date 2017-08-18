@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Someone just posted an answer to your question:</p>
        <p><b>{{ $question->title }}</b></p>
        <p>{{ $answer->answer }}</p>
        <p><a href="{{ config('app.url') }}/question/{{ $question->id }}">Click here</a> view your question and the community's answers.</p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
