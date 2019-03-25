jQuery(window).load(function() {
    jQuery('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '.slider-nav',
        prevArrow: '<a href="#" class="prev"><i aria-hidden="true" class="fa fa-angle-left"></i></a>',
        nextArrow: '<a href="#" class="next"><i aria-hidden="true" class="fa fa-angle-right"></i></a>',
      });

      jQuery('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        arrows: false,
        vertical: true
      });

      jQuery('.same-height .col').matchHeight(); 
      jQuery('.carousel-list > li').matchHeight(); 
      jQuery('.carousel-list2 li').matchHeight(); 
      jQuery('.categories ul > li').matchHeight(); 

          jQuery('.craftsmen .card').matchHeight(); 
          jQuery('.craftsmen .card .card-description').matchHeight(); 
          jQuery('.offers .card').matchHeight(); 
  
      jQuery(".view-more-btn").click(function(event){
        jQuery(".view-more-btn a").toggleClass("open");
        jQuery(".view-more-btn + ul").fadeToggle("slow", "linear");
        event.preventDefault();
    });

    
  
    jQuery('.carousel ul').carouFredSel({
      
      responsive: true,
      items:
      {
          width: 320,
          height:467,
          visible:
              {
                  min: 1,
                  max: 3
              }
      },
      scroll: {
        items: 1,
        duration: 500,
        timeoutDuration: 300,
      },
      auto: false,
      circular: false,
      prev: ".carousel .pagination .prev-btn",
      next: ".carousel .pagination .next-btn"
    });
  
    jQuery('.carousel2 ul').carouFredSel({
      responsive: true,
      items:
      {
          width: 320,
          visible:
              {
                  min: 1,
                  max: 3
              }
      },
      scroll : {
        items:
        {
            width: 900,
            visible:
                {
                    min: 1,
                    max: 3
                }
        },
        duration        : 500,
        timeoutDuration: 300
    },



      auto: false,
      circular: false,
      prev: ".carousel2 .pagination .prev-btn",
      next: ".carousel2 .pagination .next-btn"
    });
  
    jQuery('.blog-wrapper ul').carouFredSel({
      responsive: true,
      items:
      {
          visible:
              {
                  min: 1,
                  max: 1
              } 
      },
      scroll: {
        items: 1,
        duration: 500,
        timeoutDuration: 300,
      },
      auto: false,
      circular: false,
      prev: ".blog-wrapper .pagination .prev-btn",
      next: ".blog-wrapper .pagination .next-btn"
    });
  
  
  
  
    jQuery('#slideshow-secondary').slick({
      arrows: false,
      autoplay: true,     
      autoplaySpeed: 5000,
  
   });

 



 
});



  jQuery(document).ready(function() {
      jQuery(".single-job_listing .tabs-menu a").click(function(event) {
          event.preventDefault();
          jQuery(this).parent().addClass("current");
          jQuery(this).parent().siblings().removeClass("current");
          var tab = jQuery(this).attr("href");
          jQuery(".single-job_listing .tab-content").not(tab).css("display", "none");
          jQuery(tab).fadeIn();
      });

      jQuery(".svg").svgInject(function() {
        // Injection complete
      });
      var owl = jQuery(".owl-carousel");
    
     owl.owlCarousel({
        items: 3,
        itemsCustom : [
            [0, 1],
            [767, 2],
            [992, 2],
            [1200, 3],
        ],
        navigation : true,
        slideSpeed:500,
        singleItem:false,
        slideBy: 4,
        autoWidth:true,
        responsive: true,
     });
    
     jQuery( ".owl-prev").html('<i class="fa fa-angle-left"></i>');
     jQuery( ".owl-next").html('<i class="fa fa-angle-right"></i>');
     jQuery(".language-selector span").click(function(){
        jQuery(".language-selector ul").slideToggle(400);
      });
    });