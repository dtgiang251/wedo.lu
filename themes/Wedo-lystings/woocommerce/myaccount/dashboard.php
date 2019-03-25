<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
 <?php  $current_user = wp_get_current_user();
        if(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11834, 'product' ),'active')){
			$package = 'Expert';
			$product_id = apply_filters( 'wpml_object_id', 11834, 'product' );
        }elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 12225, 'product' ),'active')){
			$package = 'Pro-shop';
			$product_id = apply_filters( 'wpml_object_id', 12225, 'product' );
		}elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11742, 'product' ),'active')){
			$package = 'Pro';
			$product_id = apply_filters( 'wpml_object_id', 11742, 'product' );
		
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11676, 'product' ),'active')){
			$package = 'Start';
			$product_id = apply_filters( 'wpml_object_id', 11676, 'product' );
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11347, 'product' ),'active')){
			$package = 'Free';
			$product_id = apply_filters( 'wpml_object_id', 11347, 'product' );
        } else {
            $package = 'User';
        } ?>
<?php if($package == "User"){ ?>
<p><?php
	/* translators: 1: user display name 2: logout url */
	printf(
		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
	);
?></p>

<p><?php
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a> and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
?></p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	//do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );
} else { ?>
<?php  $current_user = wp_get_current_user();
        $product_not_in = array();
        if(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11834, 'product' ))){
			$package = 'Expert';
            $product_id = apply_filters( 'wpml_object_id', 11834, 'product' );
            $product_not_in = array(apply_filters( 'wpml_object_id', 11834, 'product' ),apply_filters( 'wpml_object_id', 12225, 'product' ),apply_filters( 'wpml_object_id', 11742, 'product' ),apply_filters( 'wpml_object_id', 11676, 'product' ),apply_filters( 'wpml_object_id', 11347, 'product' )); 
        }elseif(wcs_user_has_subscription($current_user->ID,12225)){
			$package = 'Pro-shop';
            $product_id = apply_filters( 'wpml_object_id', 12225, 'product' );
            $product_not_in = array(apply_filters( 'wpml_object_id', 12225, 'product' ),apply_filters( 'wpml_object_id', 11742, 'product' ),apply_filters( 'wpml_object_id', 11676, 'product' ),apply_filters( 'wpml_object_id', 11347, 'product' ));
		}elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11742, 'product' ))){
			$package = 'Pro';
            $product_id = apply_filters( 'wpml_object_id', 11742, 'product' );
            $product_not_in = array(apply_filters( 'wpml_object_id', 11742, 'product' ),apply_filters( 'wpml_object_id', 11676, 'product' ),apply_filters( 'wpml_object_id', 11347, 'product' ));
		
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11676, 'product' ))){
			$package = 'Start';
            $product_id = apply_filters( 'wpml_object_id', 11676, 'product' );
            $product_not_in = array(apply_filters( 'wpml_object_id', 11676, 'product' ),apply_filters( 'wpml_object_id', 11347, 'product' ));
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11347, 'product' ))){
			$package = 'Free';
            $product_id = apply_filters( 'wpml_object_id', 11347, 'product' );
            $product_not_in = array(apply_filters( 'wpml_object_id', 11347, 'product' ));
        } else {
            $package = 'User';
        } ?>

<div class="wrap-content package-option">
    <div class="container">
            <div class="pricing-package">
            <?php $product = wc_get_product( $product_id ); ?>
						<?php 	$title = $product->get_name();
				$description = $product->get_description();
				$featured = false;

				// If a custom title, description, or other options are set on this product
				// for this specific listing type, then replace the default ones with the custom one.
				if ( $type && ( $_package = $type->get_package( $product->get_id() ) ) ) {
					$title = $_package['label'] ?: $title;
					$featured = $_package['featured'] ?: $featured;

					// Split the description textarea into new lines,
					// so it can later be reconstructed to an html list.
					$description = $_package['description'] ? preg_split( '/\r\n|[\r\n]/', $_package['description'] ) : $description;
				} ?>
            <h2><?php _e('Your package','wedo-listing');?> <span><?php echo get_the_title($product_id);?></span></h2> 
            <div class="listing-box"> 
                    
                                                    <div class="row">
                    
                                                        <div class="col-md-5 col-sm-4  col">
                                                                <div class="price-box">
                                                                    <h4><?php echo get_the_title($product_id);?></h4>
                                                                    <p class="price show-no-tax">&lrm;<?php echo $product->get_price_html(); ?><span class="subscription-details">HTVA</span></p>
                                                                   
                                                                </div>
                                                        </div>
                    
                                                        <div class="col-md-7 col-sm-8  col">
                                                                
                                                                     
									<?php if ( is_array( $description ) ): ?>
								<ul class="list5">
									<?php foreach ( $description as $line ): ?>
										<li><?php echo $line ?></li>
									<?php endforeach ?>
								</ul>
							<?php else: ?>
								<?php echo $description ?>
							<?php endif ?>                                                                            </div>
                                                                
                    
                                                    </div>
                    
                                                </div>


                                                <hr>
    <?php  $product_ids = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'fields' => 'ids', 
		'orderby' => 'meta_value_num', 
		'meta_key' => '_subscription_price', 
		'order'  => 'DESC',
        'post__not_in' => $product_not_in
    ) );
    $products = array();
		if ( $product_ids->posts ) {
			foreach ( $product_ids->posts as $product_id ) {
				$products[ $product_id ] = wc_get_product( $product_id );
			}
        } 
        ?>
       <?php if($products):?>
            <h2><?php _e('Choose another package','wedo-listing');?></h2> 


        <div class="row other-package">
        <?php foreach ( $products as $key => $product ) : ?>
        <?php
				// Skip if not the right product type or not purchaseable.
				if ( ! $product->is_type( array( 'job_package', 'job_package_subscription' ) ) || ! $product->is_purchasable() ) {
					continue;
				}

				$title = $product->get_name();
				$description = $product->get_description();
				$featured = false;

				// If a custom title, description, or other options are set on this product
				// for this specific listing type, then replace the default ones with the custom one.
				if ( $type && ( $_package = $type->get_package( $product->get_id() ) ) ) {
					$title = $_package['label'] ?: $title;
					$featured = $_package['featured'] ?: $featured;

					// Split the description textarea into new lines,
					// so it can later be reconstructed to an html list.
					$description = $_package['description'] ? preg_split( '/\r\n|[\r\n]/', $_package['description'] ) : $description;
				}


				// Set checked item.
				$checked = ( intval( $selected ) === intval( $product->get_id() ) ) ? 1 : 0;
				?>
            <div class="col-sm-3 col">
                <div class="listing-box-2"> 
                    
                    <div class="price-box">
                        <h4><?php echo $title ?></h4>
						<p class="price show-no-tax">&lrm;<?php echo $product->get_price_html(); ?><span class="subscription-details">HTVA</span></p>
                      
                        <a href="<?php echo get_permalink($product->get_id() );?>" class="buttons button-2">
						<?php _e('Select','wedo-listing');?>				</a>
                            </div>
                            <?php if ( is_array( $description ) ): ?>
								<ul class="list5">
									<?php foreach ( $description as $line ): ?>
										<li><?php echo $line ?></li>
									<?php endforeach ?>
								</ul>
							<?php else: ?>
								<?php echo $description ?>
							<?php endif ?>
                    
                    
                                                </div>
            </div>
            <?php endforeach;?>

        </div>
            <?php endif;?>
        </div>
                
    </div>
</div>
<style type="text/css">
	.pricing-package .other-package .price-box .price {
		display: block;
	}
	.pricing-package .other-package .subscription-details {
		display: inline;
	}
	.listing-wrapper .pricing-package .other-package .col {
		padding-right: 5px;
		padding-left: 5px;
	}
</style>
<?php }

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
