<?php
wp_reset_query();
$buy_link = box_get_static_link('buy-credit');

$list=array("buy_credit","premium_post");
$index = rand(0,1);
$pack_type = $list[$index];

$args = array(
	'post_type' => '_package',
	'posts_per_page' =>3,
	'meta_key' => 'pack_type',
	'meta_value' => $pack_type,
);

$result = new WP_Query($args);
if( $result->have_posts() ){ ?>
	<section class="full-width packge-plan">
		<div class="container">
			<div class="row"><?php

					while( $result->have_posts() ){
						$result->the_post();
						$price = get_post_meta(get_the_ID(),'price', true); ?>
						<div class="col-md-4 package-item">
							<div class="pricing-table-plan">
								<header data-plan="basic" class="pricing-plan-header basic-plan"><span class="plan-name"><?php the_title();?></span></header>
					    		<div class="plan-features">
						    		<span class="plan-monthly primary-color"><?php box_price($price);?></span>
						    		<span class="pack-des">	<?php the_content();?> </span>
								</div>
								<?php
								if($pack_type == "buy_credit"){
									$link = add_query_arg( array('id' =>get_the_ID() ), $buy_link );
								?>
					            	<a class="btn btn-primary btn-xlarge " href="<?php echo esc_url($link);?>"><?php _e('Buy Now','boxtheme');?></a>
					            <?php } else {
					            	$submit_link = box_get_static_link("post-project");
					            	$link = add_query_arg( array('id' =>get_the_ID() ), $submit_link ); ?>
					            	<a class="btn btn-primary btn-xlarge " href="<?php echo esc_url($link);?>"><?php _e('Post Job Now','boxtheme');?></a>
					            <?php } ?>
							</div>
						</div>
					<?php }
					if ( $pack_type == "premium_post"){
						$symbol = box_get_currency_symbol();
						?>
						<div class="col-md-4 package-item">
							<div class="pricing-table-plan">
								<header data-plan="basic" class="pricing-plan-header basic-plan"><span class="plan-name">Free</span></header>
					    		<div class="plan-features">
						    		<span class="plan-monthly primary-color"> 0 <span class="currency-icon"><?php echo $symbol;?> </span></span>
						    		<span class="pack-des">Post a free job and find a freelanfer match with your project now. </span>
								</div>
								<?php
					            	$submit_link = box_get_static_link("post-project");
					            	$link = add_query_arg( array('id' =>get_the_ID() ), $submit_link ); ?>
					            	<a class="btn btn-primary btn-xlarge " href="<?php echo esc_url($link);?>"><?php _e('Post Job Now','boxtheme');?></a>
							</div>
						</div>
					<?php	} ?>

			</div> <!-- end row !-->
		</div>
	</section>
<?php } ?>