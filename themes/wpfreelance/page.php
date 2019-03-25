<?php
/**
 *Template Name: Default template
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div class="col-md-8 detail-project text-justify">
				<?php the_post(); ?>
				<h1><?php the_title();?></h1>
				<?php the_content(); ?>
			</div>
			<div class="col-md-4 sidebar" id="sidebar">
				<?php get_sidebar('main_sidebar');?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>