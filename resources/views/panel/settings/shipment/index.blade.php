@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Teslimat Ayarları</h2>
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
                <form>
                    @csrf
                    <a href="{{ route('panel.settings.shipment.create') }}" class="btn btn-primary btn-default">Yeni</a><br/><br/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Teslimat Yöntemi</th>
                                <th scope="col">Teslimat Ücreti</th>
                                <th class="text-right">{{ trans('general.settings') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(get_settings('shipment') as $method)
                                <tr>
                                    <td>{{ $method->name }}</td>
                                    <td>
                                        @if(isset($method->price))
                                            {{ number_format($method->price, 2, ",", ".") }} TL
                                        @else
                                            Değişken
                                        @endif
                                    </td>
                                    <td class="text-right">
                                    <div class="dropdown show d-inline-block widget-dropdown">
                                        <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.settings.shipment.edit', ['id' => $method->id]) }}">{{ trans('general.edit') }}</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="delete-product-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteProductModal" data-product-id="{{ $method->id }}">{{ trans('general.delete') }}</a>
                                        </li>
                                        </ul>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
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
          Bu teslimat yöntemini kalıcı olarak silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hayır, silme</button>
        <button onclick="deleteProductRequest(event)" type="button" class="btn btn-primary" data-product-id="0">Evet, sil</button>
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
                url: "{{ route('panel.settings.shipment.delete') }}",
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
