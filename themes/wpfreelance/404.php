<?php
/**
 *Template Name: Default template
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="col-md-12">
				<div class="page-content" style="width: 450px; margin: 0 auto; padding-top: 130px;">
					<h2><?php _e( 'This is somewhat embarrassing, isn’t it?', 'twentythirteen' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentythirteen' ); ?></p>
					<a href="<?php echo home_url();?>"><?php _e('Back home','boxtheme');?></
				</div><!-- .page-content -->
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>