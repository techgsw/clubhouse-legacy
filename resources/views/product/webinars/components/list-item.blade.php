<div class="card">
    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
        <div>
            @if ($product->primaryImage())
                <a href="/webinars/{{ $product->id }}" style="flex: 0 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                    <img style="height: 120px; margin: 0 auto;" src={{ $product->primaryImage()->getURL('medium') }} />
                </a>
            @else
                <div></div>
            @endif
            <a href="/webinars/{{ $product->id }}" class="no-underline" style="flex: 0 0 auto;">
                <h4>{{ $product->name }}</h4>
                <p>{{ $product->description }}</p>
            </a>
        </div>
        <div>
            <a href="/webinars/{{ $product->id }}" class="no-underline" style="flex: 0 0 auto;">
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
            <button type="button" class="buy-now btn sbs-red" style="margin-top: 18px;">REGISTER</button>
            @can ('edit-product')
                <div class="small" style="margin-top: 20px;">
                    <a href="/product/{{ $product->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            @endcan
        </div>
    </div>
</div>
