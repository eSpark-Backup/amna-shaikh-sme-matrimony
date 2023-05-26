@extends('app')
@section('title', 'Settings')
@section('style')
	
@endsection
@section('content')
	<!-- Accounts -->
    <section class="user-profile-section prersonal-prof">
        <div class="empty-banner"></div>
        <div class="container">
       <!--  <h4 class="setting-head mt-5">Settings Menu</h4> -->
        	<div class="row">
        		
                <div class="col-lg-8 user-profile-left mt-5">
               		<div class="profile-main-body">
                        <h4>Feedback</h4>
	                    <form id="user-form" class="form-horizontal" action="{{route('user.settings.post-feedback')}}" enctype="multipart/form-data" method="post">
	                    	{{ csrf_field() }}
	                    	@include('../../../admin.message')
				            <input type="hidden" name="action" >
		                    
	                        <div class="field">
	                            <label for="title">Title*</label>
	                            <input type="text" class="required" name="title" id="title"  value="{{old('title')}}" > 
	                        </div>
	                        <div class="field">
	                            <label for="description">Description*</label>
	                            <textarea name="description" id="description" class="required form-control" rows="8"></textarea>
	                           
	                        </div>
		                    <div class="field">
	                            <label for="image">Image*</label>
	                            <input type="file" name="image" class="required" id="image">
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
	<script src="{{ asset('admin-assets/assets/vendor/moment.min.js') }}"></script>
	<script src="{{ asset('admin-assets/assets/vendor/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
	
	
    <script>
        $(function(){
		    $('#user-form').validate();
        });
    </script>
@endsection
