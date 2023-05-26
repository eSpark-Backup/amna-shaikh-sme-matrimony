$(document).ready(function(){
    // Chat mobile
    $('.chat-mobile span').click(function(){
        $('.chat-sidebar').toggleClass('active');
    });
    // Chat dots
    $('.chat-dots').click(function(){
        $('.chat-act').slideToggle();
    });
    // Filters
    $('.filters').click(function(){
        $('.filters-wrap').slideToggle();
    });
    // Mobile Menu
    $('.mobile-menu').click(function(){
        $('.site-menu').slideToggle();
        $(this).toggleClass('active');
    });
    // Slider
    $('.owl-carousel.hero-slider').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout:6000,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    $('.owl-carousel.members-slider').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        dots: false,
        responsive: {
            0: {
                items:1,
                nav:false
            },
            600: {
                items:3,
                nav:false
            },
            1000: {
                items:4,
                nav:false,
                
            }
        }
    });

    $('.owl-carousel.events-section').owlCarousel({
        loop: false,
        margin: 0,
        nav: false,
        autoplay: true,
        dots: false,
        responsive: {
            0: {
                items:1,
                nav:false
            },
            600: {
                items:2,
                nav:false
            },
            1000: {
                items:2,
                nav:false,
                
            }
        }
    });

});