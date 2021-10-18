@inject('notifications', 'App\Services\Notifications')

<!--
    Notifications badge override
-->
<style>
    .notifications-menu .dropdown-toggle::after {
        visibility: hidden;
    }
    .notifications-menu .dropdown-toggle.active::after {
        visibility: visible;
    }
</style>

<header class="main-header " id="header">
    <nav class="navbar navbar-static-top navbar-expand-lg">
        <button id="sidebar-toggler" class="sidebar-toggle">
        <span class="sr-only">Toggle navigation</span>
        </button>

        <div class="navbar-right ml-auto">
        <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
                <a class="dropdown-toggle" href="{{ route('panel.updates') }}">
                    <i class="mdi mdi-cloud-download-outline"></i>
                </a>
            </li>
            <li class="dropdown notifications-menu">
                <button class="dropdown-toggle {{ count($notifications->getHeaderNotifications()) != 0 ? 'active' : '' }}" data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">{{ count($notifications->getHeaderNotifications()) }} Okunmamış Bildirim</li>
                    @foreach($notifications->getHeaderNotifications()->take(5) as $notification)
                        @if($notification->type == 'App\Notifications\OrderSubmitted')
                        <li>
                        <a href="{{ route('panel.notifications.details', ['id' => $notification->id]) }}">
                            <i class="mdi mdi-cart-outline"></i> Yeni sipariş alındı
                            <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                        </li>
                        @endif
                        @if($notification->type == 'App\Notifications\ContactMessage')
                        <li>
                        <a href="{{ route('panel.notifications.details', ['id' => $notification->id]) }}">
                            <i class="mdi mdi-message-outline"></i> Yeni mesaj
                            <span class=" font-size-12 d-inline-block float-right"><i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}</span>
                        </a>
                        </li>
                        @endif
                    @endforeach
                    <li class="dropdown-footer">
                    <a class="text-center" href="{{ route('panel.notifications') }}"> Tüm Bildirimler </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown user-menu">
            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="d-none d-lg-inline-block">{{ trans('general.hi') }}, {{ Auth::user()->first_name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    {{ Auth::user()->full_name }}
                </li>
                <li class="right-sidebar-in">
                    <a href="/">{{ trans('general.return_to_site') }}</a>
                </li>
                <li class="right-sidebar-in">
                    <a href="{{ route('panel.auth.settings') }}">Hesap Ayarları</a>
                </li>
                <li class="dropdown-footer">
                    <a href="{{ route('panel.logout') }}"> <i class="mdi mdi-logout"></i>{{ trans('general.logout') }}</a>
                </li>
            </ul>
            </li>
        </ul>
        </div>
    </nav>
    @if(get_settings('site')->service_mode)
        <div class="bg-warning p-2 font-weight-bold text-white text-center">
            BAKIM MODU AKTİF &nbsp; <span class="font-weight-normal">Bakım modunu <a class="text-white font-weight-bold" href="{{ route('panel.settings.general') }}">ayarlar sayfasından</a> kapatabilirsiniz.</span>
        </div>
    @endif 
</header>
