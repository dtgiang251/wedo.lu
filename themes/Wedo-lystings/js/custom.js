(function ($) {
    "use strict";
	
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
	
	$('.cat-main-list .cat-title').click(function(e){
		if( $(window).width() <= 575 ) {
			$(this).next().toggleClass('open');
			$(this).toggleClass('open');
		}
	});

})(jQuery);
