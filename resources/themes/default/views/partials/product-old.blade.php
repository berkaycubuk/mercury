<div class="product">
    <img src="{{ isset($product->images) && $product->images != null ? get_image($product->images[0]) : get_image(0) }}" />
    <div class="product-content">
        <h3>{{ $product->title }}</h3>
        @if($product->meta['online_orderable'])
            @if(isset($product->meta['discount_price']) && $product->meta['discount_price'] != null)
            <span><span class="old-price">{{ $product->formatted_price }}</span>{{ number_format($product->meta['discount_price'], 2, ",", ".") }}₺</span>
            @else
            <span>{{ $product->formatted_price }}</span>
            @endif
        @else
        <span>Sadece Şubelerde</span>
        @endif
        <div class="product-content-inner">
            <p>
                @if(!empty($product->short_description))
                    {{ $product->short_description }}
                @else
                    @if(strlen($product->description) > 120)
                        {{ substr($product->description, 0, 120) . '...' }}
                    @else
                        {{ $product->description }}
                    @endif
                @endif
            </p>
            <div class="product-content-inner-actions">
                <a href="{{ route('store.product', ['slug' => $product->slug]) }}" class="btn btn-secondary">Ürünü İncele</a>
                <!--
                @if($product->meta['online_orderable'])
                <a href="#" class="btn btn-primary">Sepete Ekle</a>
                @endif
                <a href="{{ route('store.product', ['slug' => $product->slug]) }}" class="link">İncele <img src="{{ asset('assets/store/img/chevron.svg') }}" /></a>
                -->
            </div>
        </div>
    </div>
</div>
