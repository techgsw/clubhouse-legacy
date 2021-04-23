<div class="container" style="margin-top: 40px;">
    <div class="col s12 m3">
        @if (!is_null($product->primaryImage()))
            <img style="padding: 18px 24px;" src={{ $product->primaryImage()->getURL('medium') }}>
        @endif
    </div>
    <div class="col s12 m9 product-description">
        <div class="right">
            <!-- Job controls -->
            <p class="small">
            @can ('edit-product', $product)
                <a href="/product/{{ $product->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
            </p>
        </div>
        <h4>{{ $product->name }}</h4>
        {!! $pd->text($product->description) !!}
        @if (count($product->options) > 0)
            @if ($is_blocked)
                <p class="sbs-red-text"><b>You have already booked one free career service in the last month, however you can still purchase more career services at the standard rate if you would like:</b></p>
            @endif
            <select class="browser-default product-option-select" name="option">
                @foreach ($product->options as $option)
                    @if ($option->price > 0)
                        <option value="{{$option->id}}">{{$option->name}}: {{ preg_replace('/calendly-link=[^\s]*/', '', $option->description) }} - ${{number_format($option->price, 2)}}</option>
                    @else
                        <option value="{{$option->id}}">{{$option->name}}</option>
                    @endif
                @endforeach
            </select>
            @if (Auth::user() && Auth::user()->can('view-clubhouse') && !$is_blocked)
                <div class="input-field" style="margin-top: 30px;">
                    <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn sbs-red">SIGN UP</a>
                </div>
            @else
                <div class="input-field" style="margin-bottom: 20px;margin-top:20px;">
                    <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn sbs-red">CHECKOUT</a>
                </div>
            @endcannot
        @else
            @can ('view-clubhouse')
                <p>This career service is currently unavailable.</p>
            @else
                <p>There are only <strong>Clubhouse Pro</strong> options available at this time.</p>
                <div class="input-field" style="margin-top: 30px;">
                    <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                </div>
            @endcan
        @endif
    </div>
</div>
