@php $pd = new Parsedown(); @endphp
<form id="create-job-form" method="post" action="" enctype="multipart/form-data" class="organization-field-autocomplete">
    {{ csrf_field() }}
    <input type="hidden" id="job-tags-json" name="job_tags_json" value="[]">
    <div class="row">
        <div class="col s12 m6">
            @if(count($organizations) != 1)
            <h4>Find Your Organization</h4>
            @endif
            <div class="input-field">
                <input id="organization-id" type="hidden" autocomplete="off" name="organization_id" value="{{ old('organization_id') ?: ($organization ? $organization->id : '') }}">
                @can('view-admin-jobs')
                    <input id="organization" type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" required>
                    <label for="organization" data-error="{{ $errors->first('organization') }}">Organization</label>
                    <p style="margin-top: 0px; font-size: 12px;"><a id="organization-modal-open" class="no-underline" href="javascript: void(0);">Can't find your ogranization? Click here.</a></p>
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
                        <input id="organization" autocomplete="off" type="text" name="organization" class="organization-autocomplete" target-input-id="organization-id" value="{{ old('organization') ?: ($organization ? $organization->name : '') }}" style="margin-bottom: 5px;" required>
                        <label for="organization" data-error="{{ $errors->first('organization') }}"><i class="fa fa-search"></i> Search</label>
                        <p style="margin-top: 0px; font-size: 12px;"><a id="organization-modal-open" class="no-underline" href="javascript: void(0);">Can't find your organization? Click here.</a></p>
                    @endif
                @endcan
            </div>
        </div>
        <div class="col s12 m6 organization-image-preview center-align {{ empty($organization) ? "hidden" : "" }}">
            <img id="organization-image" class="responsive-img" src="{{ empty($organization) || empty($organization->image) ? "" : $organization->image->getURL('medium') }}" style="max-height: 150px;" />
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <h4>Create Your Job</h4>
        </div>
        <div class="col s12 m6">
            @can('edit-job-featured-status')
                <div class="input-field">
                    <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? "checked" : "" }} />
                    <label for="featured">Featured</label>
                </div>
            @endcan
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
            @can('view-admin-jobs')
                <div class="input-field">
                    <input id="owner_email" type="text" class="" name="owner_email" value="{{ old('owner_email') }}">
                    <label for="owner_email" data-error="{{ $errors->first('owner_email') }}">Job Owner <b>(Use the email that they use to log in. Leave blank to make yourself the owner)</b></label>
                </div>
            @endcan
            @can('edit-job-recruiting-type')
            <div class="input-field">
                <label for="recruiting-type-code" class="active">Recruiting Type</label>
                <select id="recruiting-type-code" name="recruiting_type_code" class="validate" required>
                    <option value="" selected disabled>Please select...</option>
                    <option value="passive" {{ old('recruiting_type_code') == "passive" ? "selected" : ""}}>Passive</option>
                    <option value="active" {{ old('recruiting_type_code') == "active" ? "selected" : ""}}>Active</option>
                </select>
            </div>
            @endcan
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Job Description</span>
                    <input type="file" class="small" name="document" value="{{ old('document') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path" type="text" name="document_text" value="">
                </div>
            </div>
            <div class="input-field">
                <input id="external_job_link" type="text" class="{{ $errors->has('external_job_link') ? 'invalid' : '' }}" name="external_job_link" value="{{ old('external_job_link') }}">
                <label for="external_job_link" data-error="{{ $errors->first('external_job_link') }}">External Job Link <strong>(If you want people to apply on another site and <i>not</i> through theClubhouse<sup>&#174;</sup>)</strong></label>
            </div>
        </div>
        <div class="col s12 m4">
            @can ('view-admin-jobs')
                <div class="input-field">
                    <label for="job_type" class="active">Job Type</label>
                    <select name="job_type">
                        <option value="sbs_default" {{ old('job_type') == "sbs_default" ? "selected" : ""}}>Admin</option>
                        <option value="user_free" {{ old('job_type') == "user_free" ? "selected" : ""}}>Free</option>
                        <option value="user_premium" {{ old('job_type') == "user_premium" ? "selected" : ""}}>Premium</option>
                        <option value="user_platinum" {{ old('job_type') == "user_platinum" ? "selected" : ""}}>Platinum</option>
                    </select>
                </div>
            @endcan
            @include('job.forms.tag', ['job' => null])
            @cannot ('view-admin-jobs')
            <div class="input-field dark" style="margin-top:50px;">
                <p style="margin-top: 10px;">
                    <input class="sbs-red" name="job-tier" type="radio" value="free" id="free" {{ ($available_premium_job_count || $available_platinum_job_count ? '' : 'checked=checked') }} />
                    <label for="free">Free</label>
                </p>
                <p style="margin-top: 10px;">
                    <input class="sbs-red" name="job-tier" type="radio" value="premium" id="premium" {{ ($available_premium_job_count ? 'checked' : 'disabled=disabled') }} />
                    <label for="premium">Premium {{-- ({{ $available_premium_job_count }}) --}}</label>
                    {{-- @if (!$available_premium_job_count)
                        <a href="{{ $job_premium->options()->find(PRODUCT_OPTION_ID['premium_job'])->getURL(false, 'checkout') }}" class="small flat-button green">Buy Now</a>
                    @endif --}}
                </p>
                <p style="margin-top: 10px;">
                    <input class="sbs-red" name="job-tier" type="radio" value="platinum" id="platinum" {{ ($available_platinum_job_count ? 'checked' : 'disabled=disabled') }} />
                    <label for="platinum">Platinum {{--({{ $available_platinum_job_count }}) --}}</label>
                    {{-- @if (!$available_platinum_job_count)
                        <a href="{{ $job_platinum->options()->find(PRODUCT_OPTION_ID['platinum_job'])->getURL(false, 'checkout') }}" class="small flat-button green">Buy Now</a>
                    @endif --}}
                </p>
                <p style="margin-top: 12px;"><a href="#job-comparison-modal">Compare Options</a></p>
            </div>
            @endcannot
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
@include('job.components.options-comparison-modal')
