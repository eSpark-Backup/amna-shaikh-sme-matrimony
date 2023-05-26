@extends('app')
@section('title', 'Email verification')
@section('content')
	<section class="event_section" style="background-image: url('assets/images/event_bg.png');">
        <div class="events_overlay">
            <div class="container">
                <div class="events_content">
                    {!! $message !!}
                    
                </div>
            </div>
        </div>
    </section> 
@endsection