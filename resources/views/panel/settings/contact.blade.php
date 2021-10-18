@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>İletişim Bilgileri</h2>
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
                <form action="{{ route('panel.settings.contact.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="setting-email">E-posta</label>
                        <input value="{{ $siteSettings->email }}" name="email" type="text" class="form-control" id="setting-email" placeholder="E-posta">
                    </div>
                    <div class="form-group">
                        <label for="setting-phone">Telefon</label>
                        <input value="{{ $siteSettings->phone }}" name="phone" type="text" class="form-control" id="setting-phone" placeholder="Telefon">
                    </div>
                    @can('update-settings')
                        <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Şubeler</h2>
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
                <div>
                    <a href="{{ route('panel.settings.contact.branches.create-page') }}" class="btn btn-primary btn-default">Yeni Şube Ekle</a><br/><br/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Şube Adı</th>
                                <th class="text-right">{{ trans('general.settings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(get_settings('branches') as $branch)
                                <tr>
                                    <td>{{ $branch->name }}</td>
                                    <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.settings.contact.branches.edit-page', ['id' => $branch->id]) }}">{{ trans('general.edit') }}</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.settings.contact.branches.delete', ['id' => $branch->id]) }}">{{ trans('general.delete') }}</a>
                                        </li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
