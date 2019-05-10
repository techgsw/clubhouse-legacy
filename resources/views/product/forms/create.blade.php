<form id="product" method="post" action="/product" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" id="product-tags-json" name="product_tags_json" value="[]">
    <div class="row">
        <div class="input-field col s12">
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            <label for="name">Name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <div id="description-editor" class="markdown-editor" placeholder="Description"></div>
            <div class="hidden">
                <textarea class="markdown-input" name="description" editor-id="description-editor" value="{{ old('description') }}"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="file-field input-field col s12 m6">
            <div class="btn white black-text">
                <span>Image</span>
                <input type="file" name="image_url" value="{{ old('image_url') }}">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path " type="text" name="image_url_text" value="">
            </div>
        </div>
        <div class="input-field col s6 m3">
            <p class="checkbox">
                <input type="checkbox" disabled name="type" id="type" value="service" {{ old('type') ? "checked" : "" }} />
                <label for="type">Service</label>
            </p>
        </div>
        <div class="input-field col s6 m3">
            <p class="checkbox">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active') ? "checked" : "" }} />
                <label for="active">Active</label>
            </p>
        </div>
    </div>
    <h5 style="margin: 20px 0 0 0;">Options</h5>
    <div class="options">
        @include('product.forms.option', ['i'=>1, 'option'=>null])
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
<style media="screen">
    p.checkbox {
        margin-top: 0;
    }

    div.product-option {
        border-bottom: 1px dotted #9e9e9e;
        padding-bottom: 10px;
    }
    div.product-option:last-of-type {
        border-bottom: none;
    }
    div.product-option .product-option-button {
        margin-top: 20px;
        height: 40px;
        width: 40px;
        border: 1px solid #9e9e9e;
        border-radius: 50%;
        color: #6e6e6e;
        display: flex;
        flex-flow: column;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    div.product-option .product-option-button:hover {
        border: 1px solid #6e6e6e;
        color: #303030;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
    div.product-option .product-option-button .product-option-index {
        display: block;
    }
    div.product-option .product-option-button .product-option-delete {
        display: none;
    }
    div.product-option .product-option-button:hover .product-option-index {
        display: none;
    }
    div.product-option .product-option-button:hover .product-option-delete {
        display: block;
    }
</style>
