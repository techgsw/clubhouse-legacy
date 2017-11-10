<form action="/admin/job" method="get">
    <div class="row">
        <div class="col s3 input-field">
            <label class="active">Job Type</label>
            <select name="job_type" class="browser-default">
                <option value="all" {{ (!request('job_type') || request('job_type') == 'all') ? "selected" : "" }}>All</option>
                <option value="ticket-sales" {{ request('job_type') == 'ticket-sales' ? "selected" : "ticket-sales" }}>Ticket Sales</option>
                <option value="sponsorship-sales" {{ request('job_type') == 'sponsorship-sales' ? "selected" : "sponsorship-sales" }}>Sponsorship Sales</option>
                <option value="marketing" {{ request('job_type') == 'marketing' ? "selected" : "marketing" }}>Marketing</option>
                <option value="internships" {{ request('job_type') == 'internships' ? "selected" : "internships" }}>Internships</option>
                <option value="business-operations" {{ request('job_type') == 'business-operations' ? "selected" : "business-operations" }}>Business operations</option>
                <option value="data-analytics" {{ request('job_type') == 'data-analytics' ? "selected" : "data-analytics" }}>Data/Analytics</option>
                <option value="player-operations" {{ request('job_type') == 'player-operations' ? "selected" : "player-operations" }}>Player operations</option>
                <option value="communications" {{ request('job_type') == 'communications' ? "selected" : "communications" }}>Communications</option>
                <option value="it-technology" {{ request('job_type') == 'it-technology' ? "selected" : "it-technology" }}>IT and Technology</option>
                <option value="administrative" {{ request('job_type') == 'administrative' ? "selected" : "administrative" }}>Administrative</option>
            </select>
        </div>
        <div class="col s3 input-field">
            <label class="active">League</label>
            <select name="league" class="browser-default">
                <option value="all" {{ (!request('league') || request('league') == 'all') ? "selected" : "" }}>All</option>
                <option value="mlb" {{ request('league') == "mlb" ? "selected" : "" }}>MLB</option>
                <option value="mls" {{ request('league') == "mls" ? "selected" : "" }}>MLS</option>
                <option value="nba" {{ request('league') == "nba" ? "selected" : "" }}>NBA</option>
                <option value="ncaa" {{ request('league') == "ncaa" ? "selected" : "" }}>NCAA</option>
                <option value="nfl" {{ request('league') == "nfl" ? "selected" : "" }}>NFL</option>
                <option value="nhl" {{ request('league') == "nhl" ? "selected" : "" }}>NHL</option>
                <option value="wnba" {{ request('league') == "wnba" ? "selected" : "" }}>WNBA</option>
                <option value="other" {{ request('league') == "other" ? "selected" : "" }}>Other</option>
            </select>
        </div>
        <div class="col s3 input-field">
            <label class="active">State</label>
            <select name="state" class="browser-default">
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
            </select>
        </div>
        <div class="col s3 input-field">
            <label class="active">Status</label>
            <select name="status" class="browser-default">
                <option value="" {{ request('status') == "" ? "selected" : "" }}>All</option>
                <option value="open" {{ request('status') == "open" ? "selected" : "" }}>Open</option>
                <option value="closed" {{ request('status') == "closed" ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div class="col s12 m8 input-field">
            <input type="text" name="organization" id="organization" value="{{ request('organization') }}">
            <label for="organization">Organization</label>
        </div>
        <div class="col s6 m2 input-field center-align">
            <button type="submit" name="search" class="btn sbs-red" style="margin-top: 6px;">Search</button>
        </div>
        <div class="col s6 m2 input-field center-align">
            <a href="/admin/job" type="button" name="clear" class="btn white black-text" style="margin-top: 6px;">Clear</a>
        </div>
    </div>
</form>
