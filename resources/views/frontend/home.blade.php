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
                    <a href="{{ url('/login') }}" class="btn-custom-primary">Register / Login</a>
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
                    <a href="{{ url('/login') }}" class="btn-custom-primary">Register / Login</a>
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
                    <div class="story_details"> <a href="{{ url('/stories/'.$V['id']) }}">
                            <!-- <img src="assets/images/link_icon.svg" alt="icon"> -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="26" viewBox="0 0 31 26" fill="none">
                                <style xmlns="" class="adjust-screen-brightness" media="screen">
                                    html::before {
                                        content: " ";
                                        z-index: 2147483647;
                                        pointer-events: none;
                                        position: fixed;
                                        left: 0;
                                        top: 0;
                                        width: 100vw;
                                        height: 100vh;
                                        background-color: rgba(0, 0, 0, 0.35);
                                    }
                                </style>
                                <path d="M20.5514 19.651C18.7409 21.8923 16.0356 23.3996 12.934 23.6038C7.04128 23.9917 1.94978 19.5292 1.56183 13.6365C1.17387 7.74379 5.63637 2.6523 11.5291 2.26434C14.9418 2.03966 18.0858 3.44185 20.203 5.80654" stroke="#04ABCE" stroke-width="3" />
                                <g clip-path="url(#clip0_334_231)">
                                    <path d="M25.3125 9.45703C25.0686 9.45703 24.8173 9.54353 24.6211 9.72363L26.0043 16.2934L28.832 13.7013C29.2434 13.3242 29.2441 12.693 28.8316 12.3157C28.8316 12.3157 28.8316 12.3157 28.8315 12.3156L26.0039 9.72363C25.8078 9.54389 25.557 9.45703 25.3125 9.45703ZM24.6207 9.72406L24.5782 9.76301C24.1669 10.14 24.166 10.771 24.5782 11.1483L24.6207 9.72406ZM24.5786 11.1487L25.5623 12.0504H20.3125C19.8022 12.0504 19.3125 12.4395 19.3125 13.0087C19.3125 13.5779 19.8022 13.967 20.3125 13.967H25.5623L24.5782 14.8691C24.1669 15.2461 24.166 15.8771 24.5782 16.2544L24.5786 11.1487ZM24.5786 16.2548L24.6211 16.2938C25.0074 16.6479 25.6173 16.6486 26.0039 16.2938L24.5786 16.2548Z" fill="rgb(46, 117, 132)" stroke="#04ABCE" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_334_231">
                                        <rect width="12" height="11" fill="white" transform="translate(18.3125 7.50781)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            View Story</a></div>
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
                            <h5>{{ $M['first_name'] }}</h5>
                            <div class="member-infos">
                                <span><img src="assets/images/avatar.svg" alt="icon">{{ $M['occupation_id'] }}</span>
                                <span><img src="{{asset('assets/images/map.svg') }}" alt="icon">({{ $M['country_id'] }})</span>
                            </div>

                            @auth('user')
                            <a href="{{ url('user/members/'.$M['id']) }}" class="btn-custom-primary">View Full Profile</a>

                            @else
                            <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" onclick="openLoginModel()">View Full Profile</a> -->
                            <a href="javascript:void(0);" class="custom_modal btn-custom-primary">View Full Profile</a>
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
                    <a href="{{ url('/login') }}" class="btn-custom-primary">Register / Login</a>
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
            <p>{!! settings()->events_description !!}</p>
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
    <!-- modal -->
    <div class="alert_popup">
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="icon-show">!</div>
                        <h2> Please Login</h2>
                        <p>Please Login To View Full Profile Of This Member</p>
                        <div class="alert-action">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{url('login')}}">Login</a>
                        <button type="button" class="btn">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>



@endsection
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('body').on('click', '.custom_modal', function() {
            Swal.fire({
                title: 'Please Login',
                text: "Please Login To View Full Profile Of This Member!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#21c2d6',
                cancelButtonColor: '#e7147b',
                confirmButtonText: '<a href="/login">Login</div>'
            });
        });
    });
</script>
@endsection