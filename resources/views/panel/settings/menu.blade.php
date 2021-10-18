@extends('panel::layouts.panel')

@section('content')

@inject('settings', 'App\Services\Settings')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Menü Ayarları</h2>
            </div>
            <div class="card-body">
                @if (session('form_error'))
                    <div class="alert alert-danger">
                        {{ session('form_error') }}
                    </div>
                @endif
                @if (session('form_success'))
                    <div class="alert alert-success">
                        {{ session('form_success') }}
                    </div>
                @endif
                <form action="{{ route('panel.settings.menu.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h4>Özel Günler</h4>
                        <input type="hidden" id="special-menu-data" name="special-menu" value="{{ json_encode($settings->getMenu('special')) }}" />
                        <br />
                        @can('update-settings')
                            <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                        @endcan
                        <br />
                        <br />
                        <button class="btn btn-primary btn-sm" onclick="addBlockWithUrl(event)">Yeni Link</button>
                        <br />
                        <br />
                        <div id="special-menu-container" class="menu-drag-drop nested-sortable">
                            @foreach($settings->getMenu('special') as $menu)
                                @php
                                    $special_code = md5($menu->title . rand(1,10000));
                                @endphp
                                <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                    <div class="card">
                                        <div class="card-header" id="header-{{ $special_code }}">
                                            <h2 class="mb-0 w-100">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                    {{ $menu->title }}
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                            <div class="card-body">
                                                <label>Başlık</label>
                                                <input class="form-control menu-item-title" type="text" value="{{ $menu->title }}" />
                                                <br />
                                                <label>Adres</label>
                                                <input class="form-control menu-item-url" type="text" value="{{ $menu->url }}" />
                                                <br />
                                                <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <h4>Üst Menü</h4>
                        <input type="hidden" id="header-menu-data" name="header-menu" value="{{ json_encode($settings->getMenu('header')) }}" />
                        <br />
                        @can('update-settings')
                            <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                        @endcan
                        <br />
                        <br />
                        <button class="btn btn-primary btn-sm" onclick="addBlockWithUrl(event)">Yeni Link</button>
                        <button class="btn btn-primary btn-sm" onclick="addBlockWithoutUrl(event)">Yeni Blok</button>
                        <br />
                        <br />
                        <div id="header-menu-container" class="menu-drag-drop nested-sortable">
                            @foreach($settings->getMenu('header') as $menu)
                                @php
                                    $special_code = md5($menu->title . rand(1,10000));
                                @endphp
                                @if(isset($menu->url))
                                    <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                        <div class="card">
                                            <div class="card-header" id="header-{{ $special_code }}">
                                                <h2 class="mb-0 w-100">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                        {{ $menu->title }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                <div class="card-body">
                                                    <label>Başlık</label>
                                                    <input class="form-control menu-item-title" type="text" value="{{ $menu->title }}" />
                                                    <br />
                                                    <label>Adres</label>
                                                    <input class="form-control menu-item-url" type="text" value="{{ $menu->url }}" />
                                                    <br />
                                                    <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                    <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                        <div class="card">
                                            <div class="card-header" id="header-{{ $special_code }}">
                                                <h2 class="mb-0 w-100">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                        {{ $menu->title }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                <div class="card-body">
                                                    <label>Başlık</label>
                                                    <input class="form-control menu-item-title" type="text" value="{{ $menu->title }}" />
                                                    <br />
                                                    <label>Elemanları</label>
                                                    <div class="nested-sortable p-2 my-2 border">
                                                        @foreach($menu->items as $item)
                                                            @php
                                                                $special_code = md5($menu->title . rand(1,10000));
                                                            @endphp
                                                            @if(isset($item->url))
                                                                <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                                                    <div class="card">
                                                                        <div class="card-header" id="header-{{ $special_code }}">
                                                                            <h2 class="mb-0 w-100">
                                                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                                                    {{ $item->title }}
                                                                                </button>
                                                                            </h2>
                                                                        </div>

                                                                        <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                                            <div class="card-body">
                                                                                <label>Başlık</label>
                                                                                <input class="form-control menu-item-title" type="text" value="{{ $item->title }}" />
                                                                                <br />
                                                                                <label>Adres</label>
                                                                                <input class="form-control menu-item-url" type="text" value="{{ $item->url }}" />
                                                                                <br />
                                                                                <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                                                <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                                                    <div class="card">
                                                                        <div class="card-header" id="header-{{ $special_code }}">
                                                                            <h2 class="mb-0 w-100">
                                                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                                                    {{ $item->title }}
                                                                                </button>
                                                                            </h2>
                                                                        </div>

                                                                        <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                                            <div class="card-body">
                                                                                <label>Başlık</label>
                                                                                <input class="form-control menu-item-title" type="text" value="{{ $item->title }}" />
                                                                                <br />
                                                                                <label>Elemanları</label>
                                                                                <div class="nested-sortable p-2 my-2 border">
                                                                                    @foreach($item->items as $subitem)
                                                                                        @php
                                                                                            $special_code = md5($menu->title . rand(1,10000));
                                                                                        @endphp
                                                                                        <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                                                                            <div class="card">
                                                                                                <div class="card-header" id="header-{{ $special_code }}">
                                                                                                    <h2 class="mb-0 w-100">
                                                                                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                                                                            {{ $subitem->title }}
                                                                                                        </button>
                                                                                                    </h2>
                                                                                                </div>

                                                                                                <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                                                                    <div class="card-body">
                                                                                                        <label>Başlık</label>
                                                                                                        <input class="form-control menu-item-title" type="text" value="{{ $subitem->title }}" />
                                                                                                        <br />
                                                                                                        <label>Adres</label>
                                                                                                        <input class="form-control menu-item-url" type="text" value="{{ $subitem->url }}" />
                                                                                                        <br />
                                                                                                        <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                                                                        <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                <br />
                                                                                <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                                                <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <br />
                                                    <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                    <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>Alt Menü</h4>
                        <input type="hidden" id="footer-menu-data" name="footer-menu" value="{{ json_encode($settings->getMenu('footer')) }}" />
                        <br />
                        <button class="btn btn-primary btn-sm" onclick="addBlockWithUrl(event)">Yeni Link</button>
                        <button class="btn btn-primary btn-sm" onclick="addBlockWithoutUrl(event)">Yeni Blok</button>
                        <br />
                        <div id="footer-menu-container" class="menu-drag-drop nested-sortable">
                            @foreach($settings->getMenu('footer') as $menu)
                                @php
                                    $special_code = md5($menu->title . rand(1,10000));
                                @endphp
                                @if(isset($menu->url))
                                    <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                        <div class="card">
                                            <div class="card-header" id="header-{{ $special_code }}">
                                                <h2 class="mb-0 w-100">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                        {{ $menu->title }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                <div class="card-body">
                                                    <label>Başlık</label>
                                                    <input class="form-control menu-item-title" type="text" value="{{ $menu->title }}" />
                                                    <br />
                                                    <label>Adres</label>
                                                    <input class="form-control menu-item-url" type="text" value="{{ $menu->url }}" />
                                                    <br />
                                                    <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                    <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                        <div class="card">
                                            <div class="card-header" id="header-{{ $special_code }}">
                                                <h2 class="mb-0 w-100">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                        {{ $menu->title }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                <div class="card-body">
                                                    <label>Başlık</label>
                                                    <input class="form-control menu-item-title" type="text" value="{{ $menu->title }}" />
                                                    <br />
                                                    <label>Elemanları</label>
                                                    <div class="nested-sortable p-2 my-2 border">
                                                        @foreach($menu->items as $item)
                                                            @php
                                                                $special_code = md5($menu->title . rand(1,10000));
                                                            @endphp
                                                            <div id="accordion-{{ $special_code }}" class="my-2 menu-item accordion accordion-bordered">
                                                                <div class="card">
                                                                    <div class="card-header" id="header-{{ $special_code }}">
                                                                        <h2 class="mb-0 w-100">
                                                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $special_code }}" aria-expanded="false" aria-controls="collapse-{{ $special_code }}">
                                                                                {{ $item->title }}
                                                                            </button>
                                                                        </h2>
                                                                    </div>

                                                                    <div id="collapse-{{ $special_code }}" class="collapse" aria-labelledby="header-{{ $special_code }}" data-parent="#accordion-{{ $special_code }}">
                                                                        <div class="card-body">
                                                                            <label>Başlık</label>
                                                                            <input class="form-control menu-item-title" type="text" value="{{ $item->title }}" />
                                                                            <br />
                                                                            <label>Adres</label>
                                                                            <input class="form-control menu-item-url" type="text" value="{{ $item->url }}" />
                                                                            <br />
                                                                            <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                                            <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <br />
                                                    <button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>
                                                    <button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @can('update-settings')
                        <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    <script>
        $(document).ready(function() {
            initializeSortables();
        });

        function updateMenuButton(e) {
            e.preventDefault();
            updateAllMenus();
        }

        function updateAllMenus() {
            updateMenuData('#special-menu-container', '#special-menu-data');
            updateMenuData('#header-menu-container', '#header-menu-data');
            updateMenuData('#footer-menu-container', '#footer-menu-data');
        }

        function updateMenuData(menuKey, inputKey) {
            var data = [];

            $(menuKey).find('>.menu-item').each(function() {
                title = $(this).find('.menu-item-title').eq(0).val();
                if (title) {
                    $(this).find('.btn-link').eq(0).text(title);
                }

                if ($(this).find('.nested-sortable').length) {
                    items = [];

                    $(this).find('.nested-sortable').eq(0).find('>.menu-item').each(function() {
                        item_title = $(this).find('.menu-item-title').val();
                        if (item_title) {
                            $(this).find('.btn-link').eq(0).text(item_title);
                        }

                        if($(this).find('.nested-sortable').length) {
                            sub_items = [];

                            $(this).find('.nested-sortable').eq(0).find('>.menu-item').each(function() {
                                sub_item_title = $(this).find('.menu-item-title').val();
                                if (sub_item_title) {
                                    $(this).find('.btn-link').eq(0).text(sub_item_title);
                                }
                                sub_item_url = $(this).find('.menu-item-url').val();

                                sub_items.push({
                                    'title': sub_item_title,
                                    'url': sub_item_url
                                });
                            });

                            items.push({
                                'title': item_title,
                                'items': sub_items
                            });
                        } else {
                            item_url = $(this).find('.menu-item-url').val();

                            items.push({
                                'title': item_title,
                                'url': item_url
                            });
                        }
                    });

                    data.push({
                        'title': title,
                        'items': items
                    });
                } else {
                    url = $(this).find('.menu-item-url').eq(0).val();
                    data.push({
                        'title': title,
                        'url': url
                    });
                }
            });

            $(inputKey).val(JSON.stringify(data));

            return data;
        }

        function initializeSortables() {
            updateAllMenus();
            var nestedSortables = $('#header-menu-container').parent().find('.nested-sortable');
            for (var i = 0; i < nestedSortables.length; i++) {
                new Sortable(nestedSortables[i], {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    onSort: function(evt) {
                        updateAllMenus();
                    },
                });
            }

            nestedSortables = $('#footer-menu-container').parent().find('.nested-sortable');
            for (i = 0; i < nestedSortables.length; i++) {
                new Sortable(nestedSortables[i], {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    onSort: function(evt) {
                        updateAllMenus();
                    },
                });
            }
        }

        function addBlockWithoutUrl(e) {
            e.preventDefault();

            special_code = Math.floor((Math.random() * 10000) + 1);

            newElement = '<div id="accordion-new-' + special_code + '" class="my-2 menu-item accordion accordion-bordered">';
            newElement += '<div class="card">';
            newElement += '<div class="card-header" id="header-new-' + special_code + '">';
            newElement += '<h2 class="mb-0 w-100">';
            newElement += '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-new-' + special_code + '" aria-expanded="false" aria-controls="collapse-new-' + special_code + '">';
            newElement += '-- Yeni Menü Elemanı --';
            newElement += '</button>';
            newElement += '</h2>';
            newElement += '</div>';

            newElement += '<div id="collapse-new-' + special_code + '" class="collapse" aria-labelledby="header-new-' + special_code + '" data-parent="#accordion-new-' + special_code + '">';
            newElement += '<div class="card-body">';
            newElement += '<label>Başlık</label>';
            newElement += '<input class="form-control menu-item-title" type="text" />';
            newElement += '<br />';
            newElement += '<label>Elemanları</label>';
            newElement += '<div class="nested-sortable p-2 my-2 border">';
            newElement += '</div>';
            newElement += '<br />';
            newElement += '<button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>&nbsp;';
            newElement += '<button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>';
            newElement += '</div>';
            newElement += '</div>';
            newElement += '</div>';
            newElement += '</div>';

            $(e.target).parent().find('.nested-sortable').eq(0).prepend(newElement);
            initializeSortables();
        }

        function addBlockWithUrl(e) {
            e.preventDefault();

            special_code = Math.floor((Math.random() * 10000) + 1);

            newElement = '<div id="accordion-new-' + special_code + '" class="my-2 menu-item accordion accordion-bordered">';
            newElement += '<div class="card">';
            newElement += '<div class="card-header" id="header-new-' + special_code + '">';
            newElement += '<h2 class="mb-0 w-100">';
            newElement += '<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-new-' + special_code + '" aria-expanded="false" aria-controls="collapse-new-' + special_code + '">';
            newElement += '-- Yeni Menü Elemanı --';
            newElement += '</button>';
            newElement += '</h2>';
            newElement += '</div>';

            newElement += '<div id="collapse-new-' + special_code + '" class="collapse" aria-labelledby="header-new-' + special_code + '" data-parent="#accordion-new-' + special_code + '">';
            newElement += '<div class="card-body">';
            newElement += '<label>Başlık</label>';
            newElement += '<input class="form-control menu-item-title" type="text" />';
            newElement += '<br />';
            newElement += '<label>Adres</label>';
            newElement += '<input class="form-control menu-item-url" type="text" />';
            newElement += '<br />';
            newElement += '<button class="btn btn-danger btn-sm" onclick="removeMenuItem(event)">Sil</button>&nbsp;';
            newElement += '<button class="btn btn-primary btn-sm" onclick="updateMenuButton(event)">Güncelle</button>';
            newElement += '</div>';
            newElement += '</div>';
            newElement += '</div>';
            newElement += '</div>';

            $(e.target).parent().find('.nested-sortable').eq(0).prepend(newElement);
            initializeSortables();
        }

        function removeBlockItem(e) {
            e.preventDefault();
            $(e.target).parent().parent().parent().remove();
            updateAllMenus();
        }

        function removeMenuItem(e) {
            e.preventDefault();
            $(e.target).parent().parent().parent().parent().remove();
            updateAllMenus();
        }
    </script>
@endsection
