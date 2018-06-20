<form id="edit-organization" method="POST" action="/organization/{{ $organization->id }}" enctype="multipart/form-data">
    <div class="row">
        {{ csrf_field() }}
        <div class="input-field col s12 l7">
            <input id="name" type="text" class="{{ $errors->has('name') ? 'invalid' : '' }}" name="name" value="{{ old('name') ?: $organization->name }}" required>
            <label for="name" data-error="{{ $errors->first('name') }}">Name</label>
        </div>
        <div class="input-field col s12 l5">
            <input id="parent-organization-id" type="hidden" name="parent_organization_id" value="{{ old('parent_organization_id') ?: $organization->parent_organization_id }}">
            <input id="parent_organization" name="parent_organization" type="text" class="organization-autocomplete {{ $errors->has('parent_organization') ? 'invalid' : '' }}" target-input-id="parent-organization-id" value="{{ old('parent_organization') ?: $organization->parentOrganization ? $organization->parentOrganization->name : '' }}">
            <label for="parent_organization" data-error="{{ $errors->first('parent_organization') }}">Parent organization</label>
        </div>
        <div class="input-field col s12 m6">
            <select id="organization_type_id" name="organization_type_id">
                @foreach ($organization_types as $type)
                    <option value="{{$type->id}}" {{ old("organization_type_id") == $type->id ? "selected" : $organization->organization_type_id == $type->id ? "selected" : ""}}>{{ $type->name }}</option>
                @endforeach
            </select>
            <label for="organization_type_id">Type</label>
        </div>
        <div class="input-field col s12 m6">
            @php
                if ($organization->isLeague()) {
                    $league = $organization->league;
                } else {
                    $league = $organization->leagues->count() > 0 ? $organization->leagues[0] : null;
                }
            @endphp
            <div class="organization-type-league {{ $organization->isLeague() ? '' : 'hidden' }}">
                <input type="text" id="abbreviation" name="abbreviation" value="{{ old('abbreviation') ?: $league ? $league->abbreviation : '' }}">
                <label for="abbreviation">Abbreviation</label>
            </div>
            <div class="organization-type-default {{ $organization->isLeague() ? 'hidden' : '' }}">
                <select id="league_id" name="league_id">
                    <option value="" {{ !old("league_id") && !$league ? "selected" : ""}}></option>
                    @foreach ($leagues as $l)
                        <option value="{{$l->id}}" {{ old("league_id") == $l->id ? "selected" : $league && $league->id == $l->id ? "selected" : ""}}>{{ $l->abbreviation }}</option>
                    @endforeach
                </select>
                <label for="league_id">League</label>
            </div>
        </div>
        <div class="col s12 m3 center-align">
            @if ($organization->image)
                <img style="max-width: 100%; width: 200px; padding: 30px;" src={{ $organization->image->getURL('medium') }}>
            @else
                <i class="material-icons medium">add_a_photo</i>
            @endif
        </div>
        <div class="col s12 m9">
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Upload Image</span>
                    <input type="file" name="image_url" value="{{ old('image_url') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path" type="text" name="image_url_text" value="{{ old('image_url_text') }}">
                </div>
            </div>
        </div>
        @include('address.components.form', [
            'address' => $organization->addresses->count() > 0 ? $organization->addresses->first() : new App\Address
        ])
        <div class="input-field col s12">
            <button type="submit" class="btn sbs-red">Save</button>
        </div>
    </div>
</form>
