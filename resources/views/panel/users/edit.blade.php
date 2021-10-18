@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Kullanıcıyı Düzenle</h2>
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
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('panel.users.update') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="id" />
                    <div class="form-group">
                        <label for="user-first-name">{{ trans('general.first_name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $user->first_name }}" class="form-control" id="user-first-name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="user-last-name">{{ trans('general.last_name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $user->last_name }}" class="form-control" id="user-last-name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="user-email">{{ trans('general.email') }} <span class="text-danger">*</span></label>
                        <input value="{{ $user->email }}" type="text" class="form-control" id="user-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="user-role">Yetki</label>
						<select class="form-control" name="role" id="user-role">
                            @if($user->role == 'customer')
                            <option value="customer" selected>Müşteri</option>
                            <option value="writer">Yazar</option>
                            <option value="order-tracker">Sipariş Takipçisi</option>
                            <option value="admin">Yönetici</option>
                            @elseif($user->role == 'writer')
                            <option value="customer">Müşteri</option>
                            <option value="writer" selected>Yazar</option>
                            <option value="order-tracker">Sipariş Takipçisi</option>
                            <option value="admin">Yönetici</option>
                            @elseif($user->role == 'order-tracker')
                            <option value="customer">Müşteri</option>
                            <option value="writer">Yazar</option>
                            <option value="order-tracker" selected>Sipariş Takipçisi</option>
                            <option value="admin">Yönetici</option>
                            @elseif($user->role == 'admin')
                            <option value="customer">Müşteri</option>
                            <option value="writer">Yazar</option>
                            <option value="order-tracker">Sipariş Takipçisi</option>
                            <option value="admin" selected>Yönetici</option>
                            @endif
						</select>
                    </div>
                    <div class="form-group">
                        <label for="user-branch">Bağlı Olduğu Şube</label>
						<select class="form-control" name="branch" id="user-branch">
                            @if(!isset($user->meta['branch']))
                            <option value="null" selected>Şubelerden Bağımsız</option>
                            @else
                            <option value="null">Şubelerden Bağımsız</option>
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
                    <div class="form-group">
                        <label class="control control-checkbox">Doğrulanmış Hesap
                            <input type="checkbox" name="verified" {{ $user->email_verified_at != null ? 'checked' : ''  }} />
                            <div class="control-indicator"></div>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
