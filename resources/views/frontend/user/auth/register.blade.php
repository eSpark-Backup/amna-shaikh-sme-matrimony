<!DOCTYPE html>
<html>
<head>
    <title> Register - {{ env('APP_NAME') }} </title>
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
                        <h3>Register Now</h3>
                        <div class="login-links">
                            <a href="#"><img src="assets/images/facebook_icon.svg" alt="icon">Register with Facebook</a>
                            <a href="#"><img src="assets/images/gmail_icon.svg" alt="icon">Register with Google</a>
                        </div>
                        <div class="orline"><span>OR</span></div>
                        <form action="{{ route('user.auth.registerUser') }}" method="POST" id="register-form">
                            {{ csrf_field() }}
                            @include('../../../admin.message')
                            
                            <div class="fields-row">
                                <div class="field">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name"  id="first_name" data-parsley-minlength="2" data-parsley-pattern="^[A-Za-z ]+$" data-parsley-pattern-message="This field is filled only with alphabets and space." class="required" value="{{old('first_name', '')}}">
                                </div>
                                <div class="field">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="required" id="last_name" data-parsley-minlength="2" data-parsley-pattern="^[A-Za-z ]+$" data-parsley-pattern-message="This field is filled only with alphabets and space." value="{{old('last_name', '')}}"> 
                                </div>
                            </div>
                            <div class="field">
                                <label for="email">Enter Email</label>
                                <input type="email" placeholder="" name="email" id="email" class="required" value="{{old('email', '')}}">
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <i class="fa fa-eye" id="togglePassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
                                <input type="password" placeholder="" name="password" id="password" class="required" data-parsley-minlength="[8]" data-parsley-minlength="8" data-parsley-required-message="Please enter password." data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+=]).*" data-parsley-pattern-message="Your password must contain at least (1) lowercase, (1) uppercase letter, (1) special character and minimum 8 characters." id="password" value="{{old('password', '')}}">
                            </div>
                            <div class="field">
                                <label for="">Confirm Password</label>
                                <i class="fa fa-eye" id="toggleCpassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
                                <input type="password" placeholder="" name="confirm_password" class="required" equalto="#password" id="confirm_password" value="{{old('confirm_password', '')}}">
                                
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                <input type="radio" id="male" name="gender" value="0" {{ (old('gender')== 0)? 'checked':'' }}>
                                <label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="female" name="gender" value="1" {{ (old('gender')== 1)? 'checked':'' }}>
                                  <label for="female">Female</label>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" class="required" id="chkbx" name="    terms_conditions" value="1" {{ (old('terms_conditions')== 1)? 'checked':'' }}>

                                <span for="">By clicking Register Now you agree to our <a href="{{ url('terms-conditions') }}" target="_blank" style="    color: #007bff; text-decoration: underline;">terms and conditions</a></span>
                            </div>

                            <div class="field-btn fullBtn">
                                <button type="submit" class="btn-custom-primary">Register Now</button>
                            </div>
                        </form>
                        <div class="newUser">
                            <span>Already Member?</span>
                            <a href="{{ route('login') }}" class="btn-custom-secondary">Login here</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    @section('js')
    <script>
        $(function(){
            $('#register-form').parsley();
            $('#register-form').validate({
                messages: {
                    
                    password: {
                        required: "Please provide a password",
                    },
                    confirm_password: {
                        required: "Please provide a password",
                        equalTo: "Confirm password does not match"
                    },
                }
            });
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