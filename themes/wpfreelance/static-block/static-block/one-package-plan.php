<?php
wp_reset_query();
$buy_link = box_get_static_link('buy-credit');

$args = array(
	'post_type' => '_package',
	'posts_per_page' =>3
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
								<?php $link = add_query_arg( array('id' =>get_the_ID() ), $buy_link ); ?>
					            <a class="btn btn-primary btn-xlarge " href="<?php echo esc_url($link);?>"><?php _e('Buy now','boxtheme');?></a>
							</div>
						</div>
						<?php } ;?>

			</div> <!-- end row !-->
		</div>
	</section>
<?php } ?>