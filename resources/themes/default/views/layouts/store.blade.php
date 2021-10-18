@inject('settings', 'App\Services\Settings')

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />
        @if(isset($site_meta))
            @if(isset($site_meta['title']))
            <title>{{ $site_meta['title'] }} - {{ $settings->getSetting('site')->title }}</title>
            @endif
            @if(isset($site_meta['description']))
            <meta name="description" content="{{ $site_meta['description'] }}" />
            @endif
        @else
		<title>{{ $settings->getSetting('site')->title }}</title>
        <meta name="description" content="{{ $settings->getSetting('site')->description }}" />
        @endif
        @if(isset($settings->getSetting('site')->favicon) && $settings->getSetting('site')->favicon != 0)
        <link rel="shortcut icon" href="{{ get_image($settings->getSetting('site')->favicon) }}" />
        @endif
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="{{ asset(currentTheme()->assetsPath . '/css/splide.min.css') }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset(currentTheme()->assetsPath . '/css/bootstrap.min.css') }}"/>
        @if($settings->getSetting("integration")->google_analytics != null)
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->getSetting("integration")->google_analytics }}"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', '{{ $settings->getSetting("integration")->google_analytics }}');
            </script>
        @endif
    </head>
    @if(isset($_COOKIE['colormode-cookie']))
	<body data-theme="{{ $_COOKIE['colormode-cookie'] }}">
    @else
	<body>
    @endif
        @include('core::partials.loading')

        @include('core::partials.header')

        <main>
            @yield('content')
        </main>

        @include('core::partials.footer')

        <script src="{{ asset(currentTheme()->assetsPath . '/js/jquery.min.js') }}"></script>
        <script src="{{ asset(currentTheme()->assetsPath . '/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset(currentTheme()->assetsPath . '/js/splide.min.js') }}"></script>

        <script>

            function run_loading() {
                $('.loading').addClass('active');
            }

            function stop_loading() {
                $('.loading').removeClass('active');
            }
        </script>

        @stack('scripts')
		@yield('scripts')
	</body>
</html>
