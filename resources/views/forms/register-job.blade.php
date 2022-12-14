<form method="post" action="/register?job=true">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12">
            <p>Already a member? <a href="/login">Login!</a></p>
        </div>
    </div>
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
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
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
        <div class="col s12 m6" style="margin-bottom: 20px;">
            <input id="terms" name="terms" type="checkbox" required>
            <label for="terms">I agree to the <a target="_blank" href="/documents/Sports-Business-Solutions-Terms-of-Service.pdf">terms of service</a>.</label>
        </div>    
        <div class="col s12 m6">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn sbs-red">Complete Registration</button>
        </div>
    </div>
</form>
