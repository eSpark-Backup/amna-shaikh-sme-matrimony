@extends('admin.layouts.auth')
@section('title', 'Login')
@section('content')
<div class="content p-1 d-flex flex-column-fluid align-items-center position-relative">
    <div class="container py-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <!--Logo-->
                <a href="{{ route('admin.dashboard') }}"
                    class="d-flex position-relative mb-4 z-index-1 align-items-center justify-content-center">
                    <span class="sidebar-icon size-60 ">
                        <img src="{{ asset('admin-assets/assets/media/logo/footer-logo.png') }}">
                    </span>
                </a>
                <!--Card-->
                <div class="card card-body border-0 shadow-lg p-4">
                    <h4>Welcome</h4>
                    <p class="mb-4 text-muted">
                        Please Sign In with details...
                    </p>
                    <form id="login-form" class="form-auth-small" method="POST" action="{{ route('admin.auth.loginAdmin') }}">
                        {{ csrf_field() }}
                        @if ($errors->has('error'))
                            <div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ $errors->first('error') }}
                            </div>
                        @endif
                        @if (session()->get('flash_success'))
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {!! session()->get('flash_success') !!}
                            </div>
                        @endif
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control required" id="floatingInput" placeholder="name@example.com" name="email" autofocus value="{{old('email', '')}}">
                            <label for="floatingInput">Email address</label>
                            <span class="invalid-feedback">Please enter a valid email address</span>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control required"
                                id="floatingPassword" placeholder="Password" name="password" value="{{old('password', '')}}">
                            <label for="floatingPassword">Password</label>
                            <span class="invalid-feedback">Enter the password</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <a href="{{ route('admin.auth.forgot-password') }}" class="small text-muted">Forget Password?</a>
                            </div>
                        </div>
                        <button type="submit"  class="w-100 btn btn-lg btn-primary">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(function(){
        $('#login-form').validate();
    });
    $( window ).load(function() {
      $('#timezone').val(Intl.DateTimeFormat().resolvedOptions().timeZone);
    });
    $(".toggle-password").click(function()
    {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $(this).siblings('input');
        if (input.attr("type") == "password")
        {
            input.attr("type", "text");
        }
        else
        {
            input.attr("type", "password");
        }
    });
</script>
@endsection