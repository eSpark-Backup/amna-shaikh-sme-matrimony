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
        			$photo_url = ($user->profile_image) ? asset('storage/members/profile-image/'.$user->profile_image) : asset('images/image-svgrepo-com.svg'); 
        		?>
        		<div class="col-lg-4 user-profile-left">
    				<div class="card card-profile border-0">
    					<div class="card-profile-cover user-profile-image">
        					<img alt="Image placeholder" src="{{$photo_url}}" class="card-img-top user-avatar">
        				</div> 
        				<a href="#" class="mx-auto">
        					<img alt="Image placeholder" src="{{$photo_url}}" class="card-profile-image avatar rounded-circle shadow hover-shadow-lg user-avatar">
        				</a>
        				<div class="card-body p-3 pt-0 text-center padding_cls">
        					<h5 class="mb-0">{{ $user->first_name.' '.$user->last_name }}</h5> 
        					<div>{{ $user->email }}</div> 
        					<div>Profile ID#: {{ $user->id }}</div> 
        					<div>
        						<span class="text-muted">Joined</span> 
        						<br>
                    			{{ $created_at }}
                 			</div> 
                 			<div class="card bg-gradient-warning hover-shadow-lg desktop_none">
		               			<div class="card-body py-3">
		               				<div class="row row-grid align-items-center">
		               					<div class="col-lg-12">
		               						<div class="media align-items-center">
		               							<a href="#" class="upload_photo">
		               								<img alt="Image placeholder" src="{{$photo_url}}" class="avatar avatar-lg rounded-circle mr-3 user-avatar">
		               							</a> 
		               							<div>
		               								<a href="#" class="upload_photo"><span class="">Upload profile photo</span>
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
                 			<div class="actions d-flex justify-content-center delimiter-top"></div>
                 		</div>
                 	</div>
                 	<div class="d-flex btn_action">
                 		<a href="#" class="mesg-btn add_photo btn-custom-primary" > Add gallary photo </a>
	                 	<a href="{{url('user/picture-privacy')}}" class="btn-custom-secondary"><span>Picture Privacy</span></a>
	                 	
	                 </div>
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
               		<div class="card bg-gradient-warning hover-shadow-lg mt-88 mobile_none">
               			<div class="card-body py-3">
               				<div class="row row-grid align-items-center">
               					<div class="col-lg-12">
               						<div class="media align-items-center">
               							<a href="#" class="upload_photo">
               								<img alt="Image placeholder" src="{{$photo_url}}" class="avatar avatar-lg rounded-circle mr-3 user-avatar">
               							</a> 
               							<div>
               								<a href="#" class="upload_photo btn-custom-primary"><span class="">Profile picture</span>
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
               		<form id="user-form" class="form-horizontal" action="{{route('user.profile-update')}}" enctype="multipart/form-data" method="post">
	               		<div class="profile-main-body">
	                    	<h4>Account Basic Information (Mandatory) </h4>
	                    
	                    	{{ csrf_field() }}
	                    	@include('../../../admin.message')
				            <input type="hidden" name="action" value="{{$action}}" >
				            <input name="id" type="hidden" value="{{ $user->id }}" >
	                        <div class="fields-row">
	                            <div class="field">
	                                <label for="first_name">First Name <span class="star"> :*</span></label>
	                                <input type="text" name="first_name" class="required" id="first_name" value="{{ $user->first_name }}">
	                            </div>
	                            <div class="field">
	                                <label for="last_name">Last Name <span class="star"> :*</span></label>
	                                <input type="text" name="last_name" class="required" id="last_name" value="{{ $user->last_name }}">
	                            </div>
	                        </div>
	                        <div class="fields-row">
		                        <div class="field">
		                            <label for="email">Email Address  <span class="star"> :*</span></label>
		                            <input type="email" placeholder="" name="email" id="email" class="required" value="{{ $user->email }}" readonly=""> 
		                        </div>
		                        <div class="field">
		                            <label for="mobile">Mobile <span class="star"> :*</span></label>
		                            <input type="tel" placeholder="" name="mobile" id="mobile" class="required" value="{{ $user->mobile }}"> 
		                        </div>
		                    </div>
		                    @if(!isset($user->social_id) && empty($user->social_id))
		                    <div class="fields-row">
		                        <div class="field">
		                            <label for="password">Password <span class="star"> :*</span></label>
		                            <i class="fa fa-eye" id="togglePassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
		                            <input type="password" placeholder="" name="password" id="password"  value="{{old('password', $user->original_password)}}"> 

		                        </div>
		                        <div class="field">
		                            <label for="c_password">Confirm Password <span class="star"> :*</span></label>
		                            <i class="fa fa-eye" id="toggleCpassword" style="margin-left: 437px; cursor: pointer;position: absolute;margin-top: 8px"></i>
		                            <input type="password" name="original_password" id="c_password" value="{{ old('original_password',$user->original_password) }}"> 
		                        </div>
		                    </div>
		                    @endif
		                    <div class="row form-group">
		                        <div class="col-md-4">
		                            <label for="gender" class="form-label">Gender <span class="star"> :*</span></label>
		                            <select name="gender" id="gender" class="form-control required">
		                            	<option value="">-- Choose One --</option>
		                                <option value="0" {{ (old('gender', $user->gender) == 0) ? 'selected' : '' }}>Male</option>
		                                <option value="1" {{  (old('gender', $user->gender) == 1)? 'selected':'' }}>Female</option>
		                                <option value="2" {{ (old('gender', $user->gender) == 2)? 'selected':'' }}>Other</option>
		                            </select>
		                        </div>
		                        <div class="col-md-4">
		                            <label for="on_behalf_id" class="form-label">On behalf <span class="star"> :*</span></label>
		                            <select name="on_behalf_id" id="on_behalf_id" class="form-control required">
		                                <option value="">-- Choose Onbehalf --</option>
		                                @foreach ($onbehalf as $behalf)
						                    <option value="{{$behalf->id}}" {{ (old('on_behalf_id' , $user->on_behalf_id) == $behalf->id)? 'selected':'' }}>
						                      {{$behalf->name}}</option>
						                @endforeach
		                            </select>
		                        </div>
		                        <div class="col-md-4">
		                            <label for="dob" class="form-label">Date Of Birth <span class="star"> :*</span></label>
	                           		<input type="text" class="form-control datepicker hasDatepicker required" name="date_of_birth" id="dob" data-date-format="yyyy-mm-dd" value="{{ old('date_of_birth',$user->date_of_birth) }}">
		                        </div>
		                    </div>
	                       	<div class="row form-group">
	                       		<div class="col-md-6">
	                                <label for="religion_id" class="form-label">Religion <span class="star"> :*</span></label>
		                            <select name="religion_id" id="religion_id" class="form-control required">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($religions as $religion)
		                                	
						                    <option value="{{$religion->id}}" {{ (old('religion_id', $user->religion_id) == $religion->id)? 'selected':'' }}>
						                      {{$religion->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="caste_id" class="form-label">Caste <span class="star"> :*</span></label>
		                            <select name="caste_id" id="caste_id" class="form-control required">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($castes as $caste)
		                                	
						                    <option value="{{$caste->id}}"
						                      {{ (old('caste_id', $user->caste_id) == $caste->id)? 'selected' : ''}}>

						                      {{$caste->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                       	</div>
	                       	<div class="row form-group">
	                       		<div class="col-md-6">
	                                <label for="height" class="form-label">Height<span class="star"> :*</span></label>
	                                <select id="height" name="height" class="form-control required">
	                                	<option>Select Height</option>
	                                	@foreach(getHeight() as $H => $hV)
	                                		<option value="{{ $hV }}" {{ old('height',$user->height == $hV)? 'selected':'' }}>{{ $hV }}</option>
	                                	@endforeach
	                                </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="marital_status_id" class="form-label">Marital Status <span class="star"> :*</span></label>
		                            <select name="marital_status_id" class="form-control required" id="marital_status_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($maritalStatus as $m_status)
						                    <option value="{{$m_status->id}}"
						                       {{old('marital_status_id', $user->marital_status_id == $m_status->id)  ? 'selected' : ''}}> {{$m_status->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                       	</div>
	                       	<div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="education_id" class="form-label">Highest Education <span class="star"> :*</span></label>
		                            <select name="education_id" id="education_id" class="form-control required">
		                                <option value="">-- Choose Education --</option>
		                                @foreach($educations as $education)
						                  	<option value="{{$education->id}}" {{old('education_id', $user->education_id == $education->id)  ? 'selected' : ''}}>{{$education->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="occupation_id" class="form-label">Occupation <span class="star"> :*</span></label>
		                            <select name="occupation_id" id="occupation_id" class="form-control required">
		                                <option value="">-- Choose Occupation --</option>
		                                @foreach($occupations as $occupation)
					                  	<option value="{{$occupation->id}}" {{old('occupation_id', $user->occupation_id == $occupation->id)  ? 'selected' : ''}} >{{$occupation->name}}</option>
					                  	@endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-4 ">
	                                <label for="country_id" class="form-label">Present Country <span class="star"> :*</span></label>
		                            <select name="country_id" id="country_id" class="form-control required" data-countryid="{{ $user->country_id }}">
		                                <option value="">-- Choose Country --</option>
		                                @foreach($countries as $country)
						                  <option value="{{$country->id}}" {{old('country_id', $user->country_id == $country->id)  ? 'selected' : ''}}>{{$country->name}} </option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="state_id" class="form-label">State <span class="star"> :*</span></label>
		                            <select name="state_id" id="state_id" class="form-control required" data-stateid="{{ $user->state_id }}" >
		                                <option value="">-- Choose State --</option>
		                                
		                            </select>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="city_id" class="form-label">City <span class="star"> :*</span></label>
		                            <select name="city_id" id="city_id" class="form-control required" data-cityid="{{ $user->city_id }}">
		                                <option value="">-- Choose City --</option>
		                                
		                            </select>
	                            </div>
	                            
	                        </div>
	                        <div class="row form-group">
	                        	<div class="col-md-12">
	                                <label for="about" class="form-label">Introduction (Please write about you & your family) <span class="star"> :*</span></label>
	                                <textarea name="about" class="form-control required" id="about" rows="8">{{ old('about',$user->about) }}</textarea>
	                            </div>
	                        </div>	                      
	                        <div class="field-btn">
	                            <button type="button" class="submit_for_save btn-custom-primary">Save</button>
	                            @if($user->is_approved != 1 && $user->status != 4 )
	                            	<button type="button" class="submit_for_approval_popup btn-custom-secondary" onclick="submitApprovalFormPopup()">Submit for approval</button>
	                            @endif
	                        </div>
		                    <h4 class="space_cls">Additional Personal Details (Optional)</h4>
	                        
	                        <h5>Additional Personal Details</h5>
	                        <div class="row form-group">
	                            <div class="col-md-3">
	                                <label for="home_district" class="form-label">Home District</label>
		                            <input type="text" name="home_district" class="form-control" id="home_district" value="{{ $user->home_district }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="family_residence" class="form-label">Family Residence</label>
		                            <input type="text" name="family_residence" class="form-control" id="family_residence" value="{{ $user->family_residence }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="brothers_sisters" class="form-label">Special Circumstances</label>
		                            <input type="text" name="special_circumstances" id="special_circumstances" class="form-control" value="{{ $user->special_circumstances }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="father_occupation_id" class="form-label">Father Occupation</label>
		                            <select name="father_occupation_id" class="form-control" id="father_occupation_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($occupations as $coccupation)
						                    <option value="{{$coccupation->id}}"
						                      {{$coccupation->id == $user->father_occupation_id  ? 'selected' : ''}}>
						                      {{$coccupation->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <h5>Physical Attributes</h5>
	                        <div class="row form-group">
	                            
	                            <div class="col-md-6">
	                                <label for="weight" class="form-label">Weight</label>
		                            <input type="number" name="weight" class="form-control" min="0" value="{{ $user->weight }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="eye_color" class="form-label">Eye Color</label>
		                            <input type="text" name="eye_color" class="form-control" id="eye_color" value="{{ $user->eye_color }}">
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-4">
	                                <label for="hair_color" class="form-label">Hair Color</label>
		                            <input type="text" name="hair_color" class="form-control" id="hair_color" value="{{ $user->hair_color }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="complexion" class="form-label">Complexion</label>
		                            <input type="text" name="complexion" class="form-control" id="complexion" value="{{ $user->complexion }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="blood_group" class="form-label">Blood Group</label>
		                            <input type="text" name="blood_group" class="form-control" id="blood_group" value="{{ $user->blood_group }}">
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-4">
	                                <label for="body_type" class="form-label">Body Type</label>
		                            <input type="text" name="body_type" class="form-control" id="body_type" value="{{ $user->body_type }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="body_art" class="form-label">Body Art</label>
		                            <input type="text" name="body_art" class="form-control" id="body_art" value="{{ $user->body_art }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="any_desability" class="form-label">Any Desability</label>
		                            <input type="text" name="any_desability" class="form-control" id="any_desability" value="{{ $user->any_desability }}">
	                            </div>
	                        </div>
	                        <h5>Language</h5>
	                        <div class="row form-group">
	                            <div class="col-md-3">
	                                <label for="mother_language_id" class="form-label">Mother Tongue</label>
		                            <select name="mother_language_id" id="mother_language_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($languages as $language)
						                    <option value="{{$language->id}}"
						                      {{$language->id == $user->mother_language_id  ? 'selected' : ''}}>
						                      {{$language->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="language_id" class="form-label">Language</label>
		                            <select name="language_id" id="language_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($languages as $lang)
						                    <option value="{{$lang->id}}"
						                      {{$lang->id == $user->language_id  ? 'selected' : ''}}>
						                      {{$lang->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="speek_language_id" class="form-label">Speek</label>
		                            <select name="speek_language_id" id="speek_language_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($languages as $speek_lang)
						                    <option value="{{$speek_lang->id}}"
						                      {{$speek_lang->id == $user->speek_language_id  ? 'selected' : ''}}>
						                      {{$speek_lang->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="read_language_id" class="form-label">Read</label>
		                            <select name="read_language_id" id="read_language_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($languages as $read_lang)
						                    <option value="{{$read_lang->id}}"
						                      {{$read_lang->id == $user->read_language_id  ? 'selected' : ''}}>
						                      {{$read_lang->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <h5>Residency Information</h5>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="birthday_country_id" class="form-label">Birth Country</label>
		                            <select name="birthday_country_id" id="birthday_country_id" class="form-control required	">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($countries as $country)
						                    <option value="{{$country->id}}"
						                      {{$country->id == $user->birthday_country_id  ? 'selected' : ''}}>
						                      {{$country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="residency_country_id" class="form-label">Residency Country</label>
		                            <select name="residency_country_id" id="residency_country_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($countries as $r_country)
						                    <option value="{{$r_country->id}}"
						                      {{$r_country->id == $user->residency_country_id  ? 'selected' : ''}}>
						                      {{$r_country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="citizenship_country_id" class="form-label">Citizenship Country</label>
		                            <select name="citizenship_country_id" id="citizenship_country_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($countries as $r_country)
						                    <option value="{{$r_country->id}}"
						                      {{$r_country->id == $user->citizenship_country_id  ? 'selected' : ''}}>
						                      {{$r_country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="growup_country_id" class="form-label">Growup Country</label>
		                            <select name="growup_country_id" id="growup_country_id" class="form-control ">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($countries as $r_country)
						                    <option value="{{$r_country->id}}"
						                      {{$r_country->id == $user->growup_country_id  ? 'selected' : ''}}>
						                      {{$r_country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                        	<div class="col-md-6">
	                                <label for="immigration_status" class="form-label">Immigration Status</label>
		                            <input type="text" name="immigration_status" class="form-control" id="immigration_status" value="{{ $user->immigration_status }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="postal_code" class="form-label">Zip Code</label>
		                            <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ $user->postal_code }}">
	                            </div>
	                        </div>
	                        <h5>Spiritual & Social Background</h5>
	                        <div class="row form-group">
	                            
	                            <div class="col-md-4">
	                                <label for="family_value_id" class="form-label">Family Value</label>
		                            <select name="family_value_id" id="family_value_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($familyValues as $f_val)
						                    <option value="{{$f_val->id}}"
						                      {{$f_val->id == $user->family_value_id  ? 'selected' : ''}}>
						                      {{$f_val->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="family_status_id" class="form-label">Family Status</label>
		                            <select name="family_status_id" id="family_status_id" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                @foreach ($familyStatus as $f_status)
						                    <option value="{{$f_status->id}}"
						                      {{$f_status->id == $user->family_status_id  ? 'selected' : ''}}>
						                      {{$f_status->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            
		                        <div class="col-md-4">
		                            <label for="annual_income" class="form-label">Annual Income</label>
		                            <select name="annual_income" id="annual_income" class="form-control">
		                                <option value="">-- Choose Income --</option>
		                                <option value="1000 - 5000 USD" {{ ($user->annual_income ==  "1000 - 5000 USD") ? 'selected': '' }}>1000 - 5000 USD</option>
		                                <option value="5000 - 10000 USD" {{ ($user->annual_income ==  "1000 - 5000 USD") ? 'selected': '' }}>5000 - 10000 USD</option>
		                                <option value="10000 - 15000 USD" {{ ($user->annual_income ==  "1000 - 5000 USD") ? 'selected': '' }}>10000 - 15000 USD</option>
		                                <option value="15000 - 20000 USD" {{ ($user->annual_income ==  "15000 - 20000 USD") ? 'selected': '' }}>15000 - 20000 USD</option>
		                                <option value="20000 - 25000 USD" {{ ($user->annual_income ==  "20000 - 25000 USD") ? 'selected': '' }}>20000 - 25000 USD</option>
		                                <option value="25000 - 30000 USD" {{ ($user->annual_income ==  "25000 - 30000 USD") ? 'selected': '' }}>25000 - 30000 USD</option>
		                                <option value="30000 - 35000 USD" {{ ($user->annual_income ==  "30000 - 35000 USD") ? 'selected': '' }}>30000 - 35000 USD</option>
		                                <option value="35000 - 40000 USD" {{ ($user->annual_income ==  "35000 - 40000 USD") ? 'selected': '' }}>35000 - 40000 USD</option>
		                                <option value="40000 - 45000 USD" {{ ($user->annual_income ==  "40000 - 45000 USD") ? 'selected': '' }}>40000 - 45000 USD</option>
		                                <option value="45000 - 50000 USD" {{ ($user->annual_income ==  "45000 - 50000 USD") ? 'selected': '' }}>45000 - 50000 USD</option>
		                                <option value="50000 - 55000 USD" {{ ($user->annual_income ==  "50000 - 55000 USD") ? 'selected': '' }}>50000 - 55000 USD</option>
		                                <option value="Prefer not to say" {{ ($user->annual_income ==  "Prefer not to say") ? 'selected': '' }}>Prefer not to say</option>
		                            </select>
		                        </div>
		                    
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-3">
	                                <label for="personal_value" class="form-label">Personal Value</label>
		                            <input type="text" name="personal_value" class="form-control" id="personal_value" value="{{ $user->personal_value }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="community_value" class="form-label">Community Value</label>
		                            <input type="text" name="community_value" class="form-control" id="community_value" value="{{ $user->community_value }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="ethniciy" class="form-label">Ethniciy</label>
		                            <input type="text" name="ethniciy" id="ethniciy" class="form-control" value="{{ $user->ethniciy }}">
	                            </div>
	                            <div class="col-md-3">
	                                <label for="manglik" class="form-label">Manglik</label>
		                            <select name="manglik" id="manglik" class="form-control">
		                                <option value="">-- Choose One --</option>
		                                <option value="1" {{$user->manglik == 1  ? 'selected' : ''}}>No</option>
						                <option value="2" {{$user->manglik == 2  ? 'selected' : ''}} >Yes</option>
						                <option value="3" {{$user->manglik == 3  ? 'selected' : ''}} >I don't know</option>
		                            </select>
	                            </div>
	                        </div>
	                        <h5>Family Information</h5>
	                        <div class="row form-group">
	                            <div class="col-md-4">
	                                <label for="father_name" class="form-label">Father Name</label>
		                            <input type="text" name="father_name" class="form-control" id="father_name" value="{{ $user->father_name }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="mother_name" class="form-label">Mother Name</label>
		                            <input type="text" name="mother_name" class="form-control" id="mother_name" value="{{ $user->mother_name }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="brothers_sisters" class="form-label">Brothers Sisters</label>
		                            <input type="text" name="brothers_sisters" id="brothers_sisters" class="form-control" value="{{ $user->brothers_sisters }}">
	                            </div>
	                        </div>
	                        <h5>Partner Expectation</h5>
	                        <div class="row form-group">
	                            <div class="col-md-12">
	                                <label for="partner_general_requirement" class="form-label">General Requirement</label>
	                                <textarea name="partner_general_requirement" class="form-control" id="partner_general_requirement" rows="6">{{ $user->partner_general_requirement }}</textarea>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-4">
	                                <label for="partner_age" class="form-label">Age</label>
		                            <select name="partner_age" class="form-control" id="partner_age">
		                            	<option value=""> -- Choose One --</option>
		                            	@for($i = 100; $i >= 1; $i--)
		                            		<option value="{{$i}}" {{$user->partner_age == $i  ? 'selected' : ''}}>{{$i}}</option>
		                            	@endfor
		                            </select>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="partner_height" class="form-label">Height</label>
		                            <input type="text" name="partner_height" id="partner_height" class="form-control" value="{{ $user->partner_height }}">
	                            </div>
	                            <div class="col-md-4">
	                                <label for="partner_weight" class="form-label">Weight</label>
		                            <input type="text" name="partner_weight" id="partner_weight" class="form-control" value="{{ $user->partner_weight }}">
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-3">
	                                <label for="partner_marital_status_id" class="form-label">Marital Status</label>
		                            <select name="partner_marital_status_id" class="form-control" id="partner_marital_status_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($maritalStatus as $m_status)
						                    <option value="{{$m_status->id}}"
						                      {{$m_status->id == $user->partner_marital_status_id  ? 'selected' : ''}}>
						                      {{$m_status->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="partner_with_children_acceptable" class="form-label">Children Acceptables</label>
		                            <select name="partner_with_children_acceptable" class="form-control" id="partner_with_children_acceptable">
		                            	<option value="1" {{$user->partner_with_children_acceptable == 1  ? 'selected' : ''}}>Yes</option>
					                  	<option value="2" {{$user->partner_with_children_acceptable == 2  ? 'selected' : ''}} >No</option>
					                  	<option value="3" {{$user->partner_with_children_acceptable == 3  ? 'selected' : ''}} >Doesn't matter</option>
		                            	
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="partner_caste_id" class="form-label">Caste</label>
		                            <select name="partner_caste_id" class="form-control" id="partner_caste_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($castes as $p_caste)
						                    <option value="{{$p_caste->id}}"
						                      {{$p_caste->id == $user->partner_caste_id  ? 'selected' : ''}}>
						                      {{$p_caste->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-3">
	                                <label for="partner_religion_id" class="form-label">Religion</label>
		                            <select name="partner_religion_id" class="form-control" id="partner_religion_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($religions as $religion)
						                    <option value="{{$religion->id}}"
						                      {{$religion->id == $user->partner_religion_id  ? 'selected' : ''}}>
						                      {{$religion->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_country_residence_id" class="form-label">Country of Residence</label>
		                            <select name="partner_country_residence_id" class="form-control" id="partner_country_residence_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($countries as $re_country)
						                    <option value="{{$re_country->id}}"
						                      {{$re_country->id == $user->partner_country_residence_id  ? 'selected' : ''}}>
						                      {{$re_country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_education_id" class="form-label">Education</label>
		                            <select name="partner_education_id" class="form-control" id="partner_education_id">
		                            	<option value=""> -- Choose One --</option>
		                            	@foreach ($educations as $education)
						                    <option value="{{$education->id}}"
						                      {{$education->id == $user->partner_education_id  ? 'selected' : ''}}>
						                      {{$education->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_profession" class="form-label">Profession</label>
		                            <input type="text" name="partner_profession" class="form-control" id="partner_profession" value="{{ $user->partner_profession }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_complexion" class="form-label">Complexion</label>
		                           <input type="text" name="partner_complexion" class="form-control" id="partner_complexion" value="{{ $user->partner_complexion }}">
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_drinking_habits" class="form-label">Drinking Habits</label>
		                            <select name="partner_drinking_habits" class="form-control" id="partner_drinking_habits">
		                            	<option value="">-- Choose One --</option>
		                            	<option value="1" {{$user->partner_drinking_habits == 1  ? 'selected' : ''}}>Yes</option>
					                	<option value="0" {{$user->partner_drinking_habits == 0  ? 'selected' : ''}}>No</option>
					                	<option value="3" {{$user->partner_drinking_habits == 3  ? 'selected' : ''}}>Doest'n Matter</option>
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_smoking_habits" class="form-label">Smoking Habits</label>
		                            <select name="partner_smoking_habits" class="form-control" id="partner_smoking_habits">
		                            	<option value="">-- Choose One --</option>
		                            	<option value="1" {{$user->partner_smoking_habits == 1  ? 'selected' : ''}}>Yes</option>
					                	<option value="0" {{$user->partner_smoking_habits == 0  ? 'selected' : ''}}>No</option>
					                	<option value="3" {{$user->partner_smoking_habits == 3  ? 'selected' : ''}}>Doest'n Matter</option>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_diet" class="form-label">Diet</label>
		                            <input type="text" name="partner_diet" id="partner_diet" class="form-control" value="{{ $user->partner_diet }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_body_type" class="form-label">Body Type</label>
		                            <input type="text" name="partner_body_type" id="partner_body_type" class="form-control" value="{{ $user->partner_body_type }}">
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_personal_value" class="form-label">Personal Value</label>
		                            <input type="text" name="partner_personal_value" id="partner_personal_value" class="form-control" value="{{ $user->partner_personal_value }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_manglik" class="form-label">MANGLIK</label>
		                            <select name="partner_manglik" class="form-control" id="partner_manglik">
		                            	<option value="">-- Choose One --</option>
		                            	<option value="1" {{$user->partner_manglik == 1  ? 'selected' : ''}}>Yes</option>
						                <option value="2" {{$user->partner_manglik == 2  ? 'selected' : ''}} >No</option>
						                <option value="3" {{$user->partner_manglik == 3  ? 'selected' : ''}} >I don't know</option>
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_desablity" class="form-label">Any Desablity</label>
		                            <input type="text" name="partner_desablity" id="partner_desablity" class="form-control" value="{{ $user->partner_desablity }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_mother_language_id" class="form-label">Mother Tongue</label>
		                            <select name="partner_mother_language_id" class="form-control" id="partner_mother_language_id">
		                            	<option value="">-- Choose One --</option>
		                            	@foreach ($languages as $language)
						                    <option value="{{$language->id}}"
						                      {{$language->id == $user->partner_mother_language_id  ? 'selected' : ''}}>
						                      {{$language->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_prefered_status" class="form-label">Prefered Status</label>
		                            <input type="text" name="partner_prefered_status" id="partner_prefered_status" class="form-control" value="{{ $user->partner_prefered_status }}">
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_family_value_id" class="form-label">Family Value</label>
		                            <select name="partner_family_value_id" class="form-control" id="partner_family_value_id">
		                            	<option value="">-- Choose One --</option>
		                            	@foreach ($familyValues as $f_val)
						                    <option value="{{$f_val->id}}"
						                      {{$f_val->id == $user->partner_family_value_id  ? 'selected' : ''}}>
						                      {{$f_val->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                        </div>
	                        <div class="row form-group">
	                            <div class="col-md-6">
	                                <label for="partner_prefered_country_id" class="form-label" >Prefered Country</label>
		                            <select name="partner_prefered_country_id" class="form-control" id="partner_prefered_country_id">
		                            	<option value="">-- Choose One --</option>
		                            	@foreach ($countries as $re_country)
						                    <option value="{{$re_country->id}}" {{$re_country->id == $user->partner_prefered_country_id  ? 'selected' : ''}}>
						                      {{$re_country->name}}</option>
						                @endforeach
		                            </select>
	                            </div>
	                            <div class="col-md-6">
	                                <label for="partner_prefered_state_id" class="form-label">Prefered State</label>
		                            <select name="partner_prefered_state_id" class="form-control" id="partner_prefered_state_id">
		                            	<option value="">-- Choose One --</option>
		                            	@foreach($states as $state)
					                  	<option value="{{$state->id}}" {{$state->id == $user->partner_prefered_state_id  ? 'selected' : ''}}>{{$state->name}}</option>
					                  @endforeach
		                            </select>
	                            </div>
	                        </div>

	                        <div class="field-btn">
	                            <button type="button" class="submit_for_save btn-custom-primary">Save</button>
	                            @if($user->is_approved != 1 && $user->status != 4 )
	                            	
	                            	<button type="button" class="submit_for_approval_popup btn-custom-secondary" onclick="submitApprovalFormPopup()">Submit for approval</button>
	                            @endif
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
		        	<button type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
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
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
	
	
    <script>
    	var user_profile = '{{ $user->profile_image }}';
        $(function(){
        	
        	var _photo = 0;
        	
        	var states = {!! json_encode($states_ar, JSON_HEX_TAG) !!};
		  	var cities = {!! json_encode($cities_ar, JSON_HEX_TAG) !!};

		  	states = JSON.parse(states);
		  	cities = JSON.parse(cities);
		  	/*var now = new Date();
		    var day = ("0" + now.getDate()).slice(-2);
		    var month = ("0" + (now.getMonth() + 1)).slice(-2);
		    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;*/
		    //$('.datepicker ').val(today);
		    $('.datepicker').datepicker({
		        todayHighlight: true,
		        dateFormat: 'yy-mm-dd'
		    });
		    /*$('.submit_for_approval').on('click',function(){

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
	                    var action = "{{ url('/user/profile-submit-for-approval') }}"
	                    $('#user-form').attr('action', action);
	                    $('#user-form').submit();
	                }
	            });
		    });*/

		    $('.submit_for_save').on('click', function(){
		    	var action = "{{ route('user.profile-update') }}"
	            $('#user-form').attr('action', action);
	            $('#user-form').submit();
		    });

            $('#user-form').validate();

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

		    // upload profile pic
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
		            	console.log(response);
		                $('.crop_image').show();
		                $('.uploading_spinner').hide();
		                $('#uploadimageModal').modal('hide');
		                $('.user-avatar').attr("src", response.file_url);
		                $('.avatar-img').attr("src", response.file_url);
		                user_profile = response.file_url;
		                //location.reload(true);
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
                        //return;
                        window.location.reload(true);            
                    })
                    .fail(function($xhr) {
                        var response = $xhr.responseJSON;
                        $('.uploading_spinner').hide();
                        $('.crop_image').show();
                       // Swal.fire(response.msg);
                    });
            }

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
            const cpassword = document.querySelector('#c_password');

            togglecpassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const ctype = cpassword.getAttribute('type') === 'password' ? 'text' : 'password';
                cpassword.setAttribute('type', ctype);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
        });

		function submitApprovalForm() {
			var action = "{{ url('/user/profile-submit-for-approval') }}"
            $('#user-form').attr('action', action);
            $('#user-form').submit();
		}

		function submitApprovalFormPopup() {
			var first_name = $('#first_name').val();
			var last_name = $('#last_name').val();
			var email = $('#email').val();
			var mobile = $('#mobile').val();
			/*var password = $('#password').val();
			var c_password = $('#c_password').val();*/
			var on_behalf_id = $('#on_behalf_id').val();
			var dob = $('#dob').val();
			var religion_id = $('#religion_id').val();
			var caste_id = $('#caste_id').val();
			var height = $('#height').val();
			var marital_status_id = $('#marital_status_id').val();
			var education_id = $('#education_id').val();
			var occupation_id = $('#occupation_id').val();
			var country_id = $('#country_id').val();
			var state_id = $('#state_id').val();
			var city_id = $('#city_id').val();
			var about = $('#about').val();

			//user_profile = '{{ $user->profile_image }}';
			console.log(user_profile);
			if (first_name && last_name && email && mobile  && on_behalf_id && dob && religion_id && caste_id && height && marital_status_id && education_id && occupation_id && country_id && state_id && city_id && about && user_profile) {

				//$('#submit_for_approval').modal('show');
				Swal.fire({
	              title: 'Are you sure?',
	              text: "Are you sure you want to submit your profile for admin approval?",
	              icon: 'info',
	              showCancelButton: true,
	              confirmButtonColor: '#21c2d6',
	              cancelButtonColor: '#e7147b',
	              confirmButtonText: '<a href="javascript:void(0);" onclick="submitApprovalForm()">Proceed</a>'
	            });

			} else {
				if (user_profile == '') {
					Swal.fire({
		                title: 'Profile Picture is required',
		                text: "Please upload profile picture first, thank you!",
		                icon: 'warning',
		                confirmButtonColor: '#21c2d6',
		                confirmButtonText: 'Ok'
		            });
				}else{
					/*Swal.fire({
		                title: 'Oops',
		                text: "Something went wrong !",
		                icon: 'warning',
		                confirmButtonColor: '#21c2d6',
		                confirmButtonText: 'Ok'
		            });*/
		            submitApprovalForm();
				}
				
				//submitApprovalForm();
			}
		}
    </script>
@endsection
