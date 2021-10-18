@extends('panel::layouts.panel')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom">
                <h2>Notification Details</h2>
            </div>
            <div class="card-body">
                @if($notification->type == 'App\Notifications\ContactMessage')
                    <p>
                        <b>Ad Soyad:</b><br/>{{ $notification->data['full_name'] }}<br/><br/>
                        <b>Telefon:</b><br/>{{ $notification->data['phone'] }}<br/><br/>
                        <b>Mesaj:</b><br/>{{ $notification->data['message'] }}
                    </p>
                @endif
                <br />
                <a class="btn btn-secondary" href="{{ route('panel.notifications') }}">Go back</a>
            </div>
        </div>
    </div>
</div>

@endsection
