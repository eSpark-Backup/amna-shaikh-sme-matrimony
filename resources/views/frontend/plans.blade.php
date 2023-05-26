@extends('app')
@section('title', 'Plans')
@section('content')
    <main class="plansMain">
        <section class="event_section" style="background-image: url('assets/images/event_dt.png');">
            <div class="events_overlay">
                <div class="container">
                    <div class="events_content">
                        <h2>Choose your package</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="plans-section">
            <div class="container">
                <div class="plans-row flex">
                    @foreach($plans as $K => $V)
                        <?php
                            $plan = '';
                            if ($K == 0) {
                                // code...
                                $plan = 'plan1';
                            }elseif ($K == 1) {
                                $plan = 'plan2';
                            }elseif ($K == 2) {
                                $plan = 'plan3';
                            }
                        ?>
                        <div class="single-plan">
                            <div class=" {{ $plan }}">

                                <!-- <?php if ($K == 1) { ?>
                                    <div class="most_popular">
                                        <span class="btn_popular">Most Popular</span>
                                    </div>
                                <?php } ?> -->
                                <div class="plan_head_main">
                                    <div class="plan-header">
                                        <h5>{{ $V->name }}</h5>
                                        <p>{{ $V->description }}</p>
                                        
                                    </div>
                                    <div class="plan_price_meta">
                                        <div class="bottom-line">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="906" height="418.089" viewBox="0 0 906 418.089">
                                              <defs>
                                                <filter id="shape" x="0" y="0" width="906" height="418.089" filterUnits="userSpaceOnUse">
                                                  <feOffset dy="-36" input="SourceAlpha"/>
                                                  <feGaussianBlur stdDeviation="40" result="blur"/>
                                                  <feFlood flood-opacity="0.059"/>
                                                  <feComposite operator="in" in2="blur"/>
                                                  <feComposite in="SourceGraphic"/>
                                                </filter>
                                              </defs>
                                              <g transform="matrix(1, 0, 0, 1, 0, 0)" filter="url(#shape)">
                                                <path id="shape-2" data-name="shape" d="M137,0H529c37,0,56.716,16.783,67,41.563l70,136.526H0L69,40.563C77.829,18.032,100,0,137,0Z" transform="translate(120 156)" fill="#fff"/>
                                              </g>
                                            </svg>


                                            <span><span>$</span><span class="price_bold">{{ $V->price }}</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="plan-body">
                                    <ul>
                                        <li>
                                            {{ $V->period }} Days
                                        </li>
                                        <li><strong>{{ $V->instant_messages_count }} </strong>Instant Count Message <span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">Number of instant messages.</span></span></li>

                                            @if(isset($V->features) && !empty($V->features))
                                                @foreach(json_decode($V->features) as $F => $FK )
                                                    <li> {{ $FK }} <span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">{{ $FK }}</span></span> </li>
                                                @endforeach
                                        
                                            @endif

                                        

                                        <!-- <li>Unlimited Messages <span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">You can send unlimited messages</span></span></li>
                                        <li>Verified Profiles <span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">Verified Profiles</span></span></li>
                                        <li>Unlimited Swipes<span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">Unlimited Swipes</span></span></li>
                                        <li>Ad Free <span class="tooltip-wrap"><img src="{{ asset('assets/images/info_icon.png') }}" alt="icon"> <span class="tooltip-text">Ad Free</span></span></li> -->
                                       
                                    </ul>
                                </div>
                                <div class="plan-footer">

                                    @if (isset($redirect_url) && $redirect_url)
                                        <a href="{{ url('/user/plans/buy/'.$V->id).'?redirect_url='.$redirect_url }}" >Buy Now</a>

                                    @else
                                        <a href="{{ url('/user/plans/buy/'.$V->id) }}" >Buy Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    

                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')
	<script type="text/javascript">
        $(document).ready(function() {
            //toggle the component with class accordion_body
           
        });
    </script>
@endsection