@php $pd = new Parsedown(); @endphp
<form id="product" method="post" action="/product/{{$product->id}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" id="product-tags-json" name="product_tags_json" value="{{ $product_tags_json }}">
    <div class="row">
        <div class="input-field col s12">
            <input id="name" name="name" type="text" value="{{ old('name') ?: $product->name }}" required>
            <label for="name">Name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <div id="description-editor" class="markdown-editor" placeholder="Description">
                {!! $pd->text($product->description) !!}
            </div>
            <div class="hidden">
                <textarea class="markdown-input" name="description" editor-id="description-editor" value=""></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            @if ($product->primaryImage())
                <img src="{{ $product->primaryImage()->getURL('small') }}" alt="" style="padding: 18px; width: 180px; margin: 0 auto; display: block;">
            @endif
            <div class="file-field input-field">
                <div class="btn white black-text">
                    <span>Image</span>
                    <input type="file" name="image_url" value="{{ old('image_url') }}">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path " type="text" name="image_url_text" value="">
                </div>
            </div>
        </div>
        <div class="input-field col s6 m3">
            <p class="checkbox">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active') ? "checked" : $product->active ? "checked" : "" }} />
                <label for="active">Active</label>
            </p>
        </div>
        <div class="input-field col s6 m3">
            <p class="checkbox">
                <input type="checkbox" name="type" id="type" value="{{ $product->type }}" disabled {{ $product->type == 'service' ? "checked" : "" }} />
                <label for="type">Service</label>
            </p>
        </div>
    </div>
    <h5 style="margin: 20px 0 0 0;">Options</h5>
    <div class="options">
        @foreach ($product->options as $i => $option)
            @include('product.forms.option', ['i'=>$i+1, 'option'=>$option])
        @endforeach
    </div>
    <div class="product-option row" style="margin-bottom: 30px; border-top: 1px dotted #9e9e9e; border-bottom: none;">
        <div class="col s2 l1 center-align">
            <div class="product-option-button add-product-option">
                <i class="fa fa-plus"></i>
            </div>
        </div>
        <div class="col s10 l11"></div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn sbs-red">Save</button>
        </div>
    </div>
</form>
<div class="product-option-template hidden">
    @include('product.forms.option', ['i'=>null, 'option' => null])
</div>
