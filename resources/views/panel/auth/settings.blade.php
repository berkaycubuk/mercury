@extends('panel::layouts.panel')

@section('content')

<div class="card card-default">
    <div class="card-header card-header-border-bottom">
        <h2>Hesap Ayarları</h2>
    </div>
    <div class="card-body">
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
        <form action="{{ route('panel.auth.settings.update') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="@error('first-name') text-danger @enderror" for="first-name">Ad</label>
                    <input type="text" class="form-control @error('first-name') is-invalid @enderror" id="first-name" name="first-name" value="{{ $user->first_name }}" placeholder="Ad">
                    @error('first-name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="@error('last-name') text-danger @enderror" for="last-name">Soyad</label>
                    <input type="text" class="form-control" id="last-name" name="last-name" value="{{ $user->last_name }}" placeholder="Soyad">
                    @error('last-name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="@error('email') text-danger @enderror" for="email">E-posta</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" placeholder="E-posta">
                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="@error('branch') text-danger @enderror" for="branch">Şube</label>
                    <select class="form-control" name="branch" id="branch">
                        @if(isset($user->meta['branch']) && $user->meta['branch'] == null)
                        <option value="null" selected>Şube bağımsız</option>
                        @else
                        <option value="null">Şube bağımsız</option>
                        @endif
                        @foreach(get_settings('branches') as $branch)
                            @if(isset($user->meta['branch']) && $user->meta['branch'] == $branch->id)
                            <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                            @else
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="@error('new-pass') text-danger @enderror" for="first-name">Yeni Şifre</label>
                    <input type="password" class="form-control" id="new-pass" name="new-pass">
                    @error('new-pass')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="@error('new-pass-confirmation') text-danger @enderror" for="last-name">Yeni Şifre Tekrarı</label>
                    <input type="password" class="form-control" id="new-pass-confirmation" name="new-pass-confirmation">
                    @error('new-pass-confirmation')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>
            <p><b>Not:</b> Yeni şifre belirlerseniz otomatik olarak çıkış yapacaksınız ve yeniden giriş yapmanız gerekecek.</p><br/>
            <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
        </form>
    </div>
</div>

@endsection
