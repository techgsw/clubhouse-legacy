@php $pd = new Parsedown(); @endphp
<div class="card large">
    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
        @if ($product->primaryImage())
            <a href="/product/{{ $product->id }}" style="flex: 1 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                <img style="width: 120px; margin: 0 auto;" src={{ $product->primaryImage()->getURL('medium') }} />
            </a>
        @else
            <div></div>
        @endif
        <a href="/product/{{ $product->id }}" class="no-underline" style="flex: 0 0 auto;">
            <h4>{{ $product->name }}</h4>
            <p>{{ strip_tags($pd->text($product->description)) }}</p>
            @foreach ($product->options as $option)
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
        <div class="controls" style="flex: 0 0 auto;">
            @can ('edit-product')
                <div class="small" style="margin-top: 20px;">
                    <a href="/product/{{ $product->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            @endcan
        </div>
    </div>
</div>
