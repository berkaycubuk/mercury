@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.categories') }}</h2>
                <a class="ml-auto btn btn-primary" href="{{ route('panel.products.categories.export') }}">{{ __('general.export') }} (.xlsx)</a>
                @include('panel::partials.import', ['actionUrl' => route('panel.products.categories.import')])
            </div>
            <div class="card-body">
                <a class="btn btn-primary mb-2" href="{{ route('panel.products.categories.create') }}">{{ __('general.add_new') }}</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ __('general.name') }}</th>
                            <th scope="col">{{ __('general.created_at') }}</th>
                            <th class="text-right">{{ __('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><a href="{{ route('panel.products.categories.edit', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                                <td>{{ $category->translated_created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.products.categories.edit', ['id' => $category->id]) }}">{{ trans('general.edit') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a class="delete-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" data-id="{{ $category->id }}">{{ trans('general.delete') }}</a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $categories->links() }}
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
        {{ __('alert.delete_category_msg') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.no') }}</button>
        <button onclick="deleteRequest(event)" type="button" class="btn btn-primary" data-id="0">{{ __('general.yes') }}</button>
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
                url: "{{ route('panel.products.categories.delete') }}",
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
