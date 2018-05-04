<form id="create-job-form" method="post" action="/job" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m8">
            <div class="row">
                <div class="input-field col s12 m9">
                    <input id="title" type="text" class="{{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                <div class="input-field col s12 m3">
                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? "checked" : "" }} />
                    <label for="featured">Featured</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="description" class="materialize-textarea {{ $errors->has('description') ? 'invalid' : '' }}" name="description" required style="min-height: 8rem;">{{ old('description') }}</textarea>
                    <label for="description" data-error="{{ $errors->first('description') }}">Description</label>
                </div>
                <div class="input-field col s12 m5">
                    <label for="job-type" class="active">Type</label>
                    <select id="job-type" name="job_type" class="browser-default">
                        <option value="" {{ old('job_type') == "" ? "selected" : "" }}>None</option>
                        <option value="ticket-sales" {{ old('job_type') == 'ticket-sales' ? "selected" : "" }}>Ticket Sales</option>
                        <option value="sponsorship-sales" {{ old('job_type') == 'sponsorship-sales' ? "selected" : "" }}>Sponsorship Sales</option>
                        <option value="marketing" {{ old('job_type') == 'marketing' ? "selected" : "" }}>Marketing</option>
                        <option value="internships" {{ old('job_type') == 'internships' ? "selected" : "" }}>Internships</option>
                        <option value="business-operations" {{ old('job_type') == 'business-operations' ? "selected" : "" }}>Business operations</option>
                        <option value="data-analytics" {{ old('job_type') == 'data-analytics' ? "selected" : "" }}>Data/Analytics</option>
                        <option value="player-operations" {{ old('job_type') == 'player-operations' ? "selected" : "" }}>Player operations</option>
                        <option value="communications" {{ old('job_type') == 'communications' ? "selected" : "" }}>Communications</option>
                        <option value="it-technology" {{ old('job_type') == 'it-technology' ? "selected" : "" }}>IT and Technology</option>
                        <option value="administrative" {{ old('job_type') == 'administrative' ? "selected" : "" }}>Administrative</option>
                    </select>
                </div>
                <div class="file-field input-field col s12 m7">
                    <div class="btn white black-text">
                        <span>Document</span>
                        <input type="file" name="document" value="{{ old('document') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path" type="text" name="document_text" value="">
                    </div>
                </div>
                <div class="input-field col s12">
                    <button type="submit" class="btn sbs-red">Post</button>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="row">
                <div class="input-field col s12">
                    <input id="organization-id" type="hidden" name="organization_id" value="{{ old('organization_id') }}">
                    <input id="organization" type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') }}" required>
                    <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
                </div>
                <div class="organization-image-preview center-align hidden">
                    <img id="organization-image" src="" style="padding: 16px; max-width: 100px;" />
                </div>
                <div class="file-field input-field col s12">
                    <div class="btn white black-text">
                        <span>Logo</span>
                        <input type="file" name="image_url" value="{{ old('image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path " type="text" name="image_url_text" value="">
                    </div>
                </div>
                <div class="input-field col s12">
                    <input id="city" type="text" class=" {{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="{{ old('city') }}" required>
                    <label for="city" data-error="{{ $errors->first('city') }}">City</label>
                </div>
                <div class="input-field col s6">
                    <label for="state" class="active">State</label>
                    <select id="state" name="state" class="browser-default">
                        <option {{ old('state') == "" ? "selected" : "" }} disabled>Select one</option>
                        <option disabled>U.S.A.</option>
                        <option value="AL" {{ old('state') == "AL" ? "selected" : "" }}>Alabama</option>
                        <option value="AK" {{ old('state') == "AK" ? 'selected' : '' }}>Alaska</option>
                        <option value="AZ" {{ old('state') == "AZ" ? 'selected' : '' }}>Arizona</option>
                        <option value="AR" {{ old('state') == "AR" ? 'selected' : '' }}>Arkansas</option>
                        <option value="CA" {{ old('state') == "CA" ? 'selected' : '' }}>California</option>
                        <option value="CO" {{ old('state') == "CO" ? 'selected' : '' }}>Colorado</option>
                        <option value="CT" {{ old('state') == "CT" ? 'selected' : '' }}>Connecticut</option>
                        <option value="DE" {{ old('state') == "DE" ? 'selected' : '' }}>Delaware</option>
                        <option value="DC" {{ old('state') == "DC" ? 'selected' : '' }}>District Of Columbia</option>
                        <option value="FL" {{ old('state') == "FL" ? 'selected' : '' }}>Florida</option>
                        <option value="GA" {{ old('state') == "GA" ? 'selected' : '' }}>Georgia</option>
                        <option value="HI" {{ old('state') == "HI" ? 'selected' : '' }}>Hawaii</option>
                        <option value="ID" {{ old('state') == "ID" ? 'selected' : '' }}>Idaho</option>
                        <option value="IL" {{ old('state') == "IL" ? 'selected' : '' }}>Illinois</option>
                        <option value="IN" {{ old('state') == "IN" ? 'selected' : '' }}>Indiana</option>
                        <option value="IA" {{ old('state') == "IA" ? 'selected' : '' }}>Iowa</option>
                        <option value="KS" {{ old('state') == "KS" ? 'selected' : '' }}>Kansas</option>
                        <option value="KY" {{ old('state') == "KY" ? 'selected' : '' }}>Kentucky</option>
                        <option value="LA" {{ old('state') == "LA" ? 'selected' : '' }}>Louisiana</option>
                        <option value="ME" {{ old('state') == "ME" ? 'selected' : '' }}>Maine</option>
                        <option value="MD" {{ old('state') == "MD" ? 'selected' : '' }}>Maryland</option>
                        <option value="MA" {{ old('state') == "MA" ? 'selected' : '' }}>Massachusetts</option>
                        <option value="MI" {{ old('state') == "MI" ? 'selected' : '' }}>Michigan</option>
                        <option value="MN" {{ old('state') == "MN" ? 'selected' : '' }}>Minnesota</option>
                        <option value="MS" {{ old('state') == "MS" ? 'selected' : '' }}>Mississippi</option>
                        <option value="MO" {{ old('state') == "MO" ? 'selected' : '' }}>Missouri</option>
                        <option value="MT" {{ old('state') == "MT" ? 'selected' : '' }}>Montana</option>
                        <option value="NE" {{ old('state') == "NE" ? 'selected' : '' }}>Nebraska</option>
                        <option value="NV" {{ old('state') == "NV" ? 'selected' : '' }}>Nevada</option>
                        <option value="NH" {{ old('state') == "NH" ? 'selected' : '' }}>New Hampshire</option>
                        <option value="NJ" {{ old('state') == "NJ" ? 'selected' : '' }}>New Jersey</option>
                        <option value="NM" {{ old('state') == "NM" ? 'selected' : '' }}>New Mexico</option>
                        <option value="NY" {{ old('state') == "NY" ? 'selected' : '' }}>New York</option>
                        <option value="NC" {{ old('state') == "NC" ? 'selected' : '' }}>North Carolina</option>
                        <option value="ND" {{ old('state') == "ND" ? 'selected' : '' }}>North Dakota</option>
                        <option value="OH" {{ old('state') == "OH" ? 'selected' : '' }}>Ohio</option>
                        <option value="OK" {{ old('state') == "OK" ? 'selected' : '' }}>Oklahoma</option>
                        <option value="OR" {{ old('state') == "OR" ? 'selected' : '' }}>Oregon</option>
                        <option value="PA" {{ old('state') == "PA" ? 'selected' : '' }}>Pennsylvania</option>
                        <option value="RI" {{ old('state') == "RI" ? 'selected' : '' }}>Rhode Island</option>
                        <option value="SC" {{ old('state') == "SC" ? 'selected' : '' }}>South Carolina</option>
                        <option value="SD" {{ old('state') == "SD" ? 'selected' : '' }}>South Dakota</option>
                        <option value="TN" {{ old('state') == "TN" ? 'selected' : '' }}>Tennessee</option>
                        <option value="TX" {{ old('state') == "TX" ? 'selected' : '' }}>Texas</option>
                        <option value="UT" {{ old('state') == "UT" ? 'selected' : '' }}>Utah</option>
                        <option value="VT" {{ old('state') == "VT" ? 'selected' : '' }}>Vermont</option>
                        <option value="VA" {{ old('state') == "VA" ? 'selected' : '' }}>Virginia</option>
                        <option value="WA" {{ old('state') == "WA" ? 'selected' : '' }}>Washington</option>
                        <option value="WV" {{ old('state') == "WV" ? 'selected' : '' }}>West Virginia</option>
                        <option value="WI" {{ old('state') == "WI" ? 'selected' : '' }}>Wisconsin</option>
                        <option value="WY" {{ old('state') == "WY" ? 'selected' : '' }}>Wyoming</option>
                        <option disabled>Canada</option>
                        <option value="AB" {{ old('state') == "AB" ? 'selected' : '' }}>Alberta</option>
                        <option value="BC" {{ old('state') == "BC" ? 'selected' : '' }}>British Columbia</option>
                        <option value="MB" {{ old('state') == "MB" ? 'selected' : '' }}>Manitoba</option>
                        <option value="NB" {{ old('state') == "NB" ? 'selected' : '' }}>New Brunswick</option>
                        <option value="NL" {{ old('state') == "NL" ? 'selected' : '' }}>Newfoundland and Labrador</option>
                        <option value="NS" {{ old('state') == "NS" ? 'selected' : '' }}>Nova Scotia</option>
                        <option value="ON" {{ old('state') == "ON" ? 'selected' : '' }}>Ontario</option>
                        <option value="PE" {{ old('state') == "PE" ? 'selected' : '' }}>Prince Edward Island</option>
                        <option value="QC" {{ old('state') == "QC" ? 'selected' : '' }}>Quebec</option>
                        <option value="SK" {{ old('state') == "SK" ? 'selected' : '' }}>Saskatchewan</option>
                        <option value="NT" {{ old('state') == "NT" ? 'selected' : '' }}>Northwest Territories</option>
                        <option value="NU" {{ old('state') == "NU" ? 'selected' : '' }}>Nunavut</option>
                        <option value="YT" {{ old('state') == "YT" ? 'selected' : '' }}>Yukon</option>
                        <option disabled>U.K.</option>
                        <option value="England" {{ old('state') == "England" ? 'selected' : '' }}>England</option>
                        <option value="Northern Ireland" {{ old('state') == "Northern Ireland" ? 'selected' : '' }}>Northern Ireland</option>
                        <option value="Scotland" {{ old('state') == "Scotland" ? 'selected' : '' }}>Scotland</option>
                        <option value="Wales" {{ old('state') == "Wales" ? 'selected' : '' }}>Wales</option>
                    </select>
                </div>
                <div class="input-field col s6">
                    <label for="country" class="active">Country</label>
                    <select id="country" name="country" class="browser-default">
                        <option value="US" {{ old('country') == "US" ? 'selected' : '' }}>U.S.A.</option>
                        <option value="CA" {{ old('country') == "CA" ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ old('country') == "UK" ? 'selected' : '' }}>U.K.</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
