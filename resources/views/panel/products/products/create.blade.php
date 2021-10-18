@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.new_product') }}</h2>
            </div>
            <div class="card-body">
                @if ($errors->any)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                @endif
                <form action="{{ route('panel.products.products.store') }}" method="POST">
                    @csrf
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Genel</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Görseller</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Stok</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Özellikler</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Teslimat</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br />
                            <div class="form-group">
                                <label for="product-title">{{ __('general.title.default') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="product-title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="product-short-description">{{ __('general.short_description') }}</label>
                                <textarea class="form-control" id="product-short-description" name="short_description"></textarea>
                                <small>Ürün hakkında bilgilendiren kısa metin.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-description">{{ __('general.description') }}</label>
                                <textarea class="form-control" id="product-description" name="description"></textarea>
                                <small>Ürün detayları sayfasında gözükecek olan açıklama metni.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-category">{{ __('general.categories') }}</label>
                                <select class="form-control" name="category" id="product-category">
                                    <option value="null" selected>Kategorisi Yok</option>
                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id  }}">{{ $productCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product-subcategory">{{ __('general.subcategory') }}</label>
                                <select class="form-control" name="subcategory" id="product-subcategory">
                                    <option value="null" selected>Alt Kategorisi Yok</option>
                                    @foreach ($productSubcategories as $productSubcategory)
                                        <option value="{{ $productSubcategory->id  }}">{{ $productSubcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product-price">{{ __('general.price') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" step="0.01" id="product-price" name="price" required>
                                <small>Ürünün KDV hariç fiyatı. Virgül(,) yerine nokta(.) kullanınız.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-discount-price">{{ __('general.discounted_price') }}</label>
                                <input type="number" class="form-control" step="0.01" id="product-discount-price" name="discount-price">
                                <small>İndirim yoksa boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-discount-price">{{ __('general.vat_rate') }} (yüzde olarak)</label>
                                <input type="number" class="form-control" step="0.01" id="product-tax" name="tax">
                                <small>Eğer KDV oranı tanımlamazsanız bu ürün için kdv geçerli olmayacaktır.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.online_orderable') }}
                                    <input type="checkbox" name="online_orderable" />
                                    <div class="control-indicator"></div>
                                </label>
                                <small>İnternet sitesinden sipariş edilebilen ürün.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.show_on_menu') }}
                                    <input type="checkbox" name="show-on-menu" />
                                    <div class="control-indicator"></div>
                                </label>
                                <small>Yemek menüsünde listelenebilen ürün.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.public') }}
                                    <input type="checkbox" name="public" />
                                    <div class="control-indicator"></div>
                                </label>
                                <small>Herkese açık olan ürünlere üye olmayan veya üye olan herkes erişebilir.</small>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="images" role="tabpanel" aria-labelledby="images-tab">
                            <div class="form-group">
                                <label>{{ __('general.image') }}</label><br/>
                                <small>En üstteki görsel aynı zamanda ürününüzün kapak fotoğrafıdır.</small><br/>
                                <input type="hidden" name="images" id="branch-image" />
                                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">Görsel Ekle</a>
                                <br />
                                <div id="image-list-container" class="menu-drag-drop nested-sortable">
                                </div>
                                <br />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <br />
                            <div class="form-group">
                                <label for="branch-multiple-select">Bu ürüne sahip şubeler</label>
                                <select id="branch-multiple-select" class="js-example-basic-multiple form-control" name="available-branches[]" multiple="multiple">
                                    @foreach(get_settings('branches') as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                <small>Tüm şubelerde bulunuyorsa boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-stock-amount">{{ __('general.stock_amount') }}</label>
                                <input type="number" class="form-control" id="product-stock-amount" name="stock_amount">
                                <small>Stok miktarı kullanmıyorsanız boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-stock-code">{{ __('general.stock_trace_code') }}</label>
                                <input type="text" class="form-control" id="product-stock-code" name="stock_code">
                                <small>Stok takip kodu kullanmıyorsanız boş bırakabilirsiniz.</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            @if(isset($product->meta['attributes']))
                            <input name="product_attributes" type="hidden" value="{{ json_encode($product->meta['attributes']) }}" id="product-attributes-input" />
                            @else
                            <input name="product_attributes" type="hidden" id="product-attributes-input" />
                            @endif
                            <br />
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control">
                                        <option disabled selected>Özellik Seçebilirsiniz</option>
                                        @foreach($productAttributes as $attribute)
                                            <option value="{{ $attribute }}">{{ $attribute->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" onclick="submitAttribute(event)">Ekle</button>
                                </div>
                            </div><br />
                            <div id="product-attributes-sortable" class="p-3 border nested-sortable">
                            </div>
                            <br />
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <br />
                            <div class="form-group">
                                <label for="shipping-multiple-select">{{ __('general.accepted_shipping_methods') }}</label>
                                <select id="shipping-multiple-select" class="js-example-basic-multiple form-control" name="available-shippings[]" multiple="multiple">
                                    @foreach(get_settings('shipment') as $method)
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                    @endforeach
                                </select>
                                <small>Tüm teslimat yöntemlerini kabul ediyorsa boş bırakabilirsiniz.</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.products.products.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>

@include('panel::partials.images-modal', [
    'modal' => [
        'id' => 'branchesImageModal',
        'title' => 'Görsel Seçin',
        'images' => $media,
    ]
])

<style>
    .select2 {
        width: 100% !important;
    }

    .product-images-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }
</style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    <script>

        function submitAttribute(event) {
            event.preventDefault();
            attributeData = $(event.target).parent().parent().find('select').val();
            attributeData = JSON.parse(attributeData);
            attributeData.terms = JSON.parse(attributeData.terms);

            addAttributeCollapse(attributeData);
        }

        function generateString(length) {
            const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            let result = '';
            const charactersLength = characters.length;
            for ( let i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }

        function newTerm(event) {
            event.preventDefault();

            var id = generateString(10);

            element = '<div data-attribute-id="' + id + '" id="attribute-accordion-' + id + '" class="accordion accordion-bordered">';
            element += '<div class="card">';
            element += '<div class="card-header">';
            element += '<h2 class="mb-0 w-100">';
            element += '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-' + id + '" aria-expanded="false" aria-controls="collapse-' + id + '">';
            element += 'Yeni İfade';
            element += '</button>';
            element += '</h2>';
            element += '</div>';

            element += '<div id="collapse-' + id + '" class="collapse" data-parent="#attribute-accordion-' + id + '">';
            element += '<div class="card-body">';
            element += '<input type="hidden" class="form-control term-id" value="' + id + '">';
            element += '<div class="form-group">';
            element += '<label>Başlık</label>';
            element += '<input type="text" class="form-control term-name">';
            element += '</div>';
            element += '<div class="form-group">';
            element += '<label>Fiyat</label>';
            element += '<input type="number" class="form-control term-price">';
            element += '</div>';
            element += '<button onclick="deleteTerm(event)" class="btn btn-danger btn-sm">Sil</button>'
            element += '</div>';
            element += '</div>';
            element += '</div>';
            element += '</div>';

            $(event.target).parent().find('.attribute-terms').eq(0).append(element);
        }

        function addAttributeCollapse(attributeData) {
            if ($('#attribute-accordion-' + attributeData.id).length) {
                return;
            }

            element = '<div data-attribute-id="' + attributeData.id + '" id="attribute-accordion-' + attributeData.id + '" class="accordion accordion-bordered">';
            element += '<div class="card">';
            element += '<div class="card-header">';
            element += '<h2 class="mb-0 w-100">';
            element += '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-' + attributeData.id + '" aria-expanded="false" aria-controls="collapse-' + attributeData.id + '">';
            element += attributeData.name;
            element += '</button>';
            element += '</h2>';
            element += '</div>';

            element += '<div id="collapse-' + attributeData.id + '" class="collapse" data-parent="#attribute-accordion-' + attributeData.id + '">';
            element += '<div class="card-body">';
            element += '<div class="form-group">';
            element += '<label>Özellikler</label>&nbsp;';
            element += '<input type="hidden" class="form-control attribute-name" value="' + attributeData.name + '" />';
            element += '<button onclick="newTerm(event)" class="btn btn-primary btn-sm">Yeni İfade</button>'

            element += '<div class="attribute-terms">';

            for (var i = 0; i < attributeData.terms.length; i++) {
                element += '<div data-attribute-id="' + attributeData.terms[i].id + '" id="attribute-accordion-' + attributeData.terms[i].id + '" class="accordion accordion-bordered">';
                element += '<div class="card">';
                element += '<div class="card-header">';
                element += '<h2 class="mb-0 w-100">';
                element += '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-' + attributeData.terms[i].id + '" aria-expanded="false" aria-controls="collapse-' + attributeData.terms[i].id + '">';
                element += attributeData.terms[i].name;
                element += '</button>';
                element += '</h2>';
                element += '</div>';

                element += '<div id="collapse-' + attributeData.terms[i].id + '" class="collapse" data-parent="#attribute-accordion-' + attributeData.terms[i].id + '">';
                element += '<div class="card-body">';
                element += '<input type="hidden" class="form-control term-id" value="' + attributeData.terms[i].id + '">';
                element += '<div class="form-group">';
                element += '<label>Başlık</label>';
                element += '<input type="text" class="form-control term-name" value="' + attributeData.terms[i].name + '">';
                element += '</div>';
                element += '<div class="form-group">';
                element += '<label>Fiyat</label>';
                element += '<input type="number" class="form-control term-price" value="' + attributeData.terms[i].price + '">';
                element += '</div>';
                element += '<button onclick="deleteTerm(event)" class="btn btn-danger btn-sm">Sil</button>'
                element += '</div>';
                element += '</div>';
                element += '</div>';
                element += '</div>';
            }

            element += '</div>';

            element += '</div>';
            element += '<button onclick="saveAttributes(event)" class="btn btn-primary btn-sm">Kaydet</button>'
            element += '</div>';
            element += '</div>';
            element += '</div>';
            element += '</div>';

            $('#product-attributes-sortable').prepend(element);
            $('#multiple-select-attribute-' + attributeData.id).select2();
        }

        function saveAttributes(event) {
            event.preventDefault();
            panelLoadingOpen();

            attributes = [];

            $('#product-attributes-sortable').find('> .accordion').each(function() {
                attributeId = $(this).attr('data-attribute-id');
                attributeName = $(this).find('.attribute-name').val();
                terms = [];

                $(this).find('.attribute-terms').find('> .accordion').each(function() {
                    terms.push({
                        id: attributeId + '-' + $(this).find('.term-id').val(),
                        name: $(this).find('.term-name').val(),
                        price: parseFloat($(this).find('.term-price').val())
                    });
                });

                attributes.push({
                    id: attributeId,
                    name: attributeName,
                    terms: terms
                });
            });

            $('#product-attributes-input').val(JSON.stringify(attributes));

            panelLoadingClose();
        }

        function deleteTerm(event) {
            event.preventDefault();
            $(event.target).parent().parent().parent().parent().remove();
        }

        function updateImagesInput() {
            var images = [];
            $("#image-list-container .card").each(function() {
                var imageId = $(this).find('img').data('image-id');
                images.push(imageId);
            });

            $("input[name='images']").val(JSON.stringify(images));
        }

        function addImageToList (image) {
            var element = '<div class="card my-2">';
            element += '<div class="card-body">';
            element += '<img class="product-images-image" data-image-id="' + image.id + '" src="' + image.path + '" />';
            element += '<button class="btn btn-sm btn-danger" onclick="removeItemFromList(event)">Sil</button>';
            element += '</div>';
            element += '</div>';

            $('#image-list-container').append(element);

            updateImagesInput();
        }

        function removeItemFromList(event) {
            event.preventDefault();
            $(event.target).parent().parent().remove();
            updateImagesInput();
        }

        $(document).ready(function() {
            new Sortable(document.getElementById("image-list-container"), {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                onSort: function(evt) {
                    updateImagesInput();
                },
            });

            $('#branchesImageModal .image-modal-selector').click(function() {
                var imageId = $(this).attr('data-image-id');
                $('#branch-image').val(imageId);
                $('#branchesImageModal').modal('hide');

                addImageToList({
                    'id': imageId,
                    'path': $(this).find('img').attr('src')
                });
            });
        });
    </script>
@endsection
