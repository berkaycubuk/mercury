@extends('core::layouts.store')

@section('content')
<div class="page-hero">
    <div class="container page-hero-content">
        <div class="breadcrumb container">
            <ul>
                <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
                <li><img src="{{ asset('assets/store/img/chevron.svg') }}" /></li>
                <li class="active">{{ $page->title }}</li>
            </ul>
        </div>
        <h1 class="page-hero-title">{{ $page->title }}</h1>
    </div>
    <div class="page-hero-bg-effect"></div>
    <img src="https://images.unsplash.com/photo-1599599810769-bcde5a160d32?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1489&q=80" class="page-hero-bg" />
</div>

<section class="page container">

    <div class="page-content">
        <div class="page-products">
            @foreach($products as $product)
            @include('partials.product', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

@endsection
