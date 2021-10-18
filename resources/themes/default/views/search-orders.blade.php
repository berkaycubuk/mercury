@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><img src="{{ asset('assets/store/img/chevron.svg') }}" /></li>
        <li class="active">Sipariş Takibi</li>
    </ul>
</div>

<section class="page container">
    <h1>Sipariş Takibi</h1>

    @if (session('form_error'))
        <div class="alert alert-danger">
            {{ session('form_error') }}
        </div>
    @endif
    <form class="form" action="{{ route('store.track-orders.query') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Sipariş Kodunuz</label>
            <input type="text" name="order-code" placeholder="Sipariş kodunuzu giriniz..." required />
        </div>
        <button class="btn btn-primary">Gönder</button>
    </form>
</section>

@endsection
