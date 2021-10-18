@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>{{ trans('general.title.new', ['type' => trans('general.media')]) }}</h2>
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
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error  }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('panel.media.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="files" />
                    <div class="form-group">
						<label for="media-file">{{ trans('general.file') }}</label>
						<input type="file" class="form-control-file" id="media-file" name="file" multiple>
					</div>
                    <button type="submit" class="btn btn-primary btn-default">{{ trans('general.save') }}</button>
                    <a class="btn btn-secondary" href="{{ route('panel.media.index') }}">{{ trans('general.cancel') }}</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>

    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement);
    pond.setOptions({
        server: {
            url: '{{ route("panel.media.upload") }}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });

    document.addEventListener('FilePond:processfiles', function() {
        var files = [];
        $("input[name='file']").each(function() {
            files.push($(this).val());
        }); 

        $("input[name='files']").val(JSON.stringify(files));
    });

</script>

@endsection
