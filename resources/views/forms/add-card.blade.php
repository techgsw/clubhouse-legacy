<form method="post" action="/checkout">
    {{ csrf_field() }}
    @php
        $address = Auth::user()->profile->address[0];
    @endphp
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('cc_number') ? 'invalid' : '' }}">
            <input id="cc-number" type="text" name="cc_number" value="{{ old('cc_number') }}" required>
            <label for="cc-number">Credit Card Number</label>
        </div>
        <div class="input-field col s6 m3 {{ $errors->has('cc_exp_month') ? 'invalid' : '' }}">
            <select id="cc-exp-month" class="" name="cc_exp_month">
                <option value="" "selected" disabled>Please select...</option>
            </select>
            <label for="cc-exp-month">Exp. Month</label>
        </div>
        <div class="input-field col s6 m3 {{ $errors->has('cc_exp_year') ? 'invalid' : '' }}">
            <select id="cc-exp-year" class="" name="cc_exp_year">
                <option value="" "selected" disabled>Please select...</option>
            </select>
            <label for="cc-exp-year">Exp. Year</label>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h5>Billing Address</h5>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('first_name') ? 'invalid' : '' }}">
            <input id="first-name" type="text" name="first_name" value="{{ old('first_name') ?: Auth::user()->first_name }}" required>
            <label for="first-name">First Name</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('last_name') ? 'invalid' : '' }}">
            <input id="last-name" type="text" name="last_name" value="{{ old('last_name') ?: Auth::user()->last_name }}" required>
            <label for="last-name">Last name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_address1') ? 'invalid' : '' }}">
            <input id="billing-address1" type="text" name="billing_address1" value="{{ old('billing_address1') ?: $address ? $address->line1 : '' }}" required>
            <label for="billing-address1">Billing Address</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_address2') ? 'invalid' : '' }}">
            <input id="billing-address2" type="text" name="billing_address2" value="{{ old('billing_address2') ?: $address ? $address->line2 : '' }}" required>
            <label for="billing-address2">Apt/Suite #</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_city') ? 'invalid' : '' }}">
            <input id="billing_city" type="text" name="billing_city" value="{{ old('billing_city') ?: $address ? $address->city : '' }}" required>
            <label for="billing_city">City</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_state') ? 'invalid' : '' }}">
            <input id="billing_state" type="text" name="billing_state" value="{{ old('billing_state') ?: $address ? $address->state : '' }}" required>
            <label for="billing_state">State</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('billing_country') ? 'invalid' : '' }}">
            <input id="billing_country" type="text" name="billing_country" value="{{ old('billing_country') ?: $address ? $address->country : '' }}" required>
            <label for="billing_country">Country</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('billing_zip') ? 'invalid' : '' }}">
            <input id="billing_zip" type="text" name="billing_zip" value="{{ old('billing_zip') ?: $address ? $address->postal_code: '' }}" required>
            <label for="billing_zip">Postal Code</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn btn-medium sbs-red new-cc-button">Save</button>
        </div>
    </div>
</form>
