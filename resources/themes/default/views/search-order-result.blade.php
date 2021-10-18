@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.track-orders.search') }}">Sipariş Takibi</a></li>
        <li class="active">{{ $order->meta['code'] }}</li>
    </ul>
</div>

<section class="page container">
    <h1>Sipariş Detayları</h1><br/>

    <h2>Ürünler</h2>
    <table class="table">
        <tbody>
            @foreach($order->meta['items'] as $item)
            <tr>
                <td><a href="{{ route('store.product', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a></td>
                <td align="center">{{ $item['amount'] }} Adet</td>
                <td align="center">{{ number_format($item['price'], 2, ",", ".") }} TL</td>
            </tr>
            @endforeach
            <tr style="border: none">
                <td></td>
                <td align="center">KDV (%18)</td>
                <td align="center">20,00 TL</td>
            </tr>
            <tr style="border: none">
                <td></td>
                <td align="center">Kargo</td>
                <td align="center">20,00 TL</td>
            </tr>
            <tr style="border: none">
                <td></td>
                <td align="center">Toplam</td>
                <td align="center">{{ number_format($order->meta['total_price'], 2, ",", ".") }} TL</td>
            </tr>
        </tbody>
    </table><br/>

    <h2>Teslimat Adresi</h2>
    <h3>Teslimat Adresi</h3>

    <p style="line-height: 1.6; font-size: 0.95rem;">
        {{ $order->meta['shipping_address']['address'] }} <br />
        {{ $order->meta['shipping_address']['neighborhood'] }} /
        {{ $order->meta['shipping_address']['district'] }} /
        {{ $order->meta['shipping_address']['city'] }} <br/>
        <b>
            {{ $order->meta['shipping_address']['first_name'] }}
            {{ $order->meta['shipping_address']['last_name'] }}
            {{ $order->meta['shipping_address']['phone'] }}
        </b>
    </p><br />

    <h3>Fatura Adresi</h3>

    <p style="line-height: 1.6; font-size: 0.95rem;">
        {{ $order->meta['shipping_address']['address'] }} <br />
        {{ $order->meta['shipping_address']['neighborhood'] }} /
        {{ $order->meta['shipping_address']['district'] }} /
        {{ $order->meta['shipping_address']['city'] }} <br/>
        <b>
            {{ $order->meta['shipping_address']['first_name'] }}
            {{ $order->meta['shipping_address']['last_name'] }}
            {{ $order->meta['shipping_address']['phone'] }}
        </b>
    </p><br />
</section>

@endsection
