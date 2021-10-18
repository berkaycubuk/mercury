@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Yeni Teslimat Yöntemi</h2>
            </div>
            <div class="card-body">
                @if (session('form_error'))
                    <div class="alert alert-danger">
                        {{ session('form_error') }}
                    </div>
                @endif
                @if (session('form_success'))
                    <div class="alert alert-success">
                        {{ session('form_success') }}
                    </div>
                @endif
                <form action="{{ route('panel.settings.shipment.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="shipment-name">Teslimat Yöntemi</label>
                        <input type="text" class="form-control" id="shipment-name" name="name" placeholder="Ör: Kurye, PTT Kargo, ..." required>
                    </div>
                    <div class="form-group">
                        <label class="control control-checkbox">Her şehir ve mahalle için geçerli
                            <input type="checkbox" name="all-locations" />
                            <div class="control-indicator"></div>
                        </label>
                    </div>
                    <div id="shipment-cities" class="form-group">
                        <input type="hidden" name="locations-json" />
                        <h4>Geçerli Yerler</h4><br />
                        <label>Şehir</label>
                        <select id="shipment-city" class="form-control" name="location-city">
                            <option value="null" selected>Şehir Seçiniz</option>
                        </select><br />
                        <label>İlçe</label>
                        <select id="shipment-district" class="form-control" name="location-district">
                            <option value="null" selected>İlçe Seçiniz</option>
                        </select><br />
                        <label>Mahalle/Mahalleler</label>
                        <select id="multiple-select-attribute-neighborhoods" class="js-example-basic-multiple form-control" name="location-neighborhoods[]" multiple="multiple">
                        </select><br /><br />
                        <label for="shipment-price">Teslimat Ücreti</label>
                        <input type="number" class="form-control" id="shipment-price" name="location-price"><br />
                        <button class="btn btn-primary" onclick="addNewLocation(event)">Ekle</button><br /><br />
                        <h5>Eklenmiş yerler</h5>
                        <div id="shipment-saved-locations">
                        </div>
                    </div>
                    <div id="shipment-price-group" class="form-group">
                        <label>Teslimat Ücreti</label>
                        <input type="number" class="form-control" id="shipment-price-all" name="location-price-all">
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a href="{{ route('panel.settings.shipment') }}" class="btn btn-secondary btn-default">Geri Dön</a><br/><br/>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script>
        function syncLocationsInput() {
            var data = [];

            $("#shipment-saved-locations").find('.shipment-location-block').each(function() {
                var location = {
                    id: '',
                    city: {
                        id: 0,
                        name: ''
                    },
                    district: {
                        id: 0,
                        name: ''
                    },
                    neighborhood: [],
                    price: 0
                };

                $(this).find('div').each(function(index) {
                    if (index == 0) {
                        location.city = {
                            id: $(this).data('id'),
                            name: $(this).data('name')
                        };
                    } else if (index == 1) {
                        location.district = {
                            id: $(this).data('id'),
                            name: $(this).data('name')
                        };
                    } else if (index == 2) {
                        var neighborhood = [];
                        $(this).find('span').each(function() {
                            neighborhood.push({
                                id: $(this).data('id'),
                                name: $(this).data('name')
                            });
                        });
                        location.neighborhood = neighborhood;
                    } else if (index == 3) {
                        var price = $(this).data('value');
                        location.price = price;
                    }
                });

                location.id = Math.floor(Math.random() * 1000) + location.city.toString() + location.district.toString();

                data.push(location);
            });

            console.log(JSON.stringify(data));

            $("input[name='locations-json']").val(JSON.stringify(data));
        }

        function removeLocation(event) {
            $(event.target).parent().remove();
            syncLocationsInput();
        }

        function addNewLocation(event) {
            event.preventDefault();

            var city = {
                id: $("#shipment-city").val(),
                name: $("#shipment-city option:selected").text()
            };

            if (city.id == 'null') {
                return;
            }

            var district = {
                id: $("#shipment-district").val(),
                name: $("#shipment-district option:selected").text()
            };

            if (district.id == 'null') {
                return;
            }

            var neighborhoods = $("#multiple-select-attribute-neighborhoods").select2('data');

            if (neighborhoods.length == 0) {
                return;
            }

            var price = $("#shipment-price").val();

            if (!price) {
                return;
            }

            var element = '<div class="my-2 p-2 border shipment-location-block">';
            element += '<div data-type="city" data-id="' + city.id + '" data-name="' + city.name + '">Şehir: ' + city.name + '</div>';
            element += '<div data-type="district" data-id="' + district.id + '" data-name="' + district.name + '">İlçe: ' + district.name + '</div>';
            element += '<div data-type="neighborhood">Mahalle:';
            for (var i = 0; i < neighborhoods.length; i++) {
                if ((neighborhoods.length - 1) == i) {
                    element += '<span data-id="' + neighborhoods[i].id + '" data-name="' + neighborhoods[i].text + '">';
                    element += neighborhoods[i].text;
                    element += '</span>';
                } else {
                    element += '<span data-id="' + neighborhoods[i].id + '" data-name="' + neighborhoods[i].text + '">';
                    element += neighborhoods[i].text + ', ';
                    element += '</span>';
                }
            }
            element += '</div>';
            element += '<div data-type="price" data-value="' + price + '">Ücret: ' + price + ' TL</div><br />';
            element += '<button class="btn btn-danger btn-sm" onclick="removeLocation(event)">Sil</button>';
            element += '</div>';

            // clear city
            $("#shipment-city option:selected").removeAttr('selected');
            $("#shipment-city option[value='null']").prop('selected', true);

            // clear district
            $("#shipment-district option:selected").removeAttr('selected');
            $("#shipment-district option[value='null']").prop('selected', true);

            // clear neighborhood
            $("#multiple-select-attribute-neighborhoods").val(null).trigger('change');

            // clear price
            $("#shipment-price").val("");

            $("#shipment-saved-locations").append(element);
            syncLocationsInput();
        }

        function loadCities() {
            panelLoadingOpen();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('store.locations.cities') }}",
                method: 'get',
                success: function(result) {
                    for (var i = 0; i < result.data.length; i++) {
                        var element = '<option value="' + result.data[i].id + '">';
                        element += result.data[i].name;
                        element += '</option>';

                        $("#shipment-city").append(element);
                    }

                    panelLoadingClose();
                }
            });
        }

        $(document).ready(function() {
            // load all the cities
            loadCities();
            $('#shipment-price-group').hide();

            $("input[name='all-locations']").click(function() {
                if ($(this).prop('checked')) {
                    $('#shipment-cities').hide();
                    $('#shipment-price-group').show();
                } else {
                    $('#shipment-cities').show();
                    $('#shipment-price-group').hide();
                }
            });

            // get districts for the city
            $("#shipment-city").change(function() {
                panelLoadingOpen();

                // remove old districts
                $("#shipment-district").empty();
                $("#shipment-district").append('<option value="null" selected>İlçe Seçiniz</option>');

                // remove old neighborhoods
                $("#multiple-select-attribute-neighborhoods").text('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.locations.districts') }}",
                    method: 'get',
                    data: {
                        city_id: $(this).val()
                    },
                    success: function(result) {
                        for (var i = 0; i < result.data.length; i++) {
                            var element = '<option value="' + result.data[i].id + '">';
                            element += result.data[i].name;
                            element += '</option>';

                            $("#shipment-district").append(element);
                        }

                        panelLoadingClose();
                    }
                });
            });

            // get neighborhoods for the district
            $("#shipment-district").change(function() {
                panelLoadingOpen();

                // remove old neighborhoods
                $("#multiple-select-attribute-neighborhoods").text('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('store.locations.neighborhoods') }}",
                    method: 'get',
                    data: {
                        district_id: $(this).val()
                    },
                    success: function(result) {
                        for (var i = 0; i < result.data.length; i++) {
                            var element = '<option value="' + result.data[i].id + '">';
                            element += result.data[i].name;
                            element += '</option>';

                            $("#multiple-select-attribute-neighborhoods").append(element);
                        }

                        panelLoadingClose();
                    }
                });
            });
        });
    </script>

@endsection
