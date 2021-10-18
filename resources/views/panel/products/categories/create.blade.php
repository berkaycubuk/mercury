@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.new_category') }}</h2>
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
                <form action="{{ route('panel.products.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="product-category-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('general.image') }}</label><br/>
                        <input type="hidden" name="image" id="branch-image" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">{{ __('general.choose_image') }}</a>
                        <img id="branch-image-showcase" style="display: none; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.products.categories.index') }}">{{ trans('general.cancel') }}</a>
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
