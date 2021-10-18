@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Özelliği Düzenle</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <form>
                            <h4>İfade Ekle</h4><br />
                            <input type="hidden" id="attribute-id" name="id" value="{{ $attribute->id }}">
                            <div class="form-group">
                                <label for="term-name">Ad</label>
                                <input type="text" class="form-control" id="term-name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="term-price">Fiyat (Boş bırakabilirsiniz)</label>
                                <input type="number" class="form-control" id="term-price" name="price">
                            </div>
                            <button id="new-term-btn" class="btn btn-primary">Ekle</button>
                        </form>
                    </div>
                    <div class="col-lg-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ trans('general.name') }}</th>
                                    <th scope="col">Fiyat</th>
                                    <th class="text-right">{{ trans('general.settings') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attribute->terms_json as $term)
                                    <tr>
                                        <td>{{ $term->name }}</td>
                                        <td>
                                            @if(isset($term->price))
                                            {{ $term->price }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown show d-inline-block widget-dropdown">
                                                <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                                <!-- 
                                                <li class="dropdown-item">
                                                    <a href="{{ route('panel.products.attributes.edit', ['id' => $attribute->id]) }}">{{ trans('general.edit') }}</a>
                                                </li>
                                                -->
                                                <li class="dropdown-item">
                                                    <a href="{{ route('panel.products.attributes.delete-term', ['id' => $attribute->id, 'id2' => $term->uid]) }}">{{ trans('general.delete') }}</a>
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
            $('#new-term-btn').click(function(event) {
                event.preventDefault();

                attributeId = $('#attribute-id').val();
                termName = $('#term-name').val();
                termPrice = $('#term-price').val();

                if (!termName) {
                    return;
                }

                panelLoadingOpen();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('panel.products.attributes.create-term') }}",
                    method: 'post',
                    data: {
                        id: attributeId,
                        name: termName,
                        price: termPrice
                    },
                    success: function(result) {
                        $('#term-name').val('');
                        location.reload();
                    }
                });
            });
        });
    </script>

@endsection
