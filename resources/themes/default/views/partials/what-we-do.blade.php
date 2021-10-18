@inject('settings', 'App\Services\Settings')

<section class="wwd">
    <div class="wwd__circle1">
        <div class="wwd__circle1__inner"></div>
    </div>
    <div class="container">
        <div class="wwd-left">
            <h2>{{ $settings->getSetting('frontpage')->what_we_do->title }}</h2>
            <p>{{ $settings->getSetting('frontpage')->what_we_do->description }}</p>
            <img src="{{ get_image($settings->getSetting('frontpage')->what_we_do->images[0]) }}" />
        </div>
        <div class="wwd-right">
            <img src="{{ get_image($settings->getSetting('frontpage')->what_we_do->images[1]) }}" />
            <div>
                <img src="{{ get_image($settings->getSetting('frontpage')->what_we_do->images[2]) }}" />
                <img src="{{ get_image($settings->getSetting('frontpage')->what_we_do->images[3]) }}" />
            </div>
        </div>
    </div>
</section>
