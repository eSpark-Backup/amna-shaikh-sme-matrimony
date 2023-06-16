@extends('app')
@section('title', 'Contact Us')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">

@endsection
@section('content')
	<!-- Accounts -->
    <section class="event_section" style="background-image: url('assets/images/event_dt.png');">
        <div class="events_overlay">
            <div class="container">
                <div class="events_content">
                    <h2>Contact Us</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="user-profile-section prersonal-prof">
        <div class="container">
        	<div class="row">
                <div class="col-lg-4 user-profile-left mt-5 mb-5">
               		<div class="profile-main-bodyPP">
                        <h4>SME Matrimony</h4>
                        <h5><img src="https://crzglobal.xyz/assets/images/marker.svg" alt="icon">Head Office</h5>
                        <span>{{ settings()->address }}</span>
                        <h5><img src="https://crzglobal.xyz/assets/images/marker.svg" alt="icon">Give Us A Call</h5>
                        <span><a href="tel:{{ settings()->phone }}">{{ settings()->phone }}</a></span>
                        <h5><img src="https://crzglobal.xyz/assets/images/marker.svg" alt="icon">Send Us Email</h5>
                        <span><a href="mailto:{{ settings()->email }}"> {{ settings()->email }} </a></span>
                    </div>
                </div>
                <div class="col-lg-8 user-profile-left mt-5 mb-5">
                    <div class="profile-main-body">
                        <h5>Your Details</h5>
                        @include('../admin.message')
                        <form action="{{ route('send-contact-us') }}" method="POST" id="contactus-form" novalidate="novalidate">
                            @csrf
                            <div class="fields-row">
                                <div class="field">
                                    <label for="first_name">First Name*</label>
                                    <input type="text" name="first_name" id="first_name" data-parsley-minlength="2" data-parsley-pattern="^[A-Za-z ]+$" data-parsley-pattern-message="This field is filled only with alphabets and space." class="required" value="">
                                </div>
                                <div class="field">
                                    <label for="last_name">Last Name*</label>
                                    <input type="text" name="last_name" data-parsley-minlength="2" data-parsley-pattern="^[A-Za-z ]+$" data-parsley-pattern-message="This field is filled only with alphabets and space." class="required" id="last_name" value=""> 
                                </div>
                            </div>
                            <div class="fields-row">
                                <div class="field">
                                    <label for="email">Enter Email*</label>
                                    <input type="email" placeholder="" name="email" id="email" class="required" value="">
                                </div>
                                <div class="field">
                                    <label for="mobile">Mobile*</label>
                                    <input type="tel" placeholder="" name="mobile" data-parsley-pattern="^[0-9 +-]{8,17}$" data-parsley-pattern-message="Phone number should contain 8 to 17 digits only." id="mobile" class="required" value="">
                                </div>
                            </div>
                            <div class="field">
                                <label for="message">Message*</label>
                                <textarea name="message" class="form-control required" id="message" placeholder="Message" rows="8"></textarea>
                            </div>
                            <div class="field-btn">
                                <button class="btn btn-custom-primary" type="submit ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
        	</div>   
        </div>
    </section>
@endsection

@section('js')
	<script src="{{ asset('admin-assets/assets/vendor/jquery.validate.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
	
    <script>
        $(function(){
            $('#contactus-form').parsley();
            $('#contactus-form').validate();
        });
    </script>
@endsection
