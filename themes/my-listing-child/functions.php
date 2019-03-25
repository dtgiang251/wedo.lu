<?php

// Enqueue child theme style.css
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css', [],
        wp_get_theme()->get('Version')
    );
});

add_action( 'init', function() {remove_action( 'wp_head', [ mylisting()->sharer(),'add_opengraph_tags'], 5 );
remove_action( 'wpseo_opengraph', [ mylisting()->sharer(), 'remove_yoast_duplicate_og_tags'] );
remove_action( 'add_meta_boxes', [ mylisting()->sharer(), 'remove_yoast_listing_metabox'] );} );


add_shortcode('wedo-pages', 'wedo_pages');
function wedo_pages() {
    switch_to_blog(4);
        $my_id = 29951;
        $post_id_29951 = get_post($my_id);
        $content = $post_id_29951->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]>', $content);
    restore_current_blog();
    return $content;
}

add_filter( 'mylistingpackagesfreeskip-checkout', '__return_false' );