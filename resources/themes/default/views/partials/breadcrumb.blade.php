<div class="breadcrumb container">
    <ul>
        <li><a href="{{ route('store.index') }}">Home</a></li>
        @foreach(explode("/", Request::path()) as $url_path_item)
            @if($loop->last)
                <li class="active">{{ $url_path_item }}</li>
            @else
                @if($loop->index != 0)
                    @php
                        $url_string = "";
                        foreach(explode("/", Request::path()) as $key=>$value) {
                            if($key != array_key_last(explode("/", Request::path()))) {
                                $url_string .= "/" . $value;
                            }
                        }
                    @endphp
                    <li><a href="{{ $url_string }}">{{ explode("/", Request::path())[$loop->index] }}</a></li>
                @else
                    <li><a href="/{{ $url_path_item }}">{{ $url_path_item }}</a></li>
                @endif
            @endif
        @endforeach
    </ul>
</div>

