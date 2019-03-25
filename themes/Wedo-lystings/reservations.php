<?php /* Template name: Reservations */
get_header();?>
<?php while(have_posts()): the_post();?>
<div id="pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/banner-image2.jpg" alt="image">
    <div class="container vh-center">
        <h2><?php the_title();?></h2>
    </div>
</div>
<div class="listing-wrapper">
    <div class="container-fluid">
        <div class="row same-height">
                <div class="col-md-3 col-sm-4 col" id="sidebar">
                    <?php do_action( 'woocommerce_account_navigation' );?>

                    </div>
                    <div class="col-md-9 col-sm-8 col" id="main">
                        <?php the_content();?>
                    </div>

                    </div>
                    </div>
                    </div>
<?php endwhile;?>
<?php get_footer();?>