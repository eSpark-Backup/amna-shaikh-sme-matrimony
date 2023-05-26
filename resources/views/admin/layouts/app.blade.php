<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | @yield('title')</title>
  <link href="{{ asset('admin-assets/assets/media/logo/favicon.png') }}" rel="icon" type="image/png">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--Bootstrap icons-->
  <link href="{{ asset('admin-assets/assets/fonts/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <!--Google fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/fontawesome/css/all.css') }}">
  <!--Simplebar css-->
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/simplebar.min.css') }}">
  <!--Choices css-->
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/choices.min.css') }}">
  <!--Date range picker-->
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/bootstrap-datepicker.min.css') }}">
  @yield('css')
  <!--Main style-->
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/style.min.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
  
  <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/custom.css?=') }}">
  <style>
body{border:0}
.dataTables_scroll{position:relative}
.dataTables_scrollHead{margin-bottom:40px;}
.dataTables_scrollFoot{position:absolute; top:38px}
</style>
</head>
<body>
  <!--////////////////// PreLoader Start//////////////////////-->
  <div class="loader" id="loader">
    <div class="w-100 h-100 position-relative d-flex align-items-center justify-content-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader anim-spinner me-2"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>
      <div>
        <span>Loading...</span>
      </div>
    </div>
  </div>
  <!--////////////////// /.PreLoader END//////////////////////-->
  <div class="d-flex flex-column flex-root">
    <!--Page-->
    <div class="page d-flex flex-row flex-column-fluid">
      <!--///////////Page sidebar begin///////////////-->
       @include('admin.sections.sidebar')
      <!--///////////Page Sidebar End///////////////-->
      <!--///Sidebar close button for 991px or below devices///-->
      <div class="sidebar-close d-lg-none">
        <a href="#"></a>
      </div>
      <!--///.Sidebar close end///-->
      <!--///////////Page content wrapper///////////////-->
      <main class="page-content d-flex flex-column flex-row-fluid">
        <!--//page-header//-->
        @include('admin.sections.header')
        <!--//Page content//-->
        @yield('content')
        @include('admin.sections.footer')
        <!--/.Page Footer End-->
      </main>
    </div>
  </div>
<!--//////////// Core scripts Start/////////////////-->
<script src="{{ asset('admin-assets/assets/vendor/feather.min.js') }}"></script>

<script src="{{ asset('admin-assets/assets/js/theme.bundle.js') }}"></script>
<script>
  feather.replace()
</script>
<!--//////////// Core scripts End/////////////////-->
<!--Charts-->
<script src="{{ asset('admin-assets/assets/vendor/apexcharts.min.js') }}"></script>
<!--Dashboard duration calendar-->
<script src="{{ asset('admin-assets/assets/vendor/moment.min.js') }}"></script>
<script src="{{ asset('admin-assets/assets/vendor/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>

<script src="https://cdn.tiny.cloud/1/7z177e3d6ntfja3qaiasxetscc4o26hm602rj8vr7ksplfeh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{ asset('admin-assets/js/custom/custom-tiny.js') }}" ></script>
@yield('js')
<script>
  function showOverlayLoader()
  {
    document.getElementById("loader").style.display = "block";
  }
  function hideOverlayLoader()
  {
    document.getElementById("loader").style.display = "none";
  }
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);
</script>
</body>
</html>