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
        <div style="padding-bottom: 20px;" class="input-field col s6 m3 l2 center-align">
            <button type="submit" class="btn btn-medium sbs-red new-cc-button">Save</button>
        </div>
        <div style="padding-bottom: 20px;" class="input-field col s6 m3 l2 center-align">
            <button id="cancel-cc-button" type="button" class="btn btn-medium blue-grey darken-1">Cancel</button>
        </div>
    </div>
</form>
