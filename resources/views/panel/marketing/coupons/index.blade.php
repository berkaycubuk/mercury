@extends('panel::layouts.panel')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans_choice('general.coupons', 1) }}</h2>
            </div>
            <div class="card-body">
                <a class="btn btn-primary mb-2" href="{{ route('panel.marketing.coupons.create') }}">{{ trans('general.add_new') }}</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ trans('general.code') }}</th>
                            <th scope="col">{{ trans('general.discount') }}</th>
                            <th scope="col">{{ trans('general.expires_at') }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td scope="col"><a href="{{ route('panel.marketing.coupons.edit', ['id' => $coupon->id]) }}">{{ $coupon->code }}</a></td>
                                <td scope="col">{{ $coupon->discount }}</td>
                                <td scope="col">{{ $coupon->translated_expires_at }}</td>
                                <td scope="col">{{ $coupon->translated_created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.marketing.coupons.edit', ['id' => $coupon->id]) }}">{{ trans('general.edit') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a class="delete-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" data-id="{{ $coupon->id }}">{{ trans('general.delete') }}</a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Bu kuponu kalıcı olarak silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hayır, silme</button>
        <button onclick="deleteRequest(event)" type="button" class="btn btn-primary" data-id="0">Evet, sil</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

    <script>
        function deleteRequest(event) {
            var id = $(event.target).data('id');
            panelLoadingOpen();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('panel.marketing.coupons.delete') }}",
                method: 'post',
                data: {
                    id: id
                },
                success: function(result) {
                    $("#deleteModal").modal("hide");
                    window.location.reload();
                }
            });
        }

        $(document).ready(function() {
            $('.delete-modal-trigger').click(function() {
                var id = $(this).data('id');
                $('#deleteModal .btn-primary').attr('data-id', id);
            });
        });
    </script>

@endsection
