<?php /* Template name: Subscription */
get_header();?>
<div id="pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/banner-image2.jpg" alt="image">
    <div class="container vh-center">
        <h2>Pricing</h2>
    </div>
</div>
<?php  $current_user = wp_get_current_user();
        $product_not_in = array();
        if(wcs_user_has_subscription($current_user->ID,11834,'active')){
			$package = 'Expert';
            $product_id = 11834;
            $product_not_in = array(11834,12225,11742,11676,11347); 
        }elseif(wcs_user_has_subscription($current_user->ID,12225,'active')){
			$package = 'Pro-shop';
            $product_id = 12225;
            $product_not_in = array(12225,11742,11676,11347);
		}elseif(wcs_user_has_subscription($current_user->ID,11742,'active')){
			$package = 'Pro';
            $product_id = 11742;
            $product_not_in = array(11742,11676,11347);
		
        } elseif(wcs_user_has_subscription($current_user->ID,11676,'active')){
			$package = 'Start';
            $product_id = 11676;
            $product_not_in = array(11676,11347);
        } elseif(wcs_user_has_subscription($current_user->ID,11347,'active')){
			$package = 'Free';
            $product_id = 11347;
            $product_not_in = array(11347);
        } else {
			$product_id = 0;
            $package = 'User';
        } ?>

<div class="wrap-content package-option">
    <div class="container">
            <div class="pricing-package">
            <?php $product = wc_get_product( $product_id ); ?>
			<?php
				if( $product ) :
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
				} ?>
            <h2>Your package is <span><?php echo get_the_title($product_id);?></span></h2> 
            <div class="listing-box"> 
                    
                                                    <div class="row">
                    
                                                        <div class="col-md-5 col-sm-4  col">
                                                                <div class="price-box">
                                                                    <h4><?php echo get_the_title($product_id);?></h4>
                                                                    <p class="price">&lrm;<?php echo $product->get_price_html(); ?></p>
                                                                   
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
                                                <div class="text-right">
                                                        <a href="<?php echo home_url('/dashboard/');?>" class="buttons button-2">
                                                                Continue to your Dashboard			</a>                                                    
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
            <h2>Select another package</h2> 


        <div class="row">
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
            <div class="col-sm-6 col">
                <div class="listing-box-2"> 
                    
                    <div class="price-box">
                        <h4><?php echo $title ?></h4>
                        <p class="price"><?php echo $product->get_price_html(); ?></p>
                      
                        <a href="<?php echo get_permalink($product->get_id() );?>" class="buttons button-2">
                            Select a subscription				</a>
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
            <?php endif;?>
			
        </div>
                
    </div>
</div>

<?php get_footer();?>