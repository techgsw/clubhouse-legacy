<div class="input-field col s12">
    <input id="line1" type="text" class="{{ $errors->has('line1') ? 'invalid' : '' }}" name="line1" value="{{ old('line1') ?: $address->line1 }}">
    <label for="line1" data-error="{{ $errors->first('line1') }}">Street Address</label>
</div>
<div class="input-field col s12">
    <input id="line2" type="text" class="{{ $errors->has('line2') ? 'invalid' : '' }}" name="line2" value="{{ old('line2') ?: $address->line2 }}">
    <label for="line2" data-error="{{ $errors->first('line2') }}">Line 2</label>
</div>
<div class="input-field col s12 m8">
    <input id="city" type="text" class="{{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="{{ old('city') ?: $address->city }}">
    <label for="city" data-error="{{ $errors->first('city') }}">City</label>
</div>
<div class="input-field col s12 m4">
    <input id="postal-code" type="text" class="{{ $errors->has('postal_code') ? 'invalid' : '' }}" name="postal_code" value="{{ old('postal_code') ?: $address->postal_code }}">
    <label for="postal-code" data-error="{{ $errors->first('postal_code') }}">Postal Code</label>
</div>
<div class="input-field col s6">
    <select name="state">
        <option value="" {{ old("state") == "" ? "selected" : is_null($address->state) ? "selected" : "" }} disabled>U.S.A.</option>
        <option value="AL" {{ old('state') == "AL" ? "selected" : $address->state == "AL" ? 'selected' : '' }}>Alabama</option>
        <option value="AK" {{ old('state') == "AK" ? 'selected' : $address->state == "AK" ? 'selected' : '' }}>Alaska</option>
        <option value="AZ" {{ old('state') == "AZ" ? 'selected' : $address->state == "AZ" ? 'selected' : '' }}>Arizona</option>
        <option value="AR" {{ old('state') == "AR" ? 'selected' : $address->state == "AR" ? 'selected' : '' }}>Arkansas</option>
        <option value="CA" {{ old('state') == "CA" ? 'selected' : $address->state == "CA" ? 'selected' : '' }}>California</option>
        <option value="CO" {{ old('state') == "CO" ? 'selected' : $address->state == "CO" ? 'selected' : '' }}>Colorado</option>
        <option value="CT" {{ old('state') == "CT" ? 'selected' : $address->state == "CT" ? 'selected' : '' }}>Connecticut</option>
        <option value="DE" {{ old('state') == "DE" ? 'selected' : $address->state == "DE" ? 'selected' : '' }}>Delaware</option>
        <option value="DC" {{ old('state') == "DC" ? 'selected' : $address->state == "DC" ? 'selected' : '' }}>District Of Columbia</option>
        <option value="FL" {{ old('state') == "FL" ? 'selected' : $address->state == "FL" ? 'selected' : '' }}>Florida</option>
        <option value="GA" {{ old('state') == "GA" ? 'selected' : $address->state == "GA" ? 'selected' : '' }}>Georgia</option>
        <option value="HI" {{ old('state') == "HI" ? 'selected' : $address->state == "HI" ? 'selected' : '' }}>Hawaii</option>
        <option value="ID" {{ old('state') == "ID" ? 'selected' : $address->state == "ID" ? 'selected' : '' }}>Idaho</option>
        <option value="IL" {{ old('state') == "IL" ? 'selected' : $address->state == "IL" ? 'selected' : '' }}>Illinois</option>
        <option value="IN" {{ old('state') == "IN" ? 'selected' : $address->state == "IN" ? 'selected' : '' }}>Indiana</option>
        <option value="IA" {{ old('state') == "IA" ? 'selected' : $address->state == "IA" ? 'selected' : '' }}>Iowa</option>
        <option value="KS" {{ old('state') == "KS" ? 'selected' : $address->state == "KS" ? 'selected' : '' }}>Kansas</option>
        <option value="KY" {{ old('state') == "KY" ? 'selected' : $address->state == "KY" ? 'selected' : '' }}>Kentucky</option>
        <option value="LA" {{ old('state') == "LA" ? 'selected' : $address->state == "LA" ? 'selected' : '' }}>Louisiana</option>
        <option value="ME" {{ old('state') == "ME" ? 'selected' : $address->state == "ME" ? 'selected' : '' }}>Maine</option>
        <option value="MD" {{ old('state') == "MD" ? 'selected' : $address->state == "MD" ? 'selected' : '' }}>Maryland</option>
        <option value="MA" {{ old('state') == "MA" ? 'selected' : $address->state == "MA" ? 'selected' : '' }}>Massachusetts</option>
        <option value="MI" {{ old('state') == "MI" ? 'selected' : $address->state == "MI" ? 'selected' : '' }}>Michigan</option>
        <option value="MN" {{ old('state') == "MN" ? 'selected' : $address->state == "MN" ? 'selected' : '' }}>Minnesota</option>
        <option value="MS" {{ old('state') == "MS" ? 'selected' : $address->state == "MS" ? 'selected' : '' }}>Mississippi</option>
        <option value="MO" {{ old('state') == "MO" ? 'selected' : $address->state == "MO" ? 'selected' : '' }}>Missouri</option>
        <option value="MT" {{ old('state') == "MT" ? 'selected' : $address->state == "MT" ? 'selected' : '' }}>Montana</option>
        <option value="NE" {{ old('state') == "NE" ? 'selected' : $address->state == "NE" ? 'selected' : '' }}>Nebraska</option>
        <option value="NV" {{ old('state') == "NV" ? 'selected' : $address->state == "NV" ? 'selected' : '' }}>Nevada</option>
        <option value="NH" {{ old('state') == "NH" ? 'selected' : $address->state == "NH" ? 'selected' : '' }}>New Hampshire</option>
        <option value="NJ" {{ old('state') == "NJ" ? 'selected' : $address->state == "NJ" ? 'selected' : '' }}>New Jersey</option>
        <option value="NM" {{ old('state') == "NM" ? 'selected' : $address->state == "NM" ? 'selected' : '' }}>New Mexico</option>
        <option value="NY" {{ old('state') == "NY" ? 'selected' : $address->state == "NY" ? 'selected' : '' }}>New York</option>
        <option value="NC" {{ old('state') == "NC" ? 'selected' : $address->state == "NC" ? 'selected' : '' }}>North Carolina</option>
        <option value="ND" {{ old('state') == "ND" ? 'selected' : $address->state == "ND" ? 'selected' : '' }}>North Dakota</option>
        <option value="OH" {{ old('state') == "OH" ? 'selected' : $address->state == "OH" ? 'selected' : '' }}>Ohio</option>
        <option value="OK" {{ old('state') == "OK" ? 'selected' : $address->state == "OK" ? 'selected' : '' }}>Oklahoma</option>
        <option value="OR" {{ old('state') == "OR" ? 'selected' : $address->state == "OR" ? 'selected' : '' }}>Oregon</option>
        <option value="PA" {{ old('state') == "PA" ? 'selected' : $address->state == "PA" ? 'selected' : '' }}>Pennsylvania</option>
        <option value="RI" {{ old('state') == "RI" ? 'selected' : $address->state == "RI" ? 'selected' : '' }}>Rhode Island</option>
        <option value="SC" {{ old('state') == "SC" ? 'selected' : $address->state == "SC" ? 'selected' : '' }}>South Carolina</option>
        <option value="SD" {{ old('state') == "SD" ? 'selected' : $address->state == "SD" ? 'selected' : '' }}>South Dakota</option>
        <option value="TN" {{ old('state') == "TN" ? 'selected' : $address->state == "TN" ? 'selected' : '' }}>Tennessee</option>
        <option value="TX" {{ old('state') == "TX" ? 'selected' : $address->state == "TX" ? 'selected' : '' }}>Texas</option>
        <option value="UT" {{ old('state') == "UT" ? 'selected' : $address->state == "UT" ? 'selected' : '' }}>Utah</option>
        <option value="VT" {{ old('state') == "VT" ? 'selected' : $address->state == "VT" ? 'selected' : '' }}>Vermont</option>
        <option value="VA" {{ old('state') == "VA" ? 'selected' : $address->state == "VA" ? 'selected' : '' }}>Virginia</option>
        <option value="WA" {{ old('state') == "WA" ? 'selected' : $address->state == "WA" ? 'selected' : '' }}>Washington</option>
        <option value="WV" {{ old('state') == "WV" ? 'selected' : $address->state == "WV" ? 'selected' : '' }}>West Virginia</option>
        <option value="WI" {{ old('state') == "WI" ? 'selected' : $address->state == "WI" ? 'selected' : '' }}>Wisconsin</option>
        <option value="WY" {{ old('state') == "WY" ? 'selected' : $address->state == "WY" ? 'selected' : '' }}>Wyoming</option>
        <option disabled>Canada</option>
        <option value="AB" {{ old('state') == "AB" ? 'selected' : $address->state == "AB" ? 'selected' : '' }}>Alberta</option>
        <option value="BC" {{ old('state') == "BC" ? 'selected' : $address->state == "BC" ? 'selected' : '' }}>British Columbia</option>
        <option value="MB" {{ old('state') == "MB" ? 'selected' : $address->state == "MB" ? 'selected' : '' }}>Manitoba</option>
        <option value="NB" {{ old('state') == "NB" ? 'selected' : $address->state == "NB" ? 'selected' : '' }}>New Brunswick</option>
        <option value="NL" {{ old('state') == "NL" ? 'selected' : $address->state == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
        <option value="NS" {{ old('state') == "NS" ? 'selected' : $address->state == "NS" ? 'selected' : '' }}>Nova Scotia</option>
        <option value="ON" {{ old('state') == "ON" ? 'selected' : $address->state == "ON" ? 'selected' : '' }}>Ontario</option>
        <option value="PE" {{ old('state') == "PE" ? 'selected' : $address->state == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
        <option value="QC" {{ old('state') == "QC" ? 'selected' : $address->state == "QC" ? 'selected' : '' }}>Quebec</option>
        <option value="SK" {{ old('state') == "SK" ? 'selected' : $address->state == "SK" ? 'selected' : '' }}>Saskatchewan</option>
        <option value="NT" {{ old('state') == "NT" ? 'selected' : $address->state == "NT" ? 'selected' : '' }}>Northwest Territories</option>
        <option value="NU" {{ old('state') == "NU" ? 'selected' : $address->state == "NU" ? 'selected' : '' }}>Nunavut</option>
        <option value="YT" {{ old('state') == "YT" ? 'selected' : $address->state == "YT" ? 'selected' : '' }}>Yukon</option>
        <option disabled>U.K.</option>
        <option value="England" {{ old('state') == "England" ? 'selected' : $address->state == "England" ? 'selected' : '' }}>England</option>
        <option value="Northern Ireland" {{ old('state') == "Northern Ireland" ? 'selected' : $address->state == "Northern Ireland" ? 'selected' : '' }}>Northern Ireland</option>
        <option value="Scotland" {{ old('state') == "Scotland" ? 'selected' : $address->state == "Scotland" ? 'selected' : '' }}>Scotland</option>
        <option value="Wales" {{ old('state') == "Wales" ? 'selected' : $address->state == "Wales" ? 'selected' : '' }}>Wales</option>
    </select>
    <label>State</label>
</div>
<div class="input-field col s6">
    <select name="country">
        <option value="US" {{ old('country') == "US" ? 'selected' : $address->country == "US" ? 'selected' : '' }}>U.S.A.</option>
        <option value="CA" {{ old('country') == "CA" ? 'selected' : $address->country == "CA" ? 'selected' : '' }}>Canada</option>
        <option value="UK" {{ old('country') == "UK" ? 'selected' : $address->country == "UK" ? 'selected' : '' }}>U.K.</option>
    </select>
    <label>Country</label>
</div>
