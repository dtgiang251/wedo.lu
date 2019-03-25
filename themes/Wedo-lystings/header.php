<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php esc_attr( bloginfo( 'charset' ) ) ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="pingback" href="<?php esc_attr( bloginfo( 'pingback_url' ) ) ?>">
	<meta name="ahrefs-site-verification" content="7d3c8dbe6c131ae381402dcaae77b9f698e1e693ddf8a0b84597cbe600f5b0f7">

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
		// var_dump( $wp_query );
		// var_dump( is_page() );
		// var_dump( is_tax() );
	?>
	
	<?php wp_head(); ?>
	
	<?php 
		if ( $check ) {
			$wp_query->query( $_SESSION["old_query"] );
		} 
	?> 
	
	<script type="text/javascript">(function(o){var b="https://api.autopilothq.com/anywhere/",t="c8cb5e1d6548483a90754e1d8fea91ad94a1fce4ea7243ef820cf97c915601fa",a=window.AutopilotAnywhere={_runQueue:[],run:function(){this._runQueue.push(arguments);}},c=encodeURIComponent,s="SCRIPT",d=document,l=d.getElementsByTagName(s)[0],p="t="+c(d.title||"")+"&u="+c(d.location.href||"")+"&r="+c(d.referrer||""),j="text/javascript",z,y;if(!window.Autopilot) window.Autopilot=a;if(o.app) p="devmode=true&"+p;z=function(src,asy){var e=d.createElement(s);e.src=src;e.type=j;e.async=asy;l.parentNode.insertBefore(e,l);};y=function(){z(b+t+'?'+p,true);};if(window.attachEvent){window.attachEvent("onload",y);}else{window.addEventListener("load",y,false);}})({});</script>
	
</head>
<body <?php body_class(); ?>>
<div id="c27-site-wrapper">

<?php c27()->get_partial( 'loading-screens/' . c27()->get_setting( 'general_loading_overlay', 'none' ) ) ?>

<?php

$GLOBALS['case27_custom_styles'] = '';
$pageTop = apply_filters('case27_pagetop_args', [
	'header' => [
		'show' => true,
		'args' => [],
	],

	'title-bar' => [
		'show' => c27()->get_setting('header_show_title_bar', false),
		'args' => [
			'title' => get_the_archive_title(),
			'ref' => 'default-title-bar',
		],
	]
]);

if ($pageTop['header']['show']) {
	c27()->get_section('header', $pageTop['header']['args']);

	if ($pageTop['title-bar']['show']) {
		c27()->get_section('title-bar', $pageTop['title-bar']['args']);
	}
}
