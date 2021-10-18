@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Sayfayı Düzenle</h2>
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
                <form action="{{ route('panel.pages.update') }}" method="POST">
                    @csrf
                    <input type="text" style="display: none" id="page-id" name="id" value="{{ $page->id }}">
                    <div class="form-group">
                        <label for="page-title">{{ trans('general.title.default') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="page-title" name="title" value="{{ $page->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="page-slug">{{ trans('general.slug') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="page-slug" name="slug" value="{{ $page->slug }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('general.content') }}</label>
                        <textarea id="editor" name="content">{{ $page->content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.pages.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var editor = new Jodit('#editor', {
            toolbarSticky: true,
            toolbarStickyOffset: 78,
            buttons: [
                'source', '|',
                'bold',
                'strikethrough',
                'underline',
                'italic', '|',
                'ul',
                'ol', '|',
                'outdent', 'indent',  '|',
                'font',
                'fontsize',
                'brush',
                'paragraph', '|',
                'table',
                'link', '|',
                'align', 'undo', 'redo', '|',
                'hr',
                'eraser',
                'copyformat', '|',
                'symbol',
                'fullsize',
            ],
            colorPickerDefaultTab: 'text',
        });
    </script>
@endsection
