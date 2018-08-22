@php $pd = new Parsedown(); @endphp
<div class="card">
    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
        <div>
            @if ($product->primaryImage())
                <a href="{{ $product->getURL(false, 'webinars') }}" style="flex: 0 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                    <img style="height: 120px; margin: 0 auto;" src={{ $product->primaryImage()->getURL('medium') }} />
                </a>
            @else
                <div></div>
            @endif
            <a href="{{ $product->getURL(false, 'webinars') }}" class="no-underline" style="flex: 0 0 auto;">
                <h4>{{ $product->name }}</h4>
                <p>{{ strip_tags($pd->text($product->description)) }}</p>
            </a>
        </div>
        <div>
            <a href="{{ $product->getURL(false, 'webinars') }}" class="no-underline" style="flex: 0 0 auto;">
                @foreach ($product->availableOptions() as $option)
                    <div class="option" style="margin: 12px 0;">
                        <h6 style="font-weight: bold;">{{ $option->name }}</h6>
                        @if ($option->price > 0)
                            <p>${{ number_format($option->price, 2) }}</p>
                        @else
                            <p>FREE</p>
                        @endif
                    </div>
                @endforeach
            </a>
        </div>
        <div class="controls" style="flex: 0 0 auto;">
            <a href="{{ $product->getURL(false, 'webinars') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">REGISTER</a>
            @can ('edit-product')
                <div class="small" style="margin-top: 20px;">
                    <a href="/product/{{ $product->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            @endcan
        </div>
    </div>
</div>
