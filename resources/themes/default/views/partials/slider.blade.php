@inject('settings', 'App\Services\Settings')

<section class="slider slider-main">
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($settings->getSetting('frontpage')->main_slider as $slide)
                    <li class="splide__slide">
                        <div class="slider-slide-content container">
                            <h2>{{ $slide->title }}</h2>
                            <p>{{ $slide->description }}</p>
                            @if($slide->button->text)
                                <a class="btn btn-transparent" href="{{ $slide->button->url }}">{{ $slide->button->text }}</a>
                            @endif
                        </div>
                        <div class="slide-image-modifier"></div>
                        <img src="{{ get_image($slide->image) }}" />
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="splide__progress">
            <div class="splide__progress__bar">
            </div>
        </div>
    </div>
</section>

@section('scripts')
    <script>
        new Splide( '.splide', {
            type: 'loop',
            autoplay: true,
            interval: 5000,
            arrows: false,
        }).mount();
    </script>
@endsection
