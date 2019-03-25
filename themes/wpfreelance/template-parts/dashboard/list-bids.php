<?php
/**
 * be included in page-dashboard and list all bidded of current freelancer
 * Only available for freelancer account.
**/

	global $user_ID;
	wp_reset_query();
	$status = isset( $_GET['status'] ) ? $_GET['status'] : array('publish','pending','disputing','resolved','done','awarded');
	$check = $status;
	if( is_array($status) )
		$check = 'any';
	$loadmore = false;
	$link =  box_get_static_link('dashboard');  ?>

	<ul class="db-list-project db-list-bid">
		<li class="heading list-style-none full">
			<div class="col-md-8 pull-left">
				<?php _e('Your bids','boxtheme');?>
			</div>
			<div class="col-md-4 pull-right">
				<form class="pull-right full dashboard-filter">
						<select class="form-control">
							<option <?php selected( $check, 'publish' ); ?>  value="<?php echo $link;?>"> <?php _e('All Status','boxtheme');?></option>
							<option <?php selected( $check, 'publish' ); ?> value="<?php echo add_query_arg('status','publish', $link);?>"><?php _e('Activity','boxtheme');?></option>
							<option <?php selected( $check, 'awarded' ); ?>  value="<?php echo add_query_arg('status','awarded', $link);?>"><?php _e('Working','boxtheme');?></option>
							<option <?php selected( $check, 'done' ); ?>  value="<?php echo add_query_arg('status','done', $link);?>"> <?php _e('Complete','boxtheme');?></option>
							<option <?php selected( $check, 'disputing' ); ?>  value="<?php echo add_query_arg('status','disputing', $link);?>"><?php _e('Disputing/Resolved','boxtheme');?>

							</option>
						</select>
				</form>
			</div>
		</li>
		<?php
			$args = array(
			'post_type' => 'bid',
			'author'=> $user_ID,
			'posts_per_page' => -1,
		);
		if( $status == 'disputing' )
			$status = array('disputing','resolved');

		$args['post_status'] = $status;

		$query = new WP_Query($args);

		echo '<li class="heading heading-table list-style-none padding-bottom-10">';
				echo '<div class ="col-md-2">';				_e('Project Title','boxtheme');				echo '</div>';
				echo '<div class ="col-md-5">';				_e('Cover letter','boxtheme');				echo '</div>';
				echo '<div class ="col-md-1">';				_e('Price','boxtheme');				echo '</div>';
				echo '<div class ="col-md-2">'; _e('Posted date','boxtheme');echo '</div>'; ?>
				<div class ="col-md-2 text-center"><?php _e('Status','boxtheme');?></div><?php

			echo '</li>';
		if( $query-> have_posts() ){
			while ($query->have_posts()) {
				global $post;
				$query->the_post();
				$bid = BX_Bid::get_instance()->convert($post);
				$project = get_post($bid->post_parent); ?>

				<li class="list-style-none padding-bottom-10 full">
					<div class ="col-md-2"> <a class="primary-color project-title" href="<?php echo get_permalink($project->ID);?>"> <?php echo $project->post_title;?></a></div>
					<div class ="col-md-5"> <?php the_content();?></div>
					<div class ="col-md-1"> <?php	box_price($bid->{BID_PRICE}); ?></div>
					<div class ="col-md-2"> <?php	echo get_the_date(); ?></div>
					<div class ="col-md-2 text-center">
						<?php echo box_project_status($bid->post_status);?>
					</div>
				</li><?php

			}
			wp_reset_postdata();
		} else {
			echo '<li class="col-md-12" style="padding-top: 20px; list-style:none">';
			_e('There are no bid.','boxtheme');
			echo '</li>';
		}

		echo '</ul>';
		wp_reset_query();

?>