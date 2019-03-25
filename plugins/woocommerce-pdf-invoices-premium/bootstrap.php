<?php
/**
 * Plugin Name: WooCommerce PDF Invoices Premium
 * Plugin URI: https://wcpdfinvoices.com/
 * Description: Premium extension for WooCommerce PDF Invoices plugin.
 * Version: 1.6.9
 * Author: Bas Elbers
 * Author URI: https://wcpdfinvoices.com/
 * Requires at least: 4.0
 * Tested up to: 4.9
 * WC requires at least: 2.6.14
 * WC tested up to: 3.3.3
 *
 * Text Domain: woocommerce-pdf-invoices
 *
 * Copyright: © 2015 BE Shops.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package BEWPIP
 * @category Integration
 * @author Bas Elbers
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load WooCommerce PDF Invoices Premium after WooCommerce PDF Invoices has been loaded.
 */
function _bewpip_on_plugin_load() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	if ( ! defined( 'BEWPIP_VERSION' ) ) {
		define( 'BEWPIP_VERSION', '1.6.9' );
	}

	if ( ! defined( 'BEWPIP_URL' ) ) {
		define( 'BEWPIP_URL', plugins_url( '', __FILE__ ) );
	}

	if ( ! defined( 'BEWPIP_DIR' ) ) {
		define( 'BEWPIP_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	require_once BEWPIP_DIR . '/vendor/autoload.php';

	if ( ! BEWPIP_Install::plugin_activation() ) {
		return;
	}

	/**
	 * Main instance of BE_WooCommerce_PDF_Invoices.
	 *
	 * @since  1.6.0
	 * @return BE_WooCommerce_PDF_Invoices_Premium
	 */
	function WPIP() {
		return BE_WooCommerce_PDF_Invoices_Premium::instance();
	}
	WPIP();
}
add_action( 'plugins_loaded', '_bewpip_on_plugin_load', 11 );

// Installation.
if ( is_admin() ) {
	require_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class-install.php';

	register_activation_hook( __FILE__, array( 'BEWPIP_Install', 'plugin_activation' ) );
	register_deactivation_hook( __FILE__, array( 'BEWPIP_Install', 'plugin_deactivation' ) );
}
