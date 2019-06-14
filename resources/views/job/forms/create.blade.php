<form id="create-job-form" method="post" action="" enctype="multipart/form-data" class="organization-field-autocomplete">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m8">
            <div class="row">
                <div class="input-field col s12 m9">
                    <input id="title" type="text" class="{{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                @can('edit-job')
                <div class="input-field col s12 m3">
                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? "checked" : "" }} />
                    <label for="featured">Featured</label>
                </div>
                @endcan
                <div class="input-field col s12">
                    <div id="description" class="markdown-editor" placeholder="Description" style="outline: none; margin-bottom: 30px; padding-bottom: 16px; border-bottom: 1px solid #9e9e9e;"></div>
                    <div class="hidden">
                        <textarea class="markdown-input" name="description" value=""></textarea>
                    </div>
                </div>
                <div class="input-field col s12">
                    <label for="job-type" class="active">Job Track</label>
                    <select id="job-type" name="job_type" class="browser-default" required>
                        <option value="" {{ old('job_type') == "" ? "selected" : "" }}>Please select...</option>
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
                @can('edit-job')
                <div class="input-field col s12">
                    <label for="recruiting-type-code" class="active">Recruiting Type</label>
                    <select id="recruiting-type-code" name="recruiting_type_code" class="browser-default" required>
                        <option value="" selected disabled>Please select...</option>
                        <option value="passive" {{ old('recruiting_type_code') == "passive" ? "selected" : ""}}>Passive</option>
                        <option value="active" {{ old('recruiting_type_code') == "active" ? "selected" : ""}}>Active</option>
                    </select>
                </div>
                @endcan
                <div class="file-field input-field col s12">
                    <div class="btn white black-text">
                        <span>Document</span>
                        <input type="file" name="document" value="{{ old('document') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path" type="text" name="document_text" value="">
                    </div>
                </div>
                <div class="input-field col s12">
                    @can('view-admin-jobs')
                        <p>
                            <input type="checkbox" class="show-hide" show-hide-target-id="organization-fields" name="reuse_organization_fields" id="reuse_organization_fields" value="1" checked />
                            <label for="reuse_organization_fields">Use organization name and logo</label>
                        </p>
                    @endcan
                </div>
                <div class="col s12 hidden" id="organization-fields">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="alt-organization" type="text" name="alt_organization" value="{{ old('alt_organization') ?: '' }}">
                            <label for="alt-organization" data-error="{{ $errors->first('alt_organization') }}">Organization name</label>
                        </div>
                        <div class="file-field input-field col s12">
                            <div class="btn white black-text">
                                <span>Logo</span>
                                <input type="file" name="alt_image_url" value="{{ old('alt_image_url') }}">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path " type="text" name="alt_image_url_text" value="">
                            </div>
                        </div>
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
                    @can('view-admin-jobs')
                        <input id="organization-id" type="hidden" name="organization_id" value="{{ old('organization_id') ?: ($organization ? $organization->id : '') }}">
                        <input id="organization" autocomplete='new-password' type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" required>
                        <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
                    @else
                        @if(count($organizations) > 1)
                            <label for="organization" class="active organization-autocomplete">Organization</label>
                            <select id="organization-id" name="organization_id" class="browser-default">
                                <option {{ old('organization') == "" ? "selected" : "" }} disabled>Select one</option>
                                @foreach ($organizations as $org)
                                    @if ($org->name == $organization->name)
                                        <option selected value="{{$org->id}}" data-organization-state="" data-organization-country="">{{ $org->name }}</option>

                                    @else
                                        <option value="{{$org->id}}" data-organization-state="" data-organization-country="">{{ $org->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @elseif(count($organizations) == 1)
                            <label for="organization" class="active organization-autocomplete">Organization</label>
                            <select id="organization-id" name="organization_id" class="browser-default">
                                <option value="{{$organizations[0]->id}}" data-organization-state="" data-organization-country="">{{ $organizations[0]->name }}</option>
                            </select>
                        @else
                            <input id="organization-id" type="hidden" name="organization_id" value="{{ old('organization_id') ?: ($organization ? $organization->id : '') }}">
                            <input id="organization" autocomplete='new-password' type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" required>
                            <label for="organization" data-error="{{ $errors->first('organization') }}">Find your organization</label>
                        @endif
                    @endcan
                </div>
                <div class="input-field col s12">
                    <label for="league" class="active">League</label>
                    <select id="league" name="league" class="browser-default">
                        <option value="" {{ old('job_type') == "" ? "selected" : "" }}>None</option>

                        @foreach ($leagues as $league_itr)
                            @if (!is_null($league) && $league->abbreviation == $league_itr->abbreviation) 
                                <option selected value="{{ $league_itr->abbreviation }}" {{ old('league') == $league_itr->abbreviation ? "selected" : "" }}>{{ $league_itr->abbreviation }}</option>
                            @else
                                <option value="{{ $league_itr->abbreviation }}" {{ old('league') == $league_itr->abbreviation ? "selected" : "" }}>{{ $league_itr->abbreviation }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="organization-image-preview center-align {{ empty($organization) ? "hidden" : "" }}">
                    <img id="organization-image" src="{{ empty($organization) || empty($organization->image) ? "" : $organization->image->getURL('medium') }}" style="padding: 16px; max-width: 100px;" />
                </div>
                <div class="input-field col s12">
                    @if (is_null($organization) || is_null($organization->addresses->first()))
                        <input id="city" type="text" class=" {{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="" required>
                    @else
                        <input id="city" type="text" class=" {{ $errors->has('city') ? 'invalid' : '' }}" name="city" value="{{$organization->addresses->first()->city}}" required>
                    @endif
                        <label for="city" data-error="{{ $errors->first('city') }}">City</label>
                </div>
                <div class="input-field col s6">
                    <label for="state" class="active">State</label>
                    <select id="state" name="state" class="browser-default">
                        <option {{ old('state') == "" ? "selected" : "" }} disabled>Select one</option>
                        <option disabled>U.S.A.</option>
                        <option value="AL" {{ old('state') == "AL" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'AL' ? 'selected' : '' }}>Alabama</option>
                        <option value="AK" {{ old('state') == "AK" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'AK' ? 'selected' : '' }}>Alaska</option>
                        <option value="AZ" {{ old('state') == "AZ" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'AZ' ? 'selected' : '' }}>Arizona</option>
                        <option value="AR" {{ old('state') == "AR" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'AR' ? 'selected' : '' }}>Arkansas</option>
                        <option value="CA" {{ old('state') == "CA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'CA' ? 'selected' : '' }}>California</option>
                        <option value="CO" {{ old('state') == "CO" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'CO' ? 'selected' : '' }}>Colorado</option>
                        <option value="CT" {{ old('state') == "CT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'CT' ? 'selected' : '' }}>Connecticut</option>
                        <option value="DE" {{ old('state') == "DE" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'DE' ? 'selected' : '' }}>Delaware</option>
                        <option value="DC" {{ old('state') == "DC" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'DC' ? 'selected' : '' }}>District Of Columbia</option>
                        <option value="FL" {{ old('state') == "FL" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'FL' ? 'selected' : '' }}>Florida</option>
                        <option value="GA" {{ old('state') == "GA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'GA' ? 'selected' : '' }}>Georgia</option>
                        <option value="HI" {{ old('state') == "HI" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'HI' ? 'selected' : '' }}>Hawaii</option>
                        <option value="ID" {{ old('state') == "ID" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'ID' ? 'selected' : '' }}>Idaho</option>
                        <option value="IL" {{ old('state') == "IL" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'IL' ? 'selected' : '' }}>Illinois</option>
                        <option value="IN" {{ old('state') == "IN" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'IN' ? 'selected' : '' }}>Indiana</option>
                        <option value="IA" {{ old('state') == "IA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'IA' ? 'selected' : '' }}>Iowa</option>
                        <option value="KS" {{ old('state') == "KS" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'KS' ? 'selected' : '' }}>Kansas</option>
                        <option value="KY" {{ old('state') == "KY" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'KY' ? 'selected' : '' }}>Kentucky</option>
                        <option value="LA" {{ old('state') == "LA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'LA' ? 'selected' : '' }}>Louisiana</option>
                        <option value="ME" {{ old('state') == "ME" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'ME' ? 'selected' : '' }}>Maine</option>
                        <option value="MD" {{ old('state') == "MD" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MD' ? 'selected' : '' }}>Maryland</option>
                        <option value="MA" {{ old('state') == "MA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MA' ? 'selected' : '' }}>Massachusetts</option>
                        <option value="MI" {{ old('state') == "MI" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MI' ? 'selected' : '' }}>Michigan</option>
                        <option value="MN" {{ old('state') == "MN" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MN' ? 'selected' : '' }}>Minnesota</option>
                        <option value="MS" {{ old('state') == "MS" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MS' ? 'selected' : '' }}>Mississippi</option>
                        <option value="MO" {{ old('state') == "MO" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MO' ? 'selected' : '' }}>Missouri</option>
                        <option value="MT" {{ old('state') == "MT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MT' ? 'selected' : '' }}>Montana</option>
                        <option value="NE" {{ old('state') == "NE" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NE' ? 'selected' : '' }}>Nebraska</option>
                        <option value="NV" {{ old('state') == "NV" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NV' ? 'selected' : '' }}>Nevada</option>
                        <option value="NH" {{ old('state') == "NH" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NH' ? 'selected' : '' }}>New Hampshire</option>
                        <option value="NJ" {{ old('state') == "NJ" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NJ' ? 'selected' : '' }}>New Jersey</option>
                        <option value="NM" {{ old('state') == "NM" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NM' ? 'selected' : '' }}>New Mexico</option>
                        <option value="NY" {{ old('state') == "NY" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NY' ? 'selected' : '' }}>New York</option>
                        <option value="NC" {{ old('state') == "NC" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NC' ? 'selected' : '' }}>North Carolina</option>
                        <option value="ND" {{ old('state') == "ND" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'ND' ? 'selected' : '' }}>North Dakota</option>
                        <option value="OH" {{ old('state') == "OH" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'OH' ? 'selected' : '' }}>Ohio</option>
                        <option value="OK" {{ old('state') == "OK" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'OK' ? 'selected' : '' }}>Oklahoma</option>
                        <option value="OR" {{ old('state') == "OR" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'OR' ? 'selected' : '' }}>Oregon</option>
                        <option value="PA" {{ old('state') == "PA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'PA' ? 'selected' : '' }}>Pennsylvania</option>
                        <option value="RI" {{ old('state') == "RI" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'RI' ? 'selected' : '' }}>Rhode Island</option>
                        <option value="SC" {{ old('state') == "SC" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'SC' ? 'selected' : '' }}>South Carolina</option>
                        <option value="SD" {{ old('state') == "SD" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'SD' ? 'selected' : '' }}>South Dakota</option>
                        <option value="TN" {{ old('state') == "TN" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'TN' ? 'selected' : '' }}>Tennessee</option>
                        <option value="TX" {{ old('state') == "TX" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'TX' ? 'selected' : '' }}>Texas</option>
                        <option value="UT" {{ old('state') == "UT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'UT' ? 'selected' : '' }}>Utah</option>
                        <option value="VT" {{ old('state') == "VT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'VT' ? 'selected' : '' }}>Vermont</option>
                        <option value="VA" {{ old('state') == "VA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'VA' ? 'selected' : '' }}>Virginia</option>
                        <option value="WA" {{ old('state') == "WA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'WA' ? 'selected' : '' }}>Washington</option>
                        <option value="WV" {{ old('state') == "WV" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'WV' ? 'selected' : '' }}>West Virginia</option>
                        <option value="WI" {{ old('state') == "WI" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'WI' ? 'selected' : '' }}>Wisconsin</option>
                        <option value="WY" {{ old('state') == "WY" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'WY' ? 'selected' : '' }}>Wyoming</option>
                        <option disabled>Canada</option>
                        <option value="AB" {{ old('state') == "AB" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'AB' ? 'selected' : '' }}>Alberta</option>
                        <option value="BC" {{ old('state') == "BC" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'BC' ? 'selected' : '' }}>British Columbia</option>
                        <option value="MB" {{ old('state') == "MB" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'MB' ? 'selected' : '' }}>Manitoba</option>
                        <option value="NB" {{ old('state') == "NB" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NB' ? 'selected' : '' }}>New Brunswick</option>
                        <option value="NL" {{ old('state') == "NL" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NL' ? 'selected' : '' }}>Newfoundland and Labrador</option>
                        <option value="NS" {{ old('state') == "NS" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NS' ? 'selected' : '' }}>Nova Scotia</option>
                        <option value="ON" {{ old('state') == "ON" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'ON' ? 'selected' : '' }}>Ontario</option>
                        <option value="PE" {{ old('state') == "PE" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'PE' ? 'selected' : '' }}>Prince Edward Island</option>
                        <option value="QC" {{ old('state') == "QC" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'QC' ? 'selected' : '' }}>Quebec</option>
                        <option value="SK" {{ old('state') == "SK" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                        <option value="NT" {{ old('state') == "NT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NT' ? 'selected' : '' }}>Northwest Territories</option>
                        <option value="NU" {{ old('state') == "NU" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'NU' ? 'selected' : '' }}>Nunavut</option>
                        <option value="YT" {{ old('state') == "YT" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'YT' ? 'selected' : '' }}>Yukon</option>
                        <option disabled>U.K.</option>
                        <option value="England" {{ old('state') == "England" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'England' ? 'selected' : '' }}>England</option>
                        <option value="Northern Ireland" {{ old('state') == "Northern Ireland" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'Northern Ireland' ? 'selected' : '' }}>Northern Ireland</option>
                        <option value="Scotland" {{ old('state') == "Scotland" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'Scotland' ? 'selected' : '' }}>Scotland</option>
                        <option value="Wales" {{ old('state') == "Wales" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->state == 'Wales' ? 'selected' : '' }}>Wales</option>
                    </select>
                </div>
                <div class="input-field col s6">
                    <label for="country" class="active">Country</label>
                    <select id="country" name="country" class="browser-default">
                        <option value="US" {{ old('country') == "US" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->country == 'US' ? 'selected' : '' }}>U.S.A.</option>
                        <option value="CA" {{ old('country') == "CA" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->country == 'CA' ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ old('country') == "UK" ? 'selected' : $organization && !is_null($organization->addresses->first()) && $organization->addresses->first()->country == 'UK' ? 'selected' : '' }}>U.K.</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
