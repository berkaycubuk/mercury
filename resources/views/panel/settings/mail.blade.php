@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>E-posta Ayarları</h2>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="smtp-server-address">SMTP Sunucu Adresi</label>
                        <input type="text" class="form-control" id="smtp-server-address" placeholder="smpt.deneme.com" value="{{ $settings->smtp_server_address }}">
                    </div>
                    <div class="form-group">
                        <label for="smtp-port">SMTP Port</label>
                        <input type="number" class="form-control" id="smtp-port" placeholder="465" value="{{ $settings->smpt_port }}">
                    </div>
                    <div class="form-group">
                        <label for="email-username">E-posta Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="email-username" placeholder="deneme@deneme.com" value="{{ $settings->email_username }}">
                    </div>
                    <div class="form-group">
                        <label for="email-password">E-posta Şifre</label>
                        <input type="password" class="form-control" id="email-password">
                    </div>
                    <div class="form-group">
                        <label for="email-from-name">E-posta Gönderen Adı</label>
                        <input type="text" class="form-control" id="email-from-name" value="{{ $settings->email_from_name }}">
                    </div>
                    @can('update-settings')
                        <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
