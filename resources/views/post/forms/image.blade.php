<!-- /resources/views/post/forms/image.blade.php -->
<input type="hidden" class="image-id" id="blog-image-id-{{is_null($i) ? "" : $i}}" name="image[{{is_null($i) ? "" : $i}}][id]" value="{{is_null($image) ? '' : $image->id }}">
@if(!is_null($image))
<div class="col s6">
    <p class="hide-on-med-and-up" style="text-align: center;">
        <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ $image->getURL('share') }} />
    </p>
    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;">
        <img style="width: auto; max-height: 250px; box-shadow: 2px 2px #F2F2F2;" src={{ $image->getURL('share') }} />
    </p>
</div>
@endif
<div class="col s6">
    <div class="file-field input-field very-small">
        <div class="btn white black-text">
            <span>Edit<span class="hide-on-small-only"> Image</span></span>
            <input class="file-button" type="file" name="image[{{is_null($i) ? "" : $i}}][url]" value="{{ old('image['.(is_null($i) ? "" : $i).'][url]') }}">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text" name="image[{{is_null($i) ? "" : $i}}][url_text]" id="blog-image-url-text-{{is_null($i) ? "" : $i}}" data-index="{{is_null($i) ? "" : $i}}" value="{{ old('image['.(is_null($i) ? "" : $i).'][url_text]') }}">
        </div>
    </div>
    <input type="text" class="blog-alt-input" placeholder="Alt" data-index="{{is_null($i) ? "" : $i}}" name="image[{{is_null($i) ? "" : $i}}][alt]" id="blog-image-alt-{{is_null($i) ? "" : $i}}" value="{{old('image['.(is_null($i) ? "" : $i).'][alt]') ?: (is_null($image) ? '' : $image->pivot->alt)}}" maxlength="100">
    <input type="text" class="blog-caption-input" placeholder="Caption" data-index="{{is_null($i) ? "" : $i}}" name="image[{{is_null($i) ? "" : $i}}][caption]" id="blog-image-caption-{{is_null($i) ? "" : $i}}" value="{{old('image['.(is_null($i) ? "" : $i).'][caption]') ?: (is_null($image) ? '' : $image->pivot->caption)}}">
    <strong>Copy and paste the following into the blog to add the image:</strong>
    <div class="formatted-blog-image-text" >
        ![<span id="formatted-blog-image-alt-{{is_null($i) ? "" : $i}}">{{(is_null($i) ? '' : $i)}}</span>]<span id="formatted-blog-image-url-{{is_null($i) ? "" : $i}}">({{ is_null($image) ? '/' : $image->getURL('large') }})</span><span id="formatted-blog-image-caption-{{is_null($i) ? "" : $i}}">{{old('image['.(is_null($i) ? "" : $i).'][caption]') ? '[caption]'.old('image['.(is_null($i) ? "" : $i).'][caption]').'[/caption]' : (is_null($image) || is_null($image->pivot->caption)) ? "" : "[caption]".$image->pivot->caption."[/caption]"}}</span>
    </div>
</div>
