<?php

if ( ! defined( 'CASE27_THEME_DIR' ) ) {
	define( 'CASE27_THEME_DIR', get_template_directory() );
}

if ( ! defined( 'CASE27_INTEGRATIONS_DIR' ) ) {
	define( 'CASE27_INTEGRATIONS_DIR', CASE27_THEME_DIR . '/includes/integrations' );
}

if ( ! defined( 'CASE27_ASSETS_DIR' ) ) {
	define( 'CASE27_ASSETS_DIR', CASE27_THEME_DIR . '/assets' );
}

if ( ! defined( 'CASE27_ENV' ) ) {
	define( 'CASE27_ENV', 'production' );
}

if ( ! defined( 'CASE27_THEME_VERSION' ) ) {
	if (CASE27_ENV == 'dev') {
		define( 'CASE27_THEME_VERSION', rand(1, 10e3) );
	} else {
		define( 'CASE27_THEME_VERSION', wp_get_theme( get_template() )->get('Version') );
	}
}

if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
	define( 'ELEMENTOR_PARTNER_ID', 2124 );
}

// Load textdomain early to include strings that are localized before
// the 'after_setup_theme' is called.
load_theme_textdomain( 'my-listing', CASE27_THEME_DIR . '/languages' );

// Load classes.
require_once CASE27_THEME_DIR . '/includes/autoload.php';

add_filter( 'mylisting\packages\free\skip-checkout', '__return_false' );
//add_action('wp', 'check_and_redirect');
function check_and_redirect() {
	if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_user_logged_in() ) {
		wp_redirect( 'https://landing.wedo.lu' );
		exit;
	  }
	if ( ! is_user_logged_in() && is_page('11431') ) {
		wp_redirect( 'https://wedo.lu' );
		exit;
	}
}