@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Genel Ayarlar</h2>
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
                <form action="{{ route('panel.settings.general.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="site-title">Site Başlığı</label>
                        <input type="text" class="form-control" id="site-title" name="title" value="{{ $siteSettings->title }}" placeholder="Site Title">
                    </div>
                    <div class="form-group">
                        <label for="site-description">Site Açıklaması</label>
                        <input type="text" class="form-control" id="site-description" name="description" value="{{ $siteSettings->description }}" placeholder="Site Description">
                    </div>
                    <div class="form-group">
                        <label>Logo</label><br/>
                        <input type="hidden" name="logo" id="logo" value="{{ isset($siteSettings->logo) ? $siteSettings->logo : '' }}" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#logoModal" id="logoSelectorButton">Görsel Seç</a>
                        <img id="logo-showcase" src="{{ isset($siteSettings->logo) ? get_image($siteSettings->logo) : get_image(0) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Favicon</label><br/>
                        <input type="hidden" name="favicon" id="favicon" value="{{ isset($siteSettings->favicon) ? $siteSettings->favicon : '' }}" />
                        <a class="btn btn-primary text-white" data-toggle="modal" data-target="#faviconModal" id="faviconSelectorButton">Görsel Seç</a>
                        <img id="favicon-showcase" src="{{ isset($siteSettings->favicon) ? get_image($siteSettings->favicon) : get_image(0) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label class="control control-checkbox">
                            Bakım modu
                            <input type="checkbox" name="service-mode" {{ $siteSettings->service_mode ? 'checked' : '' }} />
                            <div class="control-indicator"></div>
                        </label>
                        <small>Bakım modunda iken yöneticiler hariç kimse sitenizi görüntüleyemez. Ziyaretçileriniz için <b>yapım aşamasında</b> sayfası gözükür.</small>
                    </div>
                    @can('update-settings')
                        <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoModalTitle">Logo Seçin</h5>
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

<div class="modal fade" id="faviconModal" tabindex="-1" aria-labelledby="faviconModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="branchesImageModalTitle">Favicon Seçin</h5>
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
        $('#logoModal .image-modal-selector').click(function() {
            var imageId = $(this).attr('data-image-id');
            $('#logo').val(imageId);
            $('#logo-showcase').attr('src', $(this).find('img').attr('src'));
            $('#logo-showcase').css('display', 'block');
            $('#logoModal').modal('hide');
        });

        $('#faviconModal .image-modal-selector').click(function() {
            var imageId = $(this).attr('data-image-id');
            $('#favicon').val(imageId);
            $('#favicon-showcase').attr('src', $(this).find('img').attr('src'));
            $('#favicon-showcase').css('display', 'block');
            $('#faviconModal').modal('hide');
        });
    </script>
@endsection
