@inject('settings', 'App\Services\Settings')

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Sleek Dashboard - Free Bootstrap 4 Admin Dashboard Template and UI Kit. It is very powerful bootstrap admin dashboard, which allows you to build products like admin panels, content management systems and CRMs etc.">
    <meta name="_token" content="{{ csrf_token() }}" />

  <title>{{ $settings->getSetting('site')->title }}</title>

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />
  <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="{{ asset('assets/css/nprogress.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/js/select2/css/select2.min.css') }}" rel="stylesheet" />

  <!-- SLEEK CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/sleek.min.css') }}" />

  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />

  <link href="{{ asset('assets/css/jodit.min.css') }}" rel="stylesheet" />

  <!-- Filepond -->
  <link rel="stylesheet" href="{{ asset('assets/css/filepond.min.css') }}" />

  <!-- FAVICON -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="shortcut icon" />

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="{{ asset('assets/js/nprogress.js') }}"></script>

    <style>
        .image-modal-selector:hover p {
            height: 100%; 
        }

        .image-modal-selector p {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;
            background-color: rgba(0,0,0,0.25); 
        }

        .image-modal-selector img {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
  <script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
  </script>

  <!-- <div id="toaster"></div> -->

  <div class="wrapper">
    @include('panel::partials.sidebar')
    <div class="page-wrapper">
        @include('panel::partials.header')
      <div class="content-wrapper">
        <div class="content">
            @yield('content')
        </div>

        <div class="right-sidebar-2">
            <div class="right-sidebar-container-2">
                <div class="slim-scroll-right-sidebar-2">
                    <div class="right-sidebar-2-header">
                        <h2>Layout Settings</h2>
                        <p>User Interface Settings</p>
                        <div class="btn-close-right-sidebar-2">
                        <i class="mdi mdi-window-close"></i>
                        </div>
                    </div>
                    <div class="right-sidebar-2-body">
                        <span class="right-sidebar-2-subtitle">Header Layout</span>
                        <div class="no-col-space">
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 header-fixed-to btn-right-sidebar-2-active">Fixed</a>
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 header-static-to">Static</a>
                        </div>
                        <span class="right-sidebar-2-subtitle">Sidebar Layout</span>
                        <div class="no-col-space">
                        <select class="right-sidebar-2-select" id="sidebar-option-select">
                            <option value="sidebar-fixed">Fixed Default</option>
                            <option value="sidebar-fixed-minified">Fixed Minified</option>
                            <option value="sidebar-fixed-offcanvas">Fixed Offcanvas</option>
                            <option value="sidebar-static">Static Default</option>
                            <option value="sidebar-static-minified">Static Minified</option>
                            <option value="sidebar-static-offcanvas">Static Offcanvas</option>
                        </select>
                        </div>
                        <span class="right-sidebar-2-subtitle">Header Background</span>
                        <div class="no-col-space">
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 btn-right-sidebar-2-active header-light-to">Light</a>
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 header-dark-to">Dark</a>
                        </div>
                        <span class="right-sidebar-2-subtitle">Navigation Background</span>
                        <div class="no-col-space">
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 btn-right-sidebar-2-active sidebar-dark-to">Dark</a>
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 sidebar-light-to">Light</a>
                        </div>
                        <span class="right-sidebar-2-subtitle">Direction</span>
                        <div class="no-col-space">
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 btn-right-sidebar-2-active ltr-to">LTR</a>
                        <a href="javascript:void(0);" class="btn-right-sidebar-2 rtl-to">RTL</a>
                        </div>
                        <div class="d-flex justify-content-center" style="padding-top: 30px">
                        <div id="reset-options" style="width: auto; cursor: pointer" class="btn-right-sidebar-2 btn-reset">Reset
                            Settings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('panel::partials.footer')
    </div>
  </div>

    <style>
        .panel-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.2);
            visibility: hidden;
        }
    </style>

    <div class="panel-loading">
        <div class="sk-three-bounce">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/jekyll-search.min.js') }}"></script>



<script src="{{ asset('assets/js/Chart.min.js') }}"></script>



<script src="{{ asset('assets/js/jquery-jvectormap-2.0.3.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-jvectormap-world-mill.js') }}"></script>



<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>

<script src="{{ asset('assets/js/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-mask-input/jquery.mask.min.js') }}"></script>

<script>
    function panelLoadingOpen() {
        $('.panel-loading').css("visibility", "visible");
    }

    function panelLoadingClose() {
        $('.panel-loading').css("visibility", "hidden");
    }

  jQuery(document).ready(function() {
    jQuery('input[name="dateRange"]').daterangepicker({
    autoUpdateInput: false,
    singleDatePicker: true,
    locale: {
      cancelLabel: 'Clear'
    }
  });
    jQuery('input[name="dateRange"]').on('apply.daterangepicker', function (ev, picker) {
      jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
    });
    jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function (ev, picker) {
      jQuery(this).val('');
    });
  });
</script>

<script src="{{ asset('assets/js/toastr.min.js') }}"></script>

<script src="{{ asset('assets/js/sleek.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jodit.min.js') }}"></script>

<script src="{{ asset('assets/js/filepond.min.js') }}"></script>

@stack('scripts')
@yield('scripts')

@if (session('message_success'))
    <script>
        var toaster = $('#toaster');

        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        toastr.success("{{ session('message_success') }}");
    </script>
@endif

@if (session('message_error'))
    <script>
        var toaster = $('#toaster');

        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        toastr.error("{{ session('message_error') }}");
    </script>
@endif

<!-- Tawkto -->
<!--
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/613f00abd326717cb6811fd9/1fff1l83n';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);

})();
</script>
-->

</body>

</html>
