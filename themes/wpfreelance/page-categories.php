<?php
/**
 *	Template Name: List categoires
 *	@keyword: page-categories.php
 */

// global $wp_query, $ae_post_factory, $post, $user_ID;
// $query_args = array(
// 	'post_type'   => PROJECT,
// 	'post_status' => 'publish'
// );
// $loop       = new WP_Query( $query_args );
get_header();
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >

				<div class="col-md-12">
					<?php

						echo '<div class="full">';
							echo '<h2 class="col-md-12"> LIST CATEGORIES STYLE 1 </h2>';
							box_list_categories( array('style'=>1) ) ;
						echo '</div> <!-- full !-->';

						echo '<div class="full ">';
							echo '<div class="col-md-12">&nbsp; </div>';
							echo '<div class="col-md-12">&nbsp; </div>';
							echo '<h2 class="col-md-12"> LIST CATEGORIES STYLE 2</h2>';
							box_list_categories( array('style'=>2) );
						echo '</div>';


					?>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		li.cat-label label{
			border-bottom: 2px solid #39c515;
			color: #39c515;
		}
		.list-cats-1 li a{
			padding: 3px 0;
		}
	</style>
<?php
get_footer();
