@extends('app')
@section('title', 'Buy Plan')
@section('style')
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">


@endsection
@section('content')
    <!-- Events Banner -->
    <section class="event_section" style="background-image: url('{{ asset("assets/images/event_bg.png")  }}');">
        <div class="events_overlay">
            <div class="container">
                <div class="events_content">
                    <h2>Buy {{ $plan->name }}</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="user-profile-section prersonal-prof" >
        <div class="container" style="margin-top:70px">
            <div class="row">
                <div class="col-md-8" >
                    <div class="profile-main-body">
                    	<div id="user_section">
                            @include('../../../admin.message')
	                    </div>
	                    <div id="payment_section">
	                    	<h4>Payments</h4>
                            @if (empty($user->stripe_customer) && empty($user->stripe_payment_method))

                                <div class="alert alert-warning apply-event" role="alert">
                                  <h5>Payment Details</h5>
                                  <p>You have not added your payment details, Please add details first to proceed event registration.</p>
                                    <div class="field-btn">
                                        <a href="{{ route('user.settings') }}" target="_blank" class="btn-submit" id="btn_payment">Add Payment</a>
                                    </div>
                                </div>     
                            @else
                                <div class="alert alert-info apply-event" role="alert">
                                  <h5>Payment Details</h5>
                                  <p>Only one online payment method may be stored at a time</p>
                                  <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                  <th scope="col">No</th>
                                                  <th scope="col">Name On Card</th>
                                                  <th scope="col">Expires on</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                  <th>{{ $brand }} &nbsp *****{{$last4}}</th>
                                                  <td>{{$name}}</td>
                                                  <td>{{$exp_month.'/'.$exp_year }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            <div class="alert alert-danger" role="alert" id="er_msg_outer" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span id="er_msg"></span>
                            </div>
	                    	<form method="post" action="" id="payment-form">
                        		@csrf
								
	                        	<input type="hidden" name="stripeToken" id="stripeToken" value=""/>

	                        	<input type="hidden" name="userData" id="userData" value=""/>
	                        	<input type="hidden" name="plan_id" id="id" value="{{ $plan->id }}">
	                        	<div class="field-btn">
							  		<button type="submit" class="btn-submit btn-custom-primary" style="display: inline-block !important;">Pay Now</button>
							  	</div>
							</form>
	                    </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="basic-info with_line profile-main-body">
                        <div class="basic-row flex">
                            <h4>Plan Detail:</h4>
                        </div>
                        <div class="basic-info-row">
                            <span>Plan Name</span>
                            <h6>{{ $plan->name }}</h4>
                        </div>
                        <div class="basic-info-row">
                            <span>Instant Messages</span>
                            <h6>{{ $plan->instant_messages_count }}</h6>
                        </div><div class="basic-info-row">
                            <span>Duration Days</span>
                            <h6><span id="family_seats">{{ $plan->period }}</span></h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Price</span>
                            <h6>{{ $plan->price }} USD</h6>
                        </div>
                        <hr>
                        <div class="basic-info-row">
                            <span>Total Charges</span>
                            <h6><span id="total_charges"><span id="remove_total">{{ $plan->price }} USD</span> </span></h6>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </section>
    
   
    <!-- <section class="upcoming-event-section">
        <div class="container">
            <div class="section-head">
                <h2>Upcoming Events</h2>
                <p>Please select what events you would like to participate in</p>
            </div>
            <div class="events-content">
                <ul>
                    <li>
                        <div class="single_eventss">
                            <a href="#">
                                <div class="single_event_image" style="background-image: url('{{asset('assets/images/upcoming1.png') }}');"></div>
                            </a>
                            <div class="single_event_info">
                                <h4>Pakistani Matrimonial Event in Lahore, Pk</h4>
                                <p>This Event is Over! (August 04, 2019)</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="single_eventss">
                            <a href="#">
                                <div class="single_event_image" style="background-image: url('{{asset('assets/images/upcoming2.png') }}');"></div>
                            </a>
                            <div class="single_event_info">
                                <h4>Pakistani Matrimonial Event in Lahore, Pk</h4>
                                <p>This Event is Over! (August 04, 2019)</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="single_eventss">
                            <a href="#">
                                <div class="single_event_image" style="background-image: url('{{asset('assets/images/upcoming3.png') }}');"></div>
                            </a>
                            <div class="single_event_info">
                                <h4>Pakistani Matrimonial Event in Lahore, Pk</h4>
                                <p>This Event is Over! (August 04, 2019)</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="single_eventss">
                            <a href="#">
                                <div class="single_event_image" style="background-image: url('{{asset('assets/images/upcoming4.png') }}');"></div>
                            </a>
                            <div class="single_event_info">
                                <h4>Pakistani Matrimonial Event in Lahore, Pk</h4>
                                <p>This Event is Over! (August 04, 2019)</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section> -->
    
@endsection

@section('js')
	<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
    <script>
        var event_charges = '';
        var adults_charges = '';
        var membersAr = [];
        
        
       
    </script>
    <script>
		var redirect_url = "{{$redirect_url}}";
        // Handle form submission
        var form = document.getElementById('payment-form');
    
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showOverlayLoader();
            
            //form.submit();
            var id = $('#id').val();
            if (id != '') {
                
                $.ajax({
                    // url: "/user/plans/buy-plan",
                    url: '{{ url("user/plans/buy-plan?redirect_url=") }}'+redirect_url,
                    headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }, 
                    type:"post",
                    data:{'plan_id':id },
                    cache:false,
                    
                    success:function(data){
                        hideOverlayLoader();
                        
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            window.location = data.url;
                        }else{
                            $('#er_msg').text(data.message);
                            $('#er_msg_outer').show();
                        }
                    }
                });
            }

        });
	</script>
@endsection