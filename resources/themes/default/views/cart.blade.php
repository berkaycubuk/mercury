@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li class="active">Sepetim</li>
    </ul>
</div>

<section class="cart container">
    <h1>Sepetim</h1>

    @php
        $showWarning = false;
        if ($cart->items != null) {
            foreach($cart->items as $item) {
                if(count($item['available_shippings'])) {
                    foreach($item['available_shippings'] as $method) {
                        if(isset($method['locations'])) {
                            $showWarning = true;
                            break;
                        }
                    }
                }
            }
        }
    @endphp
    @if($showWarning)
    <br />
    <div class="alert alert-info">
        <p>Sepetinizdeki bazı ürünler sadece belirli şehirlere sipariş edilebiliyor. İleriki adımlarda teslimat adresiniz farklı bir şehir olursa bazı ürünleri sepetinizden silmeniz gerekebilir.</p>
    </div>
    @endif

    <div class="cart-content">
        <div class="cart-content-left">
            <div class="cart-products">
                @if(empty($cart->items))
                    <div class="alert alert-info">
                        Sepetinizde ürün bulunmuyor.
                    </div>
                @else
                    @foreach($cart->items as $item)
                        @if(!$loop->first)
                            <hr data-product-id="{{ $item['id'] }}" />
                        @endif
                        @if(isset($item['attribute']) && isset($item['term']))
                        <div data-product-id="{{ $item['id'] }}" data-product-attribute="{{ $item['attribute']['id'] }}" data-product-term="{{ $item['term']['id'] }}" class="cart-product">
                        @else
                        <div data-product-id="{{ $item['id'] }}" class="cart-product">
                        @endif
                            <div class="cart-product-details">
                                <a class="cart-product-image" href="{{ route('store.product', ['slug' => $item['slug']]) }}">
                                    <img src="{{ get_image($item['image']) }}" />
                                </a>
                                <div class="cart-product-info">
                                    @if(isset($item['attribute']) && isset($item['term']))
                                    <span>{{ $item['title'] }} | {{ $item['term']['name'] }}</span>
                                    @else
                                    <span>{{ $item['title'] }}</span>
                                    @endif
                                    <a class="cart-product-delete">Sepetten Sil</a>
                                </div>
                            </div>
                            <div class="cart-product-amount">
                                <div class="cart-product-amount-increment">
                                    +
                                </div>
                                <div class="cart-product-amount-content">
                                    <input class="cart-product-amount-number" value="{{ $item['amount'] }}" type="text" required />
                                    <span class="cart-product-amount-text">adet</span>
                                </div>
                                <div class="cart-product-amount-decrease">
                                    -
                                </div>
                            </div>
                            <div class="cart-product-price">
                                <span>{{ format_money($item['price'] + $item['tax']) }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if(!empty($cart->items))
            <div class="form">
               <input type="text" name="card-coupon-code" placeholder="Kupon Kodu" />
               <button class="btn btn-small btn-primary" onclick="apply_coupon_code(event)">Uygula</button>
            </div>
            @endif
            <div class="cart-actions">
                <button id="empty-cart" class="btn btn-secondary">Sepeti Temizle</button>
                <a href="{{ route('store.order-online') }}" class="btn btn-secondary">Alışverişe Devam Et</a>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="cart-content-right">
            <div class="cart-summary">
                <h2>Sepet Özeti</h2>
                <div class="cart-summary-price">
                  <div class="cart-summary-price-name">Ara toplam</div>
                  <div id="cart-total-without-tax" class="cart-summary-price-amount">{{ format_money($cart->total_price - $cart->tax) }}</div>
                </div>
                <div class="cart-summary-price">
                  <div class="cart-summary-price-name">KDV</div>
                  <div id="cart-tax" class="cart-summary-price-amount">{{ format_money($cart->tax) }}</div>
                </div>
                <hr />
                <div class="cart-summary-price">
                  <div class="cart-summary-price-name">Toplam</div>
                  <div id="cart-total" class="cart-summary-price-amount">{{ format_money($cart->total_price) }}</div>
                </div>

                <!-- Coupon codes -->
                <div class="cart-summary-coupons">
                    @foreach($coupons as $coupon)
                    <div class="coupon">
                        <div class="coupon__head">
                            <a class="coupon__head__delete" onclick="delete_coupon_code(event)" data-coupon-id="{{ $coupon->id }}"></a>
                            <div class="coupon__head__title">{{ $coupon->code }}</div>
                            <span class="coupon__head__discount">{{ format_money($coupon->discount) }}</span>
                        </div>
                        @if(isset($coupon->description))
                        <div class="coupon__body">
                            <p class="coupon__body__description">
                                {{ $coupon->description }}
                            </p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                @if(!empty($cart->items))
                <a href="{{ route('store.checkout.index') }}" class="btn btn-primary">Alışverişi Tamamla</a>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
    <script>
        function update_total_price(result) {
            $('#cart-total-without-tax').text(result.cart_total_without_tax);
            $('#cart-tax').text(result.cart_tax);
            $('#cart-total').text(result.cart_total);
        }

        function addCoupon(coupon) {
            var couponEl = '<div class="coupon">';
            couponEl += '<div class="coupon__head">';
            couponEl += '<a class="coupon__head__delete" onclick="delete_coupon_code(event)" data-coupon-id="' + coupon.id + '"></a>';
            couponEl += '<div class="coupon__head__title">' + coupon.code + '</div>';
            couponEl += '<span class="coupon__head__discount">' + coupon.discount.toLocaleString('tr-TR', { minimumFractionDigits: 2 }) + '₺</span>';
            couponEl += '</div>';

            if (coupon.description) {
                couponEl += '<div class="coupon__body">';
                couponEl += '<p class="coupon__body__description">';
                couponEl += coupon.description;
                couponEl += '</p>';
                couponEl += '</div>';
            }

            couponEl += '</div>';

            $('.cart-summary-coupons').append(couponEl);
        }

        function delete_coupon_code(event) {
            var deleteBtn = $(event.target);
            var couponId = deleteBtn.data('coupon-id');

            run_loading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.cart.coupon-code.delete') }}",
                method: 'post',
                data: {
                    coupon_id: couponId,
                },
                success: function(result) {
                    update_total_price({
                        cart_total_without_tax: result.cart.total_price_without_tax, 
                        cart_tax: result.cart.tax,
                        cart_total: result.cart.total_price
                    });

                    $(".cart-summary-coupons").empty();

                    for (var i = 0; i < result.cart.coupons.length; i++) {
                        addCoupon(result.cart.coupons[i]);
                    }

                    stop_loading();
                },
                error: function(result) {
                    stop_loading();
                }
            });
        } 

        function apply_coupon_code(event) {
            event.preventDefault();

            run_loading();

            var codeInput = $("input[name='card-coupon-code']");
            var code = codeInput.val();

            // clear alerts
            codeInput.parent().find('.alert').each(function() {
                $(this).remove();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.cart.coupon-code.apply') }}",
                method: 'post',
                data: {
                    code: code,
                },
                success: function(result) {
                    codeInput.val("");

                    update_total_price({
                        cart_total_without_tax: result.cart.total_price_without_tax, 
                        cart_tax: result.cart.tax,
                        cart_total: result.cart.total_price
                    });

                    var successMessage = '<p class="alert alert-success">';
                    successMessage += 'Kuponunuz eklendi!';
                    successMessage += '</p>';

                    codeInput.parent().append(successMessage);

                    $(".cart-summary-coupons").empty();

                    for (var i = 0; i < result.cart.coupons.length; i++) {
                        addCoupon(result.cart.coupons[i]);
                    }

                    stop_loading();
                },
                error: function(result) {
                    codeInput.val("");
                    
                    var errorMessage = '<p class="alert alert-danger">';
                    errorMessage += 'Kuponun tarihi geçmiş veya hatalı!';
                    errorMessage += '</p>';

                    codeInput.parent().append(errorMessage);
                    stop_loading();
                }
            });
        }

        $(document).ready(function() {
            // increase product amount
            $('.cart-product-amount-increment').click(function() {
                run_loading();

                product_id = $(this).parent().parent().attr('data-product-id');
                term = $(this).parent().parent().attr('data-product-term');
                attribute = $(this).parent().parent().attr('data-product-attribute');
                amount_input = $(this).parent().find('.cart-product-amount-number');

                if (term != null && attribute != null) {
                    var data = {
                        id: product_id,
                        term: term,
                        attribute: attribute,
                        amount: 1
                    };
                } else {
                    var data = {
                        id: product_id,
                        amount: 1
                    };
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.cart.add') }}",
                    method: 'post',
                    data: data,
                    success: function(result) {
                        amount_input.val(result.amount);
                        update_total_price(result);
                        stop_loading();
                    }
                });
            });

            // decrease product amount
            $('.cart-product-amount-decrease').click(function() {
                run_loading();

                product_element = $(this).parent().parent();
                product_id = product_element.attr('data-product-id');
                term = $(this).parent().parent().attr('data-product-term');
                attribute = $(this).parent().parent().attr('data-product-attribute');
                amount_input = $(this).parent().find('.cart-product-amount-number');

                if (term != null && attribute != null) {
                    var data = {
                        id: product_id,
                        term: term,
                        attribute: attribute,
                    };
                } else {
                    var data = {
                        id: product_id,
                    };
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.cart.remove') }}",
                    method: 'post',
                    data: data,
                    success: function(result) {
                        if (result.amount == 0) {
                            product_element.remove();
                            $("hr[data-product-id='" + product_id + "']").remove();
                        }

                        amount_input.val(result.amount);
                        update_total_price(result);
                        stop_loading();
                    }
                });
            });

            // delete product
            $('.cart-product-delete').click(function(e) {
                run_loading();

                e.preventDefault();
                product_element = $(this).parent().parent().parent();
                product_id = product_element.attr('data-product-id');
                amount_input = $(this).parent().parent().parent().find('.cart-product-amount-number');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.cart.delete') }}",
                    method: 'post',
                    data: {
                        id: product_id,
                    },
                    success: function(result) {
                        product_element.remove();
                        $("hr[data-product-id='" + product_id + "']").remove();
                        update_total_price(result);
                        stop_loading();
                    }
                });
            });

            // empty cart
            $('#empty-cart').click(function(e) {
                run_loading();

                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.cart.emptyCart') }}",
                    method: 'post',
                    success: function(result) {
                        $('.cart-product').each(function() {
                            $(this).remove();
                        });

                        $('.cart-products').find('hr').each(function() {
                            $(this).remove();
                        });

                        update_total_price(result);
                        stop_loading();
                    }
                });
            });
        });
    </script>
@endsection
