<?php /* Template name: Services */
get_header();?>
<div id="pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pagehead14.jpg" alt="image">
    <div class="container vh-center">
        <h2><?php _e('Rates & Services','wedo-listing');?></h2>
    </div>
</div>


<div class="wrap-content package-option">
    <div class="container">
    <?php
	$product_ids = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
		'fields' => 'ids'
		// 'orderby' => 'meta_value_num', 
		// 'meta_key' => '_subscription_price', 
		// 'order'  => 'DESC'
    ) );
    $products = array();
		if ( $product_ids->posts ) {
			foreach ( $product_ids->posts as $product_id ) {
				$products[ $product_id ] = wc_get_product( $product_id );
			}
        }
        ?>
        <div class="pricing-package">

        <div class="row same-height">
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
                        <div class="listing-box-2 free" > 
                            
                            <div class="price-box">
                                <h4><?php echo $title ?></h4>
                                <p class="price">‎<?php echo $product->get_price(); ?> €</p>
                                <p><?php _e('per annum','wedo-listing');?></p>
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
        </div>
                
    </div>
</div>
<style type="text/css">
	@media (min-width: 1200px) {
		.wrap-content .container {
			width: 1170px;
		}
	}
</style>
<?php get_footer();?>