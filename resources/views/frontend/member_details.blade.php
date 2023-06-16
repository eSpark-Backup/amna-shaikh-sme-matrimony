@extends('app')
@section('title', 'Member Detail')
@section('style')
<link type="text/css" rel="stylesheet" href="{{ asset('assets/lightgellary/css/lightgallery.css') }}" />
@endsection
@section('content')
<!-- Profile Page -->
<section class="user-profile-section profile-main-page">
    <div class="container">
        <div class="user-profile-row flex">
            <div class="user-profile-left">
                <?php $photo_url = checkImage(asset('storage/members/profile-image/' . $member->profile_image), '', $member->profile_image, 1);  ?>
                <div class="user-profile-image"><img src="{{$photo_url }}" class="{{$member->picture_privacy == 'blur' ? 'blur_img' : ''}}" alt="image"></div>
                <?php //$has_id = \Hashids::encode($member->id); 
                ?>
                <?php $has_id = $member->id; ?>

                <div class="profile-top-head flex">
                    <div class="profile-left-titles">

                        <h2>{{ getUserName($member->first_name.' '.$member['last_name']) }}. <span>({{(isset( $member->occupation->name))?  $member->occupation->name:'---' }})</span></h2>

                        <!-- <span><img src="{{ asset('assets/images/location_white.png') }}" alt="">{{ isset($member->city->name)?$member->city->name:'---' }}, {{ isset($member->country->name)?$member->country->name:'---' }}</span> -->

                    </div>

                </div>
                <div class="member-info">

                    <div class="member-infos d-flex">
                        <div class="d-flex">
                            <span><img src="{{ asset('assets/images/location_white.png') }}" alt="">{{ isset($member->city->name)?$member->city->name:'---' }}, {{ isset($member->country->name)?$member->country->name:'---' }}</span>
                        </div>
                        <!-- <span><img src="{{asset('assets/images/map.svg') }}" alt="icon">{{ $member['country_id'] }}</span> -->
                        <!-- <div class=" img-icon d-flex"> -->

                        <div class="d-flex col-12 col-md-8 col-lg-9 justify-content-end  col-6 order-sm-2 order-1">
                            <button class="interest-request likeMe mx-1" data-memberid="{{ $member->id }}" data-status="1"><img src="{{ url("images/Heart.png") }}" alt=""></button>
                            <button class="interest-request mx-1" data-memberid="{{ $member->id }}" data-status="3"><img src="{{ url("images/Close.png") }}" alt=""></button>
                            <button class="report-request mx-1" data-memberid="{{ $member->id }}"><img src="{{ url("images/Mark.png") }}" alt=""></button>
                        </div>
                        <!-- <img src="{{ asset('images/Heart.png')}}" alt="heart">
                            <img src="{{ asset('images/Close.png')}}" alt="close">
                            <img src="{{ asset('images/Mark.png')}}" alt=mark> -->


                    </div>

                    @auth('user')
                    <a class="btn-custom-primary btn-member-msg w-100 text-center my-2 cursor" data-member="{{ $member->toJson() }}" data-status="{{Auth::user()->status}}" data-approved="{{ Auth::user()->is_approved }}" data-memberidhash="{{ $member->id }}">Send Message</a>

                    @else
                    <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" onclick="openLoginModel()">View Full Profile</a> -->
                    <a href="javascript:void(0);" class="custom_modal btn-custom-primary cursor">View Full Profile</a>
                    @endauth
                </div>

                <!-- <a href="{{ url('user/chats?id='.$has_id ) }}" class="mesg-btn"> <img src="{{ asset('assets/images/sms.png') }}" alt="icon"> Send Message</a> -->
                <!-- <div class="prof-actions-details">
                        <a href='#' class="interest-request likeMe btn-custom-secondary" data-memberid="{{ $member->id }}" data-status="1"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</a>
                        <a href="#" class="interest-request btn-custom-secondary" data-memberid="{{$member->id}}" data-status="3"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Ignore</a>
                        <a href="javascript:void(0);" class="report-request btn-custom-primary" data-memberid="{{ $member->id }}"><i class="fa fa-flag-o" aria-hidden="true"></i> Report</a>
                    </div> -->

                @if ($member->gallery_image == 'all_member')
                <div class="profile-photos">
                    <h4>Photos:</h4>
                    <ul id="lightgallery">
                        @foreach($user_images as $K => $V)

                        <?php
                        $photo_url = ($V->user_image) ? asset('storage/members/profile-image/' . $V->user_image) : asset('images/user-placeholder.jpg');
                        ?>
                        <a href="{{$photo_url}}">
                            <img src="{{$photo_url}}" class="profile-gal {{$member->picture_privacy == 'blur' ? 'blur_img' : ''}}" />
                            <!--  <div class="profile-gal" style="background-image: url({{$photo_url}});"></div> -->
                        </a>

                        @endforeach
                    </ul>
                </div>
                @endif

            </div>
            <div class="user-profile-center">
                <div class="profile-main-body">
                    <div class="profile-inner-body">
                        <h4>Profile Information:</h4>
                        <span>Member#: ID{{ $member->id }}</span>
                    </div>
                    <div class="inner_information">
                        <div class="profile_desc">
                            <h4>Introduction</h4>
                            <p>{{ $member['about'] }}</p>
                        </div>
                        <div class="basic-info with_line">
                            <div class="basic-row flex">
                                <h4>Personal Information:</h4>
                            </div>
                            <div class="basic-info-row">
                                <span>Full Name</span>
                                <h6>{{ getUserName($member->first_name.' '.$member['last_name']) }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Gender</span>
                                <h6>
                                    <?php
                                    if ($member['gender'] == 1) {
                                        echo 'Female';
                                    } elseif ($member['gender'] == 0) {
                                        echo 'Male';
                                    } else {
                                        echo 'Others';
                                    }
                                    ?>
                                </h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Marital Status</span>
                                <h6>
                                    {{ isset($member->marital_status->name)? $member->marital_status->name:'---' }}
                                </h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Height</span>
                                <h6>{{ (isset($member['height']) && !empty($member['height']) )?$member['height']:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Date of Birth</span>
                                <h6>{{ $member['date_of_birth']}}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>On Behalf</span>
                                <h6>{{ isset($member->on_behalf->name)?$member->on_behalf->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Religion</span>
                                <h6>{{ isset($member->religion->name)? $member->religion->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Caste</span>
                                <h6>{{ isset($member->caste->name)? $member->caste->name:'---' }}</h6>
                            </div>
                        </div>
                        <div class="basic-info with_line">
                            <div class="basic-row flex">
                                <h4>Present Address Information:</h4>
                            </div>
                            <div class="basic-info-row">
                                <span>Country</span>
                                <h6>{{ isset($member->country->name)?$member->country->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>State</span>
                                <h6>
                                    {{ isset($member->state->name)? $member->state->name:'---' }}
                                </h6>
                            </div>
                            <div class="basic-info-row">
                                <span>City</span>
                                <h6>{{ isset($member->city->name)? $member->city->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Nationality</span>
                                <h6>{{ isset($member->nationality->name)? $member->nationality->name:'---' }}</h6>
                            </div>
                        </div>
                        <div class="basic-info">
                            <div class="basic-row flex">
                                <h4>Education & Career:</h4>
                            </div>
                            <div class="basic-info-row">
                                <span>Education</span>
                                <h6>{{ isset($member->education->name)? $member->education->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Specialization</span>
                                <h6>{{ isset($member->specialisation->name)? $member->specialisation->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Occupation</span>
                                <h6>{{ isset($member->occupation->name)? $member->occupation->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Working With</span>
                                <h6>{{ isset($member->working->name)? $member->working->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Annual Income</span>
                                <h6>{{ isset($member->annual_income)? $member->annual_income:'---' }}</h6>
                            </div>
                        </div>
                        <div class="basic-info with_line">
                            <div class="basic-row flex">
                                <h4>Partner Expectation:</h4>
                            </div>

                            <div class="basic-info-row">
                                <span>General Requirement</span>
                                <h6>
                                    {{ isset($member->partner_general_requirement)? $member->partner_general_requirement:'---' }}
                                </h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Age</span>
                                <h6>{{ isset($member->partner_age)? $member->partner_age:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Height</span>
                                <h6>{{ isset($member->partner_height)? $member->partner_height:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Weight</span>
                                <h6>{{ isset($member->partner_weight)? $member->partner_weight:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Marital Status</span>
                                <h6>{{ isset($member->partner_marital_status)?$member->partner_marital_status->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Children Acceptables</span>
                                <h6>{{ ($member->partner_with_children_acceptable == 2)?'No':'Yes' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Caste</span>
                                <h6>{{ ($member->partner_caste) ? $member->partner_caste->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Religion</span>
                                <h6>{{ ($member->partner_religion) ? $member->partner_religion->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Country of Residence</span>
                                <h6>{{ ($member->partner_residence_country) ? $member->partner_residence_country->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Education</span>
                                <h6>{{ ($member->partner_education) ? $member->partner_education->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Profession</span>
                                <h6>{{ ($member->partner_profession) ? $member->partner_profession:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Complexion</span>
                                <h6>{{ ($member->partner_complexion) ? $member->partner_complexion:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Drinking Habits</span>
                                <h6>{{ ($member->partner_drinking_habits == 0) ? 'No':'Yes' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Smoking Habits</span>
                                <h6>{{ ($member->partner_smoking_habits == 0) ? 'No':'Yes' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Diet</span>
                                <h6>{{ ($member->partner_diet) ? $member->partner_diet:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Body Type</span>
                                <h6>{{ ($member->partner_body_type) ? $member->partner_body_type:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Personal Value</span>
                                <h6>{{ ($member->partner_personal_value) ? $member->partner_personal_value:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Manglik</span>
                                <h6>{{ ($member->partner_manglik == 1) ? 'Yes':'No' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Any Desablity</span>
                                <h6>{{ ($member->partner_desablity) ? $member->partner_desablity:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Mother Tongue</span>
                                <h6>{{ ($member->partner_mother_language) ? $member->partner_mother_language->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Prefered Status</span>
                                <h6>{{ ($member->partner_prefered_status) ? $member->partner_prefered_status:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Family Value</span>
                                <h6>{{ ($member->partner_family_value) ? $member->partner_family_value->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Prefered Country</span>
                                <h6>{{ ($member->partner_prefered_country) ? $member->partner_prefered_country->name:'---' }}</h6>
                            </div>
                            <div class="basic-info-row">
                                <span>Prefered State</span>
                                <h6>{{ ($member->partner_prefered_state) ? $member->partner_prefered_state->name:'---' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="alert_popup">
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="report-form" class="form-horizontal" action="{{route('user.report-user')}}" method="post">
                        <div class="icon-show">!</div>
                        <h2>Are you sure you want to Report this user?</h2>
                        <!-- <p></p> -->
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="reasonList" class="form-label">Reason of reporting <span class="star"> :*</span></label>
                                <select name="reasonList" id="reasonList" class="form-control required">
                                    <option value="">-- Choose One --</option>
                                    <option value="bad_manners">Bad Manners</option>
                                    <option value="not_responsive">Not Responsive</option>
                                    <option value="fake">Fake</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12 reportComments" style="display:none;">
                                <label for="comment" class="form-label">Comments <span class="star"> :*</span></label>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="memberId" value="" id="reportMemberId">
                        <div class="alert-action">

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-custom-primary">Submit</a>
                        <button type="button" class="btn-custom-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/lightgellary/lightgallery.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- lightgallery plugins -->
<script src="{{ asset('assets/lightgellary/plugins/thumbnail/lg-thumbnail.min.js') }}"></script>


<script type="text/javascript">
    lightGallery(document.getElementById('lightgallery'), {
        plugins: [lgThumbnail]
    });
</script>

<script>
    $(document).ready(function() {
        $('body').on('click', '.interest-request', function(e) {
            e.preventDefault();
            var id = $(this).data('memberid');
            var status = $(this).data('status');
            showOverlayLoader();
            $.ajax({
                url: "{{ url('/user/send-interest-request') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "post",
                data: {
                    'member_interested_id': id,
                    'status': status
                },
                cache: false,

                success: function(data) {
                    hideOverlayLoader();

                    var data = JSON.parse(data);

                    if (data.status == 1) {
                        oTable.ajax.reload();
                        if (data.req_message != '') {
                            Swal.fire({
                                icon: 'info',
                                title: 'Why wait?',

                                text: data.req_message,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#21c2d6',
                            });
                        }
                    } else if (data.status == 0) {

                        Swal.fire({
                            icon: 'warning',
                            title: data.title,

                            text: data.message,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },

                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#21c2d6',
                        });
                        return false;
                    } else if (data.status == 3) {
                        // alert('Update Plan')
                        $('#like_for_approval').modal('show');
                    }
                }
            });
        });
    });

    $('#reasonList').on('change', function(e) {

        if ($(this).val() == 'other') {
            $('.reportComments').css('display', 'block');

        } else {
            $('.reportComments').css('display', 'none');
        }
    });

    $('body').on('click', '.report-request', function(e) {
        var memberId = $(this).attr('data-memberid');
        $('#reportMemberId').val(memberId);
        $('#reportModal').modal('show');
    });
    $('body').on('click', '.btn-member-msg', function() {

        let aprved = $(this).attr('data-approved');
        var _status = $(this).attr('data-status')


        if (aprved != 1 && _status == 4) {
            Swal.fire({
                icon: 'warning',
                title: "Account is under admin approval",

                text: "Your account is under admin approval. You'll not be able to perform any actions until your profile is approved. Thanks for your patience.",
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },

                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<a href="/user/edit-profile" target="_blank"> Go To Profile </a>',

                cancelButtonText: 'Cancel',
                cancelButtonColor: '#e7147b',
                confirmButtonColor: '#21c2d6',
            });
        } else if (aprved != 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Verification Required',

                text: 'Your account verification is required. Please complete your profile and submit it for admin approval. After your profile is approved you ll receive a verified user badge to continue your search.',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },

                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<a href="/user/edit-profile" target="_blank"> Go To Profile </a>',

                cancelButtonText: 'Okay',
                cancelButtonText: 'Cancel',
                cancelButtonColor: '#e7147b',
                confirmButtonColor: '#21c2d6',
            });
        } else if (aprved == 1) {
            var hasid = $(this).attr('data-memberidhash');
            var chat_url = "{{ url('/user/chats?id=') }}";
            chat_url = chat_url + hasid;
            window.location.href = chat_url;
        }
    });
    $('#report-form').on('submit', function(e) {
        e.preventDefault();
        var _this = $(this);
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('/user/report-user') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                hideOverlayLoader();
                $('#reportModal').modal('hide');
                var data = JSON.parse(data);

                if (data.status == 1) {
                    oTable.ajax.reload();
                    if (data.req_message != '') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Reported User',

                            text: data.req_message,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText: 'Okay',
                            confirmButtonColor: '#21c2d6',
                        });
                    }
                } else if (data.status == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: data.title,

                        text: data.message,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        showCloseButton: true,
                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonColor: '#21c2d6',

                    });
                    return false;
                }
            }
        });

    });
</script>
@endsection