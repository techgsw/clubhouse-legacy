<div class="organization-create-modal modal modal-large modal-fixed-footer">
    <div class="modal-content" style="height: calc(100% - 160px);"></div>
    <div class="modal-footer" style="height: 100%;">
        <div class="row">
            <div class="input-field col s12">
                <!-- <form id="create-organization" class="organization-create" method="POST" action="/organization" enctype="multipart/form-data"> -->
                <form id="create-organization" class="organization-create" enctype="multipart/form-data">
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="input-field col s12 l7">
                            <input id="name" type="text" class="{{ $errors->has('name') ? 'invalid' : '' }}" name="name" value="{{ old('name') ?: '' }}" required>
                            <label for="name" data-error="{{ $errors->first('name') }}">Name</label>
                        </div>
                        <div class="input-field col s12 l5">
                            <input id="parent-organization-id" type="hidden" name="parent_organization_id" value="{{ old('parent_organization_id') ?: '' }}">
                            <input id="parent_organization" name="parent_organization" type="text" class="organization-autocomplete {{ $errors->has('parent_organization') ? 'invalid' : '' }}" target-input-id="parent-organization-id" value="{{ old('parent_organization') ?: '' }}">
                            <label for="parent_organization" data-error="{{ $errors->first('parent_organization') }}">Parent organization</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select id="organization_type_id" name="organization_type_id">
                                @foreach ($organization_types as $type)
                                    <option value="{{$type->id}}" {{ old("organization_type_id") == $type->id ? "selected" : ""}}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <label for="organization_type_id">Type</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <div class="organization-type-league hidden">
                                <input type="text" id="abbreviation" name="abbreviation" value="{{ old('abbreviation') }}">
                                <label for="abbreviation">Abbreviation</label>
                            </div>
                            <div class="organization-type-default">
                                <select id="league_id" name="league_id">
                                    <option value="" {{ !old("league_id") ? "selected" : ""}}></option>
                                    @foreach ($leagues as $l)
                                        <option value="{{$l->id}}" {{ old("league_id") == $l->id ? "selected" : ""}}>{{ $l->abbreviation }}</option>
                                    @endforeach
                                </select>
                                <label for="league_id">League</label>
                            </div>
                        </div>
                        <div class="col s12 m3 center-align">
                            <i class="material-icons medium">add_a_photo</i>
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
                        @include('address.components.form', ['address' => new App\Address])
                        <div class="input-field col s12">
                            <button type="button" value="cancel" formnovalidate id="cancel-organization-form" class="cancel-organization-form btn sbs-red">cancel</button>
                            <button type="button" class="submit-org-create btn sbs-red">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
