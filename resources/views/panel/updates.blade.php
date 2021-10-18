@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Updates</h2>
            </div>
            <div class="card-body">
                Current version: {{ $currentVersion }}<br/>
                Latest version: {{ $availableVersion }}<br/>
                @if($updateAvailable)
                <div class="alert alert-warning" style="font-weight:normal" role="alert">
                    <b>Important Disclaimer:</b><br/>
                    Please backup your data before updating your Mercury!
                    After the update there can be possible data corruptions.
                </div>
                <h3>New version of Mercury found</h3><br/>
                <form action="{{ route('panel.update') }}">
                    <button class="btn btn-primary">
                        <i class=" mdi mdi-cloud-download mr-1"></i> Update
                    </button>
                </form>
                <p class="mt-2">
                    Update can take some time, please keep your tab open.
                </p>
                @else
                <h3>Your Mercury is up to date.</h3>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card card-default">
    <div class="card-header card-header-border-bottom">
        <h2>Version Notes</h2>
    </div>
    <div class="card-body">
        <ul>
        </ul>
    </div>
</div>

@endsection
