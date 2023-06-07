<!DOCTYPE html>
<html>
<head>
    <title> Login - {{ env('APP_NAME') }} </title>
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
                        <h3>Login</h3>
                        <form action="{{ route('user.auth.loginUser') }}" method="POST" id="login-form">
                            {{ csrf_field() }}
                            
                            @include('../../../admin.message')
                            <div class="field">
                                <label for="email">Enter Email</label>
                                <input type="email" class="required" placeholder="" name="email" id="email" value="{{old('email', '')}}" >
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <i class="fa fa-eye" id="togglePassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
                                <input type="password" class="required" placeholder="password" name="password" id="password" value="{{old('password', '')}}">
                            </div>
                            <div class="remember flex">
                                <div class="field-check">
                                    <!-- <label for="">
                                        Remember me
                                        <input type="checkbox">
                                        <span></span>
                                    </label> -->
                                </div>
                                <a href="{{url('/forgot-password')}}">Forget Password?</a>
                            </div>
                            <div class="field-btn fullBtn">
                                <button type="submit" class="btn-custom-primary">Login</button>
                            </div>
                        </form>
                        <div class="orline"><span>OR</span></div>
                        <div class="login-links">
                            <a href="{{ url('auth/facebook') }}"><img src="assets/images/facebook_icon.svg" alt="icon">Login with Facebook</a>
                            <a href="{{ url('auth/google') }}"><img src="assets/images/gmail_icon.svg" alt="icon">Login with Google</a>
                        </div>
                        <div class="newUser">
                            <span>New Member?</span>
                            <a href="{{ route('register') }}" class="registerNewUser btn-custom-secondary">Register Now</a>
                        </div>
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
            $('#login-form').validate();

            const togglePassword = document.querySelector('#togglePassword');
            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
    
</body>
</html>