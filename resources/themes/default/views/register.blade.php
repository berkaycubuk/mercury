@extends('core::layouts.store')

@section('content')

<section class="auth-form">
    <h2>Üye Ol</h2>
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
    <form action="{{ route('store.auth.register') }}" method="POST">
        @csrf
        <input class="input" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ad" required />
        <input class="input" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Soyad" required />
        <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="E-posta" required />
        <input class="input" type="password" name="password" placeholder="Şifre" required/>
        <div class="auth-form__captcha">
            <img src="{{ captcha_src('flat') }}" />
            <input type="text" name="captcha" placeholder="Güvenlik Kodu" />
        </div>
        <div style="color: var(--color-black);">
            <label class="input-checkbox">
                <input type="checkbox" name="accept-rules">
                <span class="input-checkbox-checkmark"></span>
            </label>
            <a style="cursor: pointer;" onclick="rulesModal.open()">Üyelik Sözleşmesini</a>
            ve
            <a style="cursor: pointer;" onclick="kvkkModal.open()">KVKK aydınlatma metnini</a> okudum, kabul ediyorum.
            <br/><br/>
        </div>
        <label class="input-checkbox">Fırsatlar ve İndirimler hakkında e-posta ve sms almak istiyorum.
            <input type="checkbox" name="accept-notifications">
            <span class="input-checkbox-checkmark"></span>
        </label>
        <button class="btn btn-primary">Üye Ol</button>
    </form>

    <a href="/giris">Hesabınız var mı? <b>Giriş Yapın</b></a>
</section>

<div class="modal" id="uyelik-modal">
    <div class="modal-content">
        <div class="modal-content-top">
            <div class="close-btn" onclick="rulesModal.close()"></div>
        </div>
        <h2>Üyelik Sözleşmesi</h2>
        <div class="modal-scroll-content">
            {!! $uyelik !!}
        </div>
    </div>
</div>

<div class="modal" id="kvkk-modal">
    <div class="modal-content">
        <div class="modal-content-top">
            <div class="close-btn" onclick="kvkkModal.close()"></div>
        </div>
        <h2>KVKK Aydınlatma Metni</h2>
        <div class="modal-scroll-content">
            {!! $kvkk !!}
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        var rulesModal = new Modal('#uyelik-modal');
        var kvkkModal = new Modal('#kvkk-modal');
    </script>
@endsection
