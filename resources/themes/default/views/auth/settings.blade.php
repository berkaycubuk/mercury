@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.account') }}">Hesabım</a></li>
        <li class="active">Ayarlar</li>
    </ul>
</div>

<section class="account-page container">
    @include('core::partials.auth-sidebar')
    <div class="account-page-content">
        <h2>Ayarlar</h2>
        <br />
        <h3>Üyelik Bilgileri</h3>
        <form class="form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Ad</label>
                    <input type="text" name="first_name" placeholder="Ad" value="{{ Auth::user()->first_name }}" />
                </div>
                <div class="form-group">
                    <label>Soyad</label>
                    <input type="text" name="last_name" placeholder="Soyad" value="{{ Auth::user()->last_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label>E-posta</label>
                <input type="text" name="email" placeholder="E-posta" value="{{ Auth::user()->email }}" disabled />
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input type="tel" name="phone" placeholder="Telefon" value="{{ Auth::user()->phone }}" disabled />
            </div>
            <button onclick="updateSettings(event)" class="btn btn-primary btn-small">Kaydet</button>
        </form>

        <h3>Şifre Değişikliği</h3>
        <form id="password-change" class="form">
            @csrf
            <div class="form-group">
                <label>Mevcut Şifre</label>
                <input type="password" name="current_password" placeholder="Mevcut Şifre" />
            </div>
            <div class="form-group">
                <label>Yeni Şifre</label>
                <input type="password" name="new_password" placeholder="Yeni Şifre" />
            </div>
            <div class="form-group">
                <label>Yeni Şifre (Tekrar)</label>
                <input type="password" name="new_password_repeat" placeholder="Yeni Şifre (Tekrar)" />
            </div>
            <button onclick="updatePassword(event)" class="btn btn-primary btn-small">Kaydet</button>
            <div class="modal">
                <div class="modal-content">
                    <div class="modal-content-top">
                        <div class="close-btn" onclick="location.reload()"></div>
                    </div>
                    <p>Şifreniz başarıyla değiştirildi!</p>
                    <div class="modal-content-bottom">
                        <a class="btn btn-secondary btn-small" onclick="location.reload()">Tamam</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('scripts')

    <script>
        cartModal = new Modal('.modal');

        function updatePassword(e) {
            e.preventDefault();

            run_loading();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
            });

            $.ajax({
                url: "{{ route('store.settings.update-password') }}",
                method: 'post',
                data: {
                    current_password: $("input[name='current_password']").val(),
                    new_password: $("input[name='new_password']").val(),
                    new_password_repeat: $("input[name='new_password_repeat']").val(),
                },
                success: function(result) {
                    stop_loading();
                    cartModal.open();
                },
                error: function(result) {
                    stop_loading();

                    alert_element = '<div class="alert alert-danger">';
                    alert_element += result.responseJSON.message;
                    alert_element += '</div><br />';

                    $('#password-change').prepend(alert_element);
                }
            });
        }

        function updateSettings(e) {
            e.preventDefault();

            run_loading();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
            });

            $.ajax({
                url: "{{ route('store.settings.update') }}",
                method: 'post',
                data: {
                    first_name: $("input[name='first_name']").val(),
                    last_name: $("input[name='last_name']").val(),
                },
                success: function(result) {
                    stop_loading();
                    location.reload();
                }
            });
        }
    </script>

@endsection
