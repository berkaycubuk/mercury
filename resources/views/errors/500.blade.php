@extends('core::layouts.store')

@section('content')

<section class="page404 container">
    <h1>Something went wrong!</h1>
    <p>Please try again later.</p>
    <div class="page404__actions">
        <a href="{{ route('store.index') }}"><i></i>Go back home</a>
        <a href="{{ route('store.order-online') }}">Order online</a>
    </div>
</section>

@endsection
