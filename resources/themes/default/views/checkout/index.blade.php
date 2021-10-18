@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.cart') }}">Sepet</a></li>
        <li class="active">Teslimat Bilgileri</li>
    </ul>
</div>

<form class="checkout container" action="{{ route('store.checkout.save-information') }}" method="POST">
    @csrf
    <div class="checkout-content form">
        @guest
        <h3>İletişim Bilgileri</h3><br />
        <div class="form-group">
            <label>E-posta Adresi</label>
            <input type="email" name="shipping-email" class="form-control @error('email') error @enderror" placeholder="E-posta" required />
            @error('email')
                <div class="form-input-error">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <hr />
        @endguest
        <h3>Teslimat Bilgileri</h3><br />
        <div class="form-row">
            <div class="form-group">
                <label>Ad</label>
                <input type="text" value="{{ old('shipping-first-name', $shipping_address->first_name) }}" class="form-control @error('shipping-first-name') error @enderror" name="shipping-first-name" placeholder="Ad" required />
                @error('shipping-first-name')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Soyad</label>
                <input type="text" value="{{ old('shipping-last-name', $shipping_address->last_name) }}" class="form-control @error('shipping-last-name') error @enderror" name="shipping-last-name" placeholder="Soyad" required />
                @error('shipping-last-name')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Şehir</label>
                <select id="shipping-city-select" name="shipping-city" class="form-control @error('shipping-city') error @enderror" required >
                    @if(old('shipping-city', $shipping_address->city->id))
                        <option value="{{ old('shipping-city', $shipping_address->city->id) }}" selected>{{ locations_get_city(old('shipping-city', $shipping_address->city->id))->name }}</option>
                    @else
                        <option value="null" selected disabled>Şehir seçin</option>
                    @endif
                </select>
                @error('shipping-city')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>İlçe</label>
                <select id="shipping-district-select" name="shipping-district" class="form-control @error('shipping-district') error @enderror" required >
                    @if(old('shipping-district', $shipping_address->district->id))
                        <option value="{{ old('shipping-district', $shipping_address->district->id) }}" selected>{{ locations_get_district(old('shipping-district', $shipping_address->district->id))->name }}</option>
                    @else
                        <option value="null" selected disabled>İlçe seçin</option>
                    @endif
                </select>
                @error('shipping-district')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Mahalle</label>
                <select id="shipping-neighborhood-select" name="shipping-neighborhood" class="form-control @error('shipping-neighborhood') error @enderror" required >
                    @if(old('shipping-neighborhood', $shipping_address->neighborhood->id))
                        <option value="{{ old('shipping-neighborhood', $shipping_address->neighborhood->id) }}" selected>{{ locations_get_neighborhood(old('shipping-neighborhood', $shipping_address->neighborhood->id))->name }}</option>
                    @else
                        <option value="null" selected disabled>Mahalle seçin</option>
                    @endif
                </select>
                @error('shipping-neighborhood')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label>Adres</label>
            <textarea name="shipping-address" class="form-control @error('shipping-address') error @enderror" placeholder="Mahalle, Cadde, Sokak ve diğer adres bilgileriniz" required>{{ old('shipping-address', $shipping_address->address) }}</textarea>
            @error('shipping-address')
            <div class="form-input-error">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Telefon</label>
            <span class="description">Teslimatın yapılacağı kişiye ulaşabilmemiz için telefon numarası.</span>
            <input type="tel" value="{{ old('shipping-phone', $shipping_address->phone) }}" name="shipping-phone" class="form-control @error('shipping-phone') error @enderror" placeholder="Telefon" required />
            @error('shipping-phone')
            <div class="form-input-error">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group form-group-flex">
            Fatura Tipi:
            <label class="input-radio">Bireysel
                <input type="radio" name="billing-type" value="personal" checked>
                <span class="input-radio-checkmark"></span>
            </label>
            <label class="input-radio">Kurumsal
                <input type="radio" name="billing-type" value="company">
                <span class="input-radio-checkmark"></span>
            </label>&nbsp;
        </div>
        <div id="billing-company-details" hidden>
            <div class="form-group">
                <label>Şirket Adı</label>
                <input value="{{ old('billing-company-name', $billing_address->company_name) }}" data-if-name-value="billing-type company" type="text" placeholder="Şirket Adı" name="billing-company-name" class="form-control @error('billing-company-name') error @enderror"/>
                @error('billing-company-name')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Vergi Numarası</label>
                <input value="{{ old('billing-company-tax-number', $billing_address->tax_number) }}" data-if-name-value="billing-type company" type="text" placeholder="Şirket Vergi Numarası" name="billing-company-tax-number" class="form-control @error('billing-company-tax-number') error @enderror"/>
                @error('billing-company-tax-number')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Vergi Dairesi</label>
                <input value="{{ old('billing-company-tax-administration', $billing_address->tax_administration) }}" data-if-name-value="billing-type company" type="text" placeholder="Şirket Vergi Dairesi" name="billing-company-tax-administration" class="form-control @error('billing-company-tax-administration') error @enderror"/>
                @error('billing-company-tax-administration')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="input-checkbox">E-fatura mükellefiyim
                    <input type="checkbox" name="e-bill-user">
                    <span class="input-checkbox-checkmark"></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="input-checkbox">Fatura adresi eklemek istiyorum.
                <input type="checkbox" onclick="toggleBillingAddress()" name="shipping-not-same-with-billing">
                <span class="input-checkbox-checkmark"></span>
            </label>
            <span class="description">Eğer fatura adresi eklerseniz, faturanız teslimat adresine değil belirteceğiniz yeni adrese teslim edilecektir.</span>
        </div>
        <div id="billing-address-details" hidden>
            <div class="form-row">
                <div class="form-group">
                    <label>Ad</label>
                    <input value="{{ old('billing-first-name', $billing_address->first_name) }}" data-if-name-checked="shipping-not-same-with-billing" type="text" name="billing-first-name" class="form-control @error('billing-first-name') error @enderror" placeholder="Ad"/>
                    @error('billing-first-name')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Soyad</label>
                    <input value="{{ old('billing-first-name', $billing_address->first_name) }}" data-if-name-checked="shipping-not-same-with-billing" type="text" name="billing-last-name" placeholder="Soyad" class="form-control @error('billing-last-name') error @enderror"/>
                    @error('billing-last-name')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Şehir</label>
                    <input value="{{ old('billing-first-name', $billing_address->first_name) }}" data-if-name-checked="shipping-not-same-with-billing" type="text" name="billing-city" class="form-control @error('billing-city') error @enderror"/>
                    @error('billing-city')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>İlçe</label>
                    <input value="{{ old('billing-first-name', $billing_address->first_name) }}" data-if-name-checked="shipping-not-same-with-billing" type="text" name="billing-district" class="form-control @error('billing-district') error @enderror"/>
                    @error('billing-district')
                    <div class="form-input-error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Adres</label>
                <textarea data-if-name-checked="shipping-not-same-with-billing" placeholder="Mahalle, Cadde, Sokak ve diğer adres bilgileriniz" name="billing-address" class="form-control @error('billing-address') error @enderror">{{ old('billing-address', $billing_address->address) }}</textarea>
                @error('billing-address')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input value="{{ old('billing-phone', $billing_address->phone) }}" data-if-name-checked="shipping-not-same-with-billing" type="tel" name="billing-phone" class="form-control @error('billing-phone') error @enderror" placeholder="Telefon"/>
                @error('billing-phone')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>E-posta</label>
                <input value="{{ old('billing-email', $billing_address->email) }}" data-if-name-checked="shipping-not-same-with-billing" type="email" name="billing-email" class="form-control @error('billing-email') error @enderror" placeholder="E-posta"/>
                @error('billing-email')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @guest
        <div class="form-group">
            <label class="input-checkbox">Hesap oluşturmak istiyorum
                <input type="checkbox" onclick="toggleCreateAccount()" name="create-new-account">
                <span class="input-checkbox-checkmark"></span>
            </label>
            <span class="description">Daha hızlı ve kolay bir alışveriş deneyimi için hesap oluşturabilirsiniz.</span>
        </div>
        <div id="new-account-form" hidden>
            <div class="form-group">
                <label>Şifre</label>
                <span class="description">Oluşturmak istediğiniz üyelik için şifreniz.</span>
                <input data-if-name-checked="create-new-account" type="password" class="form-control @error('password') error @enderror" name="password"/>
                @error('password')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Şifre Tekrarı</label>
                <span class="description">Lütfen şifrenizi tekrar yazın.</span>
                <input data-if-name-checked="create-new-account" type="password" class="form-control @error('password-repeat') error @enderror" name="password_repeat"/>
                @error('password_repeat')
                <div class="form-input-error">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        @endguest
        <hr />
        <h3>Kargo Seçenekleri</h3><br />
        <div id="cargo-options" class="cargo-options">
            @if(Auth::check())
                @if(!empty($shipping_address))
                    @foreach($shipping_choices as $choice)
                        <div class="cargo-option">
                            <label class="input-radio">{{ $choice->name }} <b>{{ format_money($choice->price) }}</b>
                                @if(count($shipping_choices) == 1)
                                <input type="radio" name="shipping-provider" value="{{ $choice->id }}" data-price="{{ $choice->price }}" checked>
                                @else
                                <input type="radio" name="shipping-provider" value="{{ $choice->id }}" data-price="{{ $choice->price }}">
                                @endif
                                <span class="input-radio-checkmark"></span>
                            </label>
                            <span class="description">Kargonuz <b>{{ $choice->name }}</b> ile yaklaşık <b>3 - 4 iş günü</b> içerisinde belirttiğiniz adrese gönderilmektedir.</span>
                        </div>
                    @endforeach
                @else
                <p style="font-style: italic; color: var(--color-gray-dark);">Lütfen teslimat için bir adres ekleyiniz.</p>
                @endif
            @else
            <p style="font-style: italic; color: var(--color-gray-dark);">Lütfen teslimat için bir adres seçiniz.</p>
            @endif
        </div>
        <hr />
        <h3>Sipariş Notu</h3><br />
        <div class="form-group">
            <label>Sipariş Notunuz</label>
            <textarea name="order-note" placeholder="Sipariş notunuz, teslimatı yapacak olan şubeye iletilecektir"></textarea>
        </div>
        <a href="{{ route('store.cart') }}" class="btn btn-secondary btn-small">Geri Dön</a>
    </div>
    <div class="checkout-sidebar">
        <h2>Sepet Özeti</h2>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Ara toplam</div>
            <div id="cart-total-without-tax" class="cart-summary-price-amount">{{ format_money($cart->total_price - $cart->tax) }}</div>
        </div>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">KDV</div>
            <div id="cart-tax" class="cart-summary-price-amount">{{ format_money($cart->tax) }}</div>
        </div>
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Kargo</div>
            <div id="cart-shipping-price" class="cart-summary-price-amount">{{ format_money(count($shipping_choices) == 1 ? $shipping_choices[0]->price : 0) }}</div>
        </div>
        <hr />
        <div class="cart-summary-price">
            <div class="cart-summary-price-name">Toplam</div>
            <div id="cart-total" class="cart-summary-price-amount">{{ format_money($cart->total_price + (count($shipping_choices) == 1 ? $shipping_choices[0]->price : 0)) }}</div>
        </div><br />

        <!-- Coupon codes -->
        <div class="cart-summary-coupons">
            @foreach($cart->coupons as $coupon)
            <div class="coupon">
                <div class="coupon__head">
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

        <button class="btn btn-primary">Ödeme İşlemleri</button>
    </div>
</form>

@endsection

@section('scripts')

    <script>

        function loadShippingChoices() {
            var city = $("#shipping-city-select").val();
            var district = $("#shipping-district-select").val();
            var neighborhood = $("#shipping-neighborhood-select").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.shipment.choices') }}",
                method: 'get',
                data: {
                    city: city,
                    district: district,
                    neighborhood: neighborhood
                },
                success: function(result) {
                    $("#cargo-options").empty();

                    for (var i = 0; i < result.choices.length; i++) {
                        var element = '<div>';
                        element += '<label class="input-radio">' + result.choices[i].name + ' <b>' + result.choices[i].price + ' TL</b>';
                        if (result.choices.length == 1) {
                            element += '<input type="radio" checked name="shipping-provider" value="' + result.choices[i].id + '" data-price="' + result.choices[i].price + '">';
                        } else {
                            element += '<input type="radio" name="shipping-provider" value="' + result.choices[i].id + '" data-price="' + result.choices[i].price + '">';
                        }
                        element += '<span class="input-radio-checkmark"></span>';
                        element += '</label>';
                        // element += '<span class="description">Kargonuz <b>' + result.choices[i].name + '</b> ile yaklaşık <b>3 - 4 iş günü</b> içerisinde belirttiğiniz adrese gönderilmektedir.</span>';
                        element += '</div>';

                        $("#cargo-options").append(element);
                    }
                }
            });
        }

        function toggleCreateAccount() {
            if ($("input[name='create-new-account']").prop('checked') == true) {
                $('#new-account-form').show();
            } else {
                $('#new-account-form').hide();
            }
        }

        function toggleBillingAddress() {
            if ($("input[name='shipping-not-same-with-billing']").prop('checked') == true) {
                $('#billing-address-details').show();
            } else {
                $('#billing-address-details').hide();
            }
        }

        $(document).ready(function() {
            var isInitial = true;

            $("input[name='billing-type']").click(function() {
                if ($(this).val() == 'company') {
                    $('#billing-company-details').show();
                } else {
                    $('#billing-company-details').hide();
                }
            });

            $("input[name='shipping-provider']").click(function() {
                $('#cart-shipping-price').text($(this).attr('data-price') + '₺');
                price = {{ get_cart_total() }} + parseFloat($(this).attr('data-price'));
                price = price.toFixed(2).toString();
                price = price.replace('.', ',');
                $('#cart-total').text(price + "₺");
            });

            if (isInitial && $('#shipping-city-select').val() != null) {
                getDistricts($('#shipping-city-select').val());
            }

            if (isInitial && $('#shipping-district-select').val() != null) {
                getNeighborhoods($('#shipping-district-select').val());
            }

            if (isInitial && $('#shipping-neighborhood-select').val() != null) {
                loadShippingChoices();
            }

            // get cities
            getCities();

            $('#shipping-city-select').change(function() {
                clearDistricts();
                clearNeighborhoods();
                getDistricts($(this).val());
            });

            $('#shipping-district-select').change(function() {
                clearNeighborhoods();
                getNeighborhoods($(this).val());
            });

            $('#shipping-neighborhood-select').change(function() {
                loadShippingChoices();
            });

            isInitial = false;
        });

        function getCities() {
            run_loading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('store.locations.cities') }}",
                method: 'get',
                success: function(result) {
                    elements = '';

                    result.data.forEach(function(city) {
                        elements += '<option value="' + city.id + '">' + city.name + '</option>';
                    });

                    $('#shipping-city-select').append(elements);
                    stop_loading();
                }
            });
        }

        function clearDistricts() {
            $('#shipping-district-select').find('option').remove();
            $('#shipping-district-select').append('<option value="null" default selected>İlçe seçin</option>');
        }

        function clearNeighborhoods() {
            $('#shipping-neighborhood-select').find('option').remove();
            $('#shipping-neighborhood-select').append('<option value="null" default selected>Mahalle seçin</option>');
        }

        function getDistricts(cityId) {
            run_loading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('store.locations.districts') }}",
                method: 'get',
                data: {
                    city_id: cityId
                },
                success: function(result) {
                    elements = '';

                    result.data.forEach(function(district) {
                        elements += '<option value="' + district.id + '">' + district.name + '</option>';
                    });

                    $('#shipping-district-select').append(elements);
                    stop_loading();
                }
            });
        }

        function getNeighborhoods(districtId) {
            run_loading();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('store.locations.neighborhoods') }}",
                method: 'get',
                data: {
                    district_id: districtId
                },
                success: function(result) {
                    elements = '';

                    result.data.forEach(function(neighborhood) {
                        elements += '<option value="' + neighborhood.id + '">' + neighborhood.name + '</option>';
                    });

                    $('#shipping-neighborhood-select').append(elements);
                    stop_loading();
                }
            });
        }
    </script>

@endsection
