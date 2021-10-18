@extends('core::layouts.store')

@section('content')

<section class="page404 container">
    <img style="width: 150px;" src="{{ asset('assets/store/img/x-circle.svg') }}" />
    <br />
    <br />
    <br />
    <br />
    <h1>Siparişiniz alınamadı!</h1>
    <p>
        Siparişiniz işlenirken bir sorunla karşılaşıldı. <br/>
        Yaşadığınız bu durum için özür dileriz. Lütfen daha sonra tekrar deneyiniz.
    </p>
    <div class="page404__actions">
        <a href="{{ route('store.index') }}"><i></i>Anasayfaya git</a>
        <a href="{{ route('store.contact.index') }}">İletişime geç</a>
    </div>
</section>

@endsection
