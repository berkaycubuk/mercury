@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Sosyal Ayarlar</h2>
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
                <form action="{{ route('panel.settings.social.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="setting-facebook">Facebook</label>
                        <input type="text" value="{{ $settings->facebook_url }}" name="facebook_url" class="form-control" id="setting-facebook" placeholder="https://facebook.com/">
                    </div>
                    <div class="form-group">
                        <label for="setting-instagram">Instagram</label>
                        <input type="text" value="{{ $settings->instagram_url }}" name="instagram_url" class="form-control" id="setting-instagram" placeholder="https://instagram.com/">
                    </div>
                    <div class="form-group">
                        <label for="setting-twitter">Twitter</label>
                        <input type="text" value="{{ $settings->twitter_url }}" name="twitter_url" class="form-control" id="setting-twitter" placeholder="https://twitter.com/">
                    </div>
                    <div class="form-group">
                        <label for="setting-youtube">YouTube</label>
                        <input type="text" value="{{ $settings->youtube_url }}" name="youtube_url" class="form-control" id="setting-youtube" placeholder="https://youtube.com/">
                    </div>
                    <div class="form-group">
                        <label for="setting-linkedin">LinkedIn</label>
                        <input type="text" value="{{ $settings->linkedin_url }}" name="linkedin_url" class="form-control" id="setting-linkedin" placeholder="https://linkedin.com/">
                    </div>
                    <div class="form-group">
                        <label for="setting-tiktok">TikTok</label>
                        <input type="text" value="{{ $settings->tiktok_url }}" name="tiktok_url" class="form-control" id="setting-tiktok" placeholder="https://tiktok.com/">
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
