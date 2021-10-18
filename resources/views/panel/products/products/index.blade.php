@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.products') }}</h2>
                <a class="ml-auto btn btn-primary" href="{{ route('panel.products.products.export') }}">{{ __('general.export') }} (.xlsx)</a>
                @include('panel::partials.import', ['actionUrl' => route('panel.products.products.import')])
            </div>
            <div class="card-body">
                @can('create-product')
                    <a class="btn btn-primary mb-2" href="{{ route('panel.products.products.create') }}">{{ trans('general.add_new') }}</a>
                @endcan

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ __('general.title.default') }}</th>
                            <th scope="col">{{ __('general.category') }}</th>
                            <th scope="col">{{ __('general.subcategory') }}</th>
                            <th scope="col">{{ __('general.price') }}</th>
                            <th scope="col">{{ __('general.created_at') }}</th>
                            <th class="text-right">{{ __('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><a href="{{ route('panel.products.products.edit', ['id' => $product->id]) }}">{{ $product->title }}</a></td>
                                <td>{{ isset($product->product_category) ? $product->product_category->name : '' }}</td>
                                <td>{{ isset($product->subcategory) ? $product->subcategory->name : '' }}</td>
                                <td>{{ $product->price }}₺</td>
                                <td>{{ $product->translated_created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    @can('update-product')
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.products.products.edit', ['id' => $product->id]) }}">{{ __('general.edit') }}</a>
                                        </li>
                                    @endcan
                                    @can('delete-product')
                                        <li class="dropdown-item">
                                            <a class="delete-product-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteProductModal" data-product-id="{{ $product->id }}">{{ __('general.delete') }}</a>
                                        </li>
                                    @endcan
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('alert.delete_product_msg') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.no') }}</button>
                <button onclick="deleteProductRequest(event)" type="button" class="btn btn-primary" data-product-id="0">{{ __('general.yes') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script>
        function deleteProductRequest(event) {
            var productId = $(event.target).data('product-id');
            panelLoadingOpen();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('panel.products.products.delete') }}",
                method: 'post',
                data: {
                    id: productId
                },
                success: function(result) {
                    $("#deleteProductModal").modal("hide");
                    window.location.reload();
                }
            });
        }

        $(document).ready(function() {
            $('.delete-product-modal-trigger').click(function() {
                var userId = $(this).data('product-id');
                $('#deleteProductModal .btn-primary').attr('data-product-id', userId);
            });
        });
    </script>

@endsection
