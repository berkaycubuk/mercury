@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.edit', ['type' => trans('general.media')]) }}</h2>
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
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error  }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('panel.media.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $media->id }}" />
                    <div class="row">
                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#mediaImageModal"><img class="media-image-thumbnail border" src="{{ asset($media->path) }}" /></a>
                            <small>Görselin üzerine tıklayarak daha detaylı görüntüleyebilirsiniz.</small>
                        </div>
                        <div class="col-md-6 mt-2 mt-md-0">
                            <div class="form-group">
                                <label for="media-name">{{ trans('general.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="media-name" name="name" value="{{ $media->name }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                            <a class="btn btn-secondary" href="{{ route('panel.media.index') }}">{{ trans('general.cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mediaImageModal" tabindex="-1" aria-labelledby="mediaImageModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img class="img-fluid" src="{{ asset($media->path) }}" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>

<style>
    .media-image-thumbnail {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
    }

    .media-image-thumbnail:hover {
        cursor: crosshair;
    }
</style>
@endsection
