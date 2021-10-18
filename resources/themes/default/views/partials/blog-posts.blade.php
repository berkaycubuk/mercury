<section class="blog-posts-section">
    <div class="text-effect">Blog Yazılarımız</div>
    <div class="container">
        <h2>Blog Yazılarımız</h2>
        <p>Alanında uzman kişilerin kaleme aldığı yararlı bilgiler ve daha fazlası.</p>
        <div id="blog-posts-slider" class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($posts as $post)
                        <li class="splide__slide">
                            <div class="blog-post">
                                <img class="blog-post-image" src="{{ get_image(0) }}" />
                                <div class="blog-post-meta">
                                    {{ $post->created_at->format('d M Y') }}
                                </div>
                                <h3>{{ $post->title }}</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consetetur sadipscing
                                    elitr, sed diam nonumy eirmod tempor invidunt
                                    ut labore et dolore magna.
                                </p>
                                <a class="btn btn-primary" href="{{ route('store.blog.post', ['slug' => $post->slug]) }}">Devamını Oku</a>
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
            new Splide('#blog-posts-slider', {
                perPage: 4,
                perMove: 1,
                gap: '1em',
                arrows: false,
                breakpoints: {
                    1600: {
                        perPage: 3
                    },
                    993: {
                        perPage: 2
                    },
                    500: {
                        perPage: 1
                    }
                }
            }).mount();
        });
    </script>
@endpush
