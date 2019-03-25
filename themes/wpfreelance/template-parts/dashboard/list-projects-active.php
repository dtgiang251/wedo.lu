<?php
/**
 * be included in page-dashboard and list all bidded of current Employer
 * Only available for Employer or Admin account.
**/

	global $user_ID;
	?>

<ul class="db-list-project ul-list-project" id="ul-active">
	<?php
		$args = array(
		'post_type' => 'project',
		'author'=> $user_ID,
		'posts_per_page' => -1,
		'post_status' => 'publish',
	);
	$query = new WP_Query($args);
	?>
	<li class="heading heading-table list-style-none padding-bottom-10">
		<div class ="col-md-5"> <?php _e('JOB TITLE','boxtheme'); ?></div>
		<div class ="col-md-2"><?php _e('PROPOSALS','boxtheme'); ?></div>
		<div class ="col-md-3"><?php _e('DATE POSTED','boxtheme'); ?></div>
		<div class ="col-md-2 text-center pull-right "></div>
	</li>
	<?php
	if( $query-> have_posts() ){
		while ($query->have_posts()) {

			global $post;
			$query->the_post();
			$project = BX_Project::get_instance()->convert( $post );

			echo '<li class="list-style-none padding-bottom-10">';
				echo '<div class ="col-md-5">';	echo '<a class="primary-color project-title" href="'.get_permalink().'">'. get_the_title().'</a>';	echo '</div>';
				echo '<div class ="col-md-2">';echo count_bids($post->ID);	echo '</div>';
				echo '<div class ="col-md-3">';	echo get_the_date();	echo '</div>';	?>
				<div class ="col-md-2 pull-right text-right text-status text-capitalize">

					<a href="#" class="btn-board btn-archived-job" id="<?php echo $project->ID;?>"  data-toggle="tooltip" title="<?php printf(__('Archived %s','boxtheme'), $project->post_titile);?>">
						<i class="fa fa-archive" aria-hidden="true"></i>
					</a>

				</div>

			</li><?php		}
	} else { ?>
		<li class="col-md-12" style="padding-top: 20px; list-style:none">
			<?php _e('There are no projects.','boxtheme'); ?>
		</li> <?php
	}
	wp_reset_query(); ?>
</ul>