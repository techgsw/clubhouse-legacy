<a href="#service-{{ $product->id }}" class="card no-underline career-service-item-card">
    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;align-items: center;">
        @if ($product->primaryImage())
            <img style="height: 80px;margin-bottom: 15px;" src={{ $product->primaryImage()->getURL('medium') }} />
        @endif
        <h5 style="margin-top:auto;margin-bottom: auto;">{{ $product->name }}</h5>
    </div>
</a>
