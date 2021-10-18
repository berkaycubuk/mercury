@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li class="active">Menü</li>
    </ul>
</div>

<section class="agreements container">
    <h1>Menü</h1>
    <p>Lütfen menüsünü incelemek istediğiniz şubemizi seçin.</p>

    <div class="agreements-navigation">
        @foreach(get_settings('branches') as $branch)
            <a href="{{ route('store.menu.branch-menu', ['slug' => $branch->slug]) }}">{{ $branch->name }}</a>
        @endforeach
    </div>
</section>

@endsection
