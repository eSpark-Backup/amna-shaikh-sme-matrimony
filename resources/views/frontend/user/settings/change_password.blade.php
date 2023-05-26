@extends('app')
@section('title', 'Settings')
@section('style')
	
@endsection
@section('content')
	<!-- Accounts -->
    <section class="user-profile-section prersonal-prof">
        <div class="empty-banner"></div>
        <div class="container">
		
        	<div class="row">
                <div class="col-lg-8 user-profile-left mt-5">
               		<div class="profile-main-body">
                        <h4>Update your password</h4>
	                    <form id="user-form" class="form-horizontal" action="{{route('user.settings.update-password')}}" method="post">
	                    	{{ csrf_field() }}
	                    	@include('../../../admin.message')
				            <input type="hidden" name="action" >
				            <div class="field">
	                            <label for="current_original_password">Current Password</label>
	                            <input type="password" placeholder="" name="current_original_password" id="original_password"  value="{{old('current_original_password')}}" class="required"> 
	                        </div>
		                    <div class="fields-row">
		                        <div class="field">
		                            <label for="password">Password</label>
		                            <input type="password" placeholder="" name="password" id="password"  value="{{old('password')}}" class="required"> 
		                        </div>
		                        <div class="field">
		                            <label for="c_password">Confirm Password</label>
		                            <input type="password" name="password_confirmation" id="c_password" value="{{old('password_confirmation')}}" class="required"> 
		                        </div>
		                    </div>
	                        <div class="field-btn">
	                            <button type="submit">Save</button>
	                        </div>
	                    </form>
                    </div>
                </div>
                <div class="col-lg-4 user-profile-left mt-5">
                    <div class="profile-main-body">
                        @include('/../../frontend.partials.setting_menus')
                    </div>
                </div>
        	</div>
            <div class="user-profile-row accounts-form flex">
                
                <div class="user-profile-center-custom ">
                    

                    
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

	<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
	
	
    <script>
        $(function(){
		    $('#user-form').validate();
        });
    </script>
@endsection
