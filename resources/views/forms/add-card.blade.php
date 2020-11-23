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
        <div style="padding-bottom: 20px;" class="input-field col s12 m6">
            <div id="cc-number-wrapper"></div>
        </div>
        @if (isset($make_primary_option) && $make_primary_option)
            <div style="padding-bottom: 20px; margin-top:0px" class="input-field col s12 m2">
                <input type="checkbox" name="make_primary" id="make_primary" value="1" checked/>
                <label for="make_primary">Make this my primary card</label>
            </div>
        @endif
        <div style="padding-bottom: 20px;" class="input-field col s6 m2 l2 center-align">
            <button type="submit" class="btn btn-medium sbs-red new-cc-button">Save</button>
        </div>
        <div style="padding-bottom: 20px;" class="input-field col s6 m2 l2 center-align">
            <button id="cancel-cc-button" type="button" class="btn btn-medium blue-grey darken-1">Cancel</button>
        </div>
    </div>
</form>
