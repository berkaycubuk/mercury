<div class="account-page-sidebar">
    <div class="account-page-sidebar-user">
        <span>Merhaba, <b>{{ Auth::user()->first_name }}</b></span>
    </div>
    <!-- <a href="{{ route('store.account') }}" class="{{ (Route::currentRouteName() == 'store.account') ? 'active' : '' }}">
        Hesabım
    </a> -->
    <a href="{{ route('store.addresses.index') }}" class="{{ (Route::currentRouteName() == 'store.addresses.index') ? 'active' : '' }}">
        Adresler
    </a>
    <a href="{{ route('store.orders') }}" class="{{ (Route::currentRouteName() == 'store.orders') ? 'active' : '' }}">
        Siparişlerim
    </a>
    <a href="{{ route('store.settings.index') }}" class="{{ (Route::currentRouteName() == 'store.settings.index') ? 'active' : '' }}">
        Ayarlar
    </a>
    @can('access-panel')
    <a href="{{ route('panel.homepage.index') }}">
        Yönetim Paneli
    </a>
    @endcan
</div>
