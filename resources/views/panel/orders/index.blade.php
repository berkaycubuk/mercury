@extends('panel::layouts.panel')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Siparişler</h2>
            </div>
            <div class="card-body">
                @if(count($orders))
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">{{ trans_choice('general.orders', 1) }}</th>
                            <th scope="col">{{ trans('general.created_at') }}</th>
                            <th scope="col">{{ trans('general.status') }}</th>
                            <th scope="col">{{ trans('general.total') }}</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ route('panel.orders.edit', ['id' => $order->id]) }}">#{{ $order->meta['code'] }}</a></td>
                                <td>{{ $order->translated_created_at }}</td>
                                <td>
                                    @if($order->state == 0)
                                    <span class="badge badge-info">Beklemede</span>
                                    @elseif($order->state == 1)
                                    <span class="badge badge-success">Tamamlandı</span>
                                    @elseif($order->state == 2)
                                    <span class="badge badge-warning">Ödenmedi</span>
                                    @elseif($order->state == 3)
                                    <span class="badge badge-danger">İptal Edildi</span>
                                    @elseif($order->state == 4)
                                    <span class="badge badge-primary">Onaylandı<br/>{{ get_branch_name($order->meta['confirmer_branch'])->name }}</span>
                                    @endif
                                </td>
                                <td>₺{{ $order->meta['total_price']}}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.orders.edit', ['id' => $order->id]) }}">{{ trans('general.edit') }}</a>
                                    </li>
                                    <li class="dropdown-item">
                                        <a href="{{ route('panel.orders.delete', ['id' => $order->id]) }}">{{ trans('general.delete') }}</a>
                                    </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $orders->links() }}
                @else
                <p>Henüz sipariş bulunmamakta.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
