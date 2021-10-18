@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Sipariş Detayları <span class="badge badge-primary">#{{ $order->meta['code'] }}</span></h2>
                <p class="ml-auto">Sipariş tarihi: {{ $order->translated_created_at }}</p>
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
                <form action="{{ route('panel.orders.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="order-id" name="id" value="{{ $order->id }}">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans_choice('general.products', 1) }}</th>
                                <th>{{ trans('general.price') }}</th>
                                <th>{{ trans('general.amount') }}</th>
                                <th>{{ trans('general.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->meta['items'] as $item)
                                <tr>
                                    <td>#{{ $item['id'] }} {{ $item['title'] }}</td>
                                    <td>{{ format_money($item['price']) }}</td>
                                    <td>{{ $item['amount'] }}</td>
                                    <td>{{ format_money($item['price'] * $item['amount']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <label class="col-sm-2">Kargo Yöntemi:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_provider_name'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Kargo Ücreti:</label>
                        <p class="col-sm-10">{{ format_money($order->meta['shipping_cost']) }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Toplam Tutar:</label>
                        <p class="col-sm-10">{{ format_money($order->meta['total_price']) }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Durum:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="state" id="order-state">
                                @if($order->state == 0)
                                <option value="0" selected>Beklemede</option>
                                @else
                                <option value="0">Beklemede</option>
                                @endif
                                @if($order->state == 1)
                                <option value="1" selected>Tamamlandı</option>
                                @else
                                <option value="1">Tamamlandı</option>
                                @endif
                                @if($order->state == 2)
                                <option value="2" selected>Ödeme Yapılmadı</option>
                                @else
                                <option value="2">Ödeme Yapılmadı</option>
                                @endif
                                @if($order->state == 3)
                                <option value="3" selected>İptal Edildi</option>
                                @else
                                <option value="3">İptal Edildi</option>
                                @endif
                                @if($order->state == 4)
                                <option value="4" selected>Onaylandı</option>
                                @else
                                <option value="4">Onaylandı</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div id="order-confirmer-branch-block" class="form-group row">
                        <label class="col-sm-2" for="order-confirmer-branch">Onaylayan Şube:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="confirmer-branch" id="order-confirmer-branch">
                                @if(!isset($order->meta['confirmer_branch']))
                                <option disabled selected>Bir Şube Seçiniz</option>
                                @endif
                                @foreach(get_settings('branches') as $branch)
                                    @if(isset($order->meta['confirmer_branch']) && $order->meta['confirmer_branch'] == $branch->id)
                                    <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                    @else
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <h4>Teslimat Bilgileri</h4><br />
                    <div class="form-group row">
                        <label class="col-sm-2">Ad Soyad:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['first_name'] }} {{ $order->meta['shipping_address']['last_name'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Telefon:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['phone'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Şehir:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['city']['name'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">İlçe:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['district']['name'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Mahalle:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['neighborhood']['name'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Adres:</label>
                        <p class="col-sm-10">{{ $order->meta['shipping_address']['address'] }}</p>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Sipariş notu:</label>
                        <p class="col-sm-10">
                        @if($order->meta['note'] != null)
                            {{ $order->meta['note'] }}
                        @else
                            <i>Sipariş notu eklenmemiş.</i>
                        @endif
                        </p>
                    </div>

                    <button
                        class="btn btn-primary"
                    >{{ trans('general.save') }}</button>
                    <a
                        class="btn btn-secondary"
                        href="{{ route('panel.orders.index') }}"
                    >{{ trans('general.back') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            if ($("#order-state").val() != 4) {
                $("#order-confirmer-branch-block").hide();
            }

            $("#order-state").change(function() {
                if ($(this).val() == 4) {
                    $("#order-confirmer-branch-block").show();
                } else {
                    $("#order-confirmer-branch-block").hide();
                }
            });
        });
    </script>
@endsection
