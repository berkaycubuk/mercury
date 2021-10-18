@extends('core::layouts.store')

@section('content')

<section class="auth-form">
    <h2>Giriş Yap</h2>
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
    @if (isset($errors) && count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <form action="{{ route('store.auth.login') }}" method="POST">
        @csrf
        <input class="input" type="email" name="email" placeholder="E-posta" required />
        <input class="input" type="password" name="password" placeholder="Şifre" required />
        <label class="input-checkbox">Beni hatırla
            <input type="checkbox" name="remember">
            <span class="input-checkbox-checkmark"></span>
        </label>
        <button class="btn btn-primary">Giriş Yap</button>
    </form>

    <a style="font-weight: bold" href="{{ route('password.request') }}">Şifremi Unuttum</a>
    <a href="{{ route('store.register') }}">Hesabınız yok mu? <b>Üye Olun</b></a>
</section>

@endsection
