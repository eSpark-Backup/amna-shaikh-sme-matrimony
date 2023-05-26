<!DOCTYPE html>
<html>
<head>
    <title> Forget Password - {{ env('APP_NAME') }} </title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="" href="">
    <link rel="shortcut icon" type="image/png" href="assets/images/fevicon.png" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/all.css">
</head>
<body>
    @include('frontend.sections.header')
    <!-- Accounts -->
    <section class="account-section">
        <div class="container">
            <div class="account-row flex">
                <div class="account-image" style="background-image: url('assets/images/login_b.jpg');">
                    <img src="assets/images/white-logo.svg" alt="image">
                </div>
                <div class="account-form">
                    <div class="account-form-inner">
                        <h3>Forget Password</h3>
                    
                        <form action="{{ route('auth.send-reset-link-email') }}" method="POST" id="forget-form">
                            {{ csrf_field() }}
                            @include('../../../admin.message')
                            <div class="field">
                                <label for="email">Enter Email</label>
                                <input type="email" class="required" placeholder="" name="email" id="email" value="{{old('email', '')}}">
                            </div>
                            <div class="field-btn fullBtn mt-0">
                                <button type="submit" class="btn-custom-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Footer-->
    @include('frontend.sections.footer')
    
    <!-- Scripts -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
    <script src="assets/js/custom.js"></script>
    
    <script>
        $(function(){
            $('#forget-form').validate();
        });
    </script>
    
</body>
</html>