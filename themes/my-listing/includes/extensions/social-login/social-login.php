<?php

namespace MyListing\Ext\Social_Login;

class Social_Login {
    use \MyListing\Src\Traits\Instantiatable;

    public $networks = [];

	public function __construct() {
		// Setup ACF settings page.
		add_action( 'acf/init', [ $this, 'setup_options_page' ] );

		// Only run past this for logged out users.
		if ( ! class_exists( 'WooCommerce' ) || is_user_logged_in() ) {
			return false;
		}

		// Setup supported networks.
		add_action( 'init', [ $this, 'setup_networks' ] );

		// Setup login endpoints.
		add_action( 'wp_ajax_cts_login_endpoint', [ $this, 'login_endpoint' ] );
        add_action( 'wp_ajax_nopriv_cts_login_endpoint', [ $this, 'login_endpoint' ] );

        // Display login buttons.
        add_action( 'woocommerce_login_form_end', [ $this, 'display_buttons' ] );
        add_action( 'woocommerce_register_form_end', [ $this, 'display_buttons' ] );
	}

	/**
	 * Init supported social login networks.
	 *
	 * @since 1.6.3
	 */
	public function setup_networks() {
		$this->networks['google']   = new Networks\Google();
		$this->networks['facebook'] = new Networks\Facebook();

		$this->networks = array_filter( $this->networks, function( $network ) {
			return $network->is_enabled();
		} );
	}

	/**
	 * Social login endpoint. Handles general request validation,
	 * and instantiates the requested network's class.
	 *
	 * @since 1.6.3
	 */
	public function login_endpoint() {
		check_ajax_referer( 'c27_ajax_nonce', 'security' );

		if ( empty( $_POST['network'] ) || empty( $this->networks[ $_POST['network'] ] ) ) {
			return false;
		}

		$network = $this->networks[ $_POST['network'] ];
		$network->handle_request( $_POST );
	}

	/**
	 * Output social login buttons.
	 *
	 * @since 1.6.3
	 */
	public function display_buttons() {
		$networks = apply_filters( 'mylisting\social-login\networks', array_keys( $this->networks ) );

		// Filter out networks that aren't active or don't exist.
		foreach ( $networks as $key => $network ) {
			if ( empty( $this->networks[ $network ] ) ) {
				unset( $networks[ $key ] );
				continue;
			}
		}

		if ( ! $networks ) {
			return false;
		}

		// Output buttons.
		?><div class="cts-social-login-wrapper">
			<p class="connect-with"><?php _ex( 'Or connect with', 'Social login message', 'my-listing' ) ?></p>
			<?php foreach ( $networks as $network ): ?>
				<?php echo $this->networks[ $network ]->display_button() ?>
			<?php endforeach ?>
		</div><?php
	}


	public function setup_options_page() {
		acf_add_options_sub_page( [
			'page_title' 	=> _x( 'Social Login', 'Social Login page title in WP Admin', 'my-listing'),
			'menu_title'	=> _x( 'Social Login', 'Social Login menu title in WP Admin', 'my-listing'),
			'menu_slug' 	=> 'theme-social-login-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false,
			'parent_slug'   => 'case27/tools.php',
		] );
	}
}
