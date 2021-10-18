@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Şubeyi Düzenle</h2>
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
                <form action="{{ route('panel.settings.contact.branches.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $branch->id }}" />
                    <div class="form-group">
                        <label for="branch-name">Şube Adı</label>
                        <input type="text" class="form-control" id="branch-name" name="name" value="{{ $branch->name }}" placeholder="Şube Adı">
                    </div>
                    <div class="form-group">
                        <label for="branch-address">Şube Adresi</label>
                        <textarea class="form-control" id="branch-address" name="address" placeholder="Şube Adresi">{{ $branch->address }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="branch-phone">Telefon Numarası</label>
                        <input type="tel" class="form-control" id="branch-phone" name="phone" value="{{ $branch->phone }}" placeholder="Telefon Numarası">
                    </div>
                    <div class="form-group">
                        <label>Şube Görseli</label><br/>
                        <input type="hidden" name="image" id="branch-image" value="{{ $branch->image }}" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">Görsel Seç</a>
                        <img id="branch-image-showcase" src="{{ get_image($branch->image) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label for="branch-embed-url">Google Maps Iframe Adresi</label>
                        <input type="text" class="form-control" id="branch-embed-url" value="{{ $branch->embed_url }}" name="embed-url">
                    </div>
                    <div class="form-group">
                        <label for="branch-map-url">Google Maps Bağlantısı</label>
                        <input type="text" class="form-control" id="branch-map-url" value="{{ $branch->map_url }}" name="map-url">
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a href="{{ route('panel.settings.contact') }}" class="btn btn-secondary btn-default">Geri Dön</a><br/><br/>
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
        $('#branchesImageModal .image-modal-selector').click(function() {
            var imageId = $(this).attr('data-image-id');
            $('#branch-image').val(imageId);
            $('#branch-image-showcase').attr('src', $(this).find('img').attr('src'));
            $('#branch-image-showcase').css('display', 'block');
            $('#branchesImageModal').modal('hide');
        });
    </script>
@endsection
