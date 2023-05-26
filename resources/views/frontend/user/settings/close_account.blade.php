@extends('app')
@section('title', 'Settings')
@section('style')
	
@endsection
@section('content')
	<!-- Accounts -->
    <section class="user-profile-section prersonal-prof">
        <div class="empty-banner"></div>
        <div class="container">
        <!-- <h4 class="setting-head mt-5">Settings Menu</h4> -->
        	<div class="row">
        		
                <div class="col-lg-8 user-profile-left mt-5">
               		<div class="profile-main-body">
                        <h4>Close your account</h4>
	                    	@include('../../../admin.message')
		                    <ul class="nav nav-tabs" id="myTab" role="tablist">
							  <li class="nav-item">
							    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Close with reason</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Close with success story</a>
							  </li>
							  
							</ul>
							<div class="tab-content" id="myTabContent">
							  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							  	<form id="terminate-form" class="form-horizontal" action="{{route('user.settings.post-delete-account')}}" enctype="multipart/form-data" method="post">
	                    			{{ csrf_field() }}
	                    			<div class="mt-5">
	                    				<div class="form-check">
										   <input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios1" value="Not Willing" checked>
										   <label class="form-check-label" for="exampleRadios1">
										    Not Willing
										  </label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios2" value="Not interested anymore">
											<label class="form-check-label" for="exampleRadios2">
											    Not interested anymore
											  </label>
										</div>
										<div class="form-check ">
											<input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios3" value="I have no time">
											<label class="form-check-label" for="exampleRadios3">
											   I have no time 
											  </label>
										</div>
										<div class="form-check ">
											<input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios4" value="Do not like it" >
											<label class="form-check-label" for="exampleRadios4">
											   Don't like it
											  </label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios5" value="I found someone" >
											<label class="form-check-label" for="exampleRadios5">
											   I found someone
											  </label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="reason_termination" id="exampleRadios6" value="Other" >
											<label class="form-check-label" for="exampleRadios6">
											   Other
											  </label>
										</div>
	                    			</div>
	                    			<div class="field-btn">
			                            <button type="submit">Save</button>
			                        </div>
	                    		</form>
							  </div>
							  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							  	<form id="successstory-form" class="form-horizontal" action="{{route('user.settings.post-success-story')}}" enctype="multipart/form-data" method="post">
			                    	{{ csrf_field() }}
				                    <div class="mt-5">
				                        <div class="field">
				                            <label for="title">Title*</label>
				                            <input type="text" class="required" name="title" id="title"  value="{{old('title')}}" > 
				                        </div>
				                        <div class="field">
				                            <label for="partner_name">Partner Name*</label>
				                            <input type="text" class="required" name="partner_name" id="partner_name"  value="{{old('partner_name')}}" > 
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
				                    </div>
			                    </form>
							  </div>
							</div>
                    </div>
                </div>
                <div class="col-lg-4 user-profile-left mt-5">
                    <div class="profile-main-body">
                        @include('/../../frontend.partials.setting_menus')
                    </div>
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
        	$('#successstory-form').validate();
        	$('#terminate-form').validate();
        });
    </script>
@endsection
