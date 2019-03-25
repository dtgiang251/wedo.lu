jQuery(document).ready(function() {
    jQuery(".widget h2").click(function() {
        jQuery(this).toggleClass("open");
    });
    jQuery('.same-height .col').matchHeight();
    jQuery('.page-template-quote-php .form2 .col label').matchHeight();
});