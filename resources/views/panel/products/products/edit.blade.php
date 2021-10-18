@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.edit_product') }}</h2>
            </div>
            <div class="card-body">
                @if ($errors->any)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                    @endforeach
                @endif
                @if (session('form_success'))
                    <div class="alert alert-success">
                        {{ session('form_success') }}
                    </div>
                @endif
                <form action="{{ route('panel.products.products.update') }}" method="POST">
                    @csrf
                    <input type="text" style="display: none" id="product-id" name="id" value="{{ $product->id }}">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('general.general') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">{{ __('general.images') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('general.stock') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="attributes-tab" data-toggle="tab" href="#attributes" role="tab" aria-controls="attributes" aria-selected="false">{{ __('general.attributes') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">{{ __('general.shipping') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br />
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ trans('general.title.default') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="product-title" name="title" value="{{ $product->title }}" required>
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div> 
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="product-short-description">{{ __('general.short_description') }}</label>
                                <textarea class="form-control" id="product-short-description" name="short_description">{{ $product->short_description }}</textarea>
                                <small>Ürün hakkında bilgilendiren kısa metin.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('general.description') }}</label>
                                <textarea class="form-control" id="product-description" name="description">{{ $product->description }}</textarea>
                                <small>Ürün detayları sayfasında gözükecek olan açıklama metni.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-category">{{ __('general.categories') }}</label>
                                <select class="form-control" name="category" id="product-category">
                                    @if ($product->product_category_id == null || $product->product_category_id == 0)
                                        <option value="null" selected>Kategorisi Yok</option>
                                    @else
                                        <option value="null">Kategorisi Yok</option>
                                    @endif
                                    @foreach ($productCategories as $productCategory)
                                        @if ($productCategory->id == $product->product_category_id)
                                            <option value="{{ $productCategory->id  }}" selected>{{ $productCategory->name }}</option>
                                        @else
                                            <option value="{{ $productCategory->id  }}">{{ $productCategory->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product-subcategory">{{ __('general.subcategory') }}</label>
                                <select class="form-control" name="subcategory" id="product-subcategory">
                                    @if ($product->subcategory_id == null || $product->subcategory_id == 0)
                                        <option value="null" selected>Alt Kategorisi Yok</option>
                                    @else
                                        <option value="null">Alt Kategorisi Yok</option>
                                    @endif
                                    @foreach ($productSubcategories as $productSubcategory)
                                        @if ($productSubcategory->id == $product->subcategory_id)
                                            <option value="{{ $productSubcategory->id  }}" selected>{{ $productSubcategory->name }}</option>
                                        @else
                                            <option value="{{ $productSubcategory->id  }}">{{ $productSubcategory->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product-price">{{ __('general.price') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="product-price" step="0.01" name="price" value="{{ $product->price }}" required>
                                <small>Ürünün KDV hariç fiyatı. Virgül(,) yerine nokta(.) kullanınız.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-discount-price">{{ __('general.discounted_price') }}</label>
                                <input type="number" class="form-control" id="product-discount-price" step="0.01" name="discount-price" value="{{ isset($product->meta['discount_price']) ? $product->meta['discount_price'] : '' }}">
                                <small>İndirim yoksa boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-tax">{{ __('general.vat_rate') }}</label>
                                <input type="number" class="form-control" id="product-tax" name="tax" step="0.01" value="{{ isset($product->meta['tax']) ? $product->meta['tax'] : '' }}">
                                <small>Eğer KDV oranı tanımlamazsanız bu ürün için kdv geçerli olmayacaktır. Girdiğiniz değer yüzde olarak hesaplanır. Virgül(,) yerine nokta(.) kullanınız.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.online_orderable') }}
                                    @if(isset($product->meta['online_orderable']) && $product->meta['online_orderable'])
                                    <input type="checkbox" name="online_orderable" checked />
                                    @else
                                    <input type="checkbox" name="online_orderable" />
                                    @endif
                                    <div class="control-indicator"></div>
                                </label>
                                <small>İnternet sitesinden sipariş edilebilen ürün.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.show_on_menu') }}
                                    @if(isset($product->meta['show_on_menu']) && $product->meta['show_on_menu'])
                                    <input type="checkbox" name="show-on-menu" checked />
                                    @else
                                    <input type="checkbox" name="show-on-menu" />
                                    @endif
                                    <div class="control-indicator"></div>
                                </label>
                                <small>Yemek menüsünde listelenebilen ürün.</small>
                            </div>
                            <div class="form-group">
                                <label class="control control-checkbox">
                                    {{ __('general.public') }}
                                    @if(isset($product->meta['public']) && $product->meta['public'])
                                    <input type="checkbox" name="public" checked />
                                    @else
                                    <input type="checkbox" name="public" />
                                    @endif
                                    <div class="control-indicator"></div>
                                </label>
                                <small>Herkese açık olan ürünlere üye olmayan veya üye olan herkes erişebilir.</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                            <br />
                            <div class="form-group">
                                <label>{{ __('general.image') }}</label><br/>
                                <small>En üstteki görsel aynı zamanda ürününüzün kapak fotoğrafıdır.</small><br/>
                                <input type="hidden" name="images" id="branch-image" value="{{ json_encode($product->images) }}" />
                                <a class="btn btn-primary text-white" data-toggle="modal" data-target="#branchesImageModal" id="branchesImageSelectorButton">Görsel Ekle</a>
                                <br />
                                <div id="image-list-container" class="menu-drag-drop nested-sortable">
                                @if($product->images != null)
                                    @foreach($product->images as $image)
                                        <div class="card my-2">
                                            <div class="card-body">
                                                <img class="product-images-image" data-image-id="{{ $image }}" src="{{ get_image($image) }}" /> 
                                                <button class="btn btn-sm btn-danger" onclick="removeItemFromList(event)">Sil</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
                                        @if(isset($product->meta['available_branches']))
                                            @if(in_array($branch->id, $product->meta['available_branches']))
                                            <option value="{{ $branch->id }}" selected>{{ $branch->name }}</option>
                                            @else
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endif
                                        @else
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small>Tüm şubelerde bulunuyorsa boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-stock-amount">{{ __('general.stock_amount') }}</label>
                                @if(isset($product->meta['stock_amount']))
                                <input type="number" class="form-control" id="product-stock-amount" value="{{ $product->meta['stock_amount'] }}" name="stock_amount">
                                @else
                                <input type="number" class="form-control" id="product-stock-amount" name="stock_amount">
                                @endif
                                <small>Stok miktarı kullanmıyorsanız boş bırakabilirsiniz.</small>
                            </div>
                            <div class="form-group">
                                <label for="product-stock-code">{{ __('general.stock_trace_code') }}</label>
                                @if(isset($product->meta['stock_code']))
                                <input type="text" class="form-control" id="product-stock-code" value="{{ $product->meta['stock_code'] }}" name="stock_code">
                                @else
                                <input type="text" class="form-control" id="product-stock-code" name="stock_code">
                                @endif
                                <small>Stok takip kodu kullanmıyorsanız boş bırakabilirsiniz.</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                            @if(isset($product->meta['attributes']))
                            <input name="product_attributes" type="hidden" value="{{ json_encode($product->meta['attributes']) }}" id="product-attributes-input" />
                            @else
                            <input name="product_attributes" type="hidden" id="product-attributes-input" />
                            @endif
                            <br />
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control">
                                        <option value="null" selected>Özel Özellik</option>
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
                                @foreach($product->attributes as $attribute)
                                <div data-attribute-id="{{ $attribute['id'] }}" id="attribute-accordion-{{ $attribute['id'] }}" class="accordion accordion-bordered">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mb-0 w-100">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $attribute['id'] }}" aria-expanded="false" aria-controls="collapse-{{ $attribute['id'] }}">
                                                    {{ $attribute['name'] }}
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-{{ $attribute['id'] }}" class="collapse" data-parent="#attribute-accordion-{{ $attribute['id'] }}">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Başlık</label>
                                                    <div class="col-sm-10">
                                                        <input value="{{ $attribute['name'] }}" type="text" class="form-control attribute-name" onChange="updateAttributeName(event)">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Özellikler</label>&nbsp;
                                                    <button onclick="newTerm(event)" class="btn btn-primary btn-sm">Yeni İfade</button>

                                                    <div class="attribute-terms">
                                                    @foreach($attribute['terms'] as $term)
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <input type="hidden" value="{{ $term['id'] }}" class="form-control term-id">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label">Başlık</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" value="{{ $term['name'] }}" class="form-control term-name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-2 col-form-label">Fiyat</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="number" value="{{ $term['price'] }}" class="form-control term-price">
                                                                    </div>
                                                                </div>
                                                                <button onclick="deleteTerm(event)" class="btn btn-danger btn-sm">Sil</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>

                                                </div>
                                                <button onclick="saveAttributes(event)" class="btn btn-primary btn-sm">Kaydet</button> &nbsp;
                                                <button onclick="deleteAttribute(event)" class="btn btn-danger btn-sm">Sil</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <br />
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <br />
                            <div class="form-group">
                                <label for="shipping-multiple-select">{{ __('general.accepted_shipping_methods') }}</label>
                                <select id="shipping-multiple-select" class="js-example-basic-multiple form-control" name="available-shippings[]" multiple="multiple">
                                    @foreach(get_settings('shipment') as $method)
                                        @if(isset($product->meta['available_shippings']))
                                            @if(in_array($method->id, $product->meta['available_shippings']))
                                            <option value="{{ $method->id }}" selected>{{ $method->name }}</option>
                                            @else
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                            @endif
                                        @else
                                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small>Tüm teslimat yöntemlerini kabul ediyorsa boş bırakabilirsiniz.</small>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.products.products.index') }}">Geri Dön</a>
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
            
            if (attributeData == "null") {
                // custom attribute
                attributeData = {
                    id: new Date().getTime(),
                    name: 'Özel Özellik',
                    terms: [],
                };
            } else {
                attributeData = JSON.parse(attributeData);
                attributeData.terms = JSON.parse(attributeData.terms);
            }

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
            id = $(event.target).parent().parent().parent().parent().parent().data('attribute-id') + '-' + id;

            element = '<div class="card">';
            element += '<div class="card-body">'
            element += '<input type="hidden" class="form-control term-id" value="' + id + '">';

            element += '<div class="form-group row">';
            element += '<label class="col-sm-2 col-form-label">Başlık</label>';
            element += '<div class="col-sm-10">'
            element += '<input type="text" class="form-control term-name">';
            element += '</div>';
            element += '</div>';

            element += '<div class="form-group row">';
            element += '<label class="col-sm-2 col-form-label">Fiyat</label>';
            element += '<div class="col-sm-10">'
            element += '<input type="number" step="0.01" class="form-control term-price">';
            element += '</div>';
            element += '</div>';

            element += '<button onclick="deleteTerm(event)" class="btn btn-danger btn-sm">Sil</button>'
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
            element += '<div class="form-group row">';
            element += '<label class="col-sm-2 col-form-label">Başlık</label>';
            element += '<div class="col-sm-10">'
            element += '<input type="text" value="' + attributeData.name + '" class="form-control attribute-name" onChange="updateAttributeName(event)">';
            element += '</div>';
            element += '</div>';
            element += '<div class="form-group">';
            element += '<label>Özellikler</label>&nbsp;';
            element += '<button onclick="newTerm(event)" class="btn btn-primary btn-sm">Yeni İfade</button>'

            element += '<div class="attribute-terms">';

            for (var i = 0; i < attributeData.terms.length; i++) {
                element += '<div class="card">';
                element += '<div class="card-body">'
                element += '<input type="hidden" class="form-control term-id" value="' + attributeData.terms[i].uid + '">';

                element += '<div class="form-group row">';
                element += '<label class="col-sm-2 col-form-label">Başlık</label>';
                element += '<div class="col-sm-10">'
                element += '<input type="text" class="form-control term-name" value="' + attributeData.terms[i].name + '">';
                element += '</div>';
                element += '</div>';

                element += '<div class="form-group row">';
                element += '<label class="col-sm-2 col-form-label">Fiyat</label>';
                element += '<div class="col-sm-10">'
                element += '<input type="number" step="0.01" class="form-control term-price" value="' + attributeData.terms[i].price + '">';
                element += '</div>';
                element += '</div>';

                element += '<button onclick="deleteTerm(event)" class="btn btn-danger btn-sm">Sil</button>'
                element += '</div>';
                element += '</div>';
            }

            element += '</div>';
            element += '</div>';
            element += '<button onclick="saveAttributes(event)" class="btn btn-primary btn-sm">Kaydet</button> &nbsp;';
            element += '<button onclick="deleteAttribute(event)" class="btn btn-danger btn-sm">Sil</button>';
            element += '</div>';
            element += '</div>';
            element += '</div>';
            element += '</div>';

            $('#product-attributes-sortable').prepend(element);
            $('#multiple-select-attribute-' + attributeData.id).select2();

            saveAttributes(event);
        }

        function updateAttributeName(event) {
            event.preventDefault();
            $(event.target).parent().parent().parent().parent().parent().find('.card-header .btn-block').text($(event.target).val());
        }

        function deleteAttribute(event) {
            event.preventDefault();
            $(event.target).parent().parent().parent().parent().remove(); 
            saveAttributes(event);
        }

        function saveAttributes(event) {
            event.preventDefault();
            panelLoadingOpen();

            attributes = [];

            $('#product-attributes-sortable').find('> .accordion').each(function() {
                attributeId = $(this).attr('data-attribute-id');
                attributeName = $(this).find('.attribute-name').val();
                terms = [];

                $(this).find('.attribute-terms').find('> .card').each(function() {
                    terms.push({
                        id: $(this).find('.term-id').val(),
                        name: $(this).find('.term-name').val(),
                        price: $(this).find('.term-price').val()
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
            $(event.target).parent().parent().remove();
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
