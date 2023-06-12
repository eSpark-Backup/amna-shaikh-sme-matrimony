@extends('app')
@section('title', 'Home')
@section('content')
<!-- Hero -->
<section class="hero-section">
    <div class="owl-carousel hero-slider">

        @php
        $images = explode(',', settings()->slider_images);
        $imgAr = array();

        foreach ($images as $K => $V) {
        if(!empty($V)){
        $imgAr[] = checkImage(asset('storage/home/' . $V),'',$V,1);
        }
        }
        @endphp
        @if(isset($imgAr) && sizeOf($imgAr) > 0)
        @foreach($imgAr as $IK => $IV)
        <div class="item">
            <div class="single-hero" style="background-image: url('{{$IV}}');">
                @auth('user')

                @else
                <div class="banner-button">
                    <a href="{{ url('/register') }}" class="btn-custom-primary">Register / Login</a>
                </div>
                @endauth

            </div>
        </div>
        @endforeach
        @else
        <div class="item">
            <div class="single-hero" style="background-image: url('assets/images/banner.png');">
                @auth('user')

                @else
                <div class="banner-button">
                    <a href="{{ url('/register') }}" class="btn-custom-primary">Register / Login</a>
                </div>
                @endauth

            </div>
        </div>
        @endif
    </div>
</section>
<!-- Couples -->
<section class="couples-section" style="background-image: url('assets/images/couples_bg.png');">
    <div class="container">
        <div class="section-head">
            <h2>{{ settings()->happy_couple_title }}</h2>
            <p>{!! settings()->happy_couple_description !!}</p>
        </div>
        @if(isset($stories) && count($stories) > 0)
        <div class="couples-content">
            <div class="owl-carousel members-slider">

                @foreach(@$stories as $K => $V)
                <div class="wedding-top-row flex">
                    <div class="wedding_image1 weddingBg" style="background-image: url({{ getImage($V['image'],'stories') }}" );><a href="{{ url('/stories/'.$V['id']) }}"></a>

                    </div>
                    <div class="story_details"> <a href="{{ url('/stories/'.$V['id']) }}"><img src="assets/images/link_icon.svg" alt="icon">View Story</a></div>
                </div>

                @endforeach

            </div>
        </div>
        @endif
        <!-- <div class="couples-content">
                <div class="wedding-top-row flex">
                    <div class="wedding_image1 weddingBg" style="background-image: url('{{ getImage(@$stories[4]['image'],'stories') }}');"><a href="{{ url('/stories/'.@$stories[4]['id']) }}"></a></div>
                    <div class="wedding_image2 weddingBg" style="background-image: url('{{ getImage(@$stories[3]['image'],'stories') }}');"><a href="{{ url('/stories/'.@$stories[3]['id']) }}"></a></div>
                </div>
                <div class="wedding-bottom-row flex">
                    <div class="wedding_image3 weddingBg" style="background-image: url('{{ getImage(@$stories[2]['image'],'stories') }}');"><a href="{{ url('/stories/'.@$stories[2]['id']) }}"></a></div>
                    <div class="wedding_image4 weddingBg" style="background-image: url('{{ getImage(@$stories[1]['image'],'stories') }}');"><a href="{{ url('/stories/'.@$stories[1]['id']) }}"></a></div>
                    <div class="wedding_image5 weddingBg" style="background-image: url('{{ getImage(@$stories[0]['image'],'stories') }}');">
                        <div class="wedOverlay">
                            <a href="{{ url('/stories') }}">
                                <span>100+ More Couples</span>
                                <span><img src="assets/images/view_link.png" alt="icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
    </div>
</section>
<!-- Members -->
<section class="members-section">

    <div class="members-content" style="background-image: url('assets/images/members_bg.png');">
        <div class="container">
            <div class="section-head new_members_section mb-4">
                <h2 id="text-clr">{{ settings()->members_title }}</h2>
                {!! settings()->members_description !!}
            </div>
        </div>
        <div class="members-list">
            <div class="container">
                <!-- Set up your HTML -->
                <div class="owl-carousel members-slider">

                    @foreach($members as $MI => $M)

                    <div class="single-member">
                        <div class="member-image">
                            <img class="{{$M['picture_privacy'] == 'blur' ? 'blur_img' : ''}}" src="{{ $M['profile_image'] }}" alt="">
                        </div>

                        <div class="member-info">
                            <div class="member-heading-occupation d-flex">
                                <h5>{{ $M['first_name'] }}</h5>
                                <span>{{ $M['occupation_id'] }}</span>
                            </div>
                            <div class="member-infos d-flex">

                                <span>
                                    <img src="{{asset('assets/images/map.svg') }}" alt="icon">({{ $M['country_id'] }})</span>

                                <div class=" img-icon d-flex">
                                    <img class="interest-request" src="{{ asset('images/Heart.png')}}" data-memberid="{{ $M['id'] }}"  data-status="1" alt="heart">
                                    &nbsp; <img class="interest-request" src="{{ asset('images/Close.png')}}"  data-memberid="{{ $M['id'] }}"  data-status="3" alt="close">
                                    &nbsp; <img class="report-request" src="{{ asset('images/Mark.png')}}"  data-memberid="{{ $M['id'] }}" alt=mark>
{{--                                    <button class="interest-request likeMe mx-1" data-memberid="{{ $M['id'] }}" data-status="1"><img src="{{ url("images/Heart.png") }}" alt=""></button>--}}
{{--                                    <button class="interest-request mx-1" data-memberid="{{ $M['id'] }}" data-status="3"><img src="{{ url("images/Close.png") }}" alt=""></button>--}}
{{--                                    <button class="report-request mx-1" data-memberid="{{ $M['id'] }}"><img src="{{ url("images/Mark.png") }}" alt=""></button>--}}
                                </div>
                            </div>

                            @auth('user')
                            <a href="{{ url('user/members/'.$M['id']) }}" class="btn-custom-primary w-100">View Full Profile</a>

                            @else
                            <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" onclick="openLoginModel()">View Full Profile</a> -->
                            <a href="javascript:void(0);" class="btn-custom-primary custom_modal">View Full Profile</a>
                            @endauth
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

</section>
<!-- NEW ABOUT US SECTION -->
<section class="slice--offset parallax-section parallax-section-lg" style="background-image: url(https://www.smematrimony.com/uploads/home_page/parallax_image/parallax_image_1558545752.jpg);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 text-center">
                <div class="section-head">
                    <h2 class="new-about-h2">About SME Matrimony</h2>
                </div>

                <span class="clearfix"></span>
                <div id="parallax_txt" class="fluid-paragraph fluid-paragraph-sm mt-3 mb-3 c-white">
                    {!! settings()->about_description !!}
                </div>

                <div class="about-us-new">
                    <a href="{{ url('/register') }}" class="btn-custom-primary">Register / Login</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--END NEW ABOUT US SECTION -->
<!-- About -->
<!-- <section class="about-section">
        <div class="container">
            <div class="about-content flex">
                <div class="about-images">
                    <div class="about_image1 about_image" style="background-image: url( '{{ getAboutSectionImages(0) }}');"></div>
                    <div class="about_image2 about_image" style="background-image: url('{{ getAboutSectionImages(1) }}');"></div>
                </div>
                <div class="about-text">
                    <div class="section-head">
                        <h2>{{ settings()->about_title }}</h2>
                        <p>{!! settings()->about_description !!}</p>
                        <a href="#"><img src="assets/images/link_icon.svg" alt="icon">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="about-bottom-image">
                <div class="about_image3 about_image" style="background-image: url('{{ getAboutSectionImages(2) }}');"></div>
            </div>
        </div>
    </section> -->
<!-- Matrimonial Events -->
<section class="events-section">
    <div class="container">
        <div class="section-head">
            <h2>{{ settings()->events_title }}</h2>
            {!! settings()->events_description !!}
        </div>

        <div class="events-content flex">
            @if(count($events))
            @foreach($events as $K => $V)

            <div class="single-event">
                <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
                <div class="event_details">
                    <h4>{{ $V->title }}</h4>
                    <p>{!! truncatedStr($V->short_description) !!} </p>
                    <strong><a href="{{ url('events/'.$V->id) }}"><img src="assets/images/link_icon.svg" alt="icon">View details</a></strong>
                    <div class="event_info">
                        <span><img src="assets/images/calender.svg" alt="icon">{{ dateCustomFormat($V->event_date) }}</span>
                        <span><img src="assets/images/map.svg" alt="icon">({{ $V->location }}, {{ $V->country}} )</span>
                    </div>
                </div>
            </div>

            @endforeach
            @else
            <div class="coming_soon">
                <img src="{{ URL::asset('images/Coming_Soon.png')}}" alt="">
            </div>
            @endif
        </div>


        @if(count($events))
        <div class="events-link">
            <a href="{{ route('events') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Events</a>
        </div>
        @endif
        <div class="section-head">
            <h2>Our Past Events</h2>
        </div>
        <!-- Past Events -->
        <div class="owl-carousel events-section">
            <!-- <div class="owl-carousel members-slider"> -->
            @foreach($past_events as $K => $V)
            <div class="single-event-home">
                <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
                <div class="event_details resize">
                    <h4>{{ $V->title }}</h4>
                    <p>{!! truncatedStr($V->short_description) !!} </p>
                    <a href="{{ url('events/'.$V->id) }}"><img src="assets/images/link_icon.svg" alt="icon">View detail</a>
                    <div class="event_info">
                        <span><img src="assets/images/calender.svg" alt="icon">{{ dateCustomFormat($V->event_date) }}</span>
                        <span><img src="assets/images/map.svg" alt="icon">({{ $V->location }}, {{ $V->country}} )</span>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- </div> -->
        </div>

        @if(count($past_events))
        <div class="events-link">
            <a href="{{ route('past-events') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Events</a>
        </div>
        @endif
        <!-- End Past Events -->
    </div>

    <div class="owl-carousel events-section">
        <!-- <div class="owl-carousel members-slider"> -->
        @foreach($events as $K => $V)
        <div class="single-event-home">
            <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
            <div class="event_details resize">
                <h4>{{ $V->title }}</h4>
                <p>{!! truncatedStr($V->short_description) !!} </p>
                <a href="{{ url('events/'.$V->id) }}"><img src="assets/images/link_icon.svg" alt="icon">View detail</a>
                <div class="event_info">
                    <span><img src="assets/images/calender.svg" alt="icon">{{ dateCustomFormat($V->event_date) }}</span>
                    <span><img src="assets/images/map.svg" alt="icon">({{ $V->location }}, {{ $V->country}} )</span>
                </div>
            </div>
            @if($V->type == 1)
            <span class="tag">Upcoming</span>
            @endif
        </div>
        @endforeach
        <!-- </div> -->
    </div>

    @if(count($events))
    <div class="events-link">
        <a href="{{ route('events') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Events</a>
    </div>
    @endif

    <!-- Past Events -->
    <div class="owl-carousel events-section">
        <div class="owl-carousel members-slider">
            @foreach($past_events as $K => $V)
            <div class="single-event-home">
                <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
                <div class="event_details resize">
                    <h4>{{ $V->title }}</h4>
                    <p>{!! truncatedStr($V->short_description) !!} </p>
                    <a href="{{ url('events/'.$V->id) }}"><img src="assets/images/link_icon.svg" alt="icon">View detail</a>
                    <div class="event_info">
                        <span><img src="assets/images/calender.svg" alt="icon">{{ dateCustomFormat($V->event_date) }}</span>
                        <span><img src="assets/images/map.svg" alt="icon">({{ $V->location }}, {{ $V->country}} )</span>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- </div> -->
        </div>

        @if(count($past_events))
        <div class="events-link">
            <a href="{{ route('past-events') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Events</a>
        </div>
        @endif
        <!-- End Past Events -->
    </div>
    <!-- modal -->
    <!-- <div class="alert_popup">
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn">Close</button>
                        <a href="{{url('login')}}">Login</a>
                    </div>
                    <div class="modal-body">
                        <div class="icon-show">!</div>
                        <h2> Please Login</h2>
                        <p>Please login to view full profile of this member</p>
                        <div class="alert-action">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> -->

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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.custom_modal', function() {
            Swal.fire({
                title: 'Please Login',
                text: "Please login to view Full Profile Of This Member!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#21c2d6',
                cancelButtonColor: '#e7147b',
                confirmButtonText: '<a href="/login">Login</div>'
            });
        });
    });


    $('body').on('click', '.interest-request', function (e) {


        e.preventDefault();
        var id = $(this).data('memberid');
        var status = $(this).data('status');
        var checkLikeLimitCondition = $(this).data('checklikelimitcondition');

        if(checkLikeLimitCondition == 1)
        {
            $('#send-like').attr("data-memberid",id);
            var chatUrl = "{{ url('user/chats') }}";
            chatUrl = chatUrl+"?id="+id;
            var a = "window.location.href = '"+chatUrl+"'"
            $('#chatLink').attr('onclick',a);

            // onclick="window.location.href = 'https://ide.geeksforgeeks.org';"
        }

        showOverlayLoader();
        $.ajax({
            url: "{{ url('/user/send-interest-request') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: "post",
            data: {
                'member_interested_id': id,
                'status': status,
                'checkLikeLimitCondition':checkLikeLimitCondition
            },
            cache: false,

            success: function (data) {
                hideOverlayLoader();

                var data = JSON.parse(data);

                if (data.status == 1) {
                    // oTable.ajax.reload();
                    if(data.req_message != ''){
                        Swal.fire({
                            icon: 'info',
                            // title: 'Why wait?',

                            text:  data.req_message ,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:'OK',
                            confirmButtonColor: '#21c2d6',
                        });
                    }
                } else if(data.status == 0) {

                    Swal.fire({
                        icon: 'warning',
                        title: data.title,
                        text:   data.message,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },

                        showCancelButton: false,
                        focusConfirm: false,
                        confirmButtonText:'OK',
                        confirmButtonColor: '#21c2d6',
                    });
                    return false;
                } else if(data.status == 3) {
                    // alert('Update Plan')
                    $('#like_for_approval').modal('show');
                }
                else if(data.status == 5) {
                    $('#liked').modal('show');
                }
            }
        });
    });

    $('body').on('click', '.report-request', function (e) {
        var memberId = $(this).attr('data-memberid');
        $('#reportMemberId').val(memberId);
        $('#reportModal').modal('show');
    });

    $('#report-form').on('submit', function (e) {
        e.preventDefault();
        var _this = $(this);
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('/user/report-user') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type:"POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                hideOverlayLoader();
                $('#reportModal').modal('hide');
                var data = JSON.parse(data);

                if (data.status == 1) {
                    // oTable.ajax.reload();
                    if(data.req_message != ''){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Reported User',

                            text:  data.req_message ,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:
                                'Okay',
                            confirmButtonColor: '#21c2d6',
                        });
                    }
                } else if(data.status == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: data.title,

                        text:   data.message,
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
