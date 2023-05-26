<!DOCTYPE html>
<html>
<head>
    <title> Account not approved yet - {{ env('APP_NAME') }} </title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="" href="">
    <link rel="shortcut icon" type="image/png" href="assets/images/fevicon.png" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/intlTelInput.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/isValidNumber.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.css')}}">
</head>
<body>
    @include('frontend.sections.header')
    <!-- Accounts -->
    <section class="account-section">
        <div class="container">
            <div class="account-row flex">
                <div class="account-image" style="background-image: url('{{ asset("assets/images/login_bg.png")}}' )">
                    <img src="assets/images/white-logo.svg" alt="image">
                </div>
                <div class="account-form">
                    <div class="account-form-inner">
                        <h3>Account is under admin approval</h3>
                       
                        
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Your account is under admin approval. You'll not be able to perform any actions until your profile is approved. Thanks for your patience.
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Footer-->
    @include('frontend.sections.footer')
    
    <!-- Scripts -->
    <script src="{{asset('assets/js/jquery-3.1.1.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/intlTelInput.min.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    
</body>
</html>