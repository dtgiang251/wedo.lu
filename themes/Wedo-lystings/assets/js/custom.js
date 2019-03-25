/*****  NavBar ******/

$(document).ready(function() {
	$(window).scrollTop()>=50?$(".navbar").addClass("change"): $(".navbar").removeClass("change")
}
),
$(window).scroll(function() {
	$(window).scrollTop()>=50?$(".navbar").addClass("change"): $(".navbar").removeClass("change")
}
),

/****Menu Icon ********/
    
 'use strict';
    (function() {
      var body = document.body;
      var burgerMenu = document.getElementsByClassName('b-menu')[0];
      var burgerContain = document.getElementsByClassName('b-container')[0];
      var burgerNav = document.getElementsByClassName('navbar-nav')[0];

      burgerMenu.addEventListener('click', function toggleClasses() {
        [body, burgerContain, burgerNav].forEach(function (el) {
          el.classList.toggle('open');
        });
      }, false);
    })();

/*****Top Button *****/

$(window).scroll(function() {
	$(window).scrollTop()>100?$("#top-button").fadeIn(): $("#top-button").fadeOut()
}
),
$(document).ready(function() {
	$("#top-button").click(function(e) {
		return e.preventDefault(), $("html, body").animate( {
			scrollTop: 0
		}
		,
		"slow"),
		!1
	}
	)
}
);

/**************Demand***************/
    $(document).ready(function() {
        $('#popularities').owlCarousel({
            loop: true
            , margin: 30
            , responsiveClass: true
            , animateOut: 'slideOutDown'
            , animateIn: 'flipInX'
            , nav: true
            , navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"]
            , responsive: {
                0: {
                    items: 1
                    , stagePadding: 0
                    , margin: 0
                }
                , 575: {
                    items: 1    
                    , stagePadding: 150
                }
                , 768: {
                    items: 2
                    , stagePadding: 60
                }
                , 991: {
                    items: 2
                    , stagePadding: 80
                }
                , 1199: {
                    items: 3    
                    , stagePadding: 80
                }
                , 1571: {
                    items: 2
                    , stagePadding: 110
                }
                , 1870: {
                    items: 2
                    , stagePadding: 150
                }
            }
        });
    });

    $('.play').on('click',function(){
        owl.trigger('play.owl.autoplay',[1000])
    });
    $('.stop').on('click',function(){
        owl.trigger('stop.owl.autoplay')
});



//    $(document).ready(function() {
// 
//      $("#popularities").owlCarousel({
//          loop:true,
//          responsiveClass:true,
//          margin: 30,
//          nav: true,
//          navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
//          
//
//          responsive:{
//              0:{
//                  items:1,
//                   margin:0
//              },
//              576:{
//                items:2,
//                autoWidth:false,
//                margin:50
//              },
//              992:{
//                  items:2,
//                  autoWidth:true,
//                  margin:50
//              },
//              1200:{
//                  items:4,
//                  autoWidth:true,
//                  margin:30,
//                  stagePadding: 100,
//                  nav: true
//              }
//          }
//
//        });   
//     });
//
//    $('.play').on('click',function(){
//        owl.trigger('play.owl.autoplay',[1000])
//    });
//    $('.stop').on('click',function(){
//        owl.trigger('stop.owl.autoplay')
//    });

var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows : true,
      },
      pagination: {
        el: '.swiper-pagination',
      },
    });
        