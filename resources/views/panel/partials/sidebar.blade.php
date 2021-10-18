<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar">
    <!-- Aplication Brand -->
    <div class="app-brand">
        <a href="{{ route('panel.homepage.index') }}">
        <span class="brand-name text-truncate">Mercury {{ env('SELF_UPDATER_VERSION_INSTALLED') }}</span>
        </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-scrollbar">

        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">
            <li class="has-sub {{ (strpos(Route::currentRouteName(), 'panel.homepage') !== false) ? 'active' : ''}}" >
            <a class="sidenav-item-link" href="{{ route('panel.homepage.index') }}" data-target="#dashboard"
                aria-expanded="false" aria-controls="dashboard">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span class="nav-text">{{ trans('general.homepage') }}</span>
            </a>
            </li>

            @can('read-product')
                <li  class="has-sub {{ (strpos(Route::currentRouteName(), 'panel.products') !== false) ? 'active expand' : ''}}" >
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#products"
                    aria-expanded="false" aria-controls="blog">
                    <i class="mdi mdi-package-variant-closed"></i>
                    <span class="nav-text">{{ __('general.products') }}</span> <b class="caret"></b>
                </a>
                <ul  class="collapse {{ (strpos(Route::currentRouteName(), 'panel.products') !== false) ? 'show' : ''}}"  id="products"
                    data-parent="#sidebar-menu">
                    <div class="sub-menu">
                        <li class="{{ (Route::currentRouteName() == 'panel.products.products.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.products.products.index') }}">
                            <span class="nav-text">{{ __('general.products') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.products.categories.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.products.categories.index') }}">
                            <span class="nav-text">{{ __('general.categories') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.products.subcategories.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.products.subcategories.index') }}">
                            <span class="nav-text">{{ __('general.subcategories') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.products.attributes.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.products.attributes.index') }}">
                            <span class="nav-text">{{ __('general.attributes') }}</span>
                            </a>
                        </li>
                    </div>
                </ul>
                </li>
            @endcan

            <li  class="{{ (strpos(Route::currentRouteName(), 'panel.orders') !== false) ? 'active' : ''}}" >
            <a class="sidenav-item-link" href="{{ route('panel.orders.index') }}"
                aria-expanded="false" >
                <i class="mdi mdi-truck"></i>
                <span class="nav-text">{{ __('general.orders') }}</span>
            </a>
            </li>

            @can('read-page')
                <li  class="{{ (strpos(Route::currentRouteName(), 'panel.pages') !== false) ? 'active' : ''}}" >
                <a class="sidenav-item-link" href="{{ route('panel.pages.index') }}"
                    aria-expanded="false" >
                    <i class="mdi mdi-file"></i>
                    <span class="nav-text">{{ __('general.pages') }}</span>
                </a>
                </li>
            @endcan

            @can('read-post')
                <li  class="has-sub {{ (strpos(Route::currentRouteName(), 'panel.blog') !== false) ? 'active expand' : ''}}" >
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#blog"
                    aria-expanded="false" aria-controls="blog">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    <span class="nav-text">{{ __('general.blog') }}</span> <b class="caret"></b>
                </a>
                <ul  class="collapse {{ (strpos(Route::currentRouteName(), 'panel.blog') !== false) ? 'show' : ''}}"  id="blog"
                    data-parent="#sidebar-menu">
                    <div class="sub-menu">
                        <li class="{{ (Route::currentRouteName() == 'panel.blog.posts.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.blog.posts.index') }}">
                            <span class="nav-text">{{ __('general.posts') }}</span>
                            </a>
                        </li>
                    </div>
                </ul>
                </li>
            @endcan

            <li class="{{ (strpos(Route::currentRouteName(), 'panel.users') !== false) ? 'active' : ''}}" >
            <a class="sidenav-item-link" href="{{ route('panel.users.index') }}" data-target="#users"
                aria-expanded="false" aria-controls="users">
                <i class="mdi mdi-account-multiple"></i>
                <span class="nav-text">{{ __('general.users') }}</span>
            </a>
            </li>

            @can('read-media')
                <li  class="{{ (strpos(Route::currentRouteName(), 'panel.media') !== false) ? 'active' : ''}}" >
                <a class="sidenav-item-link" href="{{ route('panel.media.index') }}"
                    aria-expanded="false" >
                    <i class="mdi mdi-file-image"></i>
                    <span class="nav-text">{{ __('general.media') }}</span>
                </a>
                </li>
            @endcan

            <li  class="has-sub {{ (strpos(Route::currentRouteName(), 'panel.marketing') !== false) ? 'active expand' : ''}}" >
            <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#marketing"
                aria-expanded="false" aria-controls="marketing">
                <i class="mdi mdi-voice"></i>
                <span class="nav-text">{{ __('general.marketing') }}</span> <b class="caret"></b>
            </a>
            <ul  class="collapse {{ (strpos(Route::currentRouteName(), 'panel.marketing') !== false) ? 'show' : ''}}"  id="marketing"
                data-parent="#sidebar-menu">
                <div class="sub-menu">
                    <li class="{{ (Route::currentRouteName() == 'panel.marketing.coupons.index') ? 'active' : '' }}">
                        <a class="sidenav-item-link" href="{{ route('panel.marketing.coupons.index') }}">
                        <span class="nav-text">{{ __('general.coupons') }}</span>
                        </a>
                    </li>
                </div>
            </ul>
            </li>

            @can('read-settings')
                <li  class="has-sub {{ (strpos(Route::currentRouteName(), 'panel.settings') !== false) ? 'active expand' : ''}}" >
                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#settings"
                    aria-expanded="false" aria-controls="settings">
                    <i class="mdi mdi-settings"></i>
                    <span class="nav-text">{{ __('general.settings') }}</span> <b class="caret"></b>
                </a>
                <ul  class="collapse {{ (strpos(Route::currentRouteName(), 'panel.settings') !== false) ? 'show' : ''}}"  id="settings"
                    data-parent="#sidebar-menu">
                    <div class="sub-menu">
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.general') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.general') }}">
                            <span class="nav-text">{{ __('general.general') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.contact') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.contact') }}">
                            <span class="nav-text">{{ __('general.contact_info') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.mail') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.mail') }}">
                            <span class="nav-text">{{ __('general.mail') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.integrations') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.integrations') }}">
                            <span class="nav-text">{{ __('general.integrations') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.social') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.social') }}">
                            <span class="nav-text">{{ __('general.social') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.frontpage') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.frontpage') }}">
                            <span class="nav-text">{{ __('general.homepage') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.menu') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.menu') }}">
                            <span class="nav-text">{{ __('general.menu') }}</span>
                            </a>
                        </li>
                        <li class="{{ (Route::currentRouteName() == 'panel.settings.shipment') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('panel.settings.shipment') }}">
                            <span class="nav-text">{{ __('general.shipping') }}</span>
                            </a>
                        </li>
                    </div>
                </ul>
                </li>
            @endcan
        </ul>
    </div>
    </div>
</aside>
