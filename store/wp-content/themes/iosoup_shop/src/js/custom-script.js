;
/*  Resized function
============================================= */
    var waitForFinalEvent = (function () {
        var timers = {};
        return function (callback, ms, uniqueId) {
            if (!uniqueId) {
                uniqueId = "Don't call this twice without a uniqueId";
            }
            if (timers[uniqueId]) {
                clearTimeout (timers[uniqueId]);
            }
            timers[uniqueId] = setTimeout(callback, ms);
        };
    })();


jQuery(document).ready(function($) {

    /*  Window resize function call
    ============================================= */
     $(window).resize(function () {
        waitForFinalEvent(function(){
           
            //responsiveNav();

        }, 500, "some unique string");
    });

    /*  Window scroll function
    ============================================= */
    $(window).scroll(function() {
         var scroll = $(window).scrollTop();

        if (scroll > 700) {
            $('.totop').css('bottom', '55px');
        } else {
            $('.totop').css('bottom', '-50px');
        }          
    });

    $('.totop').click(function(){
        $('html,body').animate({
            scrollTop: 0
        }, 1500);
    })


    /* Smootth Scroll
    ============================================= */
    //    $('.navbar-collapse a').click(function() {
    //     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    //       var target = $(this.hash);
    //       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    //       if (target.length) {
    //         var offsetTop = 70;
    //         if($(window).width() < 768 ){
    //             offsetTop = 50;
    //         }

    //         //$("body").scrollspy({target: "#navigation", offset:offsetTop + 34});

    //         $('html,body').animate({
    //           scrollTop: target.offset().top - offsetTop
    //         }, 1000);
    //         return false;
    //       }
    //     }
    // });


    /*  Mobile Navigation Height issue fix
    ============================================= */
    // function responsiveNav(){
    //     if($(window).width() < 750) {
    //         var screenHeight = $(window).height() - 70;
    //         var navHeight = $('.navbar').height();
    //         $('.navbar-nav').css({
    //             'max-height': screenHeight,
    //             'overflow-y': 'scroll'
    //         });
    //     }
    // };
    // responsiveNav();



    $('.btn-apply').click(function(){        
        $('html, body').animate({
            scrollTop: $("#apply-job-form").offset().top
        }, 1500);
    });


    /* Related Item slider
    ============================================= */
    $('.testimonail-slider').slick({
        dots: false,
        infinite: true,
        autoplay: true,
        arrows: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1
    });



    //sidebar position
    var sidebarPosition = function() {
        var $sidebar   = $(".sidebar-accordion"), 
            $window    = $(window),
            topPadding = 15;
    
        if($sidebar.length){
            var offset     = $sidebar.offset();
            $window.scroll(function() {
                if ($window.scrollTop() > offset.top) {
                    $sidebar.stop().animate({
                        marginTop: $window.scrollTop() - offset.top + topPadding
                    });
                } else {
                    $sidebar.stop().animate({
                        marginTop: 0
                    });
                }
            }); 
        }       
    };

    if($(window).width() > 768) {
        sidebarPosition();
    }


}); //READY FUNCTION



jQuery(window).on('load', function(){

    //wow js
    var wow = new WOW(
      {
          boxClass:     'wow',      // animated element css class (default is wow)
          animateClass: 'animated', // animation css class (default is animated)
          offset:       40,          // distance to the element when triggering the animation (default is 0)
          mobile:       false,       // trigger animations on mobile devices (default is true)
          live:         true,       // act on asynchronously loaded content (default is true)
          callback:     function(box) {
          // the callback is fired every time an animation is started
          // the argument that is passed in is the DOM node being animated
          },
          scrollContainer: null // optional scroll container selector, otherwise use window
      }
    );
     <!--[if !IE]> -->
        wow.init();
    <!-- <![endif]-->

});
