@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.edit_subcategory') }}</h2>
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
                <form action="{{ route('panel.products.subcategories.update') }}" method="POST">
                    @csrf
                    <input type="text" style="display: none" id="product-category-id" name="id" value="{{ $category->id }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ __('general.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ __('general.slug') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-slug" name="slug" value="{{ $category->slug }}" required>
                    </div>
                    <div class="form-group">
                        <label for="product-parent-category">Üst Kategori</label>
                        <select class="form-control" name="parent-category" id="product-parent-category">
                            @if (!$category->product_category_id)
                                <option disabled selected>Alt Kategori Seçin</option>
                            @endif
                            @foreach ($productCategories as $productCategory)
                                @if ($productCategory->id == $category->product_category_id)
                                    <option value="{{ $productCategory->id  }}" selected>{{ $productCategory->name }}</option>
                                @else
                                    <option value="{{ $productCategory->id  }}">{{ $productCategory->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('general.image') }}</label><br/>
                        <input type="hidden" name="image" id="branch-image" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">{{ __('general.choose_image') }}</a>
                        @if(isset($category->meta['image']) && $category->meta['image'] != null)
                        <img id="branch-image-showcase" src="{{ get_image($category->meta['image']) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                        @else
                        <img id="branch-image-showcase" src="{{ get_image(0) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ __('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.products.subcategories.index') }}">Geri Dön</a>
                </form>
            </div>
        </div>
    </div>
</div>

@include('panel::partials.images-modal', [
    'modal' => [
        'id' => 'branchesImageModal',
        'title' => __('general.choose_image'),
        'images' => $media,
    ]
])
@endsection

@section('scripts')
    <script>
        $('#branchesImageModal .image-modal-selector').click(function() {
            var imageId = $(this).attr('data-image-id');
            $('#branch-image').val(imageId);
            $('#branch-image-showcase').attr('src', $(this).find('img').attr('src'));
            $('#branch-image-showcase').css('display', 'block');
            $('#branchesImageModal').modal('hide');
        });
    </script>
@endsection
