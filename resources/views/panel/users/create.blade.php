@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.new', ['type' => trans_choice('general.users', 1)]) }}</h2>
            </div>
            <div class="card-body">
                @if (session('form_error'))
                    <div class="alert alert-danger">
                        {{ session('form_error') }}
                    </div>
                @endif
                <form action="{{ route('panel.users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user-first-name">{{ trans('general.first_name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user-first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="user-last-name">{{ trans('general.last_name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user-last-name" name="last-name" required>
                    </div>
                    <div class="form-group">
                        <label for="user-email">{{ trans('general.email') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="user-password">{{ trans('general.password') }}</label>
                        <input value="password" type="text" class="form-control" id="user-password" name="password" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user-role">Yetki</label>
						<select class="form-control" name="role" id="user-role">
                            <option value="customer" selected>Müşteri</option>
                            <option value="writer">Yazar</option>
                            <option value="order-tracker">Sipariş Takipçisi</option>
                            <option value="admin">Yönetici</option>
						</select>
                    </div>
                    <div class="form-group">
                        <label for="user-branch">Bağlı Olduğu Şube</label>
						<select class="form-control" name="branch" id="user-branch">
                            <option value="null" selected>Şubelerden Bağımsız</option>
                            @foreach(get_settings('branches') as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
