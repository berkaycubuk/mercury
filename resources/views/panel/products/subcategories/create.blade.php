@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.new_subcategory') }}</h2>
            </div>
            <div class="card-body">
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
                <form action="{{ route('panel.products.subcategories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ __('general.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="product-parent-category">Üst Kategori</label>
                        <select class="form-control" name="parent-category" id="product-parent-category">
                            <option disabled selected>Üst Kategori Seçiniz</option>
                            @foreach ($productCategories as $productCategory)
                                <option value="{{ $productCategory->id  }}">{{ $productCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ __('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.products.subcategories.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
