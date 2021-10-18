<div class="modal fade" id="{{ $modal['id'] }}" tabindex="-1" aria-labelledby="{{ $modal['id'] }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="branchesImageModalTitle">{{ $modal['title'] }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
                @foreach($modal['images'] as $image)
                    <div data-image-id="{{ $image->id }}" class="col-lg-4 image-modal-selector" style="height: 200px; cursor: pointer; position: relative;">
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
