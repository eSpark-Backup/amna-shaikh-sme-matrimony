@extends('app')
@section('title', 'Privacy Policy')
@section('style')
    <meta http-equiv="etag" content=""/>
    <meta property="og:title" content="SME"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://crzglobal.xyz/"/>
    <meta property="og:image" content="https://crzglobal.xyz/assets/images/logo.svg"/>
    <meta property="og:site_name" content="SME"/>
    <meta property="og:description" content="Smematrimony"/>
    
@endsection
@section('content')
        <section class="event_section" style="background-image: url('assets/images/event_dt.png');">
            <div class="events_overlay">
                <div class="container">
                    <div class="events_content">
                        <h2>Privacy Policy</h2>
                    </div>
                </div>
            </div>
        </section>
    <section class="events-section">
        <div class="container">
            
            <div class="events-content">
                {!! settings()->privacy_policy !!}
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