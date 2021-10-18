@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.edit', ['type' => trans_choice('general.categories', 1)]) }}</h2>
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
                <form action="{{ route('panel.blog.categories.update') }}" method="POST">
                    @csrf
                    <input type="text" style="display: none" id="product-category-id" name="id" value="{{ $category->id }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.slug') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-slug" name="slug" value="{{ $category->slug }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.blog.categories.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
