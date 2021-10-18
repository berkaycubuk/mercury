@extends('core::layouts.store')

@section('content')

<section class="page404 container">
    <img style="width: 150px;" src="{{ asset('assets/store/img/check-circle.svg') }}" />
    <br />
    <br />
    <br />
    <br />
    <h1>Siparişiniz başarıyla alındı!</h1>
    <p>
        Siparişiniz onaylanmak üzere iletildi.<br/>
        En kısa sürede onaylandığına dair size e-posta gönderilecektir.
    </p>
    <div class="page404__actions">
        <a href="{{ route('store.index') }}"><i></i>Anasayfaya git</a>
        <a href="{{ route('store.order-online') }}">Online sipariş ver</a>
    </div>
</section>

@endsection
