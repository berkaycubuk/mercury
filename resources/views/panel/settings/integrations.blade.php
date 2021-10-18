@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Integrations</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('panel.settings.integrations.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="google-analytics">Google Analytics</label>
                        <input name="google-analytics" type="text" class="form-control" id="google-analytics" value="{{ $settings->google_analytics }}" placeholder="Google Analytics Key">
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
