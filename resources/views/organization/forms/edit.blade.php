<form id="edit-organization" method="POST" action="/organization/{{ $organization->id }}" enctype="multipart/form-data">
    <div class="row">
        {{ csrf_field() }}
        <div class="input-field col s12">
            <input id="name" type="text" class="{{ $errors->has('name') ? 'invalid' : '' }}" name="name" value="{{ old('name') ?: $organization->name }}" required>
            <label for="name" data-error="{{ $errors->first('name') }}">Name</label>
        </div>
        <div class="input-field col s12">
            <input id="parent-organization-id" type="hidden" name="parent_organization_id" value="{{ old('parent_organization_id') ?: $organization->parent_organization_id }}">
            <input id="parent_organization" name="parent_organization" type="text" class="organization-autocomplete {{ $errors->has('parent_organization') ? 'invalid' : '' }}" target-input-id="parent-organization-id" value="{{ old('parent_organization') ?: $organization->parentOrganization ? $organization->parentOrganization->name : '' }}">
            <label for="parent_organization" data-error="{{ $errors->first('parent_organization') }}">Parent organization</label>
        </div>
        <div class="col s12 m3 center-align">
            @if ($organization->image)
                <img style="max-width: 100%; width: 200px;" src={{ $organization->image->getURL('medium') }}>
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
