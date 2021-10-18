@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li class="active">Hesabım</li>
    </ul>
</div>

<section class="agreements container">
    <h1>Hesabım</h1>
    <p>Hesabınız ile ilgili yapabileceğiniz işlemler:</p>

    <div class="agreements-navigation">
        <a href="{{ route('store.addresses.index') }}">Adreslerim</a>
        <a href="{{ route('store.orders') }}">Siparişlerim</a>
        <a href="{{ route('store.settings.index') }}">Ayarlar</a>
        @can('access-panel')
        <a href="{{ route('panel.homepage.index') }}">
            Yönetim Paneli
        </a>
        @endcan
    </div>
</section>

@endsection
