@php $pd = new Parsedown(); @endphp
<div class="card hoverable">
    @if ($product->primaryImage())
        <div class="card-image">
            <a href="{{ $product->getURL(false, 'webinars') }}" class="no-underline">
                <img class="" src={{ $product->primaryImage()->getURL('large') }} />
            </a>
            @can ('edit-product')
                <a style="position: absolute; top: 5px; right: 5px;" href="/product/{{ $product->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
        </div>
    @endif
</div>
