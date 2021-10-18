@inject('settings', 'App\Services\Settings')

<section class="tstory">
    <div class="tstory__circle1">
        <div class="tstory__circle1__inner"></div>
    </div>
    <div class="container">
        <div class="tstory-left">
            <img src="{{ get_image($settings->getSetting('frontpage')->the_story->image) }}" />
        </div>
        <div class="tstory-right">
            <h2>{{ $settings->getSetting('frontpage')->the_story->title }}</h2>
            <p>{{ $settings->getSetting('frontpage')->the_story->description }}</p>
            <a href="{{ $settings->getSetting('frontpage')->the_story->button->url }}" class="btn btn-primary">{{ $settings->getSetting('frontpage')->the_story->button->text }}</a>
        </div>
    </div>
</section>
