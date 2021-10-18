@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.media') }}</h2>
            </div>
            <div class="card-body">
                @can('create-media')
                    <a class="btn btn-primary mb-2" href="{{ route('panel.media.create') }}">{{ trans('general.add_new') }}</a>
                @endcan

                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">{{ trans('general.name') }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($media as $item)
                            <tr>
                                <td><input type="checkbox" /></td>
                                <td><a href="{{ route('panel.media.edit', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
                                <td>{{ $item->created_at }}</td>
                                <td class="text-right">
                                  <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        @can('update-media')
                                            <li class="dropdown-item">
                                                <a href="{{ route('panel.media.edit', ['id' => $item->id]) }}">{{ trans('general.edit') }}</a>
                                            </li>
                                        @endcan
                                        @can('delete-media')
                                            <li class="dropdown-item">
                                                <a href="{{ route('panel.media.delete', ['id' => $item->id]) }}">{{ trans('general.delete') }}</a>
                                            </li>
                                        @endcan
                                    </ul>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $media->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
