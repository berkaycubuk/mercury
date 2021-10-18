@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.homepage_settings') }}</h2>
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
                <form action="{{ route('panel.settings.frontpage.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h4>{{ trans_choice('general.slides', 1) }}</h4>
                    </div>
                    <input id="main-slider-input" type="hidden" name="main-slider" />
                    <div class="form-group">
                        <label for="slide-title">{{ trans('general.title.default') }}</label>
                        <input type="text" class="form-control" id="slide-title" name="slide-title" placeholder="{{ trans('general.title.default') }}">
                    </div>
                    <div class="form-group">
                        <label for="slide-description">{{ trans('general.description') }}</label>
                        <textarea class="form-control" id="slide-description" name="slide-description" placeholder="{{ trans('general.description') }}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slide-button-text">{{ trans('general.button_text') }}</label>
                        <input type="text" class="form-control" id="slide-button-text" name="slide-button-text" placeholder="{{ trans('general.text') }}">
                    </div>
                    <div class="form-group">
                        <label for="slide-button-url">{{ trans('general.button_link') }}</label>
                        <input type="text" class="form-control" id="slide-button-url" name="slide-button-url" placeholder="{{ trans('general.link') }}">
                    </div>
                    <div class="form-group">
                        <label>Image</label><br/>
                        <input type="hidden" name="slide-image" id="slide-image" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="slideImageSelectorButton1">Görsel Seç</a>
                        <img id="slideImageShowcase" src="{{ get_image(0) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-default add-slide-btn">{{ trans('general.add_new') }}</button>
                    </div>
                    <div class="form-group">
                        <label for="slide-description">{{ trans_choice('general.slides', 2) }}</label>
                        <div class="p-3 bg-light slides-container">
                            @foreach($frontpage->main_slider as $slide)
                                <div class="p-2 my-1 border">
                                    <p><b>{{ trans('general.title.default') }}:</b> <span class="slides-slide-title">{{ $slide->title }}</span></p>
                                    <p><b>{{ trans('general.description') }}:</b> <span class="slides-slide-description">{{ $slide->description }}</span></p>
                                    <p><b>{{ trans('general.button_text') }}:</b> <span class="slides-slide-button-text">{{ $slide->button->text }}</span></p>
                                    <p><b>{{ trans('general.button_link') }}:</b> <span class="slides-slide-button-url">{{ $slide->button->url }}</span></p>
                                    <img style="width: 200px; height: 120px; object-fit: cover;" data-image-id="{{ $slide->image }}" src="{{ get_image($slide->image) }}" />
                                    <button class="btn btn-danger btn-sm remove-slide-btn mt-2" onclick="remove_slide(event)">{{ trans('general.delete') }}</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <h4>What We Do</h4>
                    </div>
                    <div class="form-group">
                        <label for="what-we-do-title">{{ trans('general.title.default') }}</label>
                        <input type="text" class="form-control" id="what-we-do-title" name="what-we-do-title" value="{{ $frontpage->what_we_do->title }}" placeholder="{{ trans('general.title.default') }}">
                    </div>
                    <div class="form-group">
                        <label for="what-we-do-description">{{ trans('general.description') }}</label>
                        <textarea class="form-control" id="what-we-do-description" name="what-we-do-description" placeholder="{{ trans('general.description') }}">{{ $frontpage->what_we_do->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Image 1</label><br/>
                        <input type="hidden" name="what-we-do-image-1" id="what-we-do-image-1" value="{{ $frontpage->what_we_do->images[0] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="whatWeDoImageSelectorButton1">Görsel Seç</a>
                        <img id="whatWeDoImageShowcase1" src="{{ get_image($frontpage->what_we_do->images[0]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 2</label><br/>
                        <input type="hidden" name="what-we-do-image-2" id="what-we-do-image-2" value="{{ $frontpage->what_we_do->images[1] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="whatWeDoImageSelectorButton2">Görsel Seç</a>
                        <img id="whatWeDoImageShowcase2" src="{{ get_image($frontpage->what_we_do->images[1]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 3</label><br/>
                        <input type="hidden" name="what-we-do-image-3" id="what-we-do-image-3" value="{{ $frontpage->what_we_do->images[2] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="whatWeDoImageSelectorButton3">Görsel Seç</a>
                        <img id="whatWeDoImageShowcase3" src="{{ get_image($frontpage->what_we_do->images[2]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 4</label><br/>
                        <input type="hidden" name="what-we-do-image-4" id="what-we-do-image-4" value="{{ $frontpage->what_we_do->images[3] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="whatWeDoImageSelectorButton4">Görsel Seç</a>
                        <img id="whatWeDoImageShowcase4" src="{{ get_image($frontpage->what_we_do->images[3]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <hr />
                    <div class="form-group">
                        <h4>Online Sipariş</h4>
                    </div>
                    <div class="form-group">
                        <label for="online-order-cta-title">{{ trans('general.title.default') }}</label>
                        <input type="text" class="form-control" id="online-order-cta-title" name="online-order-cta-title" value="{{ $frontpage->online_order_cta->title }}" placeholder="{{ trans('general.title.default') }}">
                    </div>
                    <div class="form-group">
                        <label for="online-order-cta-description">{{ trans('general.description') }}</label>
                        <textarea class="form-control" id="online-order-cta-description" name="online-order-cta-description" placeholder="{{ trans('general.description') }}">{{ $frontpage->online_order_cta->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="online-order-cta-button-text">{{ trans('general.button_text') }}</label>
                        <input type="text" class="form-control" id="online-order-cta-button-text" name="online-order-cta-button-text" value="{{ $frontpage->online_order_cta->button->text }}" placeholder="{{ trans('general.button_text') }}">
                    </div>
                    <div class="form-group">
                        <label for="online-order-cta-button-url">{{ trans('general.button_link') }}</label>
                        <input type="text" class="form-control" id="online-order-cta-button-url" name="online-order-cta-button-url" value="{{ $frontpage->online_order_cta->button->url }}" placeholder="{{ trans('general.button_link') }}">
                    </div>
                    <div class="form-group">
                        <label>Image 1</label><br/>
                        <input type="hidden" name="online-order-image-1" id="online-order-image-1" value="{{ $frontpage->online_order_cta->images[0] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="onlineOrderImageSelectorButton1">Görsel Seç</a>
                        <img id="onlineOrderImageShowcase1" src="{{ get_image($frontpage->online_order_cta->images[0]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 2</label><br/>
                        <input type="hidden" name="online-order-image-2" id="online-order-image-2" value="{{ $frontpage->online_order_cta->images[1] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="onlineOrderImageSelectorButton2">Görsel Seç</a>
                        <img id="onlineOrderImageShowcase2" src="{{ get_image($frontpage->online_order_cta->images[1]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 3</label><br/>
                        <input type="hidden" name="online-order-image-3" id="online-order-image-3" value="{{ $frontpage->online_order_cta->images[2] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="onlineOrderImageSelectorButton3">Görsel Seç</a>
                        <img id="onlineOrderImageShowcase3" src="{{ get_image($frontpage->online_order_cta->images[2]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <div class="form-group">
                        <label>Image 4</label><br/>
                        <input type="hidden" name="online-order-image-4" id="online-order-image-4" value="{{ $frontpage->online_order_cta->images[3] }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="onlineOrderImageSelectorButton4">Görsel Seç</a>
                        <img id="onlineOrderImageShowcase4" src="{{ get_image($frontpage->online_order_cta->images[3]) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <hr />
                    <div class="form-group">
                        <h4>About Us</h4>
                    </div>
                    <div class="form-group">
                        <label for="the-story-title">{{ trans('general.title.default') }}</label>
                        <input type="text" class="form-control" id="the-story-title" name="the-story-title" value="{{ $frontpage->the_story->title }}" placeholder="{{ trans('general.title.default') }}">
                    </div>
                    <div class="form-group">
                        <label for="the-story-description">{{ trans('general.description') }}</label>
                        <textarea class="form-control" id="the-story-description" name="the-story-description" placeholder="{{ trans('general.description') }}">{{ $frontpage->the_story->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="the-story-button-text">{{ trans('general.button_text') }}</label>
                        <input type="text" class="form-control" id="the-story-button-text" name="the-story-button-text" value="{{ $frontpage->the_story->button->text }}" placeholder="{{ trans('general.button_text') }}">
                    </div>
                    <div class="form-group">
                        <label for="the-story-button-url">{{ trans('general.button_link') }}</label>
                        <input type="text" class="form-control" id="the-story-button-url" name="the-story-button-url" value="{{ $frontpage->the_story->button->url }}" placeholder="{{ trans('general.button_link') }}">
                    </div>
                    <div class="form-group">
                        <label>About Us Image</label><br/>
                        <input type="hidden" name="the-story-image" id="the-story-image" value="{{ $frontpage->the_story->image }}" />
                        <a class="btn btn-primary text-white imageSelectorModalButton" id="theStoryImageSelectorButton">Görsel Seç</a>
                        <img id="theStoryImageShowcase" src="{{ get_image($frontpage->the_story->image) }}" style="display: block; width: 300px; height: 200px; margin-top: 20px; object-fit: cover;" />
                    </div>
                    <hr />
                    <div class="form-group">
                        <h4>Products</h4>
                    </div>
                    <div class="form-group">
                        <label for="product-showcase-title">{{ trans('general.title.default') }}</label>
                        <input type="text" class="form-control" id="product-showcase-title" name="product-showcase-title" value="{{ $frontpage->product_showcase->title }}" placeholder="{{ trans('general.title.default') }}">
                    </div>
                    <div class="form-group">
                        <label for="product-showcase-description">{{ trans('general.description') }}</label>
                        <textarea class="form-control" id="product-showcase-description" name="product-showcase-description" placeholder="{{ trans('general.description') }}">{{ $frontpage->product_showcase->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="product-showcase-button-text">{{ trans('general.button_text') }}</label>
                        <input type="text" class="form-control" id="product-showcase-button-text" name="product-showcase-button-text" value="{{ $frontpage->product_showcase->button->text }}" placeholder="{{ trans('general.button_text') }}">
                    </div>
                    <div class="form-group">
                        <label for="product-showcase-button-url">{{ trans('general.button_link') }}</label>
                        <input type="text" class="form-control" id="product-showcase-button-url" name="product-showcase-button-url" value="{{ $frontpage->product_showcase->button->url }}" placeholder="{{ trans('general.button_link') }}">
                    </div>
                    @can('update-settings')
                        <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageSelectorModal" tabindex="-1" aria-labelledby="imageSelectorModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="branchesImageModalTitle">Görsel Seçin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
                @foreach($media as $image)
                    <div data-image-id="{{ $image->id }}" class="col-lg-4 image-modal-selector" style="height: 200px; cursor: pointer;">
                        <p class="w-100 p-2 text-white">{{ $image->name }}</p>
                        <img style="width: 100%; height: 100%; object-fit: cover;" class="img-thumbnail" src="{{ get_image($image->id) }}" />
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
        $(document).ready(function() {
            slides_to_json();

            $('.add-slide-btn').click(function(e) {
                e.preventDefault();
                var title = $('#slide-title').val();
                var description = $('#slide-description').val();
                var text = $('#slide-button-text').val();
                var url = $('#slide-button-url').val();
                var image = $('#slide-image').val();
                var imagePath = $("#slideImageShowcase").attr('src');

                if (!title) {
                    return;
                }

                var element = '<div class="p-2 my-1 border">';
                element += '<p><b>Başlık:</b> <span>' + title + '</span></p>';
                element += '<p><b>Açıklama:</b> <span>' + description + '</span></p>';
                element += '<p><b>Buton Metni:</b> <span>' + text + '</span></p>';
                element += '<p><b>Buton Adresi:</b> <span>' + url + '</span></p>';
                element += '<img data-image-id="' + image + '" style="width: 200px; height: 120px; object-fit: cover;" src="' + imagePath + '" />';
                element += '<button class="btn btn-danger btn-sm remove-slide-btn mt-2" onclick="remove_slide(event)">Sil</button>';
                element += '</div>';

                $('.slides-container').append(element);
                slides_to_json();
            });

            $('.imageSelectorModalButton').click(function() {
                inputId = $(this).parent().find('input').attr('id');
                showcaseId = $(this).parent().find('img').attr('id');
                modalId = '#imageSelectorModal';

                $(modalId).attr('data-image-input', inputId);
                $(modalId).attr('data-image-showcase', showcaseId);
                $(modalId).modal('show');
            });

            $('#imageSelectorModal .image-modal-selector').click(function() {
                imageId = $(this).attr('data-image-id');
                imageInput = '#' + $(this).parent().parent().parent().parent().parent().attr('data-image-input');
                imageShowcase = '#' + $(this).parent().parent().parent().parent().parent().attr('data-image-showcase');

                $(imageInput).val(imageId);
                $(imageShowcase).attr('src', $(this).find('img').attr('src'));
                $(imageShowcase).css('display', 'block');

                $('#imageSelectorModal').modal('hide');
            });

            $('.remove-slide-btn').click(function(e) {
                e.preventDefault();
                $(this).parent().remove();
                slides_to_json();
            });
        });

        function slides_to_json() {
            var slides = [];
            $('.slides-container').find('div').each(function(index) {
                slides.push({
                    'title': $(this).find('span').eq(0).text(),
                    'description': $(this).find('span').eq(1).text(),
                    'button': {
                        'text': $(this).find('span').eq(2).text(),
                        'url': $(this).find('span').eq(3).text()
                    },
                    'image': $(this).find('img').eq(0).data('image-id')
                });
            });

            slides = JSON.stringify(slides);
            $('#main-slider-input').val(slides);
        }

        function remove_slide(e) {
            e.preventDefault();
            $(e.target).parent().remove();
            slides_to_json();
        }
    </script>
@endsection
