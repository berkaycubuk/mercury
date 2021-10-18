<section class="similar-products container">
    <h2>Benzer Ürünler</h2>
    <div id="similar-products-slider" class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach($similar_products as $similar_product)
                    <li class="splide__slide">
                        @include('core::partials.product', ['product' => $similar_product])
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

@push('scripts')

    <script>
        $(document).ready(function() {
            // Sliders
            new Splide('#similar-products-slider', {
                perPage: 4,
                perMove: 1,
                gap: '1em',
                arrows: false,
                breakpoints: {
                    1200: {
                        perPage: 3
                    },
                    992: {
                        perPage: 2
                    },
                    768: {
                        perPage: 1
                    }
                }
            }).mount();
        });
    </script>
@endpush
