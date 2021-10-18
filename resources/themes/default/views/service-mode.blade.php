@inject('settings', 'App\Services\Settings')

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="robots" content="noindex, nofollow">
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    </head>
    <body>
        <div class="container vh-100 d-flex flex-column justify-content-center">
            <div class="d-flex flex-column justify-content-between">
                <div class="col-6 col-md-3 mx-auto">
                    <img class="w-100" src="{{ get_image(get_settings('site')->logo) }}" />
                </div>
                <h1 class="text-center mt-5">Websitemiz Yeni Tasarımıyla Çok Yakında Sizlerle</h1>

                <div class="my-5"></div>

                <div class="d-flex flex-wrap gap-4 justify-content-center">
                    <a style="height: 60px; width: 60px; background-color: #683B0C;" class="rounded-circle d-flex  align-items-center justify-content-center p-3 fs-2" href="{{ $settings->getSetting('site')->facebook_url }}"><i class="bi bi-facebook text-white"></i></a>
                    <a style="height: 60px; width: 60px; background-color: #683B0C;" class="rounded-circle d-flex  align-items-center justify-content-center p-3 fs-2" href="{{ $settings->getSetting('site')->instagram_url }}"><i class="bi bi-instagram text-white"></i></a>
                    <a style="height: 60px; width: 60px; background-color: #683B0C;" class="rounded-circle d-flex  align-items-center justify-content-center p-3 fs-2" href="tel:{{ $settings->getSetting('site')->phone }}"><i class="bi bi-telephone-fill text-white"></i></a>
                    <a style="height: 60px; width: 60px; background-color: #683B0C;" class="rounded-circle d-flex  align-items-center justify-content-center p-3 fs-2" href="https://goo.gl/maps/2F5k4tsnB85uVpUz8"><i class="bi bi-geo-alt-fill text-white"></i></a>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>
