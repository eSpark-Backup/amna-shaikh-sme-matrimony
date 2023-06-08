<!DOCTYPE html>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js">
<html>
<head>
    <title> @yield('title') - SME matrimony </title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="" href="">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/admin-assets/assets/media/logo/favicon.png') }}" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/loader.css') }}">

    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.css') }}">
</head>
<body>
    <!--////////////////// PreLoader Start//////////////////////-->
    <div class="loader" id="loader" style="display: none;">
      <div class="w-100 h-100 d-flex align-items-center justify-content-center load-3">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <span>Loading...</span>
      </div>
    </div>



  <!--////////////////// /.PreLoader END//////////////////////-->
    @include('frontend.sections.header')

    @yield('content')

    @include('frontend.sections.footer')
    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/socket.io.js')}}"></script>

    @yield('js')
    <script src="{{ asset('assets/js/custom.js')}}"></script>

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
        //$('.alert').not('.apply-event').fadeOut('slow');
      }, 5000);

    </script>

    <script>
      function MatchHeight() {
        $('.single-plan')
          .matchHeight({})
        ;
      }
    </script>
</body>
</html>
