@extends('core::layouts.store')

@section('content')

<section class="online-order container">
    <h1>Online Sipariş</h1>
    <!-- <p>
        Beğendiğiniz ürünleri seçin, teslimat adresinizi
        belirleyin ve kapınıza kadar ürünlerinizi teslim
        edelim.
    </p> -->

    <div class="online-order-products">
        <h2>Yeni Ürünler</h2>
        <div class="online-order-products-slider splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($new_products as $product)
                    <li class="splide__slide">
                        @include('core::partials.product', ['product' => $product])
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="online-order-products">
        <h2>Popüler Ürünler</h2>
        <div class="online-order-products-slider splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($popular_products as $product)
                    <li class="splide__slide">
                        @include('core::partials.product', ['product' => $product])
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="online-order-products online-order-categories">
        <h2>Ürün Kategorileri</h2>
        <div class="splide" style="margin-top:20px;">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($product_categories as $category)
                    <li class="splide__slide">
                        <a href="{{ route('store.products', ['slug' => $category->slug . '-c-' . $category->id]) }}" class="online-order-category">
                            <h3>{{ $category->name }}</h3>
                            <div class="online-order-category-effect"></div>
                            @if(isset($category->meta['image']) && $category->meta['image'] != null)
                            <img src="{{ get_image($category->meta['image']) }}" />
                            @else
                            <img src="{{ get_image(0) }}" />
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var elms = document.getElementsByClassName('splide');
            for (var i = 0, len = elms.length; i < len; i++) {
                new Splide(elms[i], {
                    perPage: 4,
                    perMove: 1,
                    arrows: false,
                    breakpoints: {
                        1200: {
                            perPage: 3
                        },
                        992: {
                            perPage: 2
                        },
                        768: {
                            perPage: 1
                        }
                    }
                }).mount();
            }
        });
    </script>
@endsection
