<form action="/job" method="get">
    <div class="row">
        <div class="col s12 m7">
            <div class="col s4 input-field">
                <label class="active">Job Discipline</label>
                <select name="job_discipline" class="">
                    <option value="all" {{ (!request('job_discipline') || request('job_discipline') == 'all') ? "selected" : "" }}>All</option>
                    @foreach($disciplines as $discipline)
                        <option value="{{$discipline->tag->slug}}" {{ request('job_discipline') == $discipline->tag->slug ? "selected" : "" }}>{{$discipline->tag->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s4 input-field">
                <label class="active">League</label>
                <select name="league" class="">
                    <option value="all" {{ (!request('league') || request('league') == 'all') ? "selected" : "" }}>All</option>
                    @foreach ($leagues as $league)
                        <option value="{{ $league->abbreviation }}" {{ request('league') == $league->abbreviation ? "selected" : "" }}>{{ $league->abbreviation }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s4 input-field">
                <label class="active">Location</label>
                <select id="state" name="state" class="">
                    <option value="" {{ request('state') == "" ? "selected" : "" }}>All</option>
                    <option disabled>U.S.A.</option>
                    <option value="AL" {{ request('state') == "AL" ? "selected" : "" }}>Alabama</option>
                    <option value="AK" {{ request('state') == "AK" ? 'selected' : '' }}>Alaska</option>
                    <option value="AZ" {{ request('state') == "AZ" ? 'selected' : '' }}>Arizona</option>
                    <option value="AR" {{ request('state') == "AR" ? 'selected' : '' }}>Arkansas</option>
                    <option value="CA" {{ request('state') == "CA" ? 'selected' : '' }}>California</option>
                    <option value="CO" {{ request('state') == "CO" ? 'selected' : '' }}>Colorado</option>
                    <option value="CT" {{ request('state') == "CT" ? 'selected' : '' }}>Connecticut</option>
                    <option value="DE" {{ request('state') == "DE" ? 'selected' : '' }}>Delaware</option>
                    <option value="DC" {{ request('state') == "DC" ? 'selected' : '' }}>District Of Columbia</option>
                    <option value="FL" {{ request('state') == "FL" ? 'selected' : '' }}>Florida</option>
                    <option value="GA" {{ request('state') == "GA" ? 'selected' : '' }}>Georgia</option>
                    <option value="HI" {{ request('state') == "HI" ? 'selected' : '' }}>Hawaii</option>
                    <option value="ID" {{ request('state') == "ID" ? 'selected' : '' }}>Idaho</option>
                    <option value="IL" {{ request('state') == "IL" ? 'selected' : '' }}>Illinois</option>
                    <option value="IN" {{ request('state') == "IN" ? 'selected' : '' }}>Indiana</option>
                    <option value="IA" {{ request('state') == "IA" ? 'selected' : '' }}>Iowa</option>
                    <option value="KS" {{ request('state') == "KS" ? 'selected' : '' }}>Kansas</option>
                    <option value="KY" {{ request('state') == "KY" ? 'selected' : '' }}>Kentucky</option>
                    <option value="LA" {{ request('state') == "LA" ? 'selected' : '' }}>Louisiana</option>
                    <option value="ME" {{ request('state') == "ME" ? 'selected' : '' }}>Maine</option>
                    <option value="MD" {{ request('state') == "MD" ? 'selected' : '' }}>Maryland</option>
                    <option value="MA" {{ request('state') == "MA" ? 'selected' : '' }}>Massachusetts</option>
                    <option value="MI" {{ request('state') == "MI" ? 'selected' : '' }}>Michigan</option>
                    <option value="MN" {{ request('state') == "MN" ? 'selected' : '' }}>Minnesota</option>
                    <option value="MS" {{ request('state') == "MS" ? 'selected' : '' }}>Mississippi</option>
                    <option value="MO" {{ request('state') == "MO" ? 'selected' : '' }}>Missouri</option>
                    <option value="MT" {{ request('state') == "MT" ? 'selected' : '' }}>Montana</option>
                    <option value="NE" {{ request('state') == "NE" ? 'selected' : '' }}>Nebraska</option>
                    <option value="NV" {{ request('state') == "NV" ? 'selected' : '' }}>Nevada</option>
                    <option value="NH" {{ request('state') == "NH" ? 'selected' : '' }}>New Hampshire</option>
                    <option value="NJ" {{ request('state') == "NJ" ? 'selected' : '' }}>New Jersey</option>
                    <option value="NM" {{ request('state') == "NM" ? 'selected' : '' }}>New Mexico</option>
                    <option value="NY" {{ request('state') == "NY" ? 'selected' : '' }}>New York</option>
                    <option value="NC" {{ request('state') == "NC" ? 'selected' : '' }}>North Carolina</option>
                    <option value="ND" {{ request('state') == "ND" ? 'selected' : '' }}>North Dakota</option>
                    <option value="OH" {{ request('state') == "OH" ? 'selected' : '' }}>Ohio</option>
                    <option value="OK" {{ request('state') == "OK" ? 'selected' : '' }}>Oklahoma</option>
                    <option value="OR" {{ request('state') == "OR" ? 'selected' : '' }}>Oregon</option>
                    <option value="PA" {{ request('state') == "PA" ? 'selected' : '' }}>Pennsylvania</option>
                    <option value="RI" {{ request('state') == "RI" ? 'selected' : '' }}>Rhode Island</option>
                    <option value="SC" {{ request('state') == "SC" ? 'selected' : '' }}>South Carolina</option>
                    <option value="SD" {{ request('state') == "SD" ? 'selected' : '' }}>South Dakota</option>
                    <option value="TN" {{ request('state') == "TN" ? 'selected' : '' }}>Tennessee</option>
                    <option value="TX" {{ request('state') == "TX" ? 'selected' : '' }}>Texas</option>
                    <option value="UT" {{ request('state') == "UT" ? 'selected' : '' }}>Utah</option>
                    <option value="VT" {{ request('state') == "VT" ? 'selected' : '' }}>Vermont</option>
                    <option value="VA" {{ request('state') == "VA" ? 'selected' : '' }}>Virginia</option>
                    <option value="WA" {{ request('state') == "WA" ? 'selected' : '' }}>Washington</option>
                    <option value="WV" {{ request('state') == "WV" ? 'selected' : '' }}>West Virginia</option>
                    <option value="WI" {{ request('state') == "WI" ? 'selected' : '' }}>Wisconsin</option>
                    <option value="WY" {{ request('state') == "WY" ? 'selected' : '' }}>Wyoming</option>
                    <option disabled>Canada</option>
                    <option value="AB" {{ request('state') == "AB" ? 'selected' : '' }}>Alberta</option>
                    <option value="BC" {{ request('state') == "BC" ? 'selected' : '' }}>British Columbia</option>
                    <option value="MB" {{ request('state') == "MB" ? 'selected' : '' }}>Manitoba</option>
                    <option value="NB" {{ request('state') == "NB" ? 'selected' : '' }}>New Brunswick</option>
                    <option value="NL" {{ request('state') == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
                    <option value="NS" {{ request('state') == "NS" ? 'selected' : '' }}>Nova Scotia</option>
                    <option value="ON" {{ request('state') == "ON" ? 'selected' : '' }}>Ontario</option>
                    <option value="PE" {{ request('state') == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
                    <option value="QC" {{ request('state') == "QC" ? 'selected' : '' }}>Quebec</option>
                    <option value="SK" {{ request('state') == "SK" ? 'selected' : '' }}>Saskatchewan</option>
                    <option value="NT" {{ request('state') == "NT" ? 'selected' : '' }}>Northwest Territories</option>
                    <option value="NU" {{ request('state') == "NU" ? 'selected' : '' }}>Nunavut</option>
                    <option value="YT" {{ request('state') == "YT" ? 'selected' : '' }}>Yukon</option>
                    <option disabled>U.K.</option>
                    <option value="England" {{ request('state') == "England" ? 'selected' : '' }}>England</option>
                    <option value="Northern Ireland" {{ request('state') == "Nothern Ireland" ? 'selected' : '' }}>Northern Ireland</option>
                    <option value="Scotland" {{ request('state') == "Scotland" ? 'selected' : '' }}>Scotland</option>
                    <option value="Wales" {{ request('state') == "Wales" ? 'selected' : '' }}>Wales</option>
                </select>
            </div>
        </div>
        <div class="col s12 m3 input-field">
            <div class="">
                <input type="text" name="organization" id="organization" value="{{ request('organization') }}">
                <label for="organization">Organization</label>
            </div>
        </div>
        <div class="col s12 m2 input-field center-align">
            <button type="submit" name="search" class="btn sbs-red" style="margin-bottom: 12px;">Search</button>
        </div>
    </div>
</form>
