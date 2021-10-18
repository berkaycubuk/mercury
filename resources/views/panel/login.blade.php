@extends('panel::layouts.panel')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-10">
      <div class="card">
        <div class="card-header bg-primary">
          <div class="app-brand">
            <a href="{{ route('store.index') }}">
              <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                viewBox="0 0 30 33">
                <g fill="none" fill-rule="evenodd">
                  <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                  <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                </g>
              </svg>

              <span class="brand-name">Mercury</span>
            </a>
          </div>
        </div>

        <div class="card-body p-5">
          <h4 class="text-dark mb-5">Login</h4>

          <form action="{{ route('panel.login.submit') }}" method="post">
            @csrf
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
                        {{ $error  }}
                    </div>
                @endforeach
            @endif
            <div class="row">
              <div class="form-group col-md-12 mb-4">
                <input type="email" class="form-control input-lg" id="email" name="email" aria-describedby="emailHelp" placeholder="{{ trans('general.email') }}" required>
              </div>

              <div class="form-group col-md-12 ">
                <input type="password" class="form-control input-lg" id="password" name="password" placeholder="{{ trans('general.password') }}" required>
              </div>

              <div class="col-md-12">
                <div class="d-flex my-2 justify-content-between">
                  <div class="d-inline-block mr-3">
                    <label class="control control-checkbox">Remember me
                      <input type="checkbox" name="remember" />
                      <div class="control-indicator"></div>
                    </label>
                  </div>

                  <p><a class="text-blue" href="#">Forgot Your Password?</a></p>
                </div>

                <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
