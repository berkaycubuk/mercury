@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Kullanıcılar</h2>
                <a class="ml-auto btn btn-primary" href="{{ route('panel.users.export') }}">Dışa Aktar (.xlsx)</a>
                @include('panel::partials.import', ['actionUrl' => route('panel.users.import')])
            </div>
            <div class="card-body">
                <a class="btn btn-primary mb-2" href="{{ route('panel.users.create') }}">{{ trans('general.add_new') }}</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ trans('general.name') }}</th>
                            <th scope="col">{{ trans('general.email') }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><a href="{{ route('panel.users.edit', ['id' => $user->id]) }}">{{ $user->full_name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->translated_created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.users.edit', ['id' => $user->id]) }}">{{ trans('general.edit') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a class="delete-user-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteUserModal" data-user-id="{{ $user->id }}">{{ trans('general.delete') }}</a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          Bu kullanıcıyı kalıcı olarak silmek istediğinize emin misiniz?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hayır, silme</button>
        <button onclick="deleteUserRequest(event)" type="button" class="btn btn-primary" data-user-id="0">Evet, sil</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

    <script>
        function deleteUserRequest(event) {
            var userId = $(event.target).data('user-id');
            panelLoadingOpen();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('panel.users.delete') }}",
                method: 'post',
                data: {
                    id: userId
                },
                success: function(result) {
                    $("#deleteUserModal").modal("hide");
                    window.location.reload();
                }
            });
        }

        $(document).ready(function() {
            $('.delete-user-modal-trigger').click(function() {
                var userId = $(this).data('user-id');
                $('#deleteUserModal .btn-primary').attr('data-user-id', userId);
            });
        });
    </script>

@endsection
