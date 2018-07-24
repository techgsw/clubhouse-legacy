<!--
Place this in the product form:
<input type="hidden" id="product-tags-json" name="product_tags_json">
-->
<form id="create-tag" action="/tag" method="post" class="compact prevent-default">
    {{ csrf_field() }}
    <div class="row">
        <div class="col">
            <label for="tag-autocomplete-input">Tags</label>
            <input type="text" id="tag-autocomplete-input" class="tag-autocomplete" target-input-id="product-tags-json" target-view-id="product-tags">
        </div>
        <div id="product-tags" class="col product-tags" style="padding-top: 20px;">
            @if (!is_null($product))
                @foreach ($product->tags as $tag)
                    <span class="flat-button gray small tag">
                        <button type="button" name="button" class="x remove-tag" tag-name="{{ $tag->name }}" target-input-id="product-tags-json">&times;</button>{{ $tag->name }}
                    </span>
                @endforeach
            @endif
        </div>
    </div>
</form>
