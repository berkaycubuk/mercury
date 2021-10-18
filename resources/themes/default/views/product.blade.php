@extends('core::layouts.store')

@section('content')

<style>

.product-page-customize-select.error {
    border: 1px solid red; 
}

</style>

<div class="breadcrumb container">
    <ul>
        @if(!isset($product->product_category) && !isset($product->subcategory))
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        @endif
        @if(isset($product->product_category))
        <li><a href="{{ route('store.products', ['slug' => $product->product_category->slug . '-c-' . $product->product_category->id]) }}">{{ $product->product_category->name }}</a></li>
        @endif
        @if(isset($product->subcategory))
        <li><a href="{{ route('store.products', ['slug' => $product->subcategory->slug . '-sc-' . $product->subcategory->id]) }}">{{ $product->subcategory->name }}</a></li>
        @endif
        <li class="active">{{ $product->title }}</li>
    </ul>
</div>

@inject('settings', 'App\Services\Settings')

<section class="product-page container">
    <div class="product-page-info">
        <div class="product-page-info-left">

            <section class="product-page-slider">
                <div id="product-images-slider" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @if(isset($product->images) && $product->images != null)
                                @foreach($product->images as $image)
                                <li class="splide__slide">
                                    <img src="{{ get_image($image) }}" />
                                </li>
                                @endforeach
                            @else
                                <li class="splide__slide">
                                    <img src="{{ get_image(0) }}" />
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div id="product-images-cover-slider" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @if(isset($product->images) && $product->images != null)
                                @foreach($product->images as $image)
                                <li class="splide__slide">
                                    <img src="{{ get_image($image) }}" />
                                </li>
                                @endforeach
                            @else
                                <li class="splide__slide">
                                    <img src="{{ get_image(0) }}" />
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>

        </div>
        <div class="product-page-info-right">
            <h1>{{ $product->title }}</h1>
            @if(isset($product->meta['online_orderable']) && $product->meta['online_orderable'])
                @if(isset($product->meta['discount_price']) && $product->meta['discount_price'] != null)
                <span><span class="old-price">{{ format_money($product->initial_price) }}</span><span id="product-info-price">{{ format_money($product->discounted_price_with_tax) }}</span></span>
                @else
                <span id="product-info-price">{{ format_money($product->initial_price) }}</span>
                @endif

            <div class="product-page-customize">
                @foreach($product->attributes as $attribute)
                    <h4>{{ $attribute['name'] }}</h4>
                    <select data-attribute-id="{{ $attribute['id'] }}" class="product-page-customize-select">
                        <!-- <option value="null" data-term-price="{{ $product->price_with_tax }}" selected>{{ $attribute['name'] }} seçiniz</option> -->
                        @foreach($attribute['terms'] as $term)
                            <option data-term-price="{{ $term['price'] }}" value="{{ $term['id'] }}">{{ $term['name'] }}</option>
                        @endforeach
                    </select>
                    <!-- <div class="product-page-customize-choices">
                        <div class="product-page-customize-choice active">
                            Büyük (6-8 kişilik)
                        </div>
                        <div class="product-page-customize-choice">
                            Orta (4-5 kişilik)
                        </div>
                        <div class="product-page-customize-choice">
                            Küçük (2-3 kişilik)
                        </div>
                    </div> -->
                @endforeach
            </div>

            <div class="product-page-order">
                @if(!$product->in_stock)
                <button class="btn btn-disabled">Stokta Yok</button>
                @else
                <div class="product-page-order-amount">
                    <div class="amount-increment">
                        +
                    </div>
                    <div class="amount-content">
                        <input class="amount-number" value="1" type="text" required />
                        <span class="amount-text">adet</span>
                    </div>
                    <div class="amount-decrease">
                        -
                    </div>
                </div>
                <button class="btn btn-primary order-btn">Sepete Ekle</button>
                @endif
            </div>

            <div class="product-page-badges">
                @if(!empty($product->meta['available_shippings']))
                    @foreach($product->meta['available_shippings'] as $method)
                        @php
                            foreach(get_settings('shipment') as $shipmentMethod) {
                                if ($shipmentMethod->id == $method) {
                                    $method = $shipmentMethod;
                                    break;
                                }
                            }
                        @endphp
                        @if(isset($method->locations))
                        <div class="product-page-badge">
                            <img src="{{ asset('assets/store/img/alert.svg') }}" />
                            Sadece&nbsp;
                            @foreach($method->locations as $location)
                                @if($loop->index != 0 && $loop->last)
                                    &nbsp;ve&nbsp;<b>{{ $location->city->name }}</b>
                                @elseif($loop->index != 0)
                                    &nbsp;,<b>{{ $location->city->name }}</b>
                                @else
                                    <b>{{ $location->city->name }}</b>
                                @endif
                            @endforeach
                            &nbsp;içine sipariş verilebilir!
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
            @else
            <span>Sadece şubelerde</span>
            @endif
        </div>
    </div>

    <div class="product-page-details">
        <div class="product-page-tab-selectors">
            <a class="product-page-tab-selector active">Ürün Detayları</a>
            <a class="product-page-tab-selector">Teslimat Bilgileri</a>
        </div>
        <div class="product-page-tabs">
            <div class="product-page-tab active">
                <p>{{ $product->description}}</p>
            </div>
            <div class="product-page-tab">
                <p>{{ $settings->getSetting('product')->delivery_information }}</p><br />

                <b>Teslimat Yapılan Bölgeler ve Ücretleri</b><br/>
                <ul>
                    @foreach($settings->getSetting('shipment') as $method)
                        <li>{{ $method->name }}</li>
                        <ul>
                            @if(isset($method->locations))
                                @foreach($method->locations as $location)
                                    <li>{{ $location->city->name }} - {{ $location->district->name }}: <b>{{ $location->price }}TL</b></li>
                                    <ul>
                                        @foreach($location->neighborhood as $neighborhood)
                                            <li>{{ $neighborhood->name }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @else 
                                <li>Türkiye'nin her yerine: <b>{{ $method->price }}TL</b></li>
                            @endif
                        </ul>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="modal">
    <div class="modal-content">
        <div class="modal-content-top">
            <div class="close-btn" onclick="cartModal.close()"></div>
        </div>
        <h2>Ürün sepete eklendi</h2>
        <p>Alışverişinize devam edebilir veya sepete gidebilirsiniz.</p>
        <div class="modal-content-bottom">
            <a class="btn btn-secondary btn-small" onclick="cartModal.close()">Alışverişe Devam Et</a>
            <a class="btn btn-secondary btn-small" href="{{ route('store.cart') }}">Sepete Git</a>
        </div>
    </div>
</div>

@include('core::partials.similar-products')

@include('core::partials.site-badges')

@endsection

@section('scripts')
    <script>
        cartModal = new Modal('.modal');

        $(document).ready(function() {
            var primarySlider = new Splide('#product-images-slider', {
                type: 'fade',
                perPage: 1,
                gap: '16px',
                pagination: false,
                arrows: false,
            });

            var secondarySlider = new Splide('#product-images-cover-slider', {
                rewind: true,
                fixedWidth: 100,
                fixedHeight: 64,
                isNavigation: true,
                gap: '16px',
                pagination: false,
                focus: 'center',
                arrows: false,
                cover: true,
                trimSpace: true
            }).mount();

            primarySlider.sync(secondarySlider).mount();

            // Price & amount
            var amount = 1;
            var type = 0;
            var max_amount = {{ isset($product->meta['stock_amount']) && $product->meta['stock_amount'] != null ? $product->meta['stock_amount'] : 10 }};

            $('.amount-increment').click(function() {
                if (amount < max_amount) {
                    amount++;
                    $('.amount-number').val(amount);
                }
            });

            $('.amount-decrease').click(function() {
                if (amount != 1) {
                    amount--;
                    $('.amount-number').val(amount);
                }
            });

            $('.product-page-customize-choice').click(function(e) {
                type = $(this).index();
                $('.product-page-customize-choice').each(function(index) {
                    $(this).removeClass('active');
                });
                $(this).addClass('active');
            });

            $('.product-page-customize-select').change(function() {
                var selected = $('.product-page-customize-select option:selected')
                var id = $(this).val();
                var name = selected.text();
                var price = selected.data('term-price');
                @if(isset($product->meta['tax']))
                    var tax = {{ $product->meta['tax'] }};
                @else
                    var tax = 0;
                @endif

                if (price == 0) {
                    price = {{ $product->price }};
                }

                if (price != 0 && price != null) {
                    if (id == 'null') {
                        $('#product-info-price').text(price.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '₺');
                    } else {
                        $('.product-page-customize-select').removeClass('error');
                        $('#product-info-price').text((price + (price * tax) / 100).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '₺');
                    }
                }
            });

            // add to cart
            $('.order-btn').click(function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                var typeSelector = $('.product-page-customize-select');

                if (typeSelector.val() == 'null') {
                    typeSelector.addClass('error');
                    return;
                } else {
                    typeSelector.removeClass('error');
                }

                run_loading();

                if (typeSelector.length) {
                    var data = {
                        id: "{{ $product->id }}",
                        term: typeSelector.val(),
                        attribute: typeSelector.data('attribute-id'),
                        amount: $('.amount-number').val()
                    };
                } else {
                    var data = {
                        id: "{{ $product->id }}",
                        amount: $('.amount-number').val()
                    };
                }
        
                $.ajax({
                    url: "{{ route('store.cart.add') }}",
                    method: 'post',
                    data: data,
                    success: function(result) {
                        stop_loading();
                        cartModal.open();
                    }
                });
            });

            // Tabs
            $('.product-page-tab-selector').click(function(e) {
                e.preventDefault();

                $('.product-page-tab-selector').each(function(index) {
                    $(this).removeClass('active');
                });
                $(this).addClass('active');
                $('.product-page-tab').each(function(index) {
                    $(this).removeClass('active');
                });
                $('.product-page-tab').eq($(this).index()).addClass('active');
            });
        });
    </script>
@endsection
