@inject('settings', 'App\Services\Settings')

<section class="oocta">
    <div class="oocta__images">
        <!-- <img class="oocta-image-bag" src="{{ asset('assets/store/img/oo-cta-bag.png') }}" />
        <img class="oocta-image-bread" src="{{ asset('assets/store/img/oo-cta-bread.png') }}" />
        <img class="oocta-image-cake" src="{{ asset('assets/store/img/oo-cta-cake.png') }}" />
        <img class="oocta-image-cake-2" src="{{ asset('assets/store/img/oo-cta-cake-2.png') }}" /> -->
        <img class="oocta-image-bag" src="{{ get_image($settings->getSetting('frontpage')->online_order_cta->images[0]) }}" />
        <img class="oocta-image-bread" src="{{ get_image($settings->getSetting('frontpage')->online_order_cta->images[1]) }}" />
        <img class="oocta-image-cake" src="{{ get_image($settings->getSetting('frontpage')->online_order_cta->images[2]) }}" />
        <img class="oocta-image-cake-2" src="{{ get_image($settings->getSetting('frontpage')->online_order_cta->images[3]) }}" />
    </div>
    <div class="container">
        <div class="oocta-box">
            <div class="oocta-box__dots">
                <div class="oocta-box__dot-1"></div>
                <div class="oocta-box__dot-2"></div>
                <div class="oocta-box__dot-3"></div>
            </div>
            <h2>{{ $settings->getSetting('frontpage')->online_order_cta->title }}</h2>
            <p>{{ $settings->getSetting('frontpage')->online_order_cta->description }}</p>
            <a class="btn btn-primary" href="{{ $settings->getSetting('frontpage')->online_order_cta->button->url }}">{{ $settings->getSetting('frontpage')->online_order_cta->button->text }}</a>
        </div>
    </div>
</section>
