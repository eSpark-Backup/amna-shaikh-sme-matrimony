@extends('app')
@section('title', 'Terms & Conditions')
@section('content')
        <section class="event_section" style="background-image: url('assets/images/event_dt.png');">
            <div class="events_overlay">
                <div class="container">
                    <div class="events_content">
                        <h2>Terms & Conditions</h2>
                    </div>
                </div>
            </div>
        </section>
    <section class="events-section">
        <div class="container">

            <div class="events-content">
                {!! settings()->terms_condition !!}
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