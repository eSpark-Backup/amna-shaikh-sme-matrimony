@extends('app')
@section('title', 'Events')
@section('content')
    <!-- Events Banner -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-content">
                <form action="{{ url('events') }}" method="get">
                    {{ csrf_field() }}
                    @if (session()->get('flash_danger'))
                        <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        @if(is_array(json_decode(session()->get('flash_danger'), true)))
                            {!! implode('', session()->get('flash_danger')->all(':message<br/>')) !!}
                        @else
                            {!! session()->get('flash_danger') !!}
                        @endif
                    </div>
                    @endif
                    <div class="event-filter-search">
                        <label for="">Search</label>
                        <input type="text" name="title" value="{{ old('title', $title) }}" placeholder="Search by event title">
                    </div>
                    <div class="filter-btn">
                        <button type="submit"><img src="{{asset('assets/images/srchh.png')}}" alt="icon">Search</button>
                    </div>
                </form>
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
                            @if($is_past_event != 1)
                                <span class="tag">Upcoming</span>
                            @endif
                        </div>

                    @endforeach
                @else
                    <div class="data_not_found">
                        <img src="{{ URL::asset('images/Data_not_found.png')}}" alt="">
                    </div>
                @endif
            </div>
            
            @if(count($past_events) > 0)
                <section class="events-section past_events">
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
                                        <a href="{{ url('events/'.$V->id) }}"><img src="{{asset('assets/images/link_icon.svg')}}" alt="icon">View detail</a>
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
                </section>
            @endif
            
           
        </div>
        
    </section>
    
@endsection

@section('js')
	<script type="text/javascript">
        $(document).ready(function() {
            //toggle the component with class accordion_body
           
        });
    </script>
@endsection