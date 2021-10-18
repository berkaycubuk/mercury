@extends('core::layouts.store')

@section('content')

<section class="auth-form">
    <h2>Şifre Yenile</h2>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
        <input class="input" type="email" name="email" placeholder="E-posta" required />
        <input class="input" type="password" name="password" placeholder="Şifre" required />
        <input class="input" type="password" name="password_confirmation" placeholder="Şifre Tekrarı" required />
        <button class="btn btn-primary">Güncelle</button>
    </form>

    <a href="{{ route('store.register') }}">Hesabınız yok mu? <b>Üye Olun</b></a>
</section>

@endsection
