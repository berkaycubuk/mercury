@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        @if(isset($data['subcategory']))
        <li><a href="{{ route('store.products', ['slug' => $data['category']->slug . '-c-' . $data['category']->id]) }}">{{ $data['category']->name }}</a></li>
        <li class="active">{{ $data['subcategory']->name }}</li>
        @else
        <li class="active">{{ $data['category']->name }}</li>
        @endif
    </ul>
</div>

<div class="hero">
    @if(isset($data['subcategory']))
    <h1 class="hero__title">{{ $data['subcategory']->name }}</h1>
    @else
    <h1 class="hero__title">{{ $data['category']->name }}</h1>
    @endif
</div>

<section class="products container">

    @if(isset($data['subcategory']))
        @forelse($data['subcategory']->products as $product)

            @include('core::partials.product', ['product' => $product])

        @empty

            <p class="alert alert-info">Bu kategoriye ait herhangi bir ürün bulunamadı!</p>

        @endforelse
    @else
        @forelse($data['category']->products as $product)

            @include('core::partials.product', ['product' => $product])

        @empty

            <p class="alert alert-info">Bu kategoriye ait herhangi bir ürün bulunamadı!</p>

        @endforelse
    @endif

</section>

@endsection
