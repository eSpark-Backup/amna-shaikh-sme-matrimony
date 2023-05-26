@extends('app')
@section('title', 'Stories')
@section('content')
        <section class="event_section" style="background-image: url('assets/images/event_dt.png');">
            <div class="events_overlay">
                <div class="container">
                    <div class="events_content">
                        <h2>Our Success Stories</h2>
                    </div>
                </div>
            </div>
        </section>
    <section class="events-section">
        <div class="container">
            <div class="section-head">
                <h2>{{ settings()->happy_couple_title }} </h2>
                {!! settings()->happy_couple_description !!}
            </div>
            <div class="events-content flex">
                @foreach($stories as $K => $V)
                    <div class="single-event">

                        <div class="event_image" style="background-image: url('{{ getImage($V->image,"stories") }}' );">
                        </div>

                        <div class="event_details">
                            <h4>{{ $V->title }}</h4>
                           

                            <a href="{{ url('/stories/'.$V->id) }}">
                                <img src="assets/images/link_icon.svg" alt="icon">View detail
                            </a>

                            <div class="event_info">
                                <span><img src="assets/images/calender.svg" alt="icon">{{ dateCustomFormat($V->created_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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