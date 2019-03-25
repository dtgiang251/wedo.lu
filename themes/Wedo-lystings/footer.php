	<?php c27()->get_partial('login-modal') ?>
	<?php c27()->get_partial('quick-view-modal') ?>
	<?php c27()->get_partial('photoswipe-template') ?>
	<?php c27()->get_partial('marker-templates') ?>
</div>

<?php
if (isset($GLOBALS['c27_elementor_page']) && $page = $GLOBALS['c27_elementor_page']) {
	if ( ! $page->get_settings('c27_hide_footer') ) {
		$args = [
			'show_widgets'      => $page->get_settings('c27_footer_show_widgets'),
			'show_footer_menu'  => $page->get_settings('c27_footer_show_footer_menu'),
		];

		c27()->get_section('footer', ($page->get_settings('c27_customize_footer') == 'yes' ? $args : []));
	}
} else {
	c27()->get_section('footer');
}
?>

<?php if (c27()->get_setting('footer_show_back_to_top_button', false)): ?>
	<a href="#" class="back-to-top">
		<i class="material-icons">keyboard_arrow_up</i>
	</a>
<?php endif ?>


<?php
	global $wp_query;
	$check = false;
	
	$taxonomies = [
		['tax' => 'region',                  'query_var' => 'explore_region',   'name_filter' => 'single_term_title'],
		['tax' => 'job_listing_category',    'query_var' => 'explore_category', 'name_filter' => 'single_cat_title'],
		['tax' => 'case27_job_listing_tags', 'query_var' => 'explore_tag',      'name_filter' => 'single_tag_title'],
	];
	foreach ( $taxonomies as $tax ) {
		if ( get_query_var( $tax['query_var'] ) && ( $term = get_term_by( 'slug', sanitize_title( get_query_var( $tax['query_var'] ) ), $tax['tax'] ) ) ) {
			$check = true;
			$_SESSION["old_query"] = $wp_query->query;
			$wp_query->query( array(
				$tax['tax'] => sanitize_title( get_query_var( $tax['query_var'] ) )
			) );
		} 
	}
?>

<?php wp_footer() ?>

<?php 
	if ( $check ) {
		$wp_query->query( $_SESSION["old_query"] );
	} 
?> 

<?php do_action( 'case27_footer' ) ?>

<script>
map = new google.maps.Map(document.getElementsByClassName('c27-map'), { zoom: 11 });
</script>

</body>
</html>
