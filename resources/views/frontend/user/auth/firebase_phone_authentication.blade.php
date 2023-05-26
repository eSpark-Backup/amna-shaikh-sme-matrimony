<!DOCTYPE html>
<html>
<head>
    <title> Phone Number Verification - {{ env('APP_NAME') }} </title>
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
                <div class="account-image" style="background-image: url('{{ asset("assets/images/login_b.jpg")}}' )">
                    <img src="assets/images/white-logo.svg" alt="image">
                </div>
                <div class="account-form">
                    <div class="account-form-inner">

                        <h3>Phone Number Authentication</h3>
                        
                        
                        <form action="{{ route('verify-mobile-code') }}" method="POST" id="verify_code_form">
                            {{ csrf_field() }}
                            
                            
                            <input type="hidden" name="code" value="" id="input_code">
                            <input type="hidden" name="mobile"  id="mobile_number">
                        </form>
                        <form id="number-form">
                            @include('../../../admin.message')
                            <div class="field">
                                <label>Phone Number:</label>
                                <input type="tel" id="phone" class="form-control" value="{{old('mobile', '')}}">
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide"></span>
                            </div>
                            <div class="field">
                                <div id="recaptcha-container"></div>    
                            </div>
                            <div class="field-btnPP">
                               <button type="button" class="btn-custom-primary" onclick="phoneSendAuth();">Send Code</button>
                            </div>
                        </form>

                        <div class="card" id="phone-verify" style="margin-top: 10px; display: none;">
                            <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
                            
                            <div class="alert alert-danger" id="error" style="display: none;"></div>
                            <div class="alert alert-success" role="alert" id="sentSuccess" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                
                            </div>

                          <div class="card-header">
                            Enter Verification code
                          </div>
                          <div class="card-body">
                            <form>
                                <input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code">
                                <button type="button" class="btn-custom-secondary mt-3" id="back_phone" style="display: inline-block !important;">Back</button>
                                <button type="button" class="btn-custom-primary mt-3" onclick="codeverify();" style="display: inline-block !important;margin-left: 5px;">Verify Code</button>
                            </form>
                          </div>
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

    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    
  
    <script>
        $(document).ready(function(){
          $(".alert").delay(12000).slideUp(300);
          $('#back_phone').on('click',function(){
            $('#phone-verify').hide();
            $("#number-form").show();
          });
        });
      // Your web app's Firebase configuration
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      const firebaseConfig = {
        apiKey: "AIzaSyD7gEKqjI0EZIA6nfMklBreXgdQff3xS_A",
        authDomain: "sme-matrimony-99129.firebaseapp.com",
        databaseURL: "https://sme-matrimony-99129.firebaseio.com",
        projectId: "sme-matrimony-99129",
        storageBucket: "sme-matrimony-99129.appspot.com",
        messagingSenderId: "758391897071",
        appId: "1:758391897071:web:db773773c313a451b9d41a",
        measurementId: "G-P2CD44Z5L8"
      };

      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      //const app = initializeApp(firebaseConfig);
      //const analytics = getAnalytics(app);


        var input = document.querySelector("#phone"),
          errorMsg = document.querySelector("#error-msg"),
          validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti = window.intlTelInput(input, {
          
          utilsScript: "{{ asset('assets/js/utils.js?1638200991544')}}"
        });

        var reset = function() {
          input.classList.remove("error");
          input.classList.remove("error");
          errorMsg.innerHTML = "";
          errorMsg.classList.add("hide");
          validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
          reset();
          if (input.value.trim()) {
            if (iti.isValidNumber()) {
              validMsg.classList.remove("hide");
            } else {
              input.classList.add("error");
              var errorCode = iti.getValidationError();
              errorMsg.innerHTML = errorMap[errorCode];
              errorMsg.classList.remove("hide");
            }
          }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);  

      
        window.onload=function () {
          render();
        };
      
        function render() {
            window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
      
        function phoneSendAuth() {
               
            //var number = $("#phone").val();
            var number = iti.getNumber();
            
            $("#error").hide();
            if (number == '') {
                $("#error").text('Please enter valid phone number');
                $("#error").show();
                return false;
            }
            $('#mobile_number').val(number);
            firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
                  
                window.confirmationResult=confirmationResult;
                coderesult=confirmationResult;
                
      
                $("#sentSuccess").text("Please enter here the code that will be sent to your phone number.");
                $("#sentSuccess").show();
                $("#number-form").hide();
                $("#phone-verify").show();

            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
            
        }
      
        function codeverify() {
            $("#error").hide();
            var code = $("#verificationCode").val();
            if (code == '') {
                $("#error").text('Please enter 6 digit code');
                $("#error").show();
                return false;
            }
            coderesult.confirm(code).then(function (result) {
                var user = result.user;
                //console.log(user);
                if (user) {
                    $('#input_code').val(code);
                    $('#verify_code_form').submit();
                    //$("#successRegsiter").text("you are register Successfully.");
                    //$("#successRegsiter").show();
                }
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
                $("#sentSuccess").hide();
            });
        }
    </script>
    
</body>
</html>