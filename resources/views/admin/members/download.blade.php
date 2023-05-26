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
            <h5 class="mb-1">Profile</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')
              


                <!-- Profile Page -->
                <section class="user-profile-section">
                    <div class="empty-banner"></div>
                    <div class="container">
                        <div class="user-profile-row flex">
                            <div class="user-profile-left">
                                <div class="user-profile-image"><img src="{{url('assets/images/main_image.png')}}" alt="image"></div>
                                <a href="#" class="mesg-btn">Public View</a>
                                
                                <div class="profile-photos">
                                    <h4>Photos from Aqsa:</h4>
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <div class="profile-gal" style="background-image: url('{{url('assets/images/profile1.png')}}');"></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="profile-gal" style="background-image: url('{{url('assets/images/profile2.png')}}');"></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="profile-gal" style="background-image: url('{{url('assets/images/profile3.png')}}');"></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="profile-gal" style="background-image: url('{{url('assets/images/profile4.png')}}');"></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="profile-gal" style="background-image: url('{{url('assets/images/profile5.png')}}');"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="user-profile-center">
                                <div class="profile-top-head flex">
                                    <div class="profile-left-titles">
                                        <h2>Aqsa Aftab. <span>(Teacher)</span></h2>
                                        <span><img src="{{url('assets/images/location_white.png')}}" alt="">Multan, Pakistan</span>
                                        <span><strong>ID:</strong>#B0D773296026</span>
                                    </div>
                                </div>
                                <div class="profile-main-body">
                                    <h4>Profile Information:</h4>
                                    <p>Etiam ac odio vitae eros venenatis finibus. Nunc nec facilisis ligula. Donec non quam metus. Fusce semper velit sed purus condimentum, sed consectetur justo ornare. Morbi ut enim egestas, vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                    <p>Vitae eros venenatis finibus. Nunc nec facilisis ligula. Donec non quam metus. Fusce semper velit sed purus condimentum, sed consectetur justo ornare. Morbi ut enim egestas, vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                    <p>Eros venenatis finibus. Nunc nec facilisis ligula. Donec non quam metus. Fusce semper velit sed purus condimentum, sed consectetur justo ornare. Morbi ut enim egestas, vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                    <p>vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                    <h4>More Information:</h4>
                                    <p>Eros venenatis finibus. Nunc nec facilisis ligula. Donec non quam metus. Fusce semper velit sed purus condimentum, sed consectetur justo ornare. Morbi ut enim egestas, vestibulum turpis ac, sodales nibh. Etiam feugiat non ipsum eu accumsan. Aenean ac est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                    <p>Est volutpat, congue mi eget, pellentesque tellus. Integer convallis est non mattis ultricies. Nunc in venenatis leo, nec bibendum ante.</p>
                                </div>
                            </div>
                            <div class="user-profile-right">
                                <div class="basic-row flex">
                                    <h4>Quick Information:</h4>
                                </div>
                                <div class="quick-info-row flex">
                                    <span><img src="{{url('assets/images/birthday.png')}}" alt="icon">24 year</span>
                                    <span><img src="{{url('assets/images/diamond1.png')}}" alt="icon">Never Married</span>
                                    <span><img src="{{url('assets/images/map1.png')}}" alt="icon">Pakistani</span>
                                    <span><img src="{{url('assets/images/radio1.png')}}" alt="icon">Rajput</span>
                                    <span><img src="{{url('assets/images/bars1.png')}}" alt="icon">5.2 feet</span>
                                    <span><img src="{{url('assets/images/female.png')}}" alt="icon">Female</span>
                                </div>
                                <div class="basic-info with_line">
                                    <div class="basic-row flex">
                                        <h4>Basic Information:</h4>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Full Name</span>
                                        <h6>Hina Nadeem</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Gender</span>
                                        <h6>Female</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Age</span>
                                        <h6>24</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Marital Status</span>
                                        <h6>Never Married</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Number of Children</span>
                                        <h6>0</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Date of Birth</span>
                                        <h6>23/01/1997</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>On Behalf</span>
                                        <h6>Sister</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Area</span>
                                        <h6>-------</h6>
                                    </div>
                                </div>
                                <div class="basic-info">
                                    <div class="basic-row flex">
                                        <h4>Partner Expectation:</h4>
                                        <!-- <a href="#"><img src="assets/images/edit.png" alt="icon"></a> -->
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Full Name</span>
                                        <h6>Hina Nadeem</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Gender</span>
                                        <h6>Female</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Age</span>
                                        <h6>24</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Marital Status</span>
                                        <h6>Never Married</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Number of Children</span>
                                        <h6>0</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Date of Birth</span>
                                        <h6>23/01/1997</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>On Behalf</span>
                                        <h6>Sister</h6>
                                    </div>
                                    <div class="basic-info-row">
                                        <span>Area</span>
                                        <h6>-------</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/members')}}">
                      <button type="button" class="btn btn btn-secondary">
                        <span>Cancel</span>
                      </button>
                    </a>
                    <a href="{{url('admin/members')}}/{{ $member->id }}/download">
                      <button type="button" class="btn btn-primary  btn-fullrounded">
                        <span>Download</span>
                      </button>
                    </a>
                  </div>
              </div>
            
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
