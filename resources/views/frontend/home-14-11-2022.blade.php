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
                            <div class="hero-content">
                                <span class="heartic"><img src="assets/images/hearts.png" alt="icon"></span>
                                <span>Distracted by readable</span>
                                <h1>Choose a wife rather by your ear than your eye.</h1>
                                @auth('user')

                                @else
                                    <a href="{{ url('/login') }}">Login/Signup</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="item">
                    <div class="single-hero" style="background-image: url('assets/images/banner.png');">
                        <div class="hero-content">
                            <span class="heartic"><img src="assets/images/hearts.png" alt="icon"></span>
                            <span>Distracted by readable</span>
                            <h1>Choose a wife rather by your ear than your eye.</h1>
                            @auth('user')
                                    
                            @else
                                <a href="{{ url('/login') }}">Login/Signup</a>
                            @endauth
                        </div>
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
                {!! settings()->happy_couple_description !!}
            </div>
            <div class="couples-content">
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
            </div>
        </div>
    </section>
    <!-- Matrimonial Events -->
    <section class="events-section">
        <div class="container">
            <div class="section-head">
                <h2>{{ settings()->events_title }}</h2>
                {!! settings()->events_description !!}
            </div>
            
            <div class="events-content flex">
                @foreach($events as $K => $V)
                    <div class="single-event">
                        <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
                        <div class="event_details">
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
            </div>
            <div class="events-link">
                <a href="{{ route('events') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Events</a>
            </div>
        </div>
        <div class="bracelet_image"><img src="assets/images/bracelet_image.png" alt="image"></div>
    </section>
    <!-- Members -->
    <section class="members-section">
        <div class="members-content flex">
            <div class="members-text">
                <div class="section-head">
                    <h2>{{ settings()->members_title }}</h2>
                    {!! settings()->members_description !!}
                    <a href="{{ route('user.members') }}"><img src="assets/images/link_icon.svg" alt="icon">View All Members</a>
                </div>
            </div>
            <div class="members-image" style="background-image: url('assets/images/members_bg.png');">
            </div>
        </div>
        <div class="members-list">
            <div class="container">
                <div class="row">
                @foreach($members as $MI => $M)

                    <div class="col-md-3">
                        <div class="single-member">
                            <img class="member-image" src="{{ $M['profile_image'] }}" alt="">
                            <div class="member-info">
                                <h5>{{ $M['first_name'] }}</h5>
                                <div class="member-infos">
                                    <span><img src="assets/images/avatar.svg" alt="icon">{{ $M['occupation_id'] }}</span>
                                    <span><img src="{{asset('assets/images/map.svg') }}" alt="icon">({{ $M['country_id'] }})</span>
                                </div>
                                <a href="{{ url('user/members/'.$M['id']) }}">View Full Profile</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- About -->
    <section class="about-section">
        <div class="container">
            <div class="about-content flex">
                <div class="about-images">
                    <div class="about_image1 about_image" style="background-image: url( '{{ getAboutSectionImages(0) }}');"></div>
                    <div class="about_image2 about_image" style="background-image: url('{{ getAboutSectionImages(1) }}');"></div>
                </div>
                <div class="about-text">
                    <div class="section-head">
                        <h2>{{ settings()->about_title }}</h2>
                        {!! settings()->about_description !!}                        
                        <a href="#"><img src="assets/images/link_icon.svg" alt="icon">Register Now</a>
                    </div>
                </div>
            </div>
            <div class="about-bottom-image">
                <div class="about_image3 about_image" style="background-image: url('{{ getAboutSectionImages(2) }}');"></div>
            </div>
        </div>
    </section>
    
@endsection