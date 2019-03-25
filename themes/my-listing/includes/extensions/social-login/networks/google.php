<?php

namespace MyListing\Ext\Social_Login\Networks;

class Google extends Network {

    protected
        $request,
        $userdata,
        $app_id;

    /**
     * Include required scripts and setup settings for Google login.
     *
     * @since 1.6.3
     */
    public function __construct() {
        if ( ! $this->is_enabled() ) {
            return false;
        }

        $this->app_id = c27()->get_setting( 'social_login_google_client_id' );

        add_action( 'wp_enqueue_scripts', function() {
            wp_enqueue_script( 'google-platform-js', 'https://apis.google.com/js/platform.js?onload=cts_google_login', ['jquery'], null, true );
            wp_add_inline_script( 'google-platform-js', $this->login_script(), 'before' ); // @todo: Add support for redirect_to url parameter (pass it with JS)
        } );

        add_action( 'wp_head', function() { ?>
            <meta name="google-signin-client_id" content="<?php echo esc_attr( $this->app_id ) ?>">
        <?php } );
    }

    /**
     * Check if Sign-In with Google is enabled,
     * and a client ID has been provided.
     *
     * @since 1.6.3
     * @return bool
     */
    public function is_enabled() {
        return c27()->get_setting( 'social_login_google_enabled' ) && c27()->get_setting( 'social_login_google_client_id' );
    }

    /**
     * Attach handler to "Login with Google" button.
     *
     * @since 1.6.3
     */
    public function login_script() { ob_start(); ?>
        <script type="text/javascript">
            function cts_google_login() {
                gapi.load('auth2', function() {
                    gapi.auth2.init();
                    jQuery( '.cts-google-signin' ).each(function(i, el) {
                        gapi.auth2.getAuthInstance().attachClickHandler( el, {}, function( user ) {
                            jQuery.ajax( {
                                url: CASE27.ajax_url + '?action=cts_login_endpoint&security=' + CASE27.ajax_nonce,
                                type: 'POST',
                                dataType: 'json',
                                data: { network: 'google', token: user.getAuthResponse().id_token },
                                success: function( response ) {
                                    if ( typeof response === 'object' && response.status === 'login_successful' && response.redirect ) {
                                        return window.location.replace( response.redirect );
                                    }
                                },
                                error: function( xhr, status, error ) {
                                    console.log('Failed', xhr, status, error);
                                }
                            } );
                        } );
                    });
                } );
            }
        </script><?php
        // wp_add_inline_script() throws a warning when including <script> tags.
        return trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', ob_get_clean() ) );
    }

    /**
     * Display "Login with Google" button in auth forms.
     *
     * @since 1.6.3
     */
    public function display_button() { ?>
        <div class="buttons button-2 cts-google-signin"><i class="fa fa-google"></i> <?php _ex( 'Google', 'Login with Google button', 'my-listing' ) ?></div>
    <?php }

    /**
     * Handle the ajax login post request.
     *
     * @param array $request POST request object.
     * @since 1.6.3
     */
    public function handle_request( $request ) {
        $this->request = $request;
        $this->get_user_data();

        if ( $this->login() ) {
            return wp_send_json( [
                'status' => 'login_successful',
                'redirect' => $this->get_login_redirect_url(),
            ] );
        }

        return wp_send_json( [ 'status' => 'login_invalid' ] );
    }

    /**
     * Get user data from their Google profile.
     *
     * @since 1.6.3
     */
    public function get_user_data() {
        if ( empty( $this->request['token'] ) ) {
            return false;
        }

        $response = wp_remote_get( sprintf( 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=%s', $this->request['token'] ) );
        $data = wp_remote_retrieve_body( $response );

        if ( is_wp_error( $data ) ) {
            return false;
        }

        $this->transform_userdata( json_decode( $data ) );
    }

    /**
     * Transform user data object to the format expected by login() method.
     * email      -> data.email
     * first_name -> data.given_name
     * last_name  -> data.family_name
     */
    public function transform_userdata( $data ) {
        $this->userdata = [];

        if ( ! is_object( $data ) || empty( $data->aud ) || $data->aud !== $this->app_id ) {
            return false;
        }

        if ( ! empty( $data->email ) ) {
            $this->userdata['email'] = $data->email;
        }

        if ( ! empty( $data->given_name ) ) {
            $this->userdata['first_name'] = $data->given_name;
        }

        if ( ! empty( $data->family_name ) ) {
            $this->userdata['last_name'] = $data->family_name;
        }
    }
}