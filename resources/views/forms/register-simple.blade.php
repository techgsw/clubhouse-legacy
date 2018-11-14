<form id="registration-simple" method="post" action="{{ route('register') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
            <input id="first-name" type="text" name="first_name" value="{{ old('first_name') }}" required>
            <label for="first-name">First name</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
            <input id="last-name" type="text" name="last_name" value="{{ old('last_name') }}" required>
            <label for="last-name">Last name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('email') ? 'invalid' : '' }}">
            <input class="browser-default" id="email" type="email" name="email" value="{{ old('email') }}" required>
            <label for="email">Email Address</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('password') ? 'invalid' : '' }}">
            <input id="password" type="password" name="password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="password-confirm" type="password" name="password_confirmation" required>
            <label for="password-confirm">Confirm Password</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <input id="terms" name="terms" type="checkbox" required>
            <label for="terms">I agree to the <a target="_blank" href="/documents/Sports-Business-Solutions-Terms-of-Service.pdf">terms of service</a>.</label>
        </div>
        <div class="col s12">
            <div class="g-recaptcha" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin-top: 10px;" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align" style="margin-top: -20px; padding-bottom: 10px;">
            <button type="submit" class="btn sbs-red">Join Today</button>
        </div>
    </div>
</form>
