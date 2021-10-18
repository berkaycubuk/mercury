@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Edit Attribute</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.products.attributes.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="attribute-id" name="id" value="{{ $attribute->id }}">
                    <div class="form-group">
                        <label for="attribute-name">Ad</label>
                        <input type="text" class="form-control" id="attribute-name" name="name" value="{{ $attribute->name }}" required>
                    </div>
                    <button id="new-term-btn" class="btn btn-primary">Kaydet</button>
                    <a href="{{ route('panel.products.attributes.index') }}" class="btn btn-secondary">Geri Dön</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
