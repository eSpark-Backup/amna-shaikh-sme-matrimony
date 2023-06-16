<div class="single-profile">
    <div class="profile_inner">
        <div class="row">
            <div class="col-md-4 col-lg-4 col-xl-3 text-center">
                <div class="profile_user_img">
                    <?php $photo_url = checkImage(asset('storage/members/profile-image/' . $member->profile_image), '', $member->profile_image, 1);
                    ?>

                    <a href="{{ url('user/members/'.$member->id) }}">
                        <img class="profile_image {{$member->picture_privacy == 'blur' ? 'blur_img' : ''}}" src="{{ $photo_url }}" alt="Profile Image"></a>
                    <!-- <div class="profile_image" style="background-image: url('{{ $photo_url }}');"></div> -->
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-xl-9">
                <div class="profile-info-wrap">
                    <div class="profile-info">
                        <div class="profile_info_cls">
                            <h5><a href="{{ url('user/members/'.$member->id) }}">{{ $member->last_name }}</a><span>{{ (isset($member->occupation->name))?$member->occupation->name:'' }}</span>
                            </h5>
                            <div class="View_Pro"><a href="{{ url('user/members/'.$member->id) }}">View Profile</a></div>
                        </div>

                        <span><img src="{{asset('assets/images/marker.png')}}" alt="icon">{{ (isset($member->country->name))? $member->country->name:'' }}</span>
                        <div class="prof-tags">
                            <?php
                            $from = new DateTime($member->date_of_birth);
                            $to   = new DateTime('today');
                            $age = $from->diff($to)->y;
                            ?>
                            <span><img src="{{asset('assets/images/birthday.svg')}}" alt="icon">{{$age}} year</span>
                            @if( isset($member->marital_status->name) )
                            <!--  <span>
                                    <img src="{{ asset('assets/images/diamond.svg') }}"
                                        alt="icon">{{ (isset($member->marital_status->name))?$member->marital_status->name:'' }}
                                </span> -->
                            @endif
                            @if( isset($member->nationality->name) )
                            <span>
                                <img src="{{asset('assets/images/locate.svg') }}" alt="icon">{{ (isset($member->nationality->name))?$member->nationality->name:'' }}
                            </span>
                            @endif
                            @if( isset($member->caste->name) )
                            <!-- <span>
                                <img src="{{ asset('assets/images/radio.svg') }}"
                                    alt="icon">{{ (isset($member->caste->name))?$member->caste->name:'' }}
                            </span> -->
                            @endif
                            @if( isset($member->height) )
                            <span>
                                <img src="{{asset('assets/images/inches.svg') }}" alt="icon">{{ $member->height }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="basic-info-wrap">
                    <div class="basic-info members-basic-info with_line">
                        <div class="basic-row flex">
                            <h4>Basic Information:</h4>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2"><span>Member ID</span></td>
                                <td colspan="2"><a href="{{ url('user/members/'.$member->id) }}">
                                        <h6>ID{{ $member->id }}</h6>
                                    </a></td>
                            </tr>
                            <tr>
                                <td><span>Nationality</span></td>
                                <td>{{ (isset($member->country->name))? $member->country->name:'' }}</td>
                                <td><span>Caste / Sect</span></td>
                                <td>{{ (isset($member->caste->name))?$member->caste->name:'Bajwa' }}</td>
                            </tr>
                            <tr>
                                <td><span>Education</span></td>
                                <td>{{ isset($member->education->name)? $member->education->name:'---' }}</td>
                                <td><span>Marital Status</span></td>
                                <td>{{ isset($member->marital_status) ? $member->marital_status->name:'---' }}</td>
                            </tr>
                            <!-- <tr>
                               <td><span>Full Name</span></td>
                                <td><a href="{{ url('user/members/'.$member->id) }}"><h6>{{ $member->last_name }}</h6></a></td>
                                @if(isset($member->marital_status->name))
                                    <td><span>Martial Status</span></td>
                                    <td><h6>{{ $member->marital_status->name }}</h6></td>
                                @endif
                            </tr> -->
                            <!-- <tr>
                                <td><span>Gender</span></td>
                                <td>
                                    <h6>{{ $member->gender }}</h6>
                                </td>
                            </tr> -->
                            <tr>
                                <td><span>Location</span></td>
                                <td>{{ isset($member->city->name)?$member->city->name.',':'' }} {{ isset($member->country->name)?$member->country->name:'---' }}</td>
                                <!-- @if(isset($member->on_behalf->name))
                                    <td><span>On Behalf</span></td>
                                    <td><h6>{{ $member->on_behalf->name }}</h6></td>
                                @endif -->

                            </tr>
                        </table>
                        <!-- <div class="basic-info-row">
                            <span>Gender</span>
                            <h6>
                                Female
                            </h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Age</span>
                            <h6>24</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Martial Status</span>
                            <h6>Never Married</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>No Of Children</span>
                            <h6>0</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>Date Of Birth</span>
                            <h6>23/01/1997</h6>
                        </div>
                        <div class="basic-info-row">
                            <span>On Behalf</span>
                            <h6>Sister</h6>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="prof-actions">
        <!-- <a href='#' class="interest-request likeMe" data-memberid="{{ $member->id }}" data-status="1">
            <img src="{{asset('assets/images/like.svg') }}" alt="icon">Like
        </a>
        <a href="#" class="btn-member-msg" data-memberidhash="{{ $member->hash_id}}"><img src="{{asset('assets/images/msg.svg') }}" alt="icon">Message</a>

        <a href="#" class="interest-request" data-memberid="{{ $member->id }}" data-status="3"><img src="{{asset('assets/images/cross-ic.svg') }}" alt="icon">Ignore</a>
        <a href="#" class="favorite-btn" data-memberid="{{ $member->id }}" data-status="3"><img src="{{asset('assets/images/fav.svg') }}" alt="icon">Favourite</a>
        <a href="#" class="interest-request" data-memberid="{{ $member->id }}" data-status="3"><img src="{{asset('assets/images/report.svg') }}" alt="icon">Report</a> -->
        <!-- <a href='#' class="interest-request likeMe btn-custom-secondary" data-memberid="{{ $member->id }}" data-status="1"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</a> -->
        <!-- <a href="#" class="btn-member-msg  btn-custom-primary" data-memberidhash="{{ $member->hash_id}}"><i class="fa fa-commenting-o" aria-hidden="true"></i> Message</a> -->
        <!-- <a href="#" class="interest-request btn-custom-secondary" data-memberid="{{ $member->id }}" data-status="3"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Ignore</a> -->
        <!-- <a href="javascript:void(0);" class="report-request btn-custom-primary" data-memberid="{{ $member->id }}"><i class="fa fa-flag-o" aria-hidden="true"></i> Report</a> -->
        <!-- <div class="d-flex flex-row"> -->

        <div class="d-flex col-12 col-md-4 col-lg-3 col-6 order-sm-1 order-2">
            <!-- <button class="warning sendMe">Send Message</button> -->
            <a href="#" class="btn-custom-primary btn-member-msg w-100 text-center my-2" data-memberidhash="{{ $member->hash_id}}">Send Message</a>
        </div>
        <div class="d-flex col-12 col-md-8 col-lg-9 justify-content-end  col-6 order-sm-2 order-1">
            <button class="interest-request likeMe mx-1" data-memberid="{{ $member->id }}" data-status="1" data-checklikelimitcondition="1"><img src="{{ url("images/Heart.png") }}" alt=""></button>
            <button class="interest-request mx-1" data-memberid="{{ $member->id }}" data-status="3"><img src="{{ url("images/Close.png") }}" alt=""></button>
            <button class="report-request mx-1" data-memberid="{{ $member->id }}"><img src="{{ url("images/Mark.png") }}" alt=""></button>
        </div>

        <!-- </div> -->

    </div>

</div>