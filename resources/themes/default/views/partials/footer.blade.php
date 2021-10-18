@php
    $authCheck = true;

    if (!empty(auth()->user()) && auth()->user()->role == 'admin') {
        $authCheck = false;
    }
@endphp

@if(isset(get_settings('site')->service_mode) && get_settings('site')->service_mode && $authCheck)

@else
<footer class="footer">
</footer>
@endif
