@extends('app')
@section('title', 'Events')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
@endsection
@section('content')

    <main class="event_detail">
        <section class="event_section" style="background-image: url('assets/images/event_bg.png');">
            <div class="events_overlay">
                <div class="container">
                    <div class="events_content">
                        <h2>{{ $events->title }}</h2>
                        
                        <div class="">
                           
                            @if ($is_past_event != 1)
                                @if(isset($userDetail) && $userDetail->is_approved == 1)
                                    <a href="{{url('user/events/apply/'.$events->id )}}" class="btn-custom-secondary">Register Now</a>
                                @else
                                    @if(isset($userDetail) && $userDetail)
                                        
                                        <a href="#" class="btn-custom-secondary not-approved-popup" data-approved="{{ $userDetail->is_approved }}" data-status="{{ $userDetail->status }}">Register Now</a>
                                    @else
                                        <a href="#" class="btn-custom-secondary custom-login-popup">Register Now</a>
                                    @endif
                                @endif
                            @endif
                            <!-- <a href="#">Call us now</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="aboutEvent-section">
            <div class="container">
                <div class="section-head">
                    <h2>About {{ $events->title }} Event</h2>
                </div>
                <div class="events_center">
                    <p>{!! $events->short_description !!}</p>
                    <span class="separator"></span>
                    <p>{!! $events->long_description !!}</p>
                </div>
            </div>
        </section>
        <section class="video-section" style="margin-bottom:120px">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        @if(isset($events->event_video) && !empty($events->event_video))
                        <?php $vid = asset('storage/events/'.$events->event_video); ?>
                            <div class="video-content">
                                <div class="video">
                                    <!-- <iframe src="{{ $vid }}" id="video2" width="100%" height="350px" class="embed-responsive-item"  ></iframe> -->

                                    <object>
                                        <param  value="{{ $vid }}"></param>
                                        <embed src="{{ $vid }}" width="100%" height="350px"></embed>
                                    </object>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        @if(isset($events->gallary) && !empty($events->gallary))
                            <div class="video-content row">
                                @php $gellary = explode(',',$events->gallary)  @endphp
                                @foreach($gellary as $K => $V)
                                    @if($K == 30)
                                        <?php break; ?>
                                    @endif
                                <div class="col-md-3 text-center single_photo">
                                    <a href="{{ getImage($V,'event_detail') }}" data-fancybox="gallery"><img src="{{ getImage($V,'event_detail') }}" alt="image"></a>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                </div>
                <div class="">
                    @if ($is_past_event != 1)
                        @if(isset($userDetail) && $userDetail->is_approved == 1)
                            <a href="{{url('user/events/apply/'.$events->id )}}" class="btn-custom-primary">Register Now</a>
                        @else
                            @if(isset($userDetail) && $userDetail)
                                <a href="#" class="btn-custom-primary not-approved-popup" data-approved="{{ $userDetail->is_approved }}" data-status="{{ $userDetail->status }}">Register Now</a>
                            @else
                                <a href="#" class="btn-custom-primary custom-login-popup" >Register Now</a>
                            @endif
                        @endif
                    @endif
                    <!-- <a href="#">Call us now</a> -->
                </div>
            </div>

        </section>
        
        @if(count($past_events) > 0)
            <!-- <section class="events-section past_events">
                <div class="container">
                    <div class="section-head">
                        <h2>Our Past Events</h2>
                    </div>
                    <div class="events-content flex">
                        @foreach($past_events as $K => $V)
                            <div class="single-event">
                                <div class="event_image" style="background-image: url('{{ getImage($V->gallary,'events') }}');"></div>
                                <div class="event_details">
                                    <h4>{{ $V->title }}</h4>
                                    <p>{!! truncatedStr($V->short_description) !!} </p>
                                    <a href="#"><img src="{{asset('assets/images/link_icon.svg')}}" alt="icon">View detail</a>
                                    <div class="event_info">
                                        <span><img src="{{asset('assets/images/calender.svg')}}" alt="icon">{{ dateCustomFormat($V->event_date) }}</span>
                                        <span><img src="{{asset('assets/images/map.svg')}}" alt="icon">({{ $V->location }}, {{ $V->country}} )</span>
                                    </div>
                                </div>
                                @if($V->type == 1)
                                    <span class="tag">Upcoming</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section> -->
        @endif
    </main>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            //toggle the component with class accordion_body
            $(".accordion_head").click(function() {
                $('.accordion_head').each(function() {
                    $(this).parent().removeClass('active');
                });
                $(this).parent().addClass('active');
                if ($('.accordion_body').is(':visible')) {
                    $(".accordion_body").slideUp(300);
                    $(".plusminus").text('+');
                }
                if ($(this).next(".accordion_body").is(':visible')) {
                    $(this).next(".accordion_body").slideUp(300);
                    $(this).find(".plusminus").text('+');
                    $('.tab_outer.active').removeClass('active');
                } else {
                    $(this).next(".accordion_body").slideDown(300);
                    $(this).find(".plusminus").text('-');
                }
            });
            $('.custom-login-popup').on('click',function(){
                Swal.fire({
                    icon: 'warning',
                    title: "Please Login",
                  
                    text:   "Please login to complete registration for this event !",
                  
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                    '<a href="/login" target="_blank"> Login </a>',
                  
                    cancelButtonText:'Cancel',
                    cancelButtonColor: '#e7147b',
                    confirmButtonColor: '#21c2d6',
                });
            });
            $('.not-approved-popup').on('click',function(){
                var apr = $(this).data('approved');
                var sts = $(this).data('status');
                if (sts == 4) {
                    Swal.fire({
                      icon: 'warning',
                      title: "Account is under admin approval",
                      
                      text:   "Your account is under admin approval. You'll not be able to perform any actions until your profile is approved. Thanks for your patience.",

                        showCancelButton: true,
                        focusConfirm: false,
                        focusCancel: false,
                        reverseButtons: true,
                        confirmButtonText:
                        '<a href="/user/edit-profile" target="_blank"> GoTo Profile </a>',
                      
                        cancelButtonText:'Cancel',
                        cancelButtonColor: '#e7147b',
                        confirmButtonColor: '#21c2d6',
                    });
                }else{
                    Swal.fire({
                      icon: 'warning',
                      title: "Verification required",
                      
                      text:   "You can't perform any action unless you submit your profile to admin for approval. ",

                        showCancelButton: true,
                        focusConfirm: false,
                        reverseButtons: true,
                        cancelButtonText:'Cancel',
                        confirmButtonText:
                        '<a href="/user/edit-profile" target="_blank"> GoTo Profile </a>',
                        cancelButtonColor: '#e7147b',
                        confirmButtonColor: '#21c2d6',
                        reverseButtons: true
                    });
                }
                
            });
        });
    </script>
@endsection