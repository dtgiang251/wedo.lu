<?php
/**
 *	Template Name: FullWidth
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<?php the_post(); ?>
	<h1><?php the_title();?></h1>
	<?php the_date();?>
	<?php the_content(); ?>
</div>

<?php get_footer();?>

