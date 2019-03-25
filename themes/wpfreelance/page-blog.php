<?php
/**
 *	Template Name: Blog page
 */
?>
<?php get_header(); ?>
<div class="full-width" style="background: #fff;">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div class="col-md-9 detail-project text-justify">
				<h1><?php the_title();?></h1>
				<?php
				// The Query
				$args = array('post_type' => 'post');
				$the_query = new WP_Query( $args );
				// The Loop
				if ( $the_query->have_posts() ) {

					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						get_template_part( 'template-parts/post', 'loop' );
					}
					/* Restore original Post Data */
				} else {
					// no posts found
				}
				?>
			</div>
			<div class="col-md-3 sidebar no-padding-left" id="sidebar">
				<?php get_sidebar('blog');?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>

