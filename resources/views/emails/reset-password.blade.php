@component('emails.layout')
    @slot ('title')
        Reset Password
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <p>Click this link to reset your password:  <a href="{{route('password.reset', $token)}}">{{route('password.reset', $token)}}</a></p>
        <p>If you did not request a password reset, no further action is required.</p>
        <p>Regards,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
