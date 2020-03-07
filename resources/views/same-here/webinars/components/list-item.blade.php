@php $pd = new Parsedown(); @endphp
@if ($product->primaryImage())
    <div class="card hoverable">
        <div class="card-image">
            <a href="{{$product->getURL(false, 'same-here/webinars')}}" class="no-underline">
                <img class="" src={{ $product->primaryImage()->getURL('large') }} />
            </a>
            @can ('edit-product')
                <a style="position: absolute; top: 5px; right: 5px;" href="/product/{{ $product->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
        </div>
    </div>
    <div class="row" style="margin-top: -5px;margin-left:5px">
        @foreach($product->tags as $tag)
            @if ($tag->name != 'Webinar')
                <a href="/same-here/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin-left:4px">{{ $tag->name }}</a>
            @endif
        @endforeach
    </div>
@endif
