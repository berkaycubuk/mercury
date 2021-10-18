<section class="branches-slider">
    <div class="text-effect">Şubelerimiz</div>
    <div class="container">
        <h2>Şubelerimiz</h2>
        <div id="branches-slider" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach(get_settings('branches') as $branch)
                        <li class="splide__slide">
                            <div class="branch-slide">
                                <div class="branch-slide-image">
                                    <img src="{{ get_image($branch->image) }}" class="branch-slide-image" />
                                </div>
                                <div class="branch-slide-content">
                                    <div class="branch-slide-content-top">
                                        <h3>{{ $branch->name }}</h3>
                                        <p>{{ $branch->address }}</p>
                                        <div>{{ $branch->phone }}</div>
                                    </div>
                                    <div class="branch-slide-content-actions">
                                        <a href="{{ $branch->map_url }}" class="btn btn-primary">Yol Tarifi Al</a>
                                        <a href="tel:{{ $branch->phone }}" class="btn btn-primary">İletişime Geç</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            new Splide('#branches-slider', {
                perPage: 1,
                perMove: 1,
                gap: '1em',
                arrows: false,
            }).mount();
        });
    </script>
@endpush
