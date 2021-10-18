@extends('core::layouts.store')

@section('content')

<section class="contact container">
    <h1>İletişime Geçin</h1>

    <div class="contact-addresses">
        <h2>Şubelerimiz</h2>
        <div class="branches-slider">
            @foreach(get_settings('branches') as $branch)
            <div class="branch-slide">
                <iframe class="branch-slide-image" class="contact-address-map" src="{{ $branch->embed_url}}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                <div class="branch-slide-content">
                    <div class="branch-slide-content-top">
                        <h3>{{ $branch->name }}</h3>
                        <p>{{ $branch->address}}</p>
                        <div>{{ $branch->phone }}</div>
                    </div>
                    <div class="branch-slide-content-actions">
                        <a href="{{ $branch->map_url }}" class="btn btn-primary">Yol Tarifi Al</a>
                        <a href="tel:{{ $branch->phone }}" class="btn btn-primary">İletişime Geç</a>
                    </div>
                </div>
            </div><br/>
            @endforeach
        </div>
    </div>

    <div class="contact-form">
        <h2>İletişim Formu</h2>

        @if (session('form_success'))
            <br />
            <div class="alert alert-success">
                {{ session('form_success') }}
            </div>
        @endif

        <form class="form" action="{{ route('store.contact.submit') }}" method="post">
            @csrf
            @guest
            <div class="form-row">
                <div class="form-group">
                    <label>Adınız</label>
                    <input type="text" name="full_name" required />
                </div>
                <div class="form-group">
                    <label>Telefon Numaranız</label>
                    <input type="tel" name="phone" required />
                </div>
            </div>
            <div class="form-group">
                <label>Mesajınız</label>
                <textarea name="message" required></textarea>
            </div>
            @endguest
            <div class="form-group">
                <label>Mesajınız</label>
                <textarea name="message" placeholder="İletmek istediğiniz mesajınızı yazınız." required></textarea>
            </div>
            <div style="flex-direction: column; align-items: flex-start;" class="auth-form__captcha">
                <img style="margin-bottom: 10px" src="{{ captcha_src('flat') }}" />
                <input type="text" name="captcha" placeholder="Güvenlik Kodu" />
            </div>
            <button class="btn btn-primary">Gönder</button>
        </form>
    </div>
</section>

@endsection
