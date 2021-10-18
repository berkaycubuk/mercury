@inject('settings', 'App\Services\Settings')

<section class="scp">
    <div class="container">
        <h2>{{ $settings->getSetting('frontpage')->product_showcase->title }}</h2>
        <p>{{ $settings->getSetting('frontpage')->product_showcase->description }}</p>
        <div class="scp-products">
            @foreach($new_products as $product)
                @include('core::partials.product')
            @endforeach
        </div>
        <div class="scp-more">
            <a href="{{ $settings->getSetting('frontpage')->product_showcase->button->url }}" class="btn btn-primary">{{ $settings->getSetting('frontpage')->product_showcase->button->text }}</a>
        </div>
    </div>
    <div class="bg-effect"></div>
</section>
