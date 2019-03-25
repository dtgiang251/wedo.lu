<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:


// END ENQUEUE PARENT ACTION

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'chld_thm_font-awesome', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/font-awesome.min.css', array(  ) );
    wp_enqueue_style( 'chld_thm_chosen-css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/choosen.css', array(  ));
    wp_enqueue_style( 'chld_thm_main-css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/main.css', array(  ));
    wp_enqueue_style( 'chld_thm_icon-css', trailingslashit( get_stylesheet_directory_uri() ) . 'header-assets/assets/stylesheets/icons.1.6.2.css', array(  ));
    wp_enqueue_style( 'chld_thm_header_main-css', trailingslashit( get_stylesheet_directory_uri() ) . 'header-assets/assets/stylesheets/main.css', array(  ));
    wp_enqueue_style( 'chld_thm_redesign_template-css', trailingslashit( get_stylesheet_directory_uri() ) . 'new/assets/stylesheets/template.css', array(  ));
   // wp_enqueue_style( 'chld_thm_material', 'https://fonts.googleapis.com/icon?family=Material+Icons&ver=4.9.5', array(  ));
   // wp_enqueue_style( 'chld_thm_new-header', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/new-header.css', array( ) );
    wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( ), '1.0.9' );
    wp_enqueue_script( 'slick-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/slick.min.js', [], null, true );
    wp_enqueue_script( 'carousel', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/jquery.carouFredSel-6.2.1-packed.js', [], null, true );
    wp_enqueue_script( 'matchheight', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/jquery.matchHeight.js', [], null, true );
    wp_enqueue_script( 'svginject', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/svginject.js', [], null, true );
    wp_enqueue_script( 'validator', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/jquery.validate.min.js', [], '1.1', false );
    // Localize the script with new data
    $translation_array = array(
	'required_text' => __( 'Ce champ est obligatoire.', 'box-theme' ),
    );
    wp_localize_script( 'validator', 'object_name', $translation_array );
    wp_enqueue_script( 'chosen', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/choosen.js', [], '1.1', false );
   
        wp_enqueue_script( 'post-project-new', trailingslashit( get_stylesheet_directory_uri() ) . 'new/assets/javascripts/post-project-new.js', array(),'1.2', true );
        $translation_array1 = array(
            'description_text' => __( 'Vous devez fournir une description.', 'box-theme' ),
            );
            wp_localize_script( 'post-project-new', 'object_name1', $translation_array1 );
    
    wp_enqueue_script( 'header-main-js', trailingslashit( get_stylesheet_directory_uri() ) . 'header-assets/assets/javascripts/main.js', [], null, true );
    wp_enqueue_script( 'new-template-js', trailingslashit( get_stylesheet_directory_uri() ) . 'new/assets/javascripts/template.js', [], null, true );
    wp_enqueue_script( 'main-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/main.js', [], null, true );
}, 100 );

function exclude_category( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;
    $user = wp_get_current_user();
    $role = ( array ) $user->roles;
    if (!empty($role)):
        if ( in_array( 'employer', (array) $user->roles ) ) :
            if ( is_post_type_archive( 'project' ) ) {
                $query->set( 'author', get_current_user_id() );
            }
        endif;
    endif;
}
add_action( 'pre_get_posts', 'exclude_category', 1 );

add_filter( 'woocommerce_add_cart_item_data', 'woo_custom_add_to_cart' );
 
function woo_custom_add_to_cart( $cart_item_data ) {
global $woocommerce;
$woocommerce->cart->empty_cart();
 
return $cart_item_data;
}

// @link https://businessbloomer.com/woocommerce-merge-account-tabs/
// Credit: Rodolfo Melogli
add_filter( 'woocommerce_account_menu_items', function( $items ) {
    unset($items['edit-address']);
    unset($items['payment-methods']);
    return $items;
}, 999 );

add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_payment_methods' );
add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_address' );
add_filter( 'mylistingpackagesfreeskip-checkout', '__return_false' );




function bx_page_template_redirect1(){
	global $user_ID;


	if( ! is_user_logged_in() ){

		       
       /* if ( is_post_type_archive('project') ) {
            $login_page = add_query_arg( array('redirect'=>home_url( '/projects/' ) ),box_get_static_link( 'login' ) );
			wp_redirect( 'http://wedo.lu');
			exit();
        }

        if ( is_singular('project') ) {
            $login_page = add_query_arg( array('redirect'=>get_the_permalink() ),box_get_static_link( 'login' ) );
			wp_redirect( 'http://wedo.lu');
			exit();
        }
        if ( is_page_template('page-login.php') ) {
            $login_page = add_query_arg( array('redirect'=>get_the_permalink() ),box_get_static_link( 'login' ) );
			wp_redirect( 'http://wedo.lu');
			exit();
        } */
        if(is_tax('project_cat') || is_tax('skills')){
            wp_redirect( home_url());
			exit();
        }

	} 
}
add_action( 'template_redirect', 'bx_page_template_redirect1', 15 );

register_nav_menus( array(
	'main_menu_new' => 'Main Menu New',
) );



add_filter('is_account_verified', 'henry_is_account_verified', 10);
function henry_is_account_verified() {
	return true;
}

add_action( 'pre_get_posts', function ( $q )
{
    if (    !is_admin() // Only target the frontend
         && $q->is_main_query() // Only target the main query
         && is_tax() // Only target category pages
    ) {
        if ( is_tax( 'project_cat' ) ){
        $current_user = wp_get_current_user();
        $user1 = new WP_User($current_user->ID); //123 is the user ID
        $user_role = key($user1->caps);
        if($user_role=='subscriber'){
        $q->set( 'author' , $current_user->ID);
        }
       }

        if ( is_tax( 'skill' ) )   {
            $current_user = wp_get_current_user();
            $user1 = new WP_User($current_user->ID); //123 is the user ID
            $user_role = key($user1->caps);
            if($user_role=='subscriber'){
            $q->set( 'author' , $current_user->ID);
            }
        }
            
    }
});

function custom_footer() {
	
    if(ICL_LANGUAGE_CODE=='en'){
        include_once('/home/ftpwedo/public_html/footer-new/footer-en.html');
    } elseif(ICL_LANGUAGE_CODE=='de'){
        include_once('/home/ftpwedo/public_html/footer-new/footer-de.html');
    }else{
		include_once('/home/ftpwedo/public_html/footer-new/footer.html');
    }
}
add_action( 'wp_footer', 'custom_footer' );

function eg_add_rewrite_rules() {
    global $wp_rewrite;
    $new_rules = array(
        // 'quote/(.+)/?/(.+)/?$' => 'index.php?page_id=2178&categories=' . $wp_rewrite->preg_index(1) . '&skills=' . $wp_rewrite->preg_index(2)
		'quote/([^/]*)/([^/]*)/?' => 'index.php?page_id=2178&categories=' . $wp_rewrite->preg_index(1) . '&skills=' . $wp_rewrite->preg_index(2)
    );

    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'eg_add_rewrite_rules' );
  
add_filter( 'term_link', 'giang_change_ingredients_permalinks', 10, 2 );
function giang_change_ingredients_permalinks( $permalink, $term ) {
    if ($term->taxonomy == 'skill' ) {
		$actual_link = home_url('/quote/');
		
		$categories = get_terms('project_cat', array(
			'hide_empty' => false,
		) );
		
		$parent_cat = '';
		
		foreach( $categories as $cat ) {
			$skills = get_field('skills', $cat);
			if( $skills ) foreach($skills as $skill){
				if( $skill->slug == $term->slug ) {
					$parent_cat = $cat->slug; break;
				}
			}
		}
		if( $parent_cat ) $permalink = $actual_link . $parent_cat . '/' . $term->slug;
	}
    return $permalink;
}
function prefix_register_query_var( $vars ) {
    $vars[] = 'categories';
    $vars[] = 'skills';
 
    return $vars;
}

include ("giang-functions.php");
 
add_filter( 'query_vars', 'prefix_register_query_var' );

function generate_custom_title($title) {
    /* your code to generate the new title and assign the $title var to it... */
    if(get_query_var( 'skills')):
        $skills = get_term_by('slug', get_query_var( 'skills') , 'skill');
        if(get_field('seo_title',$skills)){
        $title = get_field('seo_title',$skills);
        } else {
        $title = $skills->name.' - Wedo.lu';
        }
       endif;
    
        return $title;
}
add_filter( 'wpseo_title', 'generate_custom_title', 15 );

add_filter( 'wpseo_opengraph_desc', 'change_desc' );
 function change_desc( $desc ) {
   
   // This article is actually a landing page for an eBook
   if(get_query_var( 'skills')):
	$skills = get_term_by('slug', get_query_var( 'skills') , 'skill');
	$desc = get_field('seo_description',$skills);
   endif;       
   
   return $desc;
 }

 add_filter( 'wpseo_metadesc', 'change_desc1' );
 function change_desc1( $desc ) {
   
   // This article is actually a landing page for an eBook
   if(get_query_var( 'skills')):
	$skills = get_term_by('slug', get_query_var( 'skills') , 'skill');
	$desc = get_field('seo_description',$skills);
   endif;       
   
   return $desc;
 }