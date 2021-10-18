@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Bildirimler</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Mesaj</th>
                            <th scope="col">Bildirim Zamanı</th>
                            <th class="text-right">{{ trans('general.settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            @if($notification->type == 'App\Notifications\OrderSubmitted')
                            <tr>
                                <td><a class="{{ $notification->read_at != null ? 'text-secondary' : '' }}" href="{{ route('panel.notifications.details', ['id' => $notification->id]) }}"><i class="mdi mdi-cart-outline"></i> Yeni sipariş alındı</a></td>
                                <td><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.notifications.delete', ['id' => $notification->id]) }}">Bildirimi Sil</a>
                                        </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                            @endif
                            @if($notification->type == 'App\Notifications\ContactMessage')
                            <tr>
                                <td><a class="{{ $notification->read_at != null ? 'text-secondary' : '' }}" href="{{ route('panel.notifications.details', ['id' => $notification->id]) }}"><i class="mdi mdi-message-outline"></i> İletişim formuna yeni mesaj gönderildi</a></td>
                                <td><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</td>
                                <td class="text-right">
                                <div class="dropdown show d-inline-block widget-dropdown">
                                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                                        <li class="dropdown-item">
                                            <a href="{{ route('panel.notifications.delete', ['id' => $notification->id]) }}">Bildirimi Sil</a>
                                        </li>
                                    </ul>
                                </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
