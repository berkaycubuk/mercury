@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.blog') }} {{ trans_choice('general.categories', 1) }}</h2>
            </div>
            <div class="card-body">
                <a class="btn btn-primary mb-2" href="{{ route('panel.blog.categories.create') }}">{{ trans('general.add_new') }}</a>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ trans('general.name') }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td><a href="{{ route('panel.blog.categories.edit', ['id' => $category->id]) }}">{{ $category->name }}</a></td>
                                <td>{{ $category->created_at }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.blog.categories.edit', ['id' => $category->id]) }}">{{ trans('general.edit') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.blog.categories.delete', ['id' => $category->id]) }}">{{ trans('general.delete') }}</a>
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
@endsection
