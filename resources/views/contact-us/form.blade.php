<div class="row" style="margin: 75px 0px;">
    <div class="col hide-on-small-and-down m7" style="margin-left:-5%;padding-right:7%; display:flex; justify-content:right;">
        <div style="box-shadow:25px 25px; max-width:744px; display:flex; justify-content: center; overflow:hidden;">
            <img src="/images/sbs_contact_form_image.jpg" style="min-width:744px; box-shadow:25px 25px;">
        </div>
    </div>
    <div class="col s12 m5" style="max-width:500px;">
        <form action="/contact" method="post">
            <h4>Want to become a partner?</h4>
            <h4>Contact us</h4>
            {{ csrf_field() }}
            <div class="sbs input-field" {{ $errors->has('name') ? 'invalid' : '' }}>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                <label for="name">Name</label>
            </div>
            <div class="sbs input-field" {{ $errors->has('email') ? 'invalid' : '' }}>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                <label for="email">Email</label>
            </div>
            <div class="sbs input-field" {{ $errors->has('phone') ? 'invalid' : '' }}>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
                <label for="phone">Phone</label>
            </div>
            <div class="sbs input-field" {{ $errors->has('organization') ? 'invalid' : '' }}>
                <input id="organization" type="text" name="organization" value="{{ old('organization') }}">
                <label for="organization">Organization</label>
            </div>
            <div class="input-field" style="display:flex;align-items:center;flex-wrap:wrap;">
                <div class="g-recaptcha" style="margin-right:20px; margin-top:10px;"data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                <button type="submit" style="margin-top:10px;" class="btn btn-large sbs-red">Submit</button>
            </div>
        </form>
    </div>
</div>
