@extends('panel::layouts.panel')

@section('content')
<div class="error-wrapper rounded border bg-white px-5">
    <div class="row justify-content-center">
        <div class="col-xl-4">
            <h1 class="text-primary bold error-title">404</h1>
            <p class="pt-4 pb-5 error-subtitle">Page you're looking is not found</p>
            <a href="{{ route('panel.homepage.index') }}" class="btn btn-primary btn-pill">Go back home</a>
        </div>
    </div>
</div>
@endsection
