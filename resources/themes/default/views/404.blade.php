@extends('core::layouts.store')

@section('content')

<section class="page404 container">
    <h1>Aradığınız sayfa bulunamadı!</h1>
    <p>Sayfa kaldırılmış veya değiştirilmiş olabilir.</p>
    <div class="page404__actions">
        <a href="{{ route('store.index') }}"><i></i>Anasayfaya git</a>
        <a href="{{ route('store.order-online') }}">Online sipariş ver</a>
    </div>
</section>

@endsection
