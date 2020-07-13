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
            @cannot('view-clubhouse')
                <a class="btn btn-large sbs-red" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" style="line-height: 1.2em;height:4em;font-weight: 600;display:flex;align-items: center;justify-content: center;text-transform: unset;margin-bottom: 20px;">Get this service FREE as a Clubhouse PRO member. <br>Start your {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial now</a>
            @endcannot
            <select class="browser-default product-option-select" name="option">
                @foreach ($product->options as $option)
                    @if ($option->price > 0)
                        @can ('view-clubhouse')
                            <option value="{{$option->id}}">{{$option->name}}: {{ $option->description }} - FREE with Clubhouse Pro</option>
                        @else
                            <option value="{{$option->id}}">{{$option->name}}: {{ $option->description }} - ${{number_format($option->price, 2)}}</option>
                        @endcan
                    @else
                        <option value="{{$option->id}}">{{$option->name}}</option>
                    @endif
                @endforeach
            </select>
            @can ('view-clubhouse')
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
