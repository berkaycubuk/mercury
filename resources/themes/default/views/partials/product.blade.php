<a href="{{ route('store.product', ['slug' => $product->slug]) }}" class="product">
    <div class="product__image">
        <div class="product__image__effect"></div>
        <img src="{{ isset($product->images) && $product->images != null ? get_image($product->images[0]) : get_image(0) }}" />
    </div>
    <div class="product-content">
        <h3>{{ $product->title }}</h3>
        @if(isset($product->meta['online_orderable']) && $product->meta['online_orderable'])
            @if(isset($product->meta['discount_price']) && $product->meta['discount_price'] != null)
            <span><span class="old-price">{{ format_money($product->price_with_tax) }}</span>{{ format_money($product->discounted_price_with_tax) }}</span>
            @else
            <span>{{ format_money($product->price_with_tax) }}</span>
            @endif
        @else
        <span>Sadece Şubelerde</span>
        @endif
    </div>
</a>
