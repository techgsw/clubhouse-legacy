<form method="post" id="add-card" action="/checkout/add-card">
    {{ csrf_field() }}
    @php
        $address = Auth::user()->profile->address[0];
    @endphp
    <div class="row">
        <div class="col s12">
            <h5>Billing Information</h5>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
            <input id="first-name" class="validate" type="text" name="first_name" value="{{ old('first_name') ?: Auth::user()->first_name }}" required>
            <label for="first-name">First Name</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
            <input id="last-name" class="validate" type="text" name="last_name" value="{{ old('last_name') ?: Auth::user()->last_name }}" required>
            <label for="last-name">Last name</label>
        </div>
    </div>
    <div class="row">
        <div style="padding-bottom: 20px;" class="input-field col s12 m6">
            <div id="cc-number-wrapper"></div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h5>Billing Address</h5>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_address1') ? 'invalid' : '' }}">
            <input id="billing-address1" class="validate" type="text" name="billing_address1" value="{{ old('billing_address1') ?: $address ? $address->line1 : '' }}" required>
            <label for="billing-address1">Billing Address</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_address2') ? 'invalid' : '' }}">
            <input id="billing-address2" class="validate" type="text" name="billing_address2" value="{{ old('billing_address2') ?: $address ? $address->line2 : '' }}" required>
            <label for="billing-address2">Apt/Suite #</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_city') ? 'invalid' : '' }}">
            <input id="billing_city" class="validate" type="text" name="billing_city" value="{{ old('billing_city') ?: $address ? $address->city : '' }}" required>
            <label for="billing_city">City</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_state') ? 'invalid' : '' }}">
            <input id="billing_state" class="validate" type="text" name="billing_state" value="{{ old('billing_state') ?: $address ? $address->state : '' }}" required>
            <label for="billing_state">State</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_country') ? 'invalid' : '' }}">
            <input id="billing_country" class="validate" type="text" name="billing_country" value="{{ old('billing_country') ?: $address ? $address->country : '' }}" required>
            <label for="billing_country">Country</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_zip') ? 'invalid' : '' }}">
            <input id="billing_zip" class="validate" type="text" name="billing_zip" value="{{ old('billing_zip') ?: $address ? $address->postal_code: '' }}" required>
            <label for="billing_zip">Postal Code</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn btn-medium sbs-red new-cc-button">Save</button>
        </div>
    </div>
</form>
