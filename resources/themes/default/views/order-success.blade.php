@extends('core::layouts.store')

@section('content')
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <h2>Order successfull</h2>
        <a href="{{ route('store.index') }}">Return to store</a>
    </div>
</div>
@endsection
