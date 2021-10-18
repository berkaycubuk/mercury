@inject('menuService', 'App\Services\Menu')

@php
    $authCheck = true;

    if (!empty(auth()->user()) && auth()->user()->role == 'admin') {
        $authCheck = false;
    }
@endphp

@if(isset(get_settings('site')->service_mode) && get_settings('site')->service_mode && $authCheck)
@else    
<header class="header">
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="/">
            <img width="50" height="50" src="{{ get_image(get_settings('site')->logo)}}" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @foreach($settings->getMenu('header') as $menu)
                @if(isset($menu->items))
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="{{ str_replace(' ', '', $menu->title) }}" role="button" data-bs-toggle="dropdown" data-bs-target="" aria-expanded="false">
                    {{ $menu->title }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="{{ str_replace(' ', '', $menu->title) }}">
                    @foreach($menu->items as $item)
                        @if(isset($item->items))
                        <li>
                          <a class="dropdown-item" href="#">
                            {{ $item->title }}
                          </a>
                          <ul class="submenu dropdown-menu">
                            @foreach($item->items as $subitem)
                                <li><a class="dropdown-item" href="{{ $subitem->url }}">{{ $subitem->title }}</a></li>
                            @endforeach
                          </ul>
                        </li>
                        @else
                        <li><a class="dropdown-item" href="{{ $item->url }}">{{ $item->title }}</a></li>
                        @endif
                    @endforeach
                  </ul>
                </li>
                @else
                <li class="nav-item">
                  <a class="nav-link" href="{{ $menu->url }}">{{ $menu->title }}</a>
                </li>
                @endif
            @endforeach
          </ul>
            <ul class="navbar-nav">
               <li class="nav-item dropdown">
                    @auth
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @include('core::svg.person') Account
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('store.account') }}">Account</a></li>
                    <li><a class="dropdown-item" href="{{ route('store.logout') }}">Logout</a></li>
                  </ul>
                    @else
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @include('core::svg.person') Login / Register
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('store.login') }}">Login</a></li>
                    <li><a class="dropdown-item" href="{{ route('store.register') }}">Register</a></li>
                  </ul>
                    @endauth
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.cart') }}">
                        @include('core::svg.cart') My Cart
                    </a>
                </li>
            </ul>
        </div>
      </div>
    </nav>
</header>
@endif

@push('scripts')
    <script>
        function toggleMobileMenu() {
            $('#mobile-dropdown').toggleClass('active');
            $('#mobile-nav-hamburger-action').toggleClass('active');
        }

        function toggleMobileDropdown(event) {
            $(event.target).parent().find('.mobile-dropdown-list').eq(0).toggleClass('active');
        }
    </script>
@endpush
