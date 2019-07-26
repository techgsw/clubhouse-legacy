@php $pd = new Parsedown(); @endphp
<form id="create-job-form" method="post" action="" enctype="multipart/form-data" class="organization-field-autocomplete">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m6">
            @if(count($organizations) != 1)
            <h4>Find Your Organization</h4>
            @endif
            <div class="input-field">
                @can('view-admin-jobs')
                    <input id="organization-id" type="hidden" name="organization_id" value="{{ old('organization_id') ?: ($organization ? $organization->id : '') }}">
                    <input id="organization" type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" required>
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
                        <h3>{{ $organizations[0]->name }}</h3>
                        <p>{{ $organizations[0]->city }} {{ $organizations[0]->state }}, {{ $organizations[0]->country }}</p>
                    @else
                        <input id="organization-id" type="hidden" name="organization_id" value="{{ old('organization_id') ?: ($organization ? $organization->id : '') }}">
                        <input id="organization" autocomplete="off" type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" style="margin-bottom: 5px;" required>
                        <label for="organization" data-error="{{ $errors->first('organization') }}"><i class="fa fa-search"></i> Search</label>
                        <p style="margin-top: 0px; font-size: 12px;"><a id="organization-modal-open" class="no-underline" href="javascript: void(0);">Can't find your ogranization? Click here.</a></p>
                    @endif
                @endcan
            </div>
        </div>
        <div class="col s12 m6 organization-image-preview center-align {{ empty($organization) ? "hidden" : "" }}">
            <img id="organization-image" class="responsive-img" src="{{ empty($organization) || empty($organization->image) ? "" : $organization->image->getURL('medium') }}" style="max-height: 150px;" />
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Create Your Job</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8">
            <div class="input-field">
                <input id="title" type="text" class="{{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required>
                <label for="title" data-error="{{ $errors->first('title') }}">Job Title</label>
            </div>
            <div class="input-field">
                <div id="description" class="markdown-editor" placeholder="Description" style="outline: none; margin-bottom: 30px; padding-bottom: 16px; border-bottom: 1px solid #9e9e9e;">{!! $pd->text(old('description')) !!}</div>
                <div class="hidden">
                    <textarea class="markdown-input" name="description" value=""></textarea>
                </div>
            </div>
            @can('edit-job-recruiting-type-code')
            <div class="input-field">
                <label for="recruiting-type-code" class="active">Recruiting Type</label>
                <select id="recruiting-type-code" name="recruiting_type_code" class="browser-default" required>
                    <option value="" selected disabled>Please select...</option>
                    <option value="passive" {{ old('recruiting_type_code') == "passive" ? "selected" : ""}}>Passive</option>
                    <option value="active" {{ old('recruiting_type_code') == "active" ? "selected" : ""}}>Active</option>
                </select>
            </div>
            @endcan
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Job Document</span>
                    <input type="file" class="small" name="document" value="{{ old('document') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path" type="text" name="document_text" value="">
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            @can('edit-job-featured-status')
            <div class="input-field">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? "checked" : "" }} />
                <label for="featured">Featured</label>
            </div>
            @endcan
            <div class="input-field">
                <label for="job-type" class="active">Job Type</label>
                <select id="job-type" name="job_type" class="" required>
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
            <div class="input-field dark">
                <p>
                    <input class="sbs-red" name="job-tier" type="radio" value="free" id="free" {{ ($available_premium_job_count || $available_platinum_job_count ? '' : 'checked=checked') }} />
                    <label for="free">Free</label>
                </p>
                <p>
                    <input class="sbs-red" name="job-tier" type="radio" value="premium" id="premium" {{ ($available_premium_job_count ? 'checked' : 'disabled=disabled') }} />
                    <label for="premium">Premium</label>
                    @if (!$available_premium_job_count)
                        <a href="{{ $job_premium->options()->first()->getURL(false, 'checkout') }}" class="small flat-button green">Buy Now</a>
                    @endif
                </p>
                <p>
                    <input class="sbs-red" name="job-tier" type="radio" value="platinum" id="platinum" {{ ($available_platinum_job_count ? 'checked' : 'disabled=disabled') }} />
                    <label for="platinum">Platinum</label>
                    @if (!$available_platinum_job_count)
                        <a href="{{ $job_platinum->options()->first()->getURL(false, 'checkout') }}" class="small flat-button green">Buy Now</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
    <div class="row">
        <div class="col s12 m8">
            <div class="input-field">
                @can('view-admin-jobs')
                    <input type="checkbox" class="show-hide" show-hide-target-id="organization-fields" name="reuse_organization_fields" id="reuse_organization_fields" value="1" checked />
                    <label for="reuse_organization_fields">Use organization name and logo</label>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center">
            <div class="input-field">
                <button type="submit" class="btn sbs-red">Post</button>
            </div>
        </div>
    </div>
</form>
