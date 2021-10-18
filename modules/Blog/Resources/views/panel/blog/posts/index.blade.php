@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Yazılar</h2>
            </div>
            <div class="card-body">
                @can('create-post')
                    <a class="btn btn-primary mb-2" href="{{ route('panel.blog.posts.create') }}">{{ trans('general.add_new') }}</a>
                @endcan

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ trans('general.title.default') }}</th>
                            <th scope="col">{{ trans('general.author') }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><a href="{{ route('panel.blog.posts.edit', ['id' => $post->id]) }}">{{ $post->title }}</a></td>
                                <td>berkaycubuk</td>
                                <td>{{ $post->translated_created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    @can('update-post')
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.blog.posts.edit', ['id' => $post->id]) }}">{{ trans('general.edit') }}</a>
                                        </li>
                                    @endcan
                                    @can('delete-post')
                                        <li class="dropdown-item">
                                            <a class="delete-modal-trigger" style="cursor: pointer" data-toggle="modal" data-target="#deleteModal" data-id="{{ $post->id }}">{{ trans('general.delete') }}</a>
                                        </li>
                                    @endcan
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $posts->links() }}
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
          Bu sayfayı kalıcı olarak silmek istediğinize emin misiniz?
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
                    'x-csrf-token': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('panel.blog.posts.delete') }}",
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
