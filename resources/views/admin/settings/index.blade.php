@extends('admin.layouts.app')
@section('title', 'General Settings')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote.min.css') }}">
@endsection
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/general-settings')}}" class="">@yield('title')</a></li>
                  <li class="breadcrumb-item active"></li>
                </ol>
              </nav>
            </div>
        </div>
    </div>
</div>
  <!--//Page Toolbar End//-->
<div class="content p-4 pb-0 d-flex flex-column-fluid">
  <div class="container-fluid px-0">
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card h-100">
          <div class="card-header">
            <h5 class="mb-1"> @yield('title')</h5>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/general-settings/update')}}"
              enctype="multipart/form-data" method="POST">
              @csrf

                <nav>
				  <div class="nav nav-tabs" id="nav-tab" role="tablist">
				    <button class="nav-link active" id="general-settings-tab" data-bs-toggle="tab" data-bs-target="#general-settings" type="button" role="tab" aria-controls="nav-home" aria-selected="true">General Settings</button>
				    <button class="nav-link" id="homepage-tab" data-bs-toggle="tab" data-bs-target="#homepage" type="button" role="tab" aria-controls="nav-homepage" aria-selected="true">Home Page</button>
				    <button class="nav-link" id="social-links-tab" data-bs-toggle="tab" data-bs-target="#social-links" type="button" role="tab" aria-controls="social-links" aria-selected="false">Social Links</button>
				    <button class="nav-link" id="terms-conditions-tab" data-bs-toggle="tab" data-bs-target="#terms-conditions" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Terms & Conditions</button>
				    <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">Privacy</button>
				  </div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
				  <!-- General Settings -->
				  <div class="tab-pane fade show active" id="general-settings" role="tabpanel" aria-labelledby="general-settings-tab">
				  	
					<div class="card padding-unset">
						<div class="card-header custom-card-header">
						    General Settings
						</div>
						<div class="card-body">
							<div class="row">
							    <div class="col-md-6">
					                <label for="name" class="form-label">System Name</label>
					                <input type="text" name="system_name" class="form-control required" id="name" value="{{ isset($item['system_name'])?$item['system_name'] :'' }}">
					            </div>
				                <div class="col-md-6">
					                <label for="title" class="form-label">System Title</label>
					                <input type="text" name="system_title" class="form-control required" id="title" value="{{isset( $item['system_title'])? $item['system_title']:'' }}">
					            </div>
					            <div class="col-md-6">
					                <label for="phone" class="form-label">System Phone</label>
					                <input type="tel" name="phone" class="form-control required" id="phone" value="{{ isset($item['phone']) ? $item['phone']:'' }}">
					            </div>
					            <div class="col-md-6">
					                <label for="email" class="form-label">System Email</label>
					                <input type="email" name="email" class="form-control required" id="email" required="" value="{{ isset($item['email'])?$item['email']:'' }}">
					            </div>
					            <div class="col-md-12">
					                <label for="address" class="form-label">Address</label>
					                <textarea name="address" id="address" class="form-control">{{ isset($item['address']) ? $item['address']:'' }}</textarea>
					            </div>
				            </div>
						</div>
					</div>
				  </div>
				  <!-- Home page -->
				  <div class="tab-pane fade" id="homepage" role="tabpanel" aria-labelledby="homepage-tab">
					<div class="card padding-unset">
						<!-- Slider Images -->
						<div class="card-header custom-card-header">
						   Slider Images
						</div>
						<div class="card-body">
							<div class="row">
							    <h3 class="m-2">Photos</h3>
					            <div class="alert-secondary m-0 " style="position: relative;padding: 1rem 1rem;margin-bottom: 1rem;border: 1px solid transparent;">
					              Select Images <input type="file" name="slider[]" multiple class="form-control" accept="image/x-png,image/gif,image/jpeg" />
					                  
					                    <div id="sp_gal">
					                      <div class="row">
					                      	@if(isset($slider_images) && count($slider_images) > 0)
						                        @foreach($slider_images as $K => $slider)
						                        <div class="col-md-2 mt-4">
						                          <img src="{{ $slider }}" style="height: 100px;">
						                          <div style="margin:8px 8px 3px 8px;">
						                          <input name="slider_chk_del[]" value="{{ $K }}" type="checkbox"> DELETE</div>
						                        </div>
						                        @endforeach
						                    @endif
					                      </div>
					                    </div>
					            </div>
				            </div>
						</div>


						<div class="card-header custom-card-header">
						    Happy Couples
						</div>
						<div class="card-body">
							<div class="row">
							    <div class="col-md-12">
					                <label for="happy_couple_title" class="form-label">Title</label>
					                <input type="text" name="happy_couple_title" class="form-control required" id="happy_couple_title" value="{{ @$item['happy_couple_title'] }}">
					            </div>
				                <div class="col-md-12">
					                <label for="title" class="form-label">Description</label>
					                <textarea name="happy_couple_description" class="form-control  open-source-plugins" >{{ @$item['happy_couple_description'] }}</textarea>
					            </div>
				            </div>
						</div>
						<div class="card-header custom-card-header">
						    Matrimonial Events
						</div>
						<div class="card-body">
							<div class="row">
							    <div class="col-md-12">
					                <label for="events_title" class="form-label">Title</label>
					                <input type="text" name="events_title" class="form-control required" id="events_title" value="{{ @$item['events_title'] }}">
					            </div>
				                <div class="col-md-12">
					                <label for="title" class="form-label">Description</label>
					                <textarea name="events_description" class="form-control open-source-plugins" cols="50">{{ @$item['events_description'] }}</textarea>
					            </div>
				            </div>
						</div>
						<div class="card-header custom-card-header">
						    New Members
						</div>
						<div class="card-body">
							<div class="row">
							    <div class="col-md-12">
					                <label for="members_title" class="form-label">Title</label>
					                <input type="text" name="members_title" class="form-control required" id="name" value="{{ @$item['members_title'] }}">
					            </div>
				                <div class="col-md-12">
					                <label for="members_description" class="form-label">Description</label>
					                <textarea name="members_description" class="form-control open-source-plugins" cols="50">{{ @$item['members_description'] }}</textarea>
					            </div>
				            </div>
						</div>
						<div class="card-header custom-card-header">
						    About SME Matrimony
						</div>
						<div class="card-body">
							<div class="row">
							    <div class="col-md-12">
					                <label for="about_title" class="form-label">Title</label>
					                <input type="text" name="about_title" class="form-control required" id="about_title" value="{{ @$item['about_title'] }}">
					            </div>
				                <div class="col-md-12">
					                <label for="title" class="form-label">Description</label>
					                <textarea name="about_description" class="form-control open-source-plugins" cols="50">{{ @$item['about_description'] }}</textarea>
					            </div>
					            <h3 class="m-2">Photos</h3>
					            <div class="alert-secondary m-0 " style="position: relative;padding: 1rem 1rem;margin-bottom: 1rem;border: 1px solid transparent;">
					              Select Images <input type="file" name="gallary[]" multiple class="form-control" accept="image/x-png,image/gif,image/jpeg" />
					                  
					                    <div id="sp_gal">
					                      <div class="row">
					                        @foreach($about_images as $K => $glry)
					                        <div class="col-md-2 mt-4">
					                          <img src="{{ $glry }}" style="height: 100px;">
					                          <div style="margin:8px 8px 3px 8px;">
					                          <input name="chk_del[]" value="{{ $K }}" type="checkbox"> DELETE</div>
					                        </div>
					                        @endforeach
					                      </div>
					                    </div>
					            </div>
				            </div>
						</div>
					</div>
				  </div>
				  <!-- Social links -->
				  <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links-tab">
				  	
					<div class="card padding-unset">
						<div class="card-header custom-card-header">
						   Social Links
						</div>
						<div class="card-body">
							<div class="row">
				                <div class="input-group mb-3">
								  <span class="input-group-text"><i class="fa fa-youtube fa-lg"></i></span>
								  <input name="youtube_link" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ @$item['youtube_link'] }}">
								</div>
					            <div class="input-group mb-3">
								  <span class="input-group-text"><i class="fa fa-facebook fa-lg"></i></span>
								  <input name="facebook_link" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ @$item['facebook_link'] }}">
								</div>
								<div class="input-group mb-3">
								  <span class="input-group-text"><i class="fa fa-instagram fa-lg"></i></span>
								  <input name="instagram_link" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ @$item['instagram_link'] }}">
								</div>
								<div class="input-group mb-3">
								  <span class="input-group-text"><i class="fa fa-whatsapp fa-lg"></i></span>
								  <input name="whatsapp" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ @$item['whatsapp'] }}">
								</div>
								<div class="input-group mb-3">
								  <span class="input-group-text"><i class="fa fa-meetup fa-lg"></i></span>
								  <input name="meetup_link" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="{{ @$item['meetup_link'] }}">
								</div>
				            </div>
						</div>
					</div>
				  </div>
				  <!-- Terms & Conditions -->
				  <div class="tab-pane fade" id="terms-conditions" role="tabpanel" aria-labelledby="terms-conditions-tab">
				  	
					<div class="card padding-unset">
						<div class="card-header custom-card-header">
						   Terms & Conditions
						</div>
						<div class="card-body">
							<div class="row">
								<label for="name" class="form-label"> Terms & Conditions</label>
				                <textarea name="terms_condition" class="form-control open-source-plugins" cols="50">{{ @$item['terms_condition'] }}</textarea>
				            </div>
						</div>
					</div>
				  </div>
				  <!-- Privacy -->
				   <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
					<div class="card padding-unset">
						<div class="card-header custom-card-header">
						   Privacy Policy
						</div>
						<div class="card-body">
							<div class="row">
								<label for="name" class="form-label">Privacy Policy</label>
				                <textarea name="privacy_policy" class="form-control open-source-plugins" cols="50">{{ @$item['privacy_policy'] }}</textarea>
				            </div>
						</div>
					</div>
				  </div>
				</div>
			  
                <input name="id" type="hidden" value="{{ @$item['id'] }}" />

                <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/dashboard')}}">
                      <button type="button" class="btn btn btn-secondary">
                        <span>Cancel</span>
                      </button>
                    </a>
                    <button type="submit" class="btn btn-primary  btn-fullrounded">
                      <span>Save</span>
                    </button>
                  </div>
              	</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin-assets/summernote/summernote.min.js') }}"></script>
<script>

  $(function() {
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('.datepicker ').val(today);
    $('.datepicker').datepicker({
        todayHighlight: true,
        dateFormat: 'yy-mm-dd'
    });
    $("#admins-form").validate({
        rules : {
                  password: {
                    required: true,
                    minlength: 5
                  },
                  original_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                  },
                }
    });
    
  });
</script>
@endsection
