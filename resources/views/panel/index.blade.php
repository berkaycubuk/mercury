@extends('panel::layouts.panel')

@inject('analytics', 'App\Services\Analytics')

@section('content')
        <!-- Top Statistics -->
        <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card widget-block mb-4 p-4 bg-danger border">
                <div class="card-block">
                    <i class="mdi mdi-account-outline mr-4 text-white"></i>
                    <h4 class="text-white my-2">{{ $analytics->getTodaysSignups() }}</h4>
                    <p>{{ __('widgets.todays_new_users.title') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card widget-block mb-4 p-4 bg-primary border">
                <div class="card-block">
                    <i class="mdi mdi-account-outline mr-4 text-white"></i>
                    <h4 class="text-white my-2">{{ $analytics->getTodaysVisitors() }}</h4>
                    <p>{{ __('widgets.todays_visitors.title') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card widget-block mb-4 p-4 bg-warning border">
                <div class="card-block">
                    <i class="mdi mdi-cart-outline mr-4 text-white"></i>
                    <h4 class="text-white my-2">{{ $analytics->getTodaysOrders() }}</h4>
                    <p>{{ __('widgets.todays_orders.title') }}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card widget-block mb-4 p-4 bg-success border">
                <div class="card-block">
                    <i class="mdi mdi-cash-multiple mr-4 text-white"></i>
                    <h4 class="text-white my-2">{{ $analytics->getTodaysTransactions() }}</h4>
                    <p>{{ __('widgets.todays_payments.title') }}</p>
                </div>
            </div>
        </div>
        </div>

            <div class="row">
                <div class="col-12">
        <!-- Recent Order Table -->
        <div class="card card-table-border-none" id="recent-orders">
        <div class="card-header">
            <h2>{{ __('general.last_orders') }}</h2> <a href="{{ route('panel.orders.index') }}" style="margin-left: 10px;">{{ __('general.all_orders') }}</a>
        </div>
        <div class="card-body pt-0 pb-5">
            @if(count($latest_orders))
            <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                <thead>
                    <tr>
                        <th>{{ __('general.order_code') }}</th>
                        <th class="d-none d-lg-table-cell">{{ __('general.date') }}</th>
                        <th class="d-none d-lg-table-cell">{{ __('general.price') }}</th>
                        <th>{{ __('general.state') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latest_orders as $order)
                    <tr>
                        <td ><a href="{{ route('panel.orders.edit', ['id' => $order->id]) }}">#{{ $order->meta['code'] }}</a></td>
                        <td class="d-none d-lg-table-cell">{{ $order->created_at }}</td>
                        <td class="d-none d-lg-table-cell">₺{{ $order->meta['total_price']}}</td>
                        <td >
                            @if($order->state == 0)
                            <span class="badge badge-info">{{ __('general.waiting') }}</span>
                            @elseif($order->state == 1)
                            <span class="badge badge-success">{{ __('general.finished') }}</span>
                            @elseif($order->state == 2)
                            <span class="badge badge-warning">{{ __('general.not_paid') }}</span>
                            @elseif($order->state == 3)
                            <span class="badge badge-danger">{{ __('general.canceled') }}</span>
                            @elseif($order->state == 4)
                            <span class="badge badge-primary">{{ __('general.confirmed') }}<br/>{{ get_branch_name($order->meta['confirmer_branch'])->name }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="dropdown show d-inline-block widget-dropdown">
                            <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                <li class="dropdown-item">
                                <a href="{{ route('panel.orders.edit', ['id' => $order->id]) }}">{{ __('general.details') }}</a>
                                </li>
                            </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>{{ __('general.no_orders_available') }}</p>
            @endif
        </div>
    </div>
</div>
            </div>
@endsection
