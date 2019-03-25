<?php

namespace MyListing\Ext\Social_Login\Networks;

abstract class Network {
    use \MyListing\Src\Traits\Instantiatable;

    // Handle AJAX request for login with this network.
	abstract public function handle_request( $request );

	// Add the JS code that will handle the frontend login button.
	abstract public function login_script();

	// Add the HTML code that will display the login button for this network.
	abstract public function display_button();

	// Transform the user data object to the format expected by the login() method.
	abstract public function transform_userdata( $data );

    // Check if this network is enabled and if it should be displayed. Return boolean.
    abstract public function is_enabled();

    /**
     * Based on the fetched user data, either create a
     * new user, or log them in if they're already registered.
     *
     * @since 1.6.3
     */
    public function login() {
        if ( ! is_array( $this->userdata ) || ! isset( $this->userdata['email'] ) ) {
            return false;
        }

        // If user already exists, log them in.
    	if ( $user = get_user_by('email', $this->userdata['email'] ) ) {
            if ( $this->login_existing_user( $user->user_login ) ) {
                return true;
            }

            return false;
        }

        // Insert new user.
        $args = [];
        $args['user_login'] = $this->userdata['email'];
        $args['user_email'] = $this->userdata['email'];
        $args['user_pass']  = wp_generate_password( 16 );

        // @todo: insert user profile picture too, through $this->userdata['picture'].
        if ( ! empty( $this->userdata['first_name'] ) ) {
            $args['first_name'] = $this->userdata['first_name'];
        }

        if ( ! empty( $this->userdata['last_name'] ) ) {
            $args['last_name'] = $this->userdata['last_name'];
        }

        $user_id = wp_insert_user( $args );

    	if ( ! is_wp_error( $user_id ) && $this->login_existing_user( $args['user_login'] ) ) {
            return true;
        }

        return false;
    }

    /**
     * Maintain the redirect functionality from the main
     * authentication forms. The 'redirect' param needs to
     * be passed with JS.
     *
     * @since 1.6.3
     */
	public function get_login_redirect_url() {
		if ( ! empty( $_POST['redirect'] ) ) {
			$redirect = $_POST['redirect'];
		} elseif ( wc_get_raw_referer() ) {
			$redirect = wc_get_raw_referer();
		} else {
			$redirect = wc_get_page_permalink( 'myaccount' );
		}

		return wp_validate_redirect( apply_filters( 'woocommerce_login_redirect', remove_query_arg( 'wc_error', $redirect ), wp_get_current_user() ), wc_get_page_permalink( 'myaccount' ) );
	}

	/**
	 * Login an existing user.
	 *
	 * @since 1.6.3
	 */
	public function login_existing_user( $username ) {
		add_filter( 'authenticate', [ $this, 'allow_programmatic_login' ], 10, 3 );
		$user = wp_signon( array( 'user_login' => $username ) );
		remove_filter( 'authenticate', [ $this, 'allow_programmatic_login'], 10, 3 );

		if ( is_a( $user, 'WP_User' ) ) {
			wp_set_current_user( $user->ID, $user->user_login );

			if ( is_user_logged_in() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Enable programmatic login for a specific user.
	 *
	 * @since 1.6.3
	 */
	public function allow_programmatic_login( $user, $username, $password ) {
		return get_user_by( 'login', $username );
	}
}