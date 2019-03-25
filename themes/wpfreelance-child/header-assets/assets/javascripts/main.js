jQuery(".menu-btn").click(function(){
  jQuery(this).toggleClass('active');
  jQuery('#main-navigation').toggleClass('open');
  jQuery('body').toggleClass('nav-open');
  return false;
});

jQuery("#main-navigation .dropdown > a").click(function(){
    jQuery("#main-navigation .dropdown ul").slideToggle("slow");
});

jQuery(".language-selector span").click(function(){
  jQuery(this).parents(".language-selector").find("ul").slideToggle(400);
});

jQuery(document).ready(function(){
  jQuery(".modal-btn").click(function(){
    jQuery("#sign-in-modal").fadeIn(300);
  });
});

