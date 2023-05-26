<!DOCTYPE html>
<html>
<head>
    <title> Forget Password - {{ env('APP_NAME') }} </title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="" href="">
    <link rel="shortcut icon" type="image/png" href="assets/images/fevicon.png" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/all.css' )}}">
</head>
<body>
    @include('frontend.sections.header')
    <!-- Accounts -->
    <section class="account-section">
        <div class="container">
            <div class="account-row flex">
                <div class="account-image" style="background-image: url('{{asset('assets/images/login_b.jpg')}}');">
                    <img src="{{asset('assets/images/white-logo.svg')}}" alt="image">
                </div>
                <div class="account-form">
                    <div class="account-form-inner">
                        <h3>Reset Password</h3>
                    
                        <form action="{{ route('auth.reset-password') }}" method="POST" id="forget-form">
                            {{ csrf_field() }}
                           @include('../../../admin.message')
                            <div class="field">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <label for="password">Password</label>
                                <i class="fa fa-eye" id="togglePassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
                                <input type="password" placeholder="" name="password" id="password" class="required" id="password" value="{{old('password', '')}}">
                            </div>
                            <div class="field">

                                <label for="">Confirm Password</label>
                                <i class="fa fa-eye" id="toggleCpassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
                                <input type="password" placeholder="" name="password_confirmation" class="required" equalto="#password" id="confirm_password" value="{{old('confirm_password', '')}}">
                            </div>
                            <div class="field-btn">
                                <button type="submit">Submit</button>
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
    <script src="{{asset('assets/js/jquery-3.1.1.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
    <script src="{{asset('assets/js/custom.js') }}"></script>
    
    <script>
        $(function(){
            $('#forget-form').validate();

            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
            //Password
            const togglecpassword = document.querySelector('#toggleCpassword');
            const cpassword = document.querySelector('#confirm_password');

            togglecpassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const ctype = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                cpassword.setAttribute('type', ctype);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
    
</body>
</html>