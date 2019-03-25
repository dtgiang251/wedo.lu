<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_font_css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/font-awesome.min.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ) );
        wp_enqueue_style( 'chld_thm_main_css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/main.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ) );
        wp_enqueue_style( 'chld_thm_main_2_css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/main-2.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ) );
        wp_enqueue_style( 'chld_thm_landing_page_css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/landing-pages.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ) );

		wp_enqueue_style( 'swiper', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/swiper.min.css', [], null, true );
		wp_enqueue_style( 'chld_thm_custom_p_css', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/stylesheets/custom-p.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ) );
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'c27-style','theme-styles-default','theme-styles-default','c27-icons' ), '1.0.1' );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );

// END ENQUEUE PARENT ACTION

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
add_action( 'wp_enqueue_scripts', function() {
    wp_deregister_script( 'c27-google-maps' );
    wp_enqueue_script( 'c27-google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . c27()->get_setting('general_google_maps_api_key') . '&libraries=places&v=3', [], null, true );
    wp_enqueue_script( 'slick-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/slick.min.js', [], null, true );
    wp_enqueue_script( 'carousel', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/jquery.carouFredSel-6.2.1-packed.js', [], null, true );
    wp_enqueue_script( 'matchheight', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/jquery.matchHeight.js', [], null, true );

    wp_enqueue_script( 'svgInject', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/svginject.js', [], null, true );
    wp_enqueue_script( 'owl', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/vendor/owl.carousel.js', [], null, true );
    wp_enqueue_script( 'main-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/javascripts/main.js', [], '5.0.0', true );
    wp_enqueue_script( 'swiper-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/swiper.min.js', [], '5.0.0', true );
    wp_enqueue_script( 'custom-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/custom.js', [], '1.0.2', true );
    wp_enqueue_script( 'custom-p-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/custom-p.js', [], '1.0.1', true );
    wp_enqueue_script( 'p-jquery-cookie-js', trailingslashit( get_stylesheet_directory_uri() ) . 'js/jquery.cookie.js', [], '1.0.1', true );
    wp_localize_script( 'custom-p-js', 'p_ajax_object', array(



        'ajaxurl' => admin_url( 'admin-ajax.php' ),



        'homeurl' => home_url(),



    ));
}, 100 );


function remove_http($url) {
    $disallowed = array('http://', 'https://', '/');
    foreach($disallowed as $d) {
       if(strpos($url, $d) === 0) {
          return str_replace($d, '', $url);
       }
    }
    return $url;
 }


// Giang Functions
include( get_stylesheet_directory() .'/giang-functions.php');
include( get_stylesheet_directory() .'/phong-functions.php');

add_filter ( 'woocommerce_account_menu_items', 'misha_one_more_link' );
function misha_one_more_link( $menu_links ){
 
    // we will hook "anyuniquetext123" later
    $home = array( 'dashboard1' => __( 'Dashboard', 'wedo-listing' ) );
   
    // $new1 = array( 'reservation' => __( 'Reservations', 'wedo-listing' ), 'wedo-websites' => __( 'Website Builder', 'wedo-listing' ) );
	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );
	// array_slice() is good when you want to add an element between the other ones
	
	// $menu_links = $home + array_slice( $menu_links, 0, 1, true )
	// + array_slice( $menu_links, 1, NULL, true ) + $new1 + $home;
	
	$menu_links = $home + array_slice( $menu_links, 0, 1, true )
	+ array_slice( $menu_links, 1, NULL, true ) + $home;
 
 
	return $menu_links;
 
 
}
 
add_filter( 'woocommerce_get_endpoint_url', 'misha_hook_endpoint', 30, 4 );
function misha_hook_endpoint( $url, $endpoint, $value, $permalink ){

    if( $endpoint === 'reservation' ) {
 
		// ok, here is the place for your custom URL, it could be external
		$url = home_url('/reservation/');
 
    }
    if( $endpoint === 'dashboard1' ) {
 
		// ok, here is the place for your custom URL, it could be external
		$url = home_url('/dashboard/');
 
	}
	return $url;
 
}


add_filter('woocommerce_account_menu_items', 'filter_wc_my_account_menu');
//add_action('template_redirect', 'redirect_for_blocked_wc_pages');

function filter_wc_my_account_menu($items) {
    $current_user = wp_get_current_user();
        if(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11834, 'product' ),'active')){
            $package = 'Expert';
            return $items;
        }elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 12225, 'product' ),'active')){
            $package = 'Pro-shop';
            return $items;
		}
        elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11742, 'product' ),'active')){
            $package = 'Pro';
            return $items;
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11676, 'product' ),'active')){
            $package = 'Start';
            return $items;
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11347, 'product' ),'active')){
            $package = 'Free';
            return $items;
        } else {
            $package = 'User';
            if (isset($items['my-listings'])) {
                unset($items['my-listings']);
            }
            if (isset($items['wedo-websites'])) {
                unset($items['wedo-websites']);
            }
            if (isset($items['subscriptions'])) {
                unset($items['subscriptions']);
            }
        }
    return $items;
}


function wc_custom_user_redirect( $redirect, $user ) {
	// Get the first of all the roles assigned to the user
	
		//Redirect administrators to the dashboard
	$redirect = home_url('/dashboard/');
	return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 11100, 2 );

add_action( 'woocommerce_created_customer', 'bi_woocommerce_created_customer', 10, 2);
function bi_woocommerce_created_customer($user_id, $new_customer_data) {
	global $wpdb;
	$role = 'subscriber';
	add_user_to_blog( 18, $user_id, $role );
	switch_to_blog( 18 );
	$user_login = $new_customer_data['user_login'];
	$wpdb->update( $wpdb->users, array( 'user_status' => 1 ), array( 'user_login' => $user_login ) );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $user_login ) );
}

function nelio_max_image_size( $file ) {
  $size = $file['size'];
  $size = $size / 1024;
  $type = $file['type'];
  $is_image = strpos( $type, 'image' ) !== false;
  $limit = 1024;
  $limit_output = '1mb';
  if ( $is_image && $size > $limit ) {
    $file['error'] = 'Image files must be smaller than ' . $limit_output;
  }//end if
  return $file;
}//end nelio_max_image_size()
add_filter( 'wp_handle_upload_prefilter', 'nelio_max_image_size' );
add_action( 'init', 'user_role_post' );
function user_role_post() {
	if(is_user_logged_in()){
		restore_current_blog();
		$current_user = wp_get_current_user();
		
		// switch_to_blog(4);
		
		$has_pro = 0;
		if(wcs_user_has_subscription( $current_user->ID,apply_filters( 'wpml_object_id', 57177, 'product' ),'active') || wcs_user_has_subscription($current_user->ID, 57177,'active') ){
			$has_pro = 1;
		}
		elseif(wcs_user_has_subscription( $current_user->ID,apply_filters( 'wpml_object_id', 57165, 'product' ),'active') || wcs_user_has_subscription($current_user->ID, 57165,'active') ){
			$has_pro = 1;
		}
		elseif( wcs_user_has_subscription( $current_user->ID,apply_filters( 'wpml_object_id', 11834, 'product' ),'active') || wcs_user_has_subscription($current_user->ID, 11834,'active') ){
			$has_pro = 1;
		}
		// elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 12225, 'product' ),'active')){
			// $has_pro = 1;
		// }
		elseif(wcs_user_has_subscription( $current_user->ID,apply_filters( 'wpml_object_id', 11742, 'product' ),'active') || wcs_user_has_subscription($current_user->ID, 11742,'active') ){
			$has_pro = 1;
		}
		switch_to_blog(18);
		$user = new WP_User($current_user->ID); //123 is the user ID
		$user_role = key($user->caps);
		$role = ( array ) $user->roles;
		if($has_pro == 1 && $user_role=='subscriber'){
		$user->set_role('freelancer');
		} elseif($has_pro == 0 && $user_role=='freelancer'){
		$user->set_role('subscriber');     
		}
		if($has_pro == 1 && in_array( 'subscriber', (array) $user->roles )){
			$user->set_role('freelancer');
			} elseif($has_pro == 0 && in_array( 'freelancer', (array) $user->roles )){
			$user->set_role('subscriber');     
			}
		if($has_pro == 1){
			$args = array(
				'author'        =>  $user->ID, 
				'post_type' => 'profile',
				'posts_per_page' => -1 // no limit
			  );         
			$current_user_posts = get_posts( $args );
			$total = count($current_user_posts);
			if($total <= 0 ){
				$args = array(
					'post_title' 	=> $user->first_name . ' '.$user->last_name ,
					'post_type'  	=> PROFILE,
					'post_author' 	=> $user->ID,
					'post_status' 	=> 'publish',
					'meta_input'	=> array(
						HOUR_RATE => 0,
						RATING_SCORE => 0,
						)
				);
				$profile_id = wp_insert_post($args);
				update_user_meta( $user->ID, 'profile_id', $profile_id );
				update_post_meta( $profile_id, 'is_subscriber', 1 );
			}
		}
		restore_current_blog();

	}
	
	
	function get_subscription_package( $user_id ) {
		if(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 57165, 'product' ),'active')){
            $package = 'Power';
        }
		elseif( wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 57177, 'product' ),'active')){
            $package = 'Plus';
        }
		elseif(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 11834, 'product' ),'active')){
            $package = 'Expert';
        }
		elseif(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 12225, 'product' ),'active')){
            $package = 'Pro-shop';
		}
        elseif(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 11742, 'product' ),'active')){
            $package = 'Pro';
        }
		elseif(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 11676, 'product' ),'active')){
            $package = 'Start';
        }
		elseif(wcs_user_has_subscription($user_id, apply_filters( 'wpml_object_id', 11347, 'product' ),'active')){
            $package = 'Free';
        }
		else {
            $package = 'User';
        }
		return $package;
	}
}