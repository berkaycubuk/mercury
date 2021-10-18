@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ __('general.attributes') }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <form>
                            <h4>{{ __('general.new_attribute') }}</h4><br />
                            <div class="form-group">
                                <label for="attribute-name">{{ __('general.name') }}</label>
                                <input type="text" class="form-control" id="attribute-name" name="name" required>
                            </div>
                            <button id="new-attribute-btn" class="btn btn-primary">{{ __('general.add') }}</button>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('general.name') }}</th>
                                    <th scope="col">{{ __('general.terms') }}</th>
                                    <th class="text-right">{{ __('general.settings') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attributes as $attribute)
                                    <tr>
                                        <td><a href="{{ route('panel.products.attributes.edit', ['id' => $attribute->id]) }}">{{ $attribute->name }}</a></td>
                                        <td>
                                            <div>
                                                @foreach($attribute->terms_json as $term)
                                                    @if($loop->index < 3)
                                                        {{ $term->name }}
                                                        @if(!$loop->last)
                                                        ,
                                                        @endif
                                                    @else
                                                        @if($loop->last)
                                                        ...
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                            <a href="{{ route('panel.products.attributes.edit-terms', ['id' => $attribute->id]) }}">{{ __('general.edit_terms') }}</a>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown show d-inline-block widget-dropdown">
                                                <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                                <li class="dropdown-item">
                                                    <a href="{{ route('panel.products.attributes.edit', ['id' => $attribute->id]) }}">{{ __('general.edit') }}</a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{ route('panel.products.attributes.delete', ['id' => $attribute->id]) }}">{{ __('general.delete') }}</a>
                                                </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#new-attribute-btn').click(function(event) {
                event.preventDefault();

                attributeName = $('#attribute-name').val();

                if (!attributeName) {
                    return;
                }

                panelLoadingOpen();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('panel.products.attributes.create') }}",
                    method: 'post',
                    data: {
                        name: attributeName
                    },
                    success: function(result) {
                        location.reload();
                    }
                });
            });
        });
    </script>

@endsection
