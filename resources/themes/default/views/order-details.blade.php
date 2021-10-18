@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.account') }}">Hesabım</a></li>
        <li><a href="{{ route('store.orders') }}">Siparişlerim</a></li>
        <li class="active">{{ $order->meta['code'] }}</li>
    </ul>
</div>

<section class="account-page container">
    @include('core::partials.auth-sidebar')
    <div class="account-page-content">
        <h2>Sipariş Detayları</h2><br />

        <h3>Teslimat Adresi</h3>

        <p style="line-height: 1.6; font-size: 0.95rem;">
            {{ $order->meta['shipping_address']['address'] }} <br />
            {{ $order->meta['shipping_address']['neighborhood']['name'] }} /
            {{ $order->meta['shipping_address']['district']['name'] }} /
            {{ $order->meta['shipping_address']['city']['name'] }} <br/>
            <b>
                {{ $order->meta['shipping_address']['first_name'] }}
                {{ $order->meta['shipping_address']['last_name'] }}
                {{ $order->meta['shipping_address']['phone'] }}
            </b>
        </p><br />

        <h3>Fatura Adresi</h3>

        <p style="line-height: 1.6; font-size: 0.95rem;">
            {{ $order->meta['shipping_address']['address'] }} <br />
            {{ $order->meta['shipping_address']['neighborhood']['name'] }} /
            {{ $order->meta['shipping_address']['district']['name'] }} /
            {{ $order->meta['shipping_address']['city']['name'] }} <br/>
            <b>
                {{ $order->meta['shipping_address']['first_name'] }}
                {{ $order->meta['shipping_address']['last_name'] }}
                {{ $order->meta['shipping_address']['phone'] }}
            </b>
        </p><br />

        <h3>Ürünler</h3>

        <table class="table">
            <tbody>
                @foreach($order->meta['items'] as $item)
                <tr>
                    <td>
                        <a href="{{ route('store.product', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a>
                    </td>
                    <td>
                        {{ $item['amount'] }} Adet
                    </td>
                    <td>
                        {{ format_money($item['price']) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: none">
                        Sipariş Tutarı
                    </td>
                    <td></td>
                    <td>
                        {{ format_money($order->meta['total_price']) }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none">
                        Kargo
                    </td>
                    <td></td>
                    <td>
                        {{ format_money($order->meta['shipping_cost']) }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none">
                        TOPLAM
                    </td>
                    <td></td>
                    <td>
                        {{ format_money($order->meta['total_price'] + $order->meta['shipping_cost']) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@endsection
