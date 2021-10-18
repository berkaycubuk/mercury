@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.edit', ['type' => trans_choice('general.posts', 1)]) }}</h2>
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
                <form action="{{ route('panel.blog.posts.update') }}" method="POST">
                    @csrf
                    <input type="text" style="display: none" id="post-id" name="id" value="{{ $post->id }}">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.title.default') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="post-title" name="title" value="{{ $post->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.slug') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="post-slug" name="slug" value="{{ $post->slug }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">{{ trans('general.content') }}</label>
                        <textarea id="editor" name="content">{{ $post->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Image</label><br/>
                        <input type="hidden" name="thumbnail" id="branch-image" value="{{ $post->thumbnail }}" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">Görsel Seç</a>
                        <img id="branch-image-showcase" src="{{ get_image($post->thumbnail) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <!-- <div class="form-group">
                        <label for="post-category">{{ trans_choice('general.categories', 1) }}</label>
						<select class="form-control" name="category" id="post-category">
                            @if (!$post->category)
                                <option disabled selected>Choose category</option>
                            @endif
                            @foreach ($postCategories as $postCategory)
                                @if ($postCategory->id == $post->category)
                                    <option value="{{ $postCategory->id  }}" selected>{{ $postCategory->name }}</option>
                                @else
                                    <option value="{{ $postCategory->id  }}">{{ $postCategory->name }}</option>
                                @endif
                            @endforeach
						</select>
                    </div> -->
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.blog.posts.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="branchesImageModal" tabindex="-1" aria-labelledby="branchesImageModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="branchesImageModalTitle">Şube Görseli Seçin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
                @foreach($media as $image)
                    <div data-image-id="{{ $image->id }}" class="col-lg-4 image-modal-selector" style="height: 200px; cursor: pointer;">
                        <p class="w-100 p-2 text-white">{{ $image->name }}</p>
                        <img src="{{ get_image($image->id) }}" />
                    </div>
                @endforeach
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script>
        var editor = new Jodit('#editor', {
            toolbarSticky: true,
            toolbarStickyOffset: 78,
            buttons: [
                'source', '|',
                'bold',
                'strikethrough',
                'underline',
                'italic', '|',
                'ul',
                'ol', '|',
                'outdent', 'indent',  '|',
                'font',
                'fontsize',
                'brush',
                'paragraph', '|',
                'table',
                'link', '|',
                'align', 'undo', 'redo', '|',
                'hr',
                'eraser',
                'copyformat', '|',
                'symbol',
                'fullsize',
            ],
            colorPickerDefaultTab: 'text',
        });

        $(document).ready(function() {
            $('#branchesImageModal .image-modal-selector').click(function() {
                var imageId = $(this).attr('data-image-id');
                $('#branch-image').val(imageId);
                $('#branch-image-showcase').attr('src', $(this).find('img').attr('src'));
                $('#branch-image-showcase').css('display', 'block');
                $('#branchesImageModal').modal('hide');
            });
        });
    </script>
@endsection
