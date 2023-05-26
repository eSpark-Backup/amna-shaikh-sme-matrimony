@extends('app')
@section('title', 'Profile')
@section('style')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
	<link rel="stylesheet" href="{{ asset('admin-assets/assets/vendor/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
@endsection
@section('content')
	<!-- Accounts -->
    <section class="user-profile-section prersonal-prof">
        <div class="empty-banner"></div>
        <div class="container">
        	<div class="row">
        		<?php 
        			$photo_url = ($user->profile_image) ? asset('storage/members/profile-image/'.$user->profile_image) : asset('images/placeholder.png'); 
        		?>
        		<div class="col-lg-4 user-profile-left">
    				<div class="card card-profile border-0">
    					<div class="card-profile-cover user-profile-image">
        					<img alt="Image placeholder" src="{{$photo_url}}" class="card-img-top user-avatar">
        				</div> 
        				<a href="#" class="mx-auto">
        					<img alt="Image placeholder" src="{{$photo_url}}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar">
        				</a>
        				<div class="card-body p-3 pt-0 text-center">
        					<h5 class="mb-0">{{ $user->first_name.' '.$user->last_name }}</h5> 
        					<div>{{ $user->email }}</div> 
        					<div>Profile ID#: {{ $user->id }}</div> 
        					<div>
        						<span class="text-muted">Joined</span> 
        						<br>
                    			{{ $created_at }}
                 			</div> 
                 			<div class="actions d-flex justify-content-center mt-3 pt-3 px-5 delimiter-top"></div>
                 		</div>
                 	</div>
                 	<a href="#" class="mesg-btn add_photo btn-custom-primary" > Add Photo </a>
                    @if(count($user_images) > 0)
	                 	<div class="profile-photos">
	                        <h4>Photos from {{ $user['first_name'].' '.$user['last_name'] }}:</h4>
	                        <ul>
	                            @foreach($user_images as $K => $V)
	                                <li>
	                                    <?php 
	                                        $photo_uri = ($V->user_image) ? asset('storage/members/profile-image/'.$V->user_image) : asset('images/user-placeholder.jpg');
	                                    ?>
	                                    <a href="{{$photo_url}}" class="image_actions" data-toggle="modal" data-target="#exampleModal" data-id="{{ $V->id }}">
		                                    <div class="profile-gal" style="background-image: url({{$photo_uri}});"></div>
		                                </a>
	                                    
	                                </li>
	                            @endforeach
	                            
	                        </ul>
	                    </div>
	                @endif    
                </div>
                <div class="col-lg-8 user-profile-left ">
               		<div class="card bg-gradient-warning hover-shadow-lg mt-88">
               			<div class="card-body py-3">
               				
               				<div class="row row-grid align-items-center">
               					<div class="col-lg-12">
               						<div class="media align-items-center">
               							<a href="#" class="upload_photo">
               								<img alt="Image placeholder" src="{{$photo_url}}" class="avatar avatar-lg rounded-circle mr-3 user-avatar">
               							</a> 
               							<div>
               								<a href="#" class="upload_photo btn-custom-primary"><span class="">Upload photo</span>
               								</a> 
               								<div style="display: none;">
               									<form>
               										<input type="file" id="file" name="file">
               									</form>
               								</div>
               							</div>
               						</div>
               					</div>
               				</div>

               			</div>
               		</div>
               		<form id="privacy-form" class="form-horizontal" action="{{route('user.privacy-update')}}" enctype="multipart/form-data" method="post">
	               		<div class="profile-main-body">
	                    	<h4>Picture Privacy Settings</h4>
	                    
	                    	{{ csrf_field() }}
	                    	@include('../../../admin.message')
				            <input type="hidden" name="action" value="{{$action}}" >
				            <input name="id" type="hidden" value="{{ $user->id }}" >
	                        
		                    <div class="row form-group">
		                        <div class="col-md-12">
		                            <label for="picture_privacy" class="form-label">Profile Picture <span class="star"> :*</span></label>
		                            <select name="picture_privacy" id="picture_privacy" class="form-control required">
		                            	<option value="">-- Choose One --</option>
		                                <option value="blur" {{ (old('picture_privacy', $user->picture_privacy) == 'blur') ? 'selected' : '' }}>Blur</option>
		                                <option value="open" {{  (old('picture_privacy', $user->picture_privacy) == 'open')? 'selected':'' }}>Open</option>
		                            </select>
		                        </div>
		                        <div class="col-md-12">
		                            <label for="gallery_image" class="form-label">Gallery Images <span class="star"> :*</span></label>
		                            <select name="gallery_image" id="gallery_image" class="form-control required">
		                            	<option value="">-- Choose One --</option>
		                                <option value="only_me" {{ (old('gallery_image', $user->gallery_image) == 'only_me') ? 'selected' : '' }}>Only Me</option>
		                                <option value="all_member" {{  (old('gallery_image', $user->gallery_image) == 'all_member')? 'selected':'' }}>All Member</option>
		                            </select>
		                        </div>
		                    </div>
	                        <div class="field-btn">
	                            <button type="button" class="submit_for_save btn-custom-primary">Save</button>
	                        </div>
                    	
                    </form>
                </div>

        	</div>
            <div class="user-profile-row accounts-form flex">
                
                <div class="user-profile-center-custom ">
                    
                </div>
            </div>
        </div>
    </section>

    <div id="uploadimageModal" class="modal" role="dialog">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	         <div class="modal-header">
	            <h5 class="modal-title" id="exampleModalLabel">Upload & Crop Image</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
	         </div>
	         <div class="modal-body">
	            <div class="row">
	               <div class="col-md-8 text-center">
	                  <div id="image_demo" class="upload-image-container"></div>
	               </div>
	               <div class="col-md-4">
	                  <br />
	                  <div class="uploading_spinner text-center form-text text-muted" style="display: none;">Uploading ...</div>
	                  <br />
	                  <br/>
	                  <button class="btn-custom-primary crop_image">Crop & Upload Image</button>
	               </div>
	            </div>
	         </div>
	         <div class="modal-footer">
	            <button type="button" class="btn-custom-cancel" data-dismiss="modal">Close</button>
	         </div>
	      </div>
	   </div>
	</div>
	<!-- Modal -->
	<div class="modal fade d-none" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Image</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
		    <form id="image-form" class="form-horizontal" action="{{route('user.image-action')}}" method="post">
		            {{ csrf_field() }}
			   	<div class="modal-body">
			        <div class="row form-group">
			        	<div class="col-md-12">
		                    <input type="radio" id="private" name="image_action" value="1">
		                    <label for="private">Make it Private&nbsp&nbsp&nbsp</label>
							<input type="radio" id="profile" name="image_action" value="2">
							<label for="profile">Make it Profile Pic &nbsp&nbsp&nbsp</label>
							<input type="radio" id="delete" name="image_action" value="3">
							<label for="delete">Delete It</label><br>
			        	</div>
			        </div>
			        <input type="hidden" name="id" id="image_id" value="">
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		           <button type="submit" class="btn btn-primary">Save</button>
		        </div>
		    </form>
	    </div>
	  </div>
	</div>
	<div class="alert_popup">
		<div class="modal fade" id="submit_for_approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <div class="icon-show">!</div>
		        <h2>Are you sure you want to submit your profile for admin approval?</h2>
		        <p></p>
		        <div class="alert-action">
		        	
		        </div>
		      </div>
		      <div class="modal-footer">
			        <a href="javascript:void(0);" onclick="submitApprovalForm()">Proceed</a>
		        	<button type="button" class="btn">Cancel</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
@endsection

@section('js')
	<script src="{{ asset('admin-assets/assets/vendor/moment.min.js') }}"></script>
	<script src="{{ asset('admin-assets/assets/vendor/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
	<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
	
	
    <script>
        $(function(){
        	var _photo = 0;
		    $('.submit_for_approval').on('click',function(){
		    	Swal.fire({
	                title: 'Are you sure?',
	                text: "Are you sure, you want to submit your details for approval",
	                icon: 'warning',
	                showCancelButton: true,
	                confirmButtonColor: '#3085d6',
	                cancelButtonColor: '#d33',
	                confirmButtonText: 'Yes, Submit It!'
	            }).then((result) => {
	                if (result.isConfirmed) {
	                    /*Swal.fire(
	                        'Deleted!',
	                        'Your file has been deleted.',
	                        'success'
	                    );*/
	                    var action = "{{ url('/user/profile-submit-for-approval') }}"
	                    $('#privacy-form').attr('action', action);
	                    $('#privacy-form').submit();
	                }
	            });
		    });
		    $('.submit_for_save').on('click', function(){
		    	var action = "{{ route('user.privacy-update') }}"
	            $('#privacy-form').attr('action', action);
	            $('#privacy-form').submit();
		    });

            $('#privacy-form').validate();

            setTimeout(function(){

		        if( $('#country_id').data('countryid') != ''){
			  		var country_id = $('#country_id').data('countryid');
			  		var str = '';
			  		$.each(states[country_id], function(index, item) {
			  			
					   	str += '<option value="'+item['id']+'">'+item['name']+'</option>';
					});

					$('#state_id option:not(:first)').remove();
					$('#state_id').append(str);
					var state_id = $('#state_id').data('stateid');
					if (state_id != '') {
						$('#state_id').val(state_id).trigger('change');
					}
					
					
			  	}
		    }, 2000);
		    setTimeout(function(){

		        if( $('#state_id').data('stateid') != ''){
			  		var state_id = $('#state_id').data('stateid');
			  		var c_str = '';
			  		$.each(cities[state_id], function(ind, it) {
					   	c_str += '<option value="'+it['id']+'">'+it['name']+'</option>';
					});

					$('#city_id option:not(:first)').remove();
					$('#city_id').append(c_str);
					var city_id = $('#city_id').data('cityid');
					if (city_id != '') {
						$('#city_id').val(city_id).trigger('change');
					}
			  	}
		    }, 2000);

		    $('body').on('change', '#state_id', function(){
		    	var id = $(this).val();
		    	var c_str = '';
		    	
				$.each(cities[id], function(indx, itm) {
				   	c_str += '<option value="'+itm['id']+'">'+itm['name']+'</option>';
				});
				$('#city_id option:not(:first)').remove();
				$('#city_id').append(c_str);
				var city_id = $('#city_id').data('cityid');
				if (city_id != '') {
					$('#city_id').val(city_id);
				}else{
					$('#city_id').val('');
				}
				
		    });
		    $('body').on('change', '#country_id', function(){
		    	var id = $(this).val();
		    	var str = '';
		    	
				$.each(states[id], function(ind, ite) {
				   	str += '<option value="'+ite['id']+'">'+ite['name']+'</option>';
				});
				$('#state_id option:not(:first)').remove();
				$('#state_id').append(str);
				var state_id = $('#state_id').data('stateid');
				if (state_id != '') {
					$('#state_id').val(state_id).trigger('change');
				}else{
					$('#state_id').val('').trigger('change');
				}
				
		    });
		   
		    $('.upload_photo').on("click", function(e) {
		        e.preventDefault();
		        $('#file').focus().trigger("click");
		    });
		    $('.image_actions').on("click", function(e) {
		        e.preventDefault();
		       var id = $(this).data('id');
		        $('#image_id').val(id);
		    });
		    $('.add_photo').on("click", function(e) {
		        e.preventDefault();
		        $('#file').focus().trigger("click");
		        _photo = 1;
		    });


		    $image_crop = $('#image_demo').croppie({
		        enableExif: true,
		    
		        viewport: {
		            width: 360,
		            height: 360,
		            type: 'square' //circle
		        },
		        boundary: {
		            width: 400,
		            height: 400
		        }
		    });

		    var fileTypes = ['jpg', 'jpeg', 'png'];

		    $('#file').on('change', function() {
		        var reader = new FileReader();
		        var file = this.files[0]; // Get your file here
		        var fileExt = file.type.split('/')[1]; // Get the file extension

		        if (fileTypes.indexOf(fileExt) !== -1) 
		        {

		          reader.onload = function(event) {
		              $image_crop.croppie('bind', {
		                  url: event.target.result
		              }).then(function() {
		                  // console.log('jQuery bind complete');
		              });
		          }
		          reader.readAsDataURL(this.files[0]);
		          $('#uploadimageModal').modal('show');
		        
		        } 
		        else 
		        {
		          alert('File not supported');
		        }
		    });

		    $('.crop_image').on("click", function(event) {
		        $image_crop.croppie('result', {
		            type: 'canvas',
		            size: 'viewport'
		        }).then(function(response) {

		            response = response.replace("data:image/png;base64,", "");
		            if (_photo == 1) {
		            	upload_photo(response);
		            }else{
		            	upload(response);
		            }
		        })
		    });


		    function upload($image) {


		        var data = {
		            '_token': "{{ csrf_token() }}",
		            'file': $image
		        }

		        $('.uploading_spinner').show();
		        $('.crop_image').hide();


		        // AJAX request

		        $.post('{{ route("user.users_change_photo", $user->id) }}', data)
		            .done(function(response) {
		                $('.crop_image').show();
		                $('.uploading_spinner').hide();
		                $('#uploadimageModal').modal('hide');
		                $('.user-avatar').attr("src", response.file_url);
		            })
		            .fail(function($xhr) {
		                var response = $xhr.responseJSON;
		                $('.uploading_spinner').hide();
		                $('.crop_image').show();
		               // Swal.fire(response.msg);
		            });
		    }
		    function upload_photo($image) {


                var data = {
                    '_token': "{{ csrf_token() }}",
                    'file': $image
                }

                $('.uploading_spinner').show();
                $('.crop_image').hide();


                // AJAX request

                $.post('{{ route("user.users_add_photo") }}', data)
                    .done(function(response) {
                        $('.crop_image').show();
                        $('.uploading_spinner').hide();
                        $('#uploadimageModal').modal('hide');
                        _photo = 0;
                         window.location.reload(true);            
                    })
                    .fail(function($xhr) {
                        var response = $xhr.responseJSON;
                        $('.uploading_spinner').hide();
                        $('.crop_image').show();
                       // Swal.fire(response.msg);
                    });
            }
        });
    </script>
@endsection
