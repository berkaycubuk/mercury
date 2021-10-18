@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.account') }}">Hesabım</a></li>
        <li class="active">Siparişlerim</li>
    </ul>
</div>

<section class="account-page container">
    @include('core::partials.auth-sidebar')
    <div class="account-page-content">
        <h2>Siparişlerim</h2>

        @if(count($orders) == 0)
            <p>Siparişiniz bulunmuyor...</p>
        @else
        <table class="account-orders">
            <thead>
                <tr>
                    <td>Tarih</td>
                    <td>Sipariş No</td>
                    <td>Durum</td>
                    <td>Fiyat</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>
                        {{ $order->created_at->format('d.m.Y') }}
                    </td>
                    <td>
                        #{{ $order->meta['code'] }}
                    </td>
                    <td>
                        {{ $order->state_text }}
                    </td>
                    <td>
                        {{ format_money($order->meta['total_price']) }}
                    </td>
                    <td>
                        <a href="{{ route('store.orders.details', ['code' => $order->meta['code']]) }}" class="btn btn-small btn-secondary">Detaylar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</section>

@endsection
