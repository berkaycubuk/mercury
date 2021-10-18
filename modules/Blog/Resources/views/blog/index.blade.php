@extends('core::layouts.store')

@section('content')

<section class="blog-hero">
    <div class="blog-hero-content container">
        <div class="blog-hero-content-meta">
            <!-- <b>Tatlılar -</b> --> {{ $posts[0]->translated_created_at }}
        </div>
        <h2>{{ $posts[0]->title }}</h2>
        <!-- <p>
            Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
            sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
        </p> -->
        <a class="btn btn-transparent" href="{{ route('store.blog.post', ['slug' => $posts[0]->slug]) }}">Devamını Oku</a>
    </div>
    <div class="blog-hero-effect"></div>
    <img class="blog-hero-background" src="{{ get_image($posts[0]->thumbnail) }}" />
</section>

<section class="blog container">
    <div class="blog-col-2">
        <div class="blog-post">
            <img class="blog-post-image" src="{{ get_image($posts[1]->thumbnail) }}" />
            <div class="blog-post-meta">
                <!-- <b>Tatlılar -</b> --> {{ $posts[1]->translated_created_at }}
            </div>
            <h3>{{ $posts[1]->title }}</h3>
            <!-- <p>
                Lorem ipsum dolor sit amet, consetetur sadipscing
                elitr, sed diam nonumy eirmod tempor invidunt
                ut labore et dolore magna.
            </p> -->
            <a class="btn btn-primary" href="{{ route('store.blog.post', ['slug' => $posts[1]->slug]) }}">Devamını Oku</a>
        </div>
        <div class="blog-post">
            <img class="blog-post-image" src="{{ get_image($posts[2]->thumbnail) }}" />
            <div class="blog-post-meta">
                <!-- <b>Tatlılar -</b> --> {{ $posts[2]->translated_created_at }}
            </div>
            <h3>{{ $posts[2]->title }}</h3>
            <!-- <p>
                Lorem ipsum dolor sit amet, consetetur sadipscing
                elitr, sed diam nonumy eirmod tempor invidunt
                ut labore et dolore magna.
            </p> -->
            <a class="btn btn-primary" href="{{ route('store.blog.post', ['slug' => $posts[2]->slug]) }}">Devamını Oku</a>
        </div>
    </div>
    <div class="blog-col-3">
        @foreach($posts as $post)
            @if($loop->index > 2)
                <div class="blog-post">
                    <img class="blog-post-image" src="{{ get_image($post->thumbnail) }}" />
                    <div class="blog-post-meta">
                        <!-- <b>Tatlılar -</b> --> {{ $post->translated_created_at }}
                    </div>
                    <h3>{{ $post->title }}</h3>
                    <!-- <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing
                        elitr, sed diam nonumy eirmod tempor invidunt
                        ut labore et dolore magna.
                    </p> -->
                    <a class="btn btn-primary" href="{{ route('store.blog.post', ['slug' => $post->slug]) }}">Devamını Oku</a>
                </div>
            @endif
        @endforeach
    </div>
</section>

@endsection
