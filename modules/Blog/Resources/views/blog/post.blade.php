@extends('core::layouts.store')

@section('content')

<section class="blog-post-page container">
    <div class="blog-post-page-meta">
        <!-- <b>Tatlılar -</b> --> {{ $post->translated_created_at }}
    </div>
    <h1 class="blog-post-page-title">{{ $post->title }}</h1>

    <div class="blog-post-page-content">
        {!! $post->content !!}
    </div>

    <div class="blog-post-page-bottom">
    <!-- 
        <div class="blog-post-page-bottom-author">
            <img class="author-image" src="{{ get_image(0) }}" />
            <div class="author-info">
                <span class="author-name">Ali Veli</span>
                <span class="author-title">ABC Restoran Şefi</span>
            </div>
        </div>

        <div class="blog-post-page-bottom-social">
            <span class="blog-post-page-bottom-social-title">Paylaş:</span>
            <div class="blog-post-page-bottom-social-items">
                <a href="#"><img src="{{ asset('assets/store/img/facebook.svg') }}" /></a>
                <a href="#"><img src="{{ asset('assets/store/img/twitter.svg') }}" /></a>
                <a href="#"><img src="{{ asset('assets/store/img/instagram.svg') }}" /></a>
                <a href="#"><img src="{{ asset('assets/store/img/youtube.svg') }}" /></a>
            </div>
        </div>
    -->
    </div>

    <h3 style="font-size: 2rem;color: var(--color-black);">Diğer yazılarımız</h3>

    <div style="margin-top: 0; padding-top: 0;" class="blog-posts-section">
        <div class="container">
            <div id="blog-posts-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($posts as $post)
                            <li class="splide__slide">
                                <div class="blog-post">
                                    <img class="blog-post-image" src="{{ get_image(0) }}" />
                                    <div class="blog-post-meta">
                                        {{ $post->translated_created_at }}
                                    </div>
                                    <h3>{{ $post->title }}</h3>
                                    <!-- <p>
                                        Lorem ipsum dolor sit amet, consetetur sadipscing
                                        elitr, sed diam nonumy eirmod tempor invidunt
                                        ut labore et dolore magna.
                                    </p> -->
                                    <a class="btn btn-primary" href="{{ route('store.blog.post', ['slug' => $post->slug]) }}">Devamını Oku</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
</section>

@endsection
