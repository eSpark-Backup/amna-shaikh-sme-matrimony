@extends('app')
@section('title', 'Apply for Event')
@section('style')
<?php 
    $alreadySelectedRelation = '';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
<script src="https://js.stripe.com/v3/"></script>

@endsection
@section('content')
<!-- Events Banner -->
<section class="event_section" style="background-image: url('assets/images/event_bg.png');">
        <div class="events_overlay">
            <div class="container">
                <div class="events_content">
                    <h2>Hi, {{ Session::get('user')->first_name }}</h2>
                    <p>We're excited to see you at the event!!</p> 
                </div>
            </div>
        </div>
    </section>

<section class="user-profile-section prersonal-prof mb-5">
    <div class="user-profile-payment mt-3">
        <div class="container">
            <!-- <div class="section-head"> -->
                <!-- <h4 class="text-center" style="margin-bottom: 0px;">{{ $events->title }}</h4>
                <p style="margin-top: 0px;">Hi, Thanks for joining event.</p>-->
            <!-- </div> -->
            <div class="row">
                <div class="col-lg-8 user-profile-left mt-5">
                    <div class="profile-main-body" id="wraper_reserve_family_members">
                        <h4>Do you want to bring any family member?</h4>
                        <div id="reserve_family_members">
                            <div class="py-3">
                                <div id="user_section">
                                    <div class="row form-group align-items-end">
                                        <div class="col-md-4">
                                            <label for="gender" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="on_behalf_id" class="form-label">Relation</label>
                                            <select name="on_behalf_id" id="relation" class="form-control required">
                                                <option value="">Choose</option>
                                                @foreach($siblings as $K => $V)

                                                <option value="{{ $V->name }}">{{ $V->name }}</option>
                                                
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="gender" class="form-label">Age</label>
                                            <select name="gender" id="age" class="form-control required">
                                                <option value="">Choose</option>
                                                <option value="100">100</option>
                                                <option value="99">99</option>
                                                <option value="98">98</option>
                                                <option value="97">97</option>
                                                <option value="96">96</option>
                                                <option value="95">95</option>
                                                <option value="94">94</option>
                                                <option value="93">93</option>
                                                <option value="92">92</option>
                                                <option value="91">91</option>
                                                <option value="90">90</option>
                                                <option value="89">89</option>
                                                <option value="88">88</option>
                                                <option value="87">87</option>
                                                <option value="86">86</option>
                                                <option value="85">85</option>
                                                <option value="84">84</option>
                                                <option value="83">83</option>
                                                <option value="82">82</option>
                                                <option value="81">81</option>
                                                <option value="80">80</option>
                                                <option value="79">79</option>
                                                <option value="78">78</option>
                                                <option value="77">77</option>
                                                <option value="76">76</option>
                                                <option value="75">75</option>
                                                <option value="74">74</option>
                                                <option value="73">73</option>
                                                <option value="72">72</option>
                                                <option value="71">71</option>
                                                <option value="70">70</option>
                                                <option value="69">69</option>
                                                <option value="68">68</option>
                                                <option value="67">67</option>
                                                <option value="66">66</option>
                                                <option value="65">65</option>
                                                <option value="64">64</option>
                                                <option value="63">63</option>
                                                <option value="62">62</option>
                                                <option value="61">61</option>
                                                <option value="60">60</option>
                                                <option value="59">59</option>
                                                <option value="58">58</option>
                                                <option value="57">57</option>
                                                <option value="56">56</option>
                                                <option value="55">55</option>
                                                <option value="54">54</option>
                                                <option value="53">53</option>
                                                <option value="52">52</option>
                                                <option value="51">51</option>
                                                <option value="50">50</option>
                                                <option value="49">49</option>
                                                <option value="48">48</option>
                                                <option value="47">47</option>
                                                <option value="46">46</option>
                                                <option value="45">45</option>
                                                <option value="44">44</option>
                                                <option value="43">43</option>
                                                <option value="42">42</option>
                                                <option value="41">41</option>
                                                <option value="40">40</option>
                                                <option value="39">39</option>
                                                <option value="38">38</option>
                                                <option value="37">37</option>
                                                <option value="36">36</option>
                                                <option value="35">35</option>
                                                <option value="34">34</option>
                                                <option value="33">33</option>
                                                <option value="32">32</option>
                                                <option value="31">31</option>
                                                <option value="30">30</option>
                                                <option value="29">29</option>
                                                <option value="28">28</option>
                                                <option value="27">27</option>
                                                <option value="26">26</option>
                                                <option value="25">25</option>
                                                <option value="24">24</option>
                                                <option value="23">23</option>
                                                <option value="22">22</option>
                                                <option value="21">21</option>
                                                <option value="20">20</option>
                                                <option value="19">19</option>
                                                <option value="18">18</option>
                                                <option value="17">17</option>
                                                <option value="16">16</option>
                                                <option value="15">15</option>
                                                <option value="14">14</option>
                                                <option value="13">13</option>
                                                <option value="12">12</option>
                                                <option value="11">11</option>
                                                <option value="10">10</option>
                                                <option value="9">9</option>
                                                <option value="8">8</option>
                                                <option value="7">7</option>
                                                <option value="6">6</option>
                                                <option value="5">5</option>
                                                <option value="4">4</option>
                                                <option value="3">3</option>
                                                <option value="2">2</option>
                                                <option value="1">1</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select name="gender" id="gender" class="form-control required" aria-invalid="false">
                                                <option value="">Choose</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="gender" class="form-label"></label>
                                            <button class="btn btn-custom-primary btn-small" id="add_more" style="    margin-top: 7px;">+ ADD</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(isset($already_guests) && count($already_guests) > 0)
                                <div class="user-profile-info pt-2 mb-3">
                                    
                                        <h5>Already Added Members</h5> 
                                        <div id="family_members_table">
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Full Name</th>
                                                            <th>Relation</th>
                                                            <th>Age</th>
                                                            <th>Gender</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($already_guests as $K => $V)
                                                            @php
                                                                $guests = json_decode($V->guests,true);
                                                            @endphp
                                                            @if(count($guests) > 0)
                                                                @foreach($guests as $gK => $gV)

                                                                <?php $alreadySelectedRelation = $alreadySelectedRelation.','.$gV['relation']; ?>
                                                                <tr>
                                                                    <td>{{ ++$gK }}</td>
                                                                    <td>{{$gV['name']}}</td>
                                                                    <td>{{$gV['relation']}}</td>
                                                                    <td>{{$gV['age']}}</td>
                                                                    <td>{{$gV['gender']}}</td>
                                                                    <td>{{$V['guest_charges']}}</td>
                                                                </tr>
                                                                @endforeach

                                                            @endif
                                                        @endforeach
                                                        <!-- <tr>
                                                            <td colspan="5" align="center">No Data Found</td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                </div>
                            @endif
                            <div class="user-profile-info pt-2 mb-3" style="display:none">
                                        <h5>New Family Members</h5>
                                    <div id="family_members_table">
                                        <div class="table-responsive">
                                            <table id="myTable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Full Name</th>
                                                        <th>Relation</th>
                                                        <th>Age</th>
                                                        <th>Gender</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div> 
                        <div class="field-btn">
                            <button type="button" class="btn-submit btn-custom-primary"
                                style="display: inline-block !important;" id="btn-next">NEXT <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                        </div> 
                    </div>
                    <div class="profile-main-body" id="wraper_payment_details" style="display:none">
                        <h4>Payment Details</h4>
                        <div id="user_section">
                            @if(isset($intent) && !empty($intent) && $card_exist == 0)
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
                                    <input type="hidden" name="userData" id="userData" value="" />
                                    <input type="hidden" name="event_id" id="id" value="{{ $events->id }}">
                                    <div class="field-btn">
                                        <button type="button" class="btn-submit btn-custom-secondary btn-back" style="display: inline-block !important;">BACK <i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
                                        <button type="submit" class="btn-submit btn-custom-primary" style="display: inline-block !important;margin-left: 5px;">Checkout</button>
                                    </div>
                                </form>
                            @else
                                <div class="mt-5">
                                    <h5>Payment Method</h5>
                                    <p>Only one online payment method may be stored at a time</p>
                                    <div id="card_table">
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
                                                        <button class="btn-info btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete" id="payment_edit"><i class="fa fa-pencil"></i></button>
                                                        @else
                                                            ---
                                                        @endif
                                                      </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <form method="post" action="" id="payment-form-simple">
                                            @csrf
                                            <input type="hidden" name="userData" id="userData" value="" />
                                            <input type="hidden" name="event_id" id="id" value="{{ $events->id }}">
                                            <div class="field-btn">
                                                <button type="button" class="btn-submit btn-custom-secondary btn-back" style="display: inline-block !important;">BACK <i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
                                                <button type="submit" class="btn-submit btn-custom-primary" style="display: inline-block !important;margin-left: 5px;">Checkout</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- payment could be editable -->
                                    <div id="edit_payment_section" style="display:none">
                                        <button class="btn-custom-secondary" type="button" data-toggle="tooltip" data-placement="top" title="Delete" id="payment_info_old">Show Old <i class="fa fa-pencil"></i></button>

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
                                            <input type="hidden" name="userData" id="userData" value="" />
                                            <input type="hidden" name="event_id" id="id" value="{{ $events->id }}">
                                            <div class="field-btn">
                                                <button type="button" class="btn-submit btn-custom-secondary btn-back" style="display: inline-block !important;">BACK <i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
                                                <button type="submit" class="btn-submit btn-custom-primary" style="display: inline-block !important;margin-left: 5px;">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- payment could be editable -->
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 user-profile-left mt-5">
                    <div class="basic-info with_line profile-main-body rounded">
                        <h4 class="setting-head">Details</h4>
                        
                        <div class="basic-info-row">
                            <span>User Name</span>
                            <h6>{{ $user->first_name.' '.$user->last_name }}</h6>
                        </div>
                        <!-- <div class="basic-info-row">
                            <span>Gender</span>
                            <h6>{{ ($user->gender == 0) ? 'Male':'Female' }}</h6>
                        </div> -->
                        <div class="basic-info-row family_data d-none">
                            <span>Seats for family reserved</span>
                            <h6><span id="family_seats">0</span></h6>
                        </div>
                        <div class="basic-info-row family_data d-none">
                            <span>Charges for family reserved</span>
                            <h6><span id="family_charges"><span id="remove_family">0 USD</span> </span></h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Event Charges</span>
                            <h6>{{ ($already_apply == 0)? $events->event_charges:0 }} USD</h6>
                        </div>
                        <hr>
                        <div class="basic-info-row">
                            <span> <b> Total Charges </b></span>
                            <h6><span id="total_charges"><span id="remove_total">{{ ($already_apply == 0)? $events->event_charges:0 }} USD</span>
                                </span></h6>
                        </div>
                        
                    </div>
                </div>
            </div>            
        </div>
    </div>

</section>

<div class="alert_popup alreadySelectedRelation">
    <div class="modal fade" id="alreadyRelation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h2>Oops!</h2>
            <p>You have already selected this relation, please try with other relation.</p>
            <div class="alert-action">
                <!-- <a href="{{ url("/plans") }}" class="btn">View Plans</a> -->
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
            </div>
          </div>
          <!-- <div class="modal-footer">
                <a href="javascript:void(0);" onclick="submitApprovalForm()">Proceed</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
          </div> -->
        </div>
      </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var event_charges = {{ ($already_apply == 0)? $events->event_charges:0 }};
    var adults_charges = '{{ $events->adults_charges }}';
    var membersAr = [];
    $(document).ready(function () {

        var seats = 1;
        var adults = 0;
        var ev_charges = event_charges;
        var clicks = 0;
        var alreadySelectedRelation = "{{$alreadySelectedRelation}}";
        var alreadyAddedRelation = [];

        if (alreadySelectedRelation.length > 0) {
            alreadyAddedRelation = alreadySelectedRelation.split(',');
        }

        $('#add_more').on('click', function () {

            if (alreadyAddedRelation.includes($('#relation').val())) {
                $('#alreadyRelation').modal('show');

            } else {
                alreadyAddedRelation.push($('#relation').val()); 
                var name = $('#name').val();
                var relation = $('#relation').val();
                var age = $('#age').val();
                var gender = $('#gender').val();

                checkValue('name', name);
                checkValue('relation', relation);
                checkValue('age', age);
                checkValue('gender', gender);

                if (checkValue('name', name) && checkValue('relation', relation) && checkValue('age',
                        age) && checkValue('gender', gender)) {

                    $('#myTable tr:last').after('<tr><td></td><td>' + name + '</td><td>' + relation +
                        '</td><td>' +
                        age + '</td><td>' + gender +
                        '</td><td>' + adults_charges +
                        '</td><td><button class="btn btn-danger btn-sm btn-delete" type="button" data-toggle="tooltip" data-placement="top" title="Delete" data-indx="' +
                        clicks + '"><i class="fa fa-trash"></i> Delete</button></td></tr>');
                    $('#name').val('');
                    $('#relation').val('');
                    $('#age').val('');
                    $('#gender').val('');
                    var count = 0;
                    $('.btn-delete').each(function (i, obj) {
                        //ev_charges = parseFloat(ev_charges) + parseFloat(adults_charges);
                        count++;

                    });
                    adults = (adults_charges) * (count);
                    seats = count;
                    var sm = parseFloat(event_charges) + parseFloat(adults);
                    $('.family_data').removeClass('d-none');

                    $('#family_seats').text(seats);
                    $('#remove_family').remove();
                    $('#family_charges').append('<span id="remove_family">' + adults + ' USD</span>');
                    $('#remove_total').remove();
                    $('#total_charges').append('<span id="remove_total">' + sm + ' USD</span>');
                    seats++;
                    $('#family_members_table').show();
                    $('.user-profile-info').show();

                    membersAr.push({
                        'name': name,
                        'relation': relation,
                        'age': age,
                        'gender': gender
                    });
                    clicks++;
                }
            }


        });

        $('body').on('click', '.btn-delete', function (e) {

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
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );


                    console.log($(this).data('indx'));
                    membersAr.splice($(this).data('indx'), 1);
                    $(this).closest('tr').remove();
                    update_price();
                }
            });

        });
        $('.btn-submitTTT').on('click', function (e) {

            var id = $('#id').val();
            if (id != '') {
                showOverlayLoader();
                $.ajax({
                    url: "{{ url('/user/send-interest-request') }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "post",
                    data: {
                        'event_id': id,
                        'guests': membersAr
                    },
                    cache: false,

                    success: function (data) {
                        hideOverlayLoader();
                        console.log(data);
                    }
                });
            }
        });
        $('#btn_payment').on('click', function () {
            showOverlayLoader();
            $('#user_section').hide();
            $('#payment_section').show();
            $('#userData').val(JSON.stringify(membersAr));
            hideOverlayLoader();
        });
        $('#btn_user').on('click', function () {
            showOverlayLoader();
            $('#payment_section').hide();
            $('#user_section').show();
            hideOverlayLoader();
        });
        $('#family_members_show').on('click', function () {
            $('#reserve_family_members').show();
            $('#family_members_hide').show();
            $('#family_members_show').hide();

        });
        $('#family_members_hide').on('click', function () {
            $('#reserve_family_members').hide();
            $('#family_members_hide').hide();
            $('#family_members_show').show();

            membersAr = [];

            $('.btn-delete').closest('tr').remove();
            update_price();
        });
        //next button for payment
        $('#btn-next').on('click',function(){
            $('#wraper_reserve_family_members').hide();
            $('#wraper_payment_details').show();
        });
        $('.btn-back').on('click',function(){
            $('#wraper_reserve_family_members').show();
            $('#wraper_payment_details').hide();
        });
        $('#payment_edit').on('click',function(){
            $('#edit_payment_section').show();
            $('#card_table').hide();
        });
        $('#payment_info_old').on('click',function(){
            $('#edit_payment_section').hide();
            $('#card_table').show();
        });
    });

    function checkValue(field, field_value) {
        if (field_value == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: field + ' field is missing, Please choose value',
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: 'Okay',
                confirmButtonColor: '#21c2d6',
            });
            return false;
        } else {
            return true;
        }
    }

    function update_price() {
        var _event = event_charges;
        var fm = adults_charges;
        var count = 0;
        var l_event = 0;
        $('.btn-delete').each(function (i, obj) {
            _event = parseFloat(_event) + parseFloat(fm);
            count++;
            $(obj).attr('data-indx', i);
        });

        fm = (fm) * (count);
       
        //l_event = (fm)+(_event);
        $('#remove_total').remove();
        $('#total_charges').append('<span id="remove_total">' + _event + ' USD</span>');
        $('#remove_family').remove();
        $('#family_charges').append('<span id="remove_family">' + fm + ' USD</span>');
        $('#family_seats').text(count);

        if (count == 0) {
            $('#family_members_table').hide();
        }

    }
</script>
<script>
    // Create a Stripe client.
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
    if ($('#card-element').length > 0) {
        cardElement.mount('#card-element');
    }
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
          ev.preventDefault();
          return false;
        } else {
          // The setup has succeeded. Display a success message.
          console.log(result);
          $('#payment-form').hide();
            if(result.setupIntent.status = 'succeeded'){
                var id = $('#id').val();
                $.ajax({
                    url: "{{url('/user/events/stripe')}}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }, 
                    type:"post",
                    data:{'payment_method': result.setupIntent.payment_method,'customer': customer, 'event_id':id,'guests':JSON.stringify(membersAr)},
                    cache:false,
                    
                    success:function(data){
                        hideOverlayLoader();
                        console.log(data);
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            window.location = data.url;
                        }else if(data.status == 3) {
                            Swal.fire({
                                icon: 'warning',
                                title: data.title,
                                text: data.message,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: 'Okay',
                                confirmButtonColor: '#21c2d6',
                            });
                            return false;
                        }else{
                            window.location = data.url;
                        }
                    }
                });
            }
        }
      });
    });
    //simple payment form
    var simpleform = document.getElementById('payment-form-simple');

    simpleform.addEventListener('submit', function (event) {
        event.preventDefault();
        showOverlayLoader();
        //stripe.createToken(card).then(function(result) {

        //form.submit();
        var id = $('#id').val();
        if (id != '') {

            $.ajax({
                url: "{{url('/user/events/stripe')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "post",
                data: {
                    'event_id': id,
                    'guests': JSON.stringify(membersAr)
                },
                cache: false,

                success: function (data) {
                    hideOverlayLoader();

                    var data = JSON.parse(data);
                    
                    if (data.status == 1) {
                        window.location = data.url;
                    }else if(data.status == 3) {
                        Swal.fire({
                            icon: 'warning',
                            title: data.title,
                            text: data.message,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: 'Okay',
                            confirmButtonColor: '#21c2d6',
                        });
                        return false;
                    }else{
                        window.location = data.url;
                    }
                }
            });
        }
        // });
    });
</script>
@endsection