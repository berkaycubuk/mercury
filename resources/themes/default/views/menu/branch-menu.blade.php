@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li><a href="{{ route('store.menu') }}">Menü</a></li>
        <li class="active">{{ $branch->name }}</li>
    </ul>
</div>

<section class="menu container">
    <h2>{{ $branch->name }} Menü</h2>

    <div class="menu-categories">
        @foreach($categories as $category)
            @if(count($category->products) > 0)
            <a class="menu-category" href="#{{ $category->slug }}">
                <div class="menu-category-title">{{ $category->name }}</div>
                <div class="menu-category-effect"></div>
                @if(isset($category->meta['image']) && $category->meta['image'] != null)
                <img class="menu-category-image" src="{{ get_image($category->meta['image']) }}" />
                @else
                <img class="menu-category-image" src="{{ get_image(0) }}" />
                @endif
            </a>
            @endif
        @endforeach
    </div>

    <div class="menu-list">
        @foreach($categories as $category)
            @if(count($category->products) > 0)
            <div class="menu-items" id="{{ $category->slug }}">
                <div class="menu-items-head">
                    <h3 class="menu-items-head-title">{{ $category->name }}</h3>
                    <div class="menu-items-head-line"></div>
                </div>
                <div class="menu-items-body">
                    <div class="menu-items-body-showcase">
                        @foreach($category->products as $product)
                            @if(isset($product->meta['show_on_menu']) && $product->meta['show_on_menu'])
                            <div class="menu-item">
                                <div class="menu-item-content">
                                    <a class="menu-item-title" href="{{ route('store.product', ['slug' => $product->slug]) }}">{{ $product->title }}</a>
                                    <p class="menu-item-information">
                                        {{ $product->short_description }}
                                    </p>
                                </div>
                                <span class="menu-item-price">{{ $product->formatted_price }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- <div class="menu-item menu-item-big">
                        <img src="https://images.unsplash.com/photo-1594756202469-9ff9799b2e4e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=335&q=80" />
                        <div class="menu-item-flex">
                            <div class="menu-item-content">
                                <a class="menu-item-title">Mercimek Çorbası</a>
                                <p class="menu-item-information">
                                    Lorem ipsum dolor sit amet,
                                    consetetur sadipscing elitr,
                                    sed diam nonumy eirmod
                                    tempor invidunt ut labore
                                    et dolore.
                                </p>
                            </div>
                            <span class="menu-item-price">8,00₺</span>
                        </div>
                    </div> -->
                </div>
            </div>
            @endif
        @endforeach
    </div>
</section>

@endsection
