@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.account') }}">Hesabım</a></li>
        <li class="active">Adresler</li>
    </ul>
</div>

<section class="account-page container">
    @include('core::partials.auth-sidebar')
    <div class="account-page-content">
        <h2>Adreslerim</h2>
        <br />
        <h3>Teslimat Adresleri</h3>
        <div class="addresses">
            <a class="address-block" onclick="openModalWithDataID('new-shipping-address', getCities('shipping-city'))">
                <div class="address-block-new">
                    Yeni adres ekle
                </div>
            </a>

            <div data-modal-id="new-shipping-address" class="modal">
                <div class="modal-content">
                    <div class="modal-content-top">
                        <div class="close-btn" onclick="openModalWithDataID('new-shipping-address')"></div>
                    </div>
                    <h3>Yeni Adres Ekle</h3>
                    <div class="form modal-scroll-content">
                        <div class="form-group">
                            <label>Ad</label>
                            <input name="shipping-first-name" type="text" placeholder="Ad" />
                        </div>
                        <div class="form-group">
                            <label>Soyad</label>
                            <input name="shipping-last-name" type="text" placeholder="Soyad" />
                        </div>
                        <div class="form-group">
                            <label>Telefon</label>
                            <input name="shipping-phone" type="text" placeholder="0 5xx xxx xx xx" />
                        </div>
                        <div class="form-group">
                            <label>Şehir</label>
                            <select id="shipping-city-select" name="shipping-city" class="city-select form-control" required >
                                <option value="null" selected default>Şehir seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>İlçe</label>
                            <select id="shipping-district-select" name="shipping-district" class="district-select form-control" required >
                                <option value="null" selected default>İlçe seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mahalle</label>
                            <select id="shipping-neighborhood-select" name="shipping-neighborhood" class="neighborhood-select form-control" required >
                                <option value="null" selected default>Mahalle seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Adres</label>
                            <textarea name="shipping-address" placeholder="Mahalle, sokak, cadde ve diğer bilgiler..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Adres Adı</label>
                            <input name="shipping-address-name" type="text" placeholder="Örnek: Evim, İş yeri, vb." />
                        </div>
                        <div class="form-group">
                            <label class="input-checkbox">Teslimat adresim fatura adresim ile aynı
                                <input type="checkbox" name="shipping-same-with-billing">
                                <span class="input-checkbox-checkmark"></span>
                            </label>
                        </div>
                        <div data-hidden-id="billing-info" hidden>
                            <div class="form-group form-group-flex">
                                Fatura Tipi:
                                <label class="input-radio">Bireysel
                                    <input type="radio" name="new-shipping-address-billing-type" value="personal" checked>
                                    <span class="input-radio-checkmark"></span>
                                </label>
                                <label class="input-radio">Kurumsal
                                    <input type="radio" name="new-shipping-address-billing-type" value="company">
                                    <span class="input-radio-checkmark"></span>
                                </label>&nbsp;
                            </div>
                            <div data-hidden-id="billing-company" hidden>
                                <div class="form-group">
                                    <label>Şirket Adı</label>
                                    <input name="billing-company-name" type="text" placeholder="Şirket Adı" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Numarası</label>
                                    <input name="billing-tax-number" type="text" placeholder="Vergi Numarası" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Dairesi</label>
                                    <input name="billing-tax-administration" type="text" placeholder="Vergi Dairesi" />
                                </div>
                                <div class="form-group">
                                    <label class="input-checkbox">E-fatura mükellefiyim
                                        <input type="checkbox" name="e-bill-user">
                                        <span class="input-checkbox-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-content-bottom">
                        <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('new-shipping-address')">Vazgeç</a>
                        <a class="btn btn-primary btn-small" onclick="createAddressWithID('new-shipping-address')">Kaydet</a>
                    </div>
                </div>
            </div>
            @foreach($shipping_addresses as $address)
                <div class="address-block">
                    <span class="address-block-person">{{ $address->full_name }}</span>
                    <p class="address-block-address">
                        {{ $address->address }}<br/>
                        {{ $address->district->name }} / {{ $address->city->name }}
                    </p>
                    <span class="address-block-phone">{{ $address->phone }}</span>
                    <div class="address-block-actions">
                        <a class="link" onclick="openModalWithDataID('{{ $address->id }}-delete')">Sil</a>
                        <a class="btn btn-primary" onclick="openModalWithDataID('{{ $address->id }}-update')">Düzenle</a>
                    </div>
                </div>

                <div data-modal-id="{{ $address->id }}-update" class="modal">
                    <div class="modal-content">
                        <div class="modal-content-top">
                            <div class="close-btn" onclick="openModalWithDataID('{{ $address->id }}-update')"></div>
                        </div>
                        <h3>Adresi Düzenle</h3>
                        <div class="form modal-scroll-content">
                            <div class="form-group">
                                <label>Ad</label>
                                <input name="shipping-first-name" type="text" value="{{ $address->first_name }}" placeholder="Ad" />
                            </div>
                            <div class="form-group">
                                <label>Soyad</label>
                                <input name="shipping-last-name" type="text" value="{{ $address->last_name }}" placeholder="Soyad" />
                            </div>
                            <div class="form-group">
                                <label>Telefon</label>
                                <input name="shipping-phone" type="text" value="{{ $address->phone }}" placeholder="0 5xx xxx xx xx" />
                            </div>
                            <div class="form-group">
                                <label>Şehir</label>
                                <select id="shipping-city-select" name="shipping-city" class="city-select form-control" required >
                                    @foreach(locations_get_cities() as $city)
                                        @if($city->id == $address->city->id)
                                        <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                        @else
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>İlçe</label>
                                <select id="shipping-district-select" name="shipping-district" class="district-select form-control" required >
                                    @foreach(locations_get_districts($address->city->id) as $district)
                                        @if($district->id == $address->district->id)
                                        <option value="{{ $district->id }}" selected>{{ $district->name }}</option>
                                        @else
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mahalle</label>
                                <select id="shipping-neighborhood-select" name="shipping-neighborhood" class="neighborhood-select form-control" required >
                                    @foreach(locations_get_neighborhoods($address->district->id) as $neighborhood)
                                        @if($neighborhood->id == $address->neighborhood->id)
                                        <option value="{{ $neighborhood->id }}" selected>{{ $neighborhood->name }}</option>
                                        @else
                                        <option value="{{ $neighborhood->id }}">{{ $neighborhood->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Adres</label>
                                <textarea name="shipping-address" placeholder="Mahalle, sokak, cadde ve diğer bilgiler...">{{ $address->address }}</textarea>
                            </div>
                        </div>
                        <div class="modal-content-bottom">
                            <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('{{ $address->id }}-update')">Vazgeç</a>
                            <a class="btn btn-primary btn-small" onclick="updateAddressWithID({{ $address->id }})">Güncelle</a>
                        </div>
                    </div>
                </div>

                <div data-modal-id="{{ $address->id }}-delete" class="modal">
                    <div class="modal-content">
                        <div class="modal-content-top">
                            <div class="close-btn" onclick="openModalWithDataID('{{ $address->id }}-delete')"></div>
                        </div>
                        <p>Adresi silmek istediğinize emin misiniz?</p>
                        <div class="modal-content-bottom">
                            <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('{{ $address->id }}-delete')">Vazgeç</a>
                            <a class="btn btn-primary btn-small" onclick="deleteAddressWithID({{ $address->id }})">Sil</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <br />
        <h3>Fatura Adresleri</h3>
        <div class="addresses">
            <a class="address-block" onclick="openModalWithDataID('new-billing-address', getCities('billing-city'))">
                <div class="address-block-new">
                    Yeni adres ekle
                </div>
            </a>

            <div data-modal-id="new-billing-address" class="modal">
                <div class="modal-content">
                    <div class="modal-content-top">
                        <div class="close-btn" onclick="openModalWithDataID('new-billing-address')"></div>
                    </div>
                    <h3>Yeni Fatura Adresi Ekle</h3>
                    <div class="form modal-scroll-content">
                        <div class="form-group">
                            <label>Ad</label>
                            <input name="billing-first-name" type="text" placeholder="Ad" />
                        </div>
                        <div class="form-group">
                            <label>Soyad</label>
                            <input name="billing-last-name" type="text" placeholder="Soyad" />
                        </div>
                        <div class="form-group">
                            <label>Telefon</label>
                            <input name="billing-phone" type="text" placeholder="0 5xx xxx xx xx" />
                        </div>
                        <div class="form-group">
                            <label>Şehir</label>
                            <select id="billing-city-select" name="billing-city" class="city-select form-control" required >
                                <option value="null" selected default>Şehir seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>İlçe</label>
                            <select id="billing-district-select" name="billing-district" class="district-select form-control" required >
                                <option value="null" selected default>İlçe seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mahalle</label>
                            <select id="billing-neighborhood-select" name="billing-neighborhood" class="neighborhood-select form-control" required >
                                <option value="null" selected default>Mahalle seçin</option>
                            </select>
                            <div class="form-input-error">
                                Bu alan zorunludur!
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Adres</label>
                            <textarea name="billing-address" placeholder="Mahalle, sokak, cadde ve diğer bilgiler..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Adres Adı</label>
                            <input name="billing-address-name" type="text" placeholder="Örnek: Evim, İş yeri, vb." />
                        </div>
                        <div data-hidden-id="billing-info">
                            <div class="form-group form-group-flex">
                                Fatura Tipi:
                                <label class="input-radio">Bireysel
                                    <input type="radio" name="new-billing-address-billing-type" value="personal" checked>
                                    <span class="input-radio-checkmark"></span>
                                </label>
                                <label class="input-radio">Kurumsal
                                    <input type="radio" name="new-billing-address-billing-type" value="company">
                                    <span class="input-radio-checkmark"></span>
                                </label>&nbsp;
                            </div>
                            <div data-hidden-id="billing-company" hidden>
                                <div class="form-group">
                                    <label>Şirket Adı</label>
                                    <input name="billing-company-name" type="text" placeholder="Şirket Adı" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Numarası</label>
                                    <input name="billing-tax-number" type="text" placeholder="Vergi Numarası" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Dairesi</label>
                                    <input name="billing-tax-administration" type="text" placeholder="Vergi Dairesi" />
                                </div>
                                <div class="form-group">
                                    <label class="input-checkbox">E-fatura mükellefiyim
                                        <input type="checkbox" name="e-bill-user">
                                        <span class="input-checkbox-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-content-bottom">
                        <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('new-billing-address')">Vazgeç</a>
                        <a class="btn btn-primary btn-small" onclick="createAddressWithID('new-billing-address', 'billing')">Kaydet</a>
                    </div>
                </div>
            </div>
            @foreach($billing_addresses as $address)
                <div class="address-block">
                    <p class="address-block-address">
                        {{ $address->address }}<br/>
                        {{ $address->district->name }} / {{ $address->city->name }}
                    </p>
                    <div class="address-block-actions">
                        <a class="link" onclick="openModalWithDataID('{{ $address->id }}-delete')">Sil</a>
                        <a class="btn btn-primary" onclick="openModalWithDataID('{{ $address->id }}-update')">Düzenle</a>
                    </div>
                </div>

                <div data-modal-id="{{ $address->id }}-update" class="modal">
                    <div class="modal-content">
                        <div class="modal-content-top">
                            <div class="close-btn" onclick="openModalWithDataID('{{ $address->id }}-update')"></div>
                        </div>
                        <h3>Adresi Düzenle</h3>
                        <div class="form modal-scroll-content">
                            <div class="form-group">
                                <label>Ad</label>
                                <input name="billing-first-name" type="text" value="{{ $address->first_name }}" placeholder="Ad" />
                            </div>
                            <div class="form-group">
                                <label>Soyad</label>
                                <input name="billing-last-name" type="text" value="{{ $address->last_name }}" placeholder="Soyad" />
                            </div>
                            <div class="form-group">
                                <label>Telefon</label>
                                <input name="billing-phone" type="text" value="{{ $address->phone }}" placeholder="0 5xx xxx xx xx" />
                            </div>
                            <div class="form-group">
                                <label>Şehir</label>
                                <select id="shipping-city-select" name="billing-city" class="city-select form-control" required >
                                    @foreach(locations_get_cities() as $city)
                                        @if($city->id == $address->city->id)
                                        <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                        @else
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>İlçe</label>
                                <select id="shipping-district-select" name="billing-district" class="district-select form-control" required >
                                    @foreach(locations_get_districts($address->city->id) as $district)
                                        @if($district->id == $address->district->id)
                                        <option value="{{ $district->id }}" selected>{{ $district->name }}</option>
                                        @else
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Mahalle</label>
                                <select id="shipping-neighborhood-select" name="billing-neighborhood" class="neighborhood-select form-control" required >
                                    @foreach(locations_get_neighborhoods($address->district->id) as $neighborhood)
                                        @if($neighborhood->id == $address->neighborhood->id)
                                        <option value="{{ $neighborhood->id }}" selected>{{ $neighborhood->name }}</option>
                                        @else
                                        <option value="{{ $neighborhood->id }}">{{ $neighborhood->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="form-input-error">
                                    Bu alan zorunludur!
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Adres</label>
                                <textarea name="billing-address" placeholder="Mahalle, sokak, cadde ve diğer bilgiler...">{{ $address->address }}</textarea>
                            </div>
                            <div class="form-group form-group-flex">
                                Fatura Tipi:
                                <label class="input-radio">Bireysel
                                    @if($address->bill_type == 'personal')
                                    <input type="radio" class="billing-address-type-input" name="{{ $address->id }}-billing-type" value="personal" checked>
                                    @else
                                    <input type="radio" class="billing-address-type-input" name="{{ $address->id }}-billing-type" value="personal">
                                    @endif
                                    <span class="input-radio-checkmark"></span>
                                </label>
                                <label class="input-radio">Kurumsal
                                    @if($address->bill_type == 'company')
                                    <input type="radio" class="billing-address-type-input" name="{{ $address->id }}-billing-type" value="company" checked>
                                    @else
                                    <input type="radio" class="billing-address-type-input" name="{{ $address->id }}-billing-type" value="company">
                                    @endif
                                    <span class="input-radio-checkmark"></span>
                                </label>&nbsp;
                            </div>
                            @if($address->bill_type == 'company')
                            <div data-hidden-id="billing-company">
                                <div class="form-group">
                                    <label>Şirket Adı</label>
                                    <input name="billing-company-name" type="text" value="{{ $address->company_name }}" placeholder="Şirket Adı" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Numarası</label>
                                    <input name="billing-tax-number" type="text" value="{{ $address->company_tax_number }}" placeholder="Vergi Numarası" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Dairesi</label>
                                    <input name="billing-tax-administration" type="text" value="{{ $address->company_tax_administration }}" placeholder="Vergi Dairesi" />
                                </div>
                                <div class="form-group">
                                    <label class="input-checkbox">E-fatura mükellefiyim
                                        @if($address->e_bill_user)
                                        <input type="checkbox" name="{{ $address->id }}-e-bill-user" checked>
                                        @else
                                        <input type="checkbox" name="{{ $address->id }}-e-bill-user">
                                        @endif
                                        <span class="input-checkbox-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            @else
                            <div data-hidden-id="billing-company" hidden>
                                <div class="form-group">
                                    <label>Şirket Adı</label>
                                    <input name="billing-company-name" type="text" placeholder="Şirket Adı" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Numarası</label>
                                    <input name="billing-tax-number" type="text" placeholder="Vergi Numarası" />
                                </div>
                                <div class="form-group">
                                    <label>Vergi Dairesi</label>
                                    <input class="billing-tax-administration" type="text" placeholder="Vergi Dairesi" />
                                </div>
                                <div class="form-group">
                                    <label class="input-checkbox">E-fatura mükellefiyim
                                        <input type="checkbox" name="{{ $address->id }}-e-bill-user">
                                        <span class="input-checkbox-checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="modal-content-bottom">
                            <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('{{ $address->id }}-update')">Vazgeç</a>
                            <a class="btn btn-primary btn-small" onclick="updateAddressWithID({{ $address->id }})">Güncelle</a>
                        </div>
                    </div>
                </div>

                <div data-modal-id="{{ $address->id }}-delete" class="modal">
                    <div class="modal-content">
                        <div class="modal-content-top">
                            <div class="close-btn" onclick="openModalWithDataID('{{ $address->id }}-delete')"></div>
                        </div>
                        <p>Adresi silmek istediğinize emin misiniz?</p>
                        <div class="modal-content-bottom">
                            <a class="btn btn-secondary btn-small" onclick="openModalWithDataID('{{ $address->id }}-delete')">Vazgeç</a>
                            <a class="btn btn-primary btn-small" onclick="deleteAddressWithID({{ $address->id }})">Sil</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')

    <script>

        function getCities(inputName) {
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

                    $('select[name="' + inputName + '"]').append(elements);
                    stop_loading();
                }
            });
        }

        function clearDistricts(inputName) {
            $('select[name="' + inputName + '"]').find('option').remove();
            $('select[name="' + inputName + '"]').append('<option value="null" default selected>İlçe seçin</option>');
        }

        function clearNeighborhoods(inputName) {
            $('select[name="' + inputName + '"]').find('option').remove();
            $('select[name="' + inputName + '"]').append('<option value="null" default selected>Mahalle seçin</option>');
        }

        function getDistricts(cityId, inputName) {
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

                    $('select[name="' + inputName +'"]').append(elements);
                    stop_loading();
                }
            });
        }

        function getNeighborhoods(districtId, inputName) {
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

                    $('select[name="' + inputName +'"]').append(elements);
                    stop_loading();
                }
            });
        }
        $(document).ready(function() {
            $("input[name='shipping-same-with-billing']").click(function() {
                if ($(this).prop("checked") == true) {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-info']").show();
                } else {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-info']").hide();
                }
            });

            $("input[name='new-shipping-address-billing-type']").click(function() {
                if ($(this).val() == 'company') {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").show();
                } else {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").hide();
                }
            });

            $("input[name='new-billing-address-billing-type']").click(function() {
                if ($(this).val() == 'company') {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").show();
                } else {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").hide();
                }
            });

            $(".billing-address-type-input").click(function() {
                if ($(this).val() == 'company') {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").show();
                } else {
                    $(this).parent().parent().parent().find("[data-hidden-id='billing-company']").hide();
                }
            });

            $('select[name="shipping-city"]').change(function() {
                clearDistricts("shipping-districts");
                clearNeighborhoods("shipping-neighborhood");
                getDistricts($(this).val(), "shipping-district");
            });

            $('select[name="shipping-district"]').change(function() {
                clearNeighborhoods("shipping-neighborhood");
                getNeighborhoods($(this).val(), "shipping-neighborhood");
            });

            $('select[name="billing-city"]').change(function() {
                clearDistricts("billing-districts");
                clearNeighborhoods("billing-neighborhood");
                getDistricts($(this).val(), "billing-district");
            });

            $('select[name="billing-district"]').change(function() {
                clearNeighborhoods("billing-neighborhood");
                getNeighborhoods($(this).val(), "billing-neighborhood");
            });
        });

        function createAddressWithID(id, type='shipping') {
            run_loading();

            modalElement = $("[data-modal-id=" + id + "]");

            addressData = {
                'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                'phone': modalElement.find("input[name='shipping-phone']").val(),
                'city': {
                    'id': modalElement.find("select[name='shipping-city']").val(),
                    'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                },
                'district': {
                    'id': modalElement.find("select[name='shipping-district']").val(),
                    'name': modalElement.find("select[name='shipping-district'] option:selected").text()
                },
                'neighborhood': {
                    'id': modalElement.find("select[name='shipping-neighborhood']").val(),
                    'name': modalElement.find("select[name='shipping-neighborhood'] option:selected").text()
                },
                'address': modalElement.find("textarea[name='shipping-address']").val(),
                'address_name': modalElement.find("input[name='shipping-address-name']").val(),
            };

            if (type == 'shipping') {

                if (modalElement.find("input[name='shipping-same-with-billing']").prop("checked") == true) {
                    addressData = {
                        'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                        'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                        'phone': modalElement.find("input[name='shipping-phone']").val(),
                        'city': {
                            'id': modalElement.find("select[name='shipping-city']").val(),
                            'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                        },
                        'district': {
                            'id': modalElement.find("select[name='shipping-district']").val(),
                            'name': modalElement.find("select[name='shipping-district'] option:selected").text()
                        },
                        'neighborhood': {
                            'id': modalElement.find("select[name='shipping-neighborhood']").val(),
                            'name': modalElement.find("select[name='shipping-neighborhood'] option:selected").text()
                        },
                        'address': modalElement.find("textarea[name='shipping-address']").val(),
                        'address_name': modalElement.find("input[name='shipping-address-name']").val(),
                        'bill_type': 'personal',
                        'create_bill_shipping': true
                    };

                    if (modalElement.find("input[name='new-shipping-address-billing-type']").val() == 'company') {
                        addressData = {
                            'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                            'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                            'phone': modalElement.find("input[name='shipping-phone']").val(),
                            'city': {
                                'id': modalElement.find("select[name='shipping-city']").val(),
                                'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                            },
                            'district': {
                                'id': modalElement.find("select[name='shipping-district']").val(),
                                'name': modalElement.find("select[name='shipping-district'] option:selected").text()
                            },
                            'neighborhood': {
                                'id': modalElement.find("select[name='shipping-neighborhood']").val(),
                                'name': modalElement.find("select[name='shipping-neighborhood'] option:selected").text()
                            },
                            'address': modalElement.find("textarea[name='shipping-address']").val(),
                            'address_name': modalElement.find("input[name='shipping-address-name']").val(),
                            'bill_type': 'company',
                            'company_name': modalElement.find("input[name='billing-company-name']").val(),
                            'company_tax_number': modalElement.find("input[name='billing-tax-number']").val(),
                            'company_tax_administration': modalElement.find("input[name='billing-tax-administration']").val(),
                            'e_bill_user': modalElement.find("input[name='e-bill-user']").prop("checked"),
                            'create_bill_shipping': true
                        };
                    }
                }

            } else if (type == 'billing') {

                addressData = {
                    'first_name': modalElement.find("input[name='billing-first-name']").val(),
                    'last_name': modalElement.find("input[name='billing-last-name']").val(),
                    'phone': modalElement.find("input[name='billing-phone']").val(),
                    'city': {
                        'id': modalElement.find("select[name='billing-city']").val(),
                        'name': modalElement.find("select[name='billing-city'] option:selected").text()
                    },
                    'district': {
                        'id': modalElement.find("select[name='billing-district']").val(),
                        'name': modalElement.find("select[name='billing-district'] option:selected").text()
                    },
                    'neighborhood': {
                        'id': modalElement.find("select[name='billing-neighborhood']").val(),
                        'name': modalElement.find("select[name='billing-neighborhood'] option:selected").text()
                    },
                    'address': modalElement.find("textarea[name='billing-address']").val(),
                    'address_name': modalElement.find("input[name='billing-address-name']").val(),
                    'bill_type': 'personal'
                };

                if (modalElement.find("input[name='new-billing-address-billing-type']").val() == 'company') {
                    addressData = {
                        'first_name': modalElement.find("input[name='billing-first-name']").val(),
                        'last_name': modalElement.find("input[name='billing-last-name']").val(),
                        'phone': modalElement.find("input[name='billing-phone']").val(),
                        'city': {
                            'id': modalElement.find("select[name='billing-city']").val(),
                            'name': modalElement.find("select[name='billing-city'] option:selected").text()
                        },
                        'district': {
                            'id': modalElement.find("select[name='billing-district']").val(),
                            'name': modalElement.find("select[name='billing-district'] option:selected").text()
                        },
                        'neighborhood': {
                            'id': modalElement.find("select[name='billing-neighborhood']").val(),
                            'name': modalElement.find("select[name='billing-neighborhood'] option:selected").text()
                        },
                        'address': modalElement.find("textarea[name='billing-address']").val(),
                        'address_name': modalElement.find("input[name='billing-address-name']").val(),
                        'bill_type': 'company',
                        'company_name': modalElement.find("input[name='billing-company-name']").val(),
                        'company_tax_number': modalElement.find("input[name='billing-tax-number']").val(),
                        'company_tax_administration': modalElement.find("input[name='billing-tax-administration']").val(),
                        'e_bill_user': modalElement.find("input[name='e-bill-user']").prop("checked")
                    };
                }

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.addresses.create') }}",
                method: 'post',
                data: {
                    address_data: addressData,
                },
                success: function(result) {
                    location.reload();
                }
            });
        }

        function updateAddressWithID(id) {
            run_loading();

            modalElement = $("[data-modal-id='" + id + "-update']");

            addressData = {
                'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                'phone': modalElement.find("input[name='shipping-phone']").val(),
                'city': {
                    'id': modalElement.find("select[name='shipping-city']").val(),
                    'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                },
                'district': {
                    'id': modalElement.find("input[name='shipping-district']").val(),
                    'name': modalElement.find("input[name='shipping-district'] option:selected").text()
                },
                'neighborhood': {
                    'id': modalElement.find("input[name='shipping-neighborhood']").val(),
                    'name': modalElement.find("input[name='shipping-neighborhood'] option:selected").text()
                },
                'address': modalElement.find("textarea[name='shipping-address']").val(),
                'address_name': modalElement.find("input[name='shipping-address-name']").val(),
            };

            if (modalElement.find("input[name='" + id + "-billing-type']").val() == 'company') {
                addressData = {
                    'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                    'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                    'phone': modalElement.find("input[name='shipping-phone']").val(),
                    'city': {
                        'id': modalElement.find("select[name='shipping-city']").val(),
                        'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                    },
                    'district': {
                        'id': modalElement.find("input[name='shipping-district']").val(),
                        'name': modalElement.find("input[name='shipping-district'] option:selected").text()
                    },
                    'neighborhood': {
                        'id': modalElement.find("input[name='shipping-neighborhood']").val(),
                        'name': modalElement.find("input[name='shipping-neighborhood'] option:selected").text()
                    },
                    'address': modalElement.find("textarea[name='shipping-address']").val(),
                    'address_name': modalElement.find("input[name='shipping-address-name']").val(),
                    'bill_type': 'company',
                    'company_name': modalElement.find("input[name='billing-company-name']").val(),
                    'company_tax_number': modalElement.find("input[name='billing-tax-number']").val(),
                    'company_tax_administration': modalElement.find("input[name='billing-tax-administration']").val(),
                    'e_bill_user': modalElement.find("input[name='" + id + "-e-bill-user']").prop("checked")
                };
            } else {
                addressData = {
                    'first_name': modalElement.find("input[name='shipping-first-name']").val(),
                    'last_name': modalElement.find("input[name='shipping-last-name']").val(),
                    'phone': modalElement.find("input[name='shipping-phone']").val(),
                    'city': {
                        'id': modalElement.find("select[name='shipping-city']").val(),
                        'name': modalElement.find("select[name='shipping-city'] option:selected").text()
                    },
                    'district': {
                        'id': modalElement.find("input[name='shipping-district']").val(),
                        'name': modalElement.find("input[name='shipping-district'] option:selected").text()
                    },
                    'neighborhood': {
                        'id': modalElement.find("input[name='shipping-neighborhood']").val(),
                        'name': modalElement.find("input[name='shipping-neighborhood'] option:selected").text()
                    },
                    'address': modalElement.find("textarea[name='shipping-address']").val(),
                    'address_name': modalElement.find("input[name='shipping-address-name']").val(),
                    'bill_type': 'personal'
                };
            }

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
            });

            $.ajax({
                url: "{{ route('store.addresses.update') }}",
                method: 'post',
                data: {
                    id: id,
                    address_data: addressData,
                },
                success: function(result) {
                    openModalWithDataID(id + '-update');
                    location.reload();
                }
            });
        }

        function deleteAddressWithID(id) {
            run_loading();
            openModalWithDataID(id + '-delete');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.addresses.delete') }}",
                method: 'post',
                data: {
                    id: id,
                },
                success: function(result) {
                    stop_loading();
                    location.reload();
                }
            });
        }
    </script>

@endsection
