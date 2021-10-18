@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>SEO Ayarları</h2>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Site Başlığı</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Site Başlığı">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Site Açıklaması</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Site Açıklaması">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Site Anahtar Kelimeleri</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Anahtar kelimeler (virgül ile ayırınız)">
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
