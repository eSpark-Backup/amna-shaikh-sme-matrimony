@extends('app')
@section('title', 'Settings')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
<script src="https://js.stripe.com/v3/"></script>
@endsection
<?php
    $redirectURL = '';

    if (request()->get('redirect_url')) {
        $redirectURL = request()->get('redirect_url');
    }
?>
@section('content')
	<!-- Accounts -->
    <section class="user-profile-section prersonal-prof">
        <div class="events_overlay">
            <div class="events_content">
                <h2>Save Card</h2>
            </div>
        </div>
        <div class="container">
        <!-- <h4 class="setting-head mt-5">Settings Menu</h4>-->
        	<div class="row">
        		
                <div class="col-lg-8 user-profile-left mt-5">
               		<div class="profile-main-body">
                        <h4>Payments</h4>
                            @include('../../../admin.message')
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Payment Method</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Transactions</a>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    @if(isset($intent) && !empty($intent))
                                        <div class="alert alert-danger" role="alert" id="er_msg_outer" style="display:none">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <span id="er_msg"></span>
                                        </div>
                                        <form method="post" action="" id="payment-form">
                                            @csrf
                                            <div id="successstory-form" data-secret="{{ $intent->client_secret }}" data-customer="{{ $intent->customer }}">
                                                <div class="mt-5">
                                                    <div class="field">
                                                        <label for="title">Card Name*</label>
                                                        <input type="text" class="required" name="name" id="cardholder-name"  > 
                                                    </div>
                                                    <div id="card-element">
                                                        <!-- Elements will create form elements here -->
                                                    </div>
                                                    <!-- Used to display form errors. -->
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                            </div>
                                            <div class="field-btn">
                                                <button type="submit" class="btn-submit btn-custom-primary" style="display: inline-block !important;">Save</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="mt-5">
                                            <h5>Payment Method</h5>
                                            <p>Only one online payment method may be stored at a time</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                          <th scope="col">No</th>
                                                          <th scope="col">Name On Card</th>
                                                          <th scope="col">Expires on</th>
                                                          <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          <th>{{ @$brand }} &nbsp *****{{@$last4}}</th>
                                                          <td>{{@$name}}</td>
                                                          <td>{{@$exp_month.'/'.@$exp_year }}</td>
                                                          <td> 
                                                          @if(isset($exp_month)) 
                                                            <button class="btn btn-danger btn-sm rounded-0 btn-delete" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                                            @else
                                                                ---
                                                            @endif
                                                          </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <!-- Profiles -->
                                <section class="profiles-section">
                                    <div class="container">
                                        <div class="profiles-content ">
                                            <table id="transactions_table" class="row-border w-100">
                                                <thead>
                                                   <tr>
                                                      <th>Transaction</th>
                                                      <th>Price (usd)</th>
                                                      <th>Date  </th>
                                                      <th>Status</th>
                                                   </tr>
                                                </thead>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </section>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
	<script>
       
        var oTable = $('#transactions_table').DataTable({
          "bLengthChange": false,
            searching: false,
            processing: true,
            serverSide: true,
            sorting: false, 
            ordering : false, 
            'language':{ 
               "loadingRecords": "&nbsp;",
               "processing": "Loading..."
            },                       
            "ajax": {
                    "url": "{!! url('user/settings') !!}",
                    
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },                   
                    "data": function ( d ) {  
                        
                    }
            },
            columns: [                              
                {data: 'type', name: 'type'},
                {data: 'amoun_paid', name: 'amoun_paid'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'}
            ]
        }).on('page.dt', function() {
          $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
          }, 'slow');
          
        });

        $('body').on('click','.btn-delete',function(e){
               
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                showOverlayLoader();
                $.ajax({
                    url:"{{url('/user/settings/delete-payment_method')}}",
                    headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }, 
                    type:"post",
                    data:'',
                    cache:false,
                    
                    success:function(data){
                        hideOverlayLoader();
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            Swal.fire(
                              'Deleted!',
                              'Your Card has been deleted.',
                              'success'
                            );
                            window.location = data.url;
                        }else{
                            $('#er_msg').text(data.message);
                            $('#er_msg_outer').show();
                        }
                    }
                });
              }
            });
            
        });
    </script>
	<script>
        // Create a Stripe client.
        var returnRedirectURL = "{{$redirectURL}}";
        const stripe = Stripe( 'pk_test_TYooMQauvdEDq54NiTphI7jx' );
        const clientSecret = $('#successstory-form').data('secret');
        const customer = $('#successstory-form').data('customer');
        const options = {
            clientSecret: clientSecret,
            // Fully customizable with appearance API.
            appearance: {
              theme: 'stripe'
            },
        };
        const elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        
        const cardElement = elements.create('card', {
            hidePostalCode: true,
            style: style
        });
        //const paymentElement = elements.create('payment');
        cardElement.mount('#card-element');

        var cardholderName = document.getElementById('cardholder-name');
        //form for get card information
        const form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
          showOverlayLoader();
          ev.preventDefault();
          stripe.confirmCardSetup(
            clientSecret,
            {
              payment_method: {
                card: cardElement,
                billing_details: {
                  name: cardholderName.value,
                },
              },
            }
          ).then(function(result) {
            if (result.error) {
              // Display error.message in your UI.
              $('#er_msg').text(result.error.message);
              $('#er_msg_outer').show();
              hideOverlayLoader();

            } else {
              // The setup has succeeded. Display a success message.
              console.log(result);
              $('#payment-form').hide();
                if(result.setupIntent.status = 'succeeded'){

                    $.ajax({
                        // url: "/user/add-stripe-card",
                        url: '{{ route("user.add-stripe-card") }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }, 
                        type:"post",
                        data:{'payment_method': result.setupIntent.payment_method,'customer': customer,'returnRedirectURL': returnRedirectURL},
                        cache:false,
                        
                        success:function(data){
                            hideOverlayLoader();
                            
                            var data = JSON.parse(data);
                            if (data.status == 1) {
                                window.location = data.url;
                            }
                        }
                    });
                }
            }
          });
        });
    </script>
    <script>
        $(function(){
        	
		  	
		    
        });
    </script>
@endsection
