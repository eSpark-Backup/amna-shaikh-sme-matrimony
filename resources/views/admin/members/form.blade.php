@extends('admin.layouts.app')
@section('title', 'Members')
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/members')}}" class="">@yield('title')</a></li>
                  <li class="breadcrumb-item active">{{$action}}</li>
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
            <h5 class="mb-1">{{$action}} Member</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/members')}}"
              enctype="multipart/form-data" method="POST">
              @csrf
                <input type="hidden" name="action" value="{{$action}}" />
                <input name="id" type="hidden" value="{{ $member->id }}" />
                <div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Introdunction
					</div>
					<div class="card-body">
					    <textarea name="about" class="form-control no-resize" rows="6">{{ ($action == 'Add') ? old('about') : $member->about}}</textarea>
					</div>
				</div>
				<!-- Basic Info -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Basic Information
					</div>
					<div class="card-body">
						<div class="row">
						    <div class="col-md-6">
				                <label for="name" class="form-label">First Name*</label>
				                <input type="text" name="first_name" class="form-control required" id="name" value="{{ ($action == 'Add') ? old('first_name') : $member->first_name}}">
				            </div>
			              <div class="col-md-6">
			                <label for="l_name" class="form-label">Last Name*</label>
			                <input type="text" name="last_name" class="form-control required" id="l_name"   value="{{ ($action == 'Add') ? old('last_name') : $member->last_name}}">
			              </div>
			            </div>
			            <div class="row">
			              <div class="col-md-6">
			                <label for="email" class="form-label">Email*</label>
			                <input type="email" name="email" class="form-control " id="email"   value="{{ ($action == 'Add') ? old('email') : $member->email}}">
			              </div>
			              <div class="col-md-6">
			                <label for="mobile" class="form-label">Mobile*</label>
			                <input type="tel" name="mobile" class="form-control " id="mobile"  value="{{ ($action == 'Add') ? old('mobile') : $member->mobile}}">
			              </div>
			            </div>
			            @if( empty($member->social_id))
				          	<div class="row">
				              <div class="col-md-6">
				                <label for="password" class="form-label">Password*</label>
				                <input type="password" name="password" class="form-control " id="password"  value="{{ ($action == 'Add') ? old('password') : $member->original_password}}" minlength="8" maxlength="30">
				              </div>
				              <div class="col-md-6">
				                <label for="c_password" class="form-label">Confirm Password*</label>
				                <input type="password" name="original_password"  class="form-control " id="c_password"  value="{{ ($action == 'Add') ? old('original_password') : $member->original_password}}" minlength="8" maxlength="30">
				              </div>
				            </div>
				          @endif
			            <!-- <div class="col-md-12">
			                <label for="plan" class="form-label">Plan</label>
			                <select id="plan" name="plan_id" class="form-select">
			                  <option value=""> -- Choose Plan -- </option>
				                foreach ($plans as $plan)
				                    <option value="plan->id}}"
				                      plan->id == $member->plan_id  ? 'selected' : ''>
				                      plan->name</option>
				                endforeach
			                </select>
			            </div> -->
			            <div class="row">
			              <div class="col-md-4">
			                <label for="gender" class="form-label">Gender*</label>
			                <select id="gender" name="gender" class="form-select ">
			                  <option value=""> -- Choose Gender -- </option>
			                  <option value="0" {{ $member->gender == 0  ? 'selected' : ''}}>Male</option>
			                  <option value="1" {{$member->gender == 1  ? 'selected' : ''}} >Female</option>
			                </select>
			              </div>
			              <div class="col-md-4">
			                <label for="on_behalf" class="form-label">On Behalf*</label>
			                <select id="on_behalf" name="on_behalf_id" class="form-select ">
			                	<option value=""> -- Choose Onbehalf -- </option>
				                @foreach ($onbehalf as $behalf)
				                    <option value="{{$behalf->id}}"
				                      {{$behalf->id == $member->on_behalf_id  ? 'selected' : ''}}>
				                      {{$behalf->name}}</option>
				                @endforeach
			                </select>
			              </div>
			              <div class="col-md-4">
			                <label for="dob" class="form-label">Date Of Birth*</label>
			                <input type="text" class="form-control datepicker hasDatepicker " name="date_of_birth" id="dob" data-date-format="yyyy-mm-dd">
			              </div>
			            </div>
			            <div class="row">
			              <div class="col-md-4">
			                  <label for="image" class="form-label">Upload Image</label>
			                  <input type="file" name="profile_image" class="form-control"
			                    onchange="readURL(this,'image',['jpeg','jpg','png','svg+xml'],'image-error','image')">
			                  <span id="image-error" style="display:none;color:#f36363;"></span>
			                  <br>
			                  <span class="label label-info">Note:</span> Recommended image resolution is 40x40 pixels.
			                  <br><br>
			                  <div style="width: 100px; height: auto">
			                      <img src="{{checkImage(asset('storage/members/profile-image/' . $member->profile_image),'avatar.png',$member->profile_image,1)}}" class="img-responsive" alt="Avatar" id="profile_image">
			                  </div>
			              </div>
			              <div class="col-md-4">
			                <label for="is_approved" class="form-label">Approval Status</label>
			                <select id="is_approved" name="is_approved" class="form-select">
			                  <option value="0" {{$member->is_approved == 0  ? 'selected' : ''}}>Pending</option>
			                  <option value="1" {{$member->is_approved == 1  ? 'selected' : ''}}>Approved</option>
			                  <!-- <option value="2" {{$member->is_approved == 2  ? 'selected' : ''}}>Block</option> -->
			                  <option value="3" {{$member->is_approved == 3  ? 'selected' : ''}}>Rejected</option>
			                </select>
			              </div>

			              <div class="col-md-4">
			                <label for="status" class="form-label">Status</label>
			                <select id="status" name="status" class="form-select">
			                  <option value="1" {{$member->status == 1  ? 'selected' : ''}}>Active</option>
			                  <option value="0" {{$member->status == 0  ? 'selected' : ''}}>Block</option>
			                  <option value="4" {{$member->status == 4  ? 'selected' : ''}}>Submitted For Approval</option>
			                  <option value="5" {{$member->status == 5  ? 'selected' : ''}}>Closed</option>
			                </select>
			              </div>
			            </div>
					</div>
				</div>
				<!-- Present Address -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Present Address
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="country_id" class="form-label">Country*</label>
				                <select id="country_id" name="country_id" class="form-select " data-countryid="{{$member->country_id}}">
				                  <option value=""> -- Choose Country -- </option>
				                  @foreach($countries as $country)
				                  <option value="{{$country->id}}" {{$country->id == $member->country_id  ? 'selected' : ''}}>{{$country->name}}</option>
				                  @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="state_id" class="form-label">State*</label>
				                <select id="state_id" name="state_id" class="form-select " data-stateid="{{$member->state_id}}">
				                  <option value="" selected=""> -- Choose State -- </option>
				                  
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="city_id" class="form-label">City</label>
				                <select id="city_id" name="city_id" class="form-select"  data-cityid="{{$member->city_id}}">
				                  <option value=""> -- Choose City -- </option>
				                  
				                </select>
				                
				            </div>
				            <div class="col-md-6">
				                <label for="postal_code" class="form-label">Postal Code</label>
				                <input type="text" class="form-control" name="postal_code" value="{{ ($action == 'Add') ? old('postal_code') : $member->postal_code}}"> 
				            </div>
			            </div>
					</div>
				</div>
				<!-- Education -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Education & Career
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="gender" class="form-label">Highest Education*</label>
				                <select id="education_id" name="education_id" class="form-select ">
				                  <option value=""> -- Choose Education -- </option>
				                   @foreach($educations as $education)
				                  	<option value="{{$education->id}}" {{$education->id == $member->education_id  ? 'selected' : ''}}>{{$education->name}}</option>
				                  @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="occupation_id" class="form-label">Occupation*</label>
				                <select id="occupation_id" name="occupation_id" class="form-select ">
				                  <option value=""> -- Choose Occupation -- </option>
				                   @foreach($occupations as $occupation)
				                  	<option value="{{$occupation->id}}" {{$occupation->id == $member->occupation_id  ? 'selected' : ''}}>{{$occupation->name}}</option>
				                  	@endforeach
				                </select>
				            </div>
			            </div>
			            <div class="col-md-12">
			                <label for="annual_income" class="form-label">Annual Income</label>
			                <input type="text" class="form-control" name="annual_income"  value="{{ ($action == 'Add') ? old('annual_income') : $member->annual_income}}">
			            </div>
					</div>
				</div>
				<!-- Physical Attributes -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Physical Attributes
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="Height" class="form-label">Height</label>
				                <input type="text" class="form-control" name="height" value="{{ ($action == 'Add') ? old('height') : $member->height}}">
				            </div>
				            <div class="col-md-6">
				                <label for="weight" class="form-label">Weight</label>
				                <input type="number" class="form-control" name="weight" min="0" value="{{ ($action == 'Add') ? old('weight') : $member->weight}}">
				            </div>
			            </div>
			           	<div class="row">
				            <div class="col-md-6">
				                <label for="eye_color" class="form-label">Eye Color</label>
				                <input type="text" class="form-control" name="eye_color" value="{{ ($action == 'Add') ? old('eye_color') : $member->eye_color}}">
				            </div>
				            <div class="col-md-6">
				                <label for="hair_color" class="form-label">Hair Color</label>
				                <input type="text" class="form-control" name="hair_color" value="{{ ($action == 'Add') ? old('hair_color') : $member->hair_color}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="complexion" class="form-label">Complexion</label>
				                <input type="text" class="form-control" name="complexion" value="{{ ($action == 'Add') ? old('complexion') : $member->complexion}}">
				            </div>
				            <div class="col-md-6">
				                <label for="blood_group" class="form-label">Blood Group</label>
				                <input type="text" class="form-control" name="blood_group" value="{{ ($action == 'Add') ? old('blood_group') : $member->blood_group}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="body_type" class="form-label">Body Type</label>
				                <input type="text" class="form-control" name="body_type" value="{{ ($action == 'Add') ? old('body_type') : $member->body_type}}">
				            </div>
				            <div class="col-md-6">
				                <label for="body_art" class="form-label">Body Art</label>
				                <input type="text" class="form-control" name="body_art" value="{{ ($action == 'Add') ? old('body_art') : $member->body_art}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="any_desability" class="form-label">Any Disability</label>
				                <input type="text" class="form-control" name="any_desability" value="{{ ($action == 'Add') ? old('any_desability') : $member->any_desability}}">
				            </div>
				            
			            </div>
					</div>
				</div>
				<!-- Language -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					   Language
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="mother_language_id" class="form-label">Mother Tongue</label>
				                <select id="mother_language_id" name="mother_language_id" class="form-select">
				                  <option value=""> -- Choose Below One -- </option>
				                 @foreach ($languages as $language)
				                    <option value="{{$language->id}}"
				                      {{$language->id == $member->mother_language_id  ? 'selected' : ''}}>
				                      {{$language->name}}</option>
				                  @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="on_behalf" class="form-label">Language</label>
				                <select id="language_id" name="language_id" class="form-select">
				                  <option value=""> -- Choose Below One -- </option>
					                @foreach ($languages as $lang)
					                    <option value="{{$lang->id}}"
					                      {{$lang->id == $member->language_id  ? 'selected' : ''}}>
					                      {{$lang->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			           	<div class="row">
				            <div class="col-md-6">
				                <label for="gender" class="form-label">Speek</label>
				                <select id="speek_language_id" name="speek_language_id" class="form-select">
				                  <option value=""> -- Choose Below One -- </option>
				                 @foreach ($languages as $speek_lang)
				                    <option value="{{$speek_lang->id}}"
				                      {{$speek_lang->id == $member->speek_language_id  ? 'selected' : ''}}>
				                      {{$speek_lang->name}}</option>
				                  @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="" class="form-label">Read</label>
				                <select id="read_language_id" name="read_language_id" class="form-select">
				                  <option value=""> -- Choose Below One -- </option>
					                @foreach ($languages as $read_lang)
					                    <option value="{{$read_lang->id}}"
					                      {{$read_lang->id == $member->read_language_id  ? 'selected' : ''}}>
					                      {{$read_lang->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
					</div>
				</div>
				<!-- Residency Information -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					  Residency Information
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="birthday_country_id" class="form-label">Birth Country</label>
				                <select id="birthday_country_id" name="birthday_country_id" class="form-select">
				                  <option value=""> -- Choose Country -- </option>
				                    @foreach ($countries as $country)
					                    <option value="{{$country->id}}"
					                      {{$country->id == $member->birthday_country_id  ? 'selected' : ''}}>
					                      {{$country->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="on_behalf" class="form-label">Residency Country</label>
				                <select id="residency_country_id" name="residency_country_id" class="form-select">
				                    <option value=""> -- Choose Country -- </option>
				                    @foreach ($countries as $r_country)
					                    <option value="{{$r_country->id}}"
					                      {{$r_country->id == $member->residency_country_id  ? 'selected' : ''}}>
					                      {{$r_country->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="citizenship_country_id" class="form-label">Citizenship Country</label>
				                <select id="citizenship_country_id" name="citizenship_country_id" class="form-select">
				                    <option value=""> -- Choose Country -- </option>
				                    @foreach ($countries as $r_country)
					                    <option value="{{$r_country->id}}"
					                      {{$r_country->id == $member->citizenship_country_id  ? 'selected' : ''}}>
					                      {{$r_country->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="growup_country_id" class="form-label">Grow up Country</label>
				                <select id="growup_country_id" name="growup_country_id" class="form-select">
				                    <option value=""> -- Choose Country -- </option>
				                    @foreach ($countries as $r_country)
					                    <option value="{{$r_country->id}}"
					                      {{$r_country->id == $member->growup_country_id  ? 'selected' : ''}}>
					                      {{$r_country->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="col-md-6">
				                <label for="gender" class="form-label">Immigration Status</label>
				                <input type="text" class="form-control" name="immigration_status" value="{{ ($action == 'Add') ? old('immigration_status') : $member->immigration_status}}">
				            </div>
					</div>
				</div>
				<!-- Spiritual & Social Background -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					  Spiritual & Social Background
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="gender" class="form-label">Religion*</label>
				                <select id="religion_id" name="religion_id" class="form-select ">
				                    <option value=""> -- Choose Religion -- </option>
				                    @foreach ($religions as $religion)
					                    <option value="{{$religion->id}}"
					                      {{$religion->id == $member->religion_id  ? 'selected' : ''}}>
					                      {{$religion->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="caste_id" class="form-label">Caste*</label>
				                <select id="caste_id" name="caste_id" class="form-select ">
				                    <option value=""> -- Choose Caste -- </option>
				                    @foreach ($castes as $caste)
					                    <option value="{{$caste->id}}"
					                      {{$caste->id == $member->caste_id  ? 'selected' : ''}}>
					                      {{$caste->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="ethniciy" class="form-label">Ethniciy</label>
				                <input type="text" class="form-control" name="ethniciy" value="{{ ($action == 'Add') ? old('ethniciy') : $member->ethniciy}}">
				            </div>
				            <div class="col-md-6">
				                <label for="personal_value" class="form-label">Personal Value</label>
				                <input type="text" class="form-control" name="personal_value" value="{{ ($action == 'Add') ? old('personal_value') : $member->personal_value}}">
				                
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="family_value_id" class="form-label">Family Value</label>
				                <select id="family_value_id" name="family_value_id" class="form-select">
				                    <option value=""> -- Choose Family Value -- </option>
				                    @foreach ($familyValues as $f_val)
					                    <option value="{{$f_val->id}}"
					                      {{$f_val->id == $member->family_value_id  ? 'selected' : ''}}>
					                      {{$f_val->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="community_value" class="form-label">Community Value</label>
				                <input type="text" class="form-control" name="community_value" value="{{ ($action == 'Add') ? old('community_value') : $member->community_value}}">
				                
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="gender" class="form-label">Family Status</label>
				                <select id="family_status_id" name="family_status_id" class="form-select">
				                    <option value=""> -- Choose Family Status -- </option>
				                    @foreach ($familyStatus as $f_status)
					                    <option value="{{$f_status->id}}"
					                      {{$f_status->id == $member->family_status_id  ? 'selected' : ''}}>
					                      {{$f_status->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="manglik" class="form-label">Manglik</label>
				                <select id="manglik" name="manglik" class="form-select">
				                  <option value=""> -- Choose Manglik -- </option>
				                  <option value="1" {{$member->manglik == 1  ? 'selected' : ''}}>No</option>
				                  <option value="2" {{$member->manglik == 2  ? 'selected' : ''}} >Yes</option>
				                  <option value="3" {{$member->manglik == 3  ? 'selected' : ''}} >I don't know</option>
				                </select>
				                
				            </div>
			            </div>
					</div>
				</div>
				<!-- Family Information -->
	            <div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Family Information
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="father_name" class="form-label">Father</label>
				                <input type="text" class="form-control" name="father_name" value="{{ ($action == 'Add') ? old('father_name') : $member->father_name}}">
				            </div>
				            <div class="col-md-6">
				                <label for="mother_name" class="form-label">Mother</label>
				                <input type="text" class="form-control" name="mother_name" value="{{ ($action == 'Add') ? old('mother_name') : $member->mother_name}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="brothers_sisters" class="form-label">Brother/Sister</label>
				                <input type="text" class="form-control" name="brothers_sisters" value="{{ ($action == 'Add') ? old('brothers_sisters') : $member->brothers_sisters}}">
				            </div>
				            
			            </div>
					</div>
				</div>
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Additional Personal Details
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="home_district" class="form-label">Home District</label>
				                <input type="text" class="form-control" name="home_district" value="{{ ($action == 'Add') ? old('home_district') : $member->home_district}}">
				            </div>
				            <div class="col-md-6">
				                <label for="family_residence" class="form-label">Family Residence</label>
				                <input type="text" class="form-control" name="family_residence" value="{{ ($action == 'Add') ? old('family_residence') : $member->family_residence}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="father_occupation_id" class="form-label">Father Occupation</label>
				                <select id="father_occupation_id" name="father_occupation_id" class="form-select">
				                    <option value=""> -- Choose Occupation -- </option>
				                    @foreach ($occupations as $coccupation)
					                    <option value="{{$coccupation->id}}"
					                      {{$coccupation->id == $member->father_occupation_id  ? 'selected' : ''}}>
					                      {{$coccupation->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="special_circumstances" class="form-label">Special Circumstances</label>
				                <input type="text" class="form-control" name="special_circumstances" value="{{ ($action == 'Add') ? old('special_circumstances') : $member->special_circumstances}}">
				            </div>
			            </div>
					</div>
				</div>
				<!-- Partner Expection -->
				<div class="card padding-unset">
					<div class="card-header custom-card-header">
					    Partner Expectation
					</div>
					<div class="card-body">
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_general_requirement" class="form-label">General Requirement</label>
				                <input type="text" class="form-control" name="partner_general_requirement" value="{{ ($action == 'Add') ? old('partner_general_requirement') : $member->partner_general_requirement}}">
				            </div>
				            <div class="col-md-6">
				                <label for="partner_age" class="form-label">Age</label>
				                <select class="form-control" name="partner_age">
				                	<option value="0">Select Age</option>
				                	@for($i=1; $i<=100; $i++)
										<option value="{{$i}}" {{$member->partner_age == $i  ? 'selected' : ''}}>{{$i}}</option>
				                		
				                	@endfor
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_height" class="form-label">Height</label>
				                <input type="text" class="form-control" name="partner_height" value="{{ ($action == 'Add') ? old('partner_height') : $member->partner_height}}">
				            </div>
				            <div class="col-md-6">
				                <label for="partner_weight" class="form-label">Weight</label>
				                <input type="text" class="form-control" name="partner_weight" value="{{ ($action == 'Add') ? old('partner_weight') : $member->partner_weight}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_marital_status_id" class="form-label">Marital Status</label>
				                <select id="partner_marital_status_id" name="partner_marital_status_id" class="form-select">
				                    <option value=""> -- Choose Marital Status -- </option>
				                    @foreach ($maritalStatus as $m_status)
					                    <option value="{{$m_status->id}}"
					                      {{$m_status->id == $member->partner_marital_status_id  ? 'selected' : ''}}>
					                      {{$m_status->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="partner_with_children_acceptable" class="form-label">With Children Acceptables </label>
				                <select id="partner_with_children_acceptable" name="partner_with_children_acceptable" class="form-select">

				                	<option value="1" {{$member->partner_with_children_acceptable == 1  ? 'selected' : ''}}>Yes</option>
				                  	<option value="2" {{$member->partner_with_children_acceptable == 2  ? 'selected' : ''}} >No</option>
				                  	<option value="3" {{$member->partner_with_children_acceptable == 3  ? 'selected' : ''}} >Doesn't matter</option>
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_country_residence_id" class="form-label">Country of residence</label>
				                <select class="form-control" name="partner_country_residence_id">
				                	<option value="0">Select Below One</option>
				                	@foreach ($countries as $re_country)
					                    <option value="{{$re_country->id}}"
					                      {{$re_country->id == $member->partner_country_residence_id  ? 'selected' : ''}}>
					                      {{$re_country->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="partner_religion_id" class="form-label">Religion</label>
				                <select class="form-control" name="partner_religion_id">
				                	<option value="">Select Below One</option>
				                	@foreach ($religions as $religion)
					                    <option value="{{$religion->id}}"
					                      {{$religion->id == $member->partner_religion_id  ? 'selected' : ''}}>
					                      {{$religion->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_education_id" class="form-label">Education</label>
				                <select class="form-control" name="partner_education_id">
				                	<option value="">Select Below One</option>
				                	@foreach ($educations as $education)
					                    <option value="{{$education->id}}"
					                      {{$education->id == $member->partner_education_id  ? 'selected' : ''}}>
					                      {{$education->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="partner_caste_id" class="form-label">Caste</label>
				                <select class="form-control" name="partner_caste_id">
				                	<option value="">Select Below One</option>
				                	@foreach ($castes as $p_caste)
					                    <option value="{{$p_caste->id}}"
					                      {{$p_caste->id == $member->partner_caste_id  ? 'selected' : ''}}>
					                      {{$p_caste->name}}</option>
					                @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_profession" class="form-label">Profession</label>
				                <input type="text" class="form-control" name="partner_profession" value="{{ ($action == 'Add') ? old('partner_profession') : $member->partner_profession}}">
				            </div>
				             <div class="col-md-6">
				                <label for="partner_complexion" class="form-label">Complexion</label>
				                <input type="text" name="partner_complexion" class="form-control" value="{{ ($action == 'Add') ? old('partner_complexion') : $member->partner_complexion}}">
				            </div>
				            
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_drinking_habits" class="form-label">Drinking Habits</label>
				                <select class="form-control" name="partner_drinking_habits">
				                	<option value="">Select Below One</option>
				                	<option value="1" {{$member->partner_drinking_habits == 1  ? 'selected' : ''}}>Yes</option>
				                	<option value="0" {{$member->partner_drinking_habits == 0  ? 'selected' : ''}}>No</option>
				                	<option value="3" {{$member->partner_drinking_habits == 3  ? 'selected' : ''}}>Doest'n Matter</option>
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="partner_smoking_habits" class="form-label">Smoking Habits</label>
				                <select class="form-control" name="partner_smoking_habits">
				                	<option value="">Select Below One</option>
				                	<option value="1" {{$member->partner_smoking_habits == 1  ? 'selected' : ''}}>Yes</option>
				                	<option value="0" {{$member->partner_smoking_habits == 0  ? 'selected' : ''}}>No</option>
				                	<option value="3" {{$member->partner_smoking_habits == 3  ? 'selected' : ''}}>Doest'n Matter</option>
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_diet" class="form-label">Diet</label>
				                <input type="text" class="form-control" name="partner_diet" value="{{ ($action == 'Add') ? old('partner_diet') : $member->partner_diet}}">
				            </div>
				            <div class="col-md-6">
				                <label for="partner_body_type" class="form-label">Body Type</label>
				                <input type="text" class="form-control" name="partner_body_type" value="{{ ($action == 'Add') ? old('partner_body_type') : $member->partner_body_type}}">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="height" class="form-label">Personal Value</label>
				                <input type="text" class="form-control" name="partner_personal_value" value="{{ ($action == 'Add') ? old('partner_personal_value') : $member->partner_personal_value}}">
				            </div>
				            <div class="col-md-6">
				                <label for="partner_manglik" class="form-label">MANGLIK</label>
				                 <select id="partner_manglik" name="partner_manglik" class="form-select">
				                  <option value=""> -- Choose Manglik -- </option>
				                  <option value="1" {{$member->partner_manglik == 1  ? 'selected' : ''}}>Yes</option>
				                  <option value="2" {{$member->partner_manglik == 2  ? 'selected' : ''}} >No</option>
				                  <option value="3" {{$member->partner_manglik == 3  ? 'selected' : ''}} >I don't know</option>
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_desablity" class="form-label">Any Desablity</label>
				                <input type="text" class="form-control" name="partner_desablity" value="{{ ($action == 'Add') ? old('partner_desablity') : $member->partner_desablity}}">
				            </div>
				            <div class="col-md-6">
				                <label for="partner_mother_language_id" class="form-label">Mother Tongue</label>
				               <select id="partner_mother_language_id" name="partner_mother_language_id" class="form-select">
				                  <option value=""> -- Choose Below One -- </option>
				                 @foreach ($languages as $language)
				                    <option value="{{$language->id}}"
				                      {{$language->id == $member->partner_mother_language_id  ? 'selected' : ''}}>
				                      {{$language->name}}</option>
				                  @endforeach
				                </select>
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_family_value_id" class="form-label">Family Value</label>
				               <select id="partner_family_value_id" name="partner_family_value_id" class="form-select">
				                    <option value=""> -- Choose Family Value -- </option>
				                    @foreach ($familyValues as $f_val)
					                    <option value="{{$f_val->id}}"
					                      {{$f_val->id == $member->partner_family_value_id  ? 'selected' : ''}}>
					                      {{$f_val->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="height" class="form-label">Prefered Status</label>
				                <input type="text" class="form-control" name="partner_prefered_status" value="{{ ($action == 'Add') ? old('partner_prefered_status') : $member->partner_prefered_status}}">
				            </div>
				            
			            </div>
			            <div class="row">
				            <div class="col-md-6">
				                <label for="partner_prefered_country_id" class="form-label">Prefered Country</label>
				                <select class="form-control" name="partner_prefered_country_id">
				                	<option value="">Select Below One</option>
				                	@foreach ($countries as $re_country)
					                    <option value="{{$re_country->id}}" {{$re_country->id == $member->partner_prefered_country_id  ? 'selected' : ''}}>
					                      {{$re_country->name}}</option>
					                @endforeach
				                </select>
				            </div>
				            <div class="col-md-6">
				                <label for="partner_prefered_state_id" class="form-label">Prefered State</label>
				                <select id="partner_prefered_state_id" name="partner_prefered_state_id" class="form-select ">
				                  <option value=""> -- Choose State -- </option>
				                   @foreach($states as $state)
				                  	<option value="{{$state->id}}" {{$state->id == $member->partner_prefered_state_id  ? 'selected' : ''}}>{{$state->name}}</option>
				                  @endforeach
				                </select>
				            </div>
			            </div>    
					</div>
				</div>
              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/members')}}">
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
<script>
  $(function() {

  	var states = {!! json_encode($states_ar, JSON_HEX_TAG) !!};
  	var cities = {!! json_encode($cities_ar, JSON_HEX_TAG) !!};
  	states = JSON.parse(states);
  	cities = JSON.parse(cities);
	
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('.datepicker ').val(today);
    $('.datepicker').datepicker({
        todayHighlight: true,
        dateFormat: 'yy-mm-dd'
    });

    setTimeout(function(){

        if( $('#country_id').data('countryid') != ''){
	  		var country_id = $('#country_id').data('countryid');
	  		var str = '';
	  		$.each(states[country_id], function(index, item) {
	  			console.log(item);
			   	str += '<option value="'+item['id']+'">'+item['name']+'</option>';
			});

			$('#state_id option:not(:first)').remove();
			$('#state_id').append(str);
			var state_id = $('#state_id').data('stateid');
			if (state_id != '') {
				$('#state_id').val(state_id).trigger('change');
			}
			
			
	  	}
    }, 3000);
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
    }, 3000);

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

    $("#admins-form").validate({
        /*rules : {
                  password: {
                    required: true,
                    minlength: 5
                  },
                  original_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                  },
                }*/
    });

  });
</script>
@endsection
