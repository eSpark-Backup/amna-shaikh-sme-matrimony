<!-- Contact Section -->
@if(!(isset($page) && $page == 'chat'))
    <section class="contact-section" style="background-image: url('{{ asset('assets/images/contact_image.png')}}');">
        <div class="contact-overlay">
            <div class="container">
                <div class="contact-header">
                    <span><img src="{{ asset('assets/images/heart-whites.svg')}}" alt="hearts"></span>                
                    <h2>Please contact us if you have any questions</h2>
                </div>
                <div class="contact-content">
                    <div class="contact-details">
                        <div class="contact-col">
                            <h4><img src="{{ asset('assets/images/phone.svg') }}" alt="icon">Give Us A Call</h4>
                            <span><a href="tel:{{ settings()->phone }}">{{ settings()->phone }}</a></span>
                        </div>
                        <div class="contact-col">
                            <h4><img src="{{ asset('assets/images/mail.svg')}}" alt="icon">Send Us Email</h4>
                            <span><a href="mailto:{{ settings()->email }}">{{ settings()->email }}</a></span>
                        </div>
                        <div class="contact-col">
                            <h4><img src="{{ asset('assets/images/marker.svg') }}" alt="icon">Head Office</h4>
                            <?php $address = urlencode(settings()->address);?>
                            <span><a href="http://maps.google.com/maps?f=d&daddr={{$address}}&nav=1" target="_blank" >{{ settings()->address }}</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!--Footer-->
<footer>
    <div class="container">
       
            <div class="footer-top">
                <div class="ft-logo">
                    <a href="#"><img src="{{ asset('assets/images/logo.svg')}}" alt="logo"></a>
                </div>
                <div class="ft-menu">
                    <nav>
                        <ul>
                            <li><a href="{{ route('home')}}">Home</a></li>
                            <li><a href="{{ url('events') }}">Matrimonial Events</a></li>
                            <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ url('terms-conditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        <div class="ft-bottom">
            <span>Copyright © {{ date('Y') }} smematrimony.com - All Rights Reserved.</span>
            <div class="ft-social">
                <ul>
                    <li><a href="{{ settings()->facebook_link }}" target="_blank"><i class="fa fa-facebook" ></i></a></li>
                    <li><a href="{{ settings()->youtube_link }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="{{ settings()->instagram_link }}" target="_blank"><i class="fa fa-instagram" ></i></a></li>
                    <li><a href="https://api.whatsapp.com/send/?phone={{ urlencode(str_replace(' ', '', settings()->whatsapp)) }}&text&type=phone_number&app_absent=0" target="_blank" ><i class="fa fa-whatsapp" ></i></a></li>
                    <li><a href="{{ settings()->meetup_link }}" target="_blank"><i class="fa fa-meetup"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
@endif