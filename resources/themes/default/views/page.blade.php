@extends('core::layouts.store')

@section('content')

<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Anasayfa</a></li>
        <li class="active">{{ $page->title }}</li>
    </ul>
</div>

<section class="page container">
    <h1>{{ $page->title }}</h1>

    <div class="page-content">
        {!! $page->content !!}
    </div>
</section>

@endsection
