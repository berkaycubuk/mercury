@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.new', ['type' => trans_choice('general.pages', 1)]) }}</h2>
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
                <form action="{{ route('panel.pages.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="page-title">{{ trans('general.title.default') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="page-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('general.content') }}</label>
                        <textarea id="editor" name="content"></textarea>
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
