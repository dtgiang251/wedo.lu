<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/banner-image2.jpg" alt="image">
    <div class="container vh-center">
<?php 	if ( is_wc_endpoint_url( 'my-listings' ) && in_the_loop() ) { // add your endpoint urls
		$title =  __( 'My content', 'wedo-listing' ); // change your entry-title
	}
	elseif ( is_wc_endpoint_url( 'dashboard' ) && in_the_loop() ) {
		$title = __( 'My Account', 'my-listing' );
	}
	elseif ( is_wc_endpoint_url( 'my-bookmarks' ) && in_the_loop() ) {
		$title = __( 'Favorites', 'wedo-listing' ); 
    }
    elseif ( is_wc_endpoint_url( 'my-bookmarks' ) && in_the_loop() ) {
		$title = __( 'Favorites', 'wedo-listing' ); 
    }
    elseif ( is_wc_endpoint_url( 'subscriptions' )  ) {
		$title = __( 'My subscription', 'wedo-listing' ); 
    }
    elseif ( is_wc_endpoint_url( 'edit-address' )  ) {
		$title = __( 'Addresses', 'wedo-listing' );
    }
    elseif ( is_wc_endpoint_url( 'edit-account' ) && in_the_loop() ) {
		$title = __( 'Account Details', 'wedo-listing' );
	} else {
		$title = get_the_title();
	}
?>
        <h2><?php echo $title;?></h2>
    </div>
</div>
<div class="listing-wrapper">
    <div class="container-fluid">
        <div class="row same-height">
                <div class="col-md-3 col-sm-4 col" id="sidebar">
<?php 
wc_print_notices();

/**
 * My Account navigation.
 * @since 2.6.0
 */

do_action( 'woocommerce_account_navigation' ); ?>
</div>
<div class="col-md-9 col-sm-8 col" id="main">
<div class="my-listings">

<div class="woocommerce-MyAccount-content">
	<?php
		/**
		 * My Account content.
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
	?>
</div>
</div>
</div>
</div>
</div>
</div>
