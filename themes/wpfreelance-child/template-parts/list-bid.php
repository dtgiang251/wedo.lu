<div class="full list-bid">
	<?php
	global $user_ID, $project, $list_bid, $bid_query;

	$args = array(
		'post_type' => BID,
		'post_parent' => $project->ID,
		'posts_per_page' => -1
	);

	$bid_query_old = new WP_Query($args);

	?>


	<?php
	global $cms_setting;
	$cms_setting = get_commision_setting();

	if( $bid_query->have_posts() ) : ?>
		<div class ="col-md-12 header-list-bid row-bid-item">
			<div class="col-md-2 text-center no-padding-right"> <?php _e('Freelancer Bidding','boxtheme');?> </div>
			<div class="col-md-8 "><?php _e('Description','boxtheme');?>		</div>
			<div class="col-md-2  text-center"> <?php _e('Price','boxtheme');?>		</div>
		</div>
		<?php
		while( $bid_query->have_posts() ):
			$bid_query->the_post();
			get_template_part( 'template-parts/bid', 'loop' );
		endwhile;

		$projet_link = get_the_permalink($project->ID);
		//bx_pagenate( $bid_query, array('base'=>$projet_link), 1, 1 );
		wp_reset_query();
	endif;
	?>
</div>