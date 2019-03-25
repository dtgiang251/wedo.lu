<?php

namespace MyListing\Ext\Social_Login\Networks;

class Facebook extends Network {
    protected
        $request,
        $userdata,
        $app_id;

    /**
     * Include required scripts and setup settings for Facebook login.
     *
     * @since 1.6.3
     */
    public function __construct() {
        if ( ! $this->is_enabled() ) {
            return false;
        }

        $this->app_id = c27()->get_setting( 'social_login_facebook_app_id' );

        add_action( 'wp_enqueue_scripts', function() {
            wp_add_inline_script( 'c27-main', $this->login_script(), 'before' ); // @todo: Add support for redirect_to url parameter (pass it with JS)
        } );
    }

    /**
     * Check if Sign-In with Facebook is enabled,
     * and an app ID has been provided.
     *
     * @since 1.6.3
     * @return bool
     */
    public function is_enabled() {
        return c27()->get_setting( 'social_login_facebook_enabled' ) && c27()->get_setting( 'social_login_facebook_app_id' );
    }

    /**
     * Attach handler to "Login with Facebook" button.
     *
     * @since 1.6.3
     */
    public function login_script() { ob_start(); ?>
        <script type="text/javascript">
            // Load the SDK asynchronously
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "https://connect.facebook.net/en_US/sdk.js";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '<?php echo esc_attr( $this->app_id ) ?>',
                    cookie     : true,
                    xfbml      : true,
                    version    : 'v3.0'
                });
            };

            jQuery('.cts-facebook-signin').click( function(e) {
                e.preventDefault();

                FB.login( function(response) {
                    if ( response.authResponse ) {
                        jQuery.ajax( {
                            url: CASE27.ajax_url + '?action=cts_login_endpoint&security=' + CASE27.ajax_nonce,
                            type: 'POST',
                            dataType: 'json',
                            data: { network: 'facebook', token: response.authResponse.accessToken },
                            success: function( response ) {
                                if ( typeof response === 'object' && response.status === 'login_successful' && response.redirect ) {
                                    return window.location.replace( response.redirect );
                                }
                            },
                            error: function( xhr, status, error ) {
                                console.log('Failed', xhr, status, error);
                            }
                        } );
                    }
                }, { scope: 'public_profile,email' } );
            } );
        </script><?php
        // wp_add_inline_script() throws a warning when including <script> tags.
        return trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', ob_get_clean() ) );
    }

    /**
     * Display "Login with Facebook" button in auth forms.
     *
     * @since 1.6.3
     */
    public function display_button() { ?>
        <div class="buttons button-2 cts-facebook-signin"><i class="fa fa-facebook"></i> <?php _ex( 'Facebook', 'Login with Facebook button', 'my-listing' ) ?></div>
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
     * Get user data from their Facebook profile.
     *
     * @since 1.6.3
     */
    public function get_user_data() {
        if ( empty( $this->request['token'] ) ) {
            return false;
        }

        $response = wp_remote_get( sprintf( 'https://graph.facebook.com/v2.12/me?fields=id,first_name,last_name,email&access_token=%s', $this->request['token'] ) );
        $data = wp_remote_retrieve_body( $response );

        if ( is_wp_error( $data ) ) {
            return false;
        }

        $this->transform_userdata( json_decode( $data ) );
    }

    /**
     * Transform user data object to the format expected by login() method.
     * email      -> data.email
     * first_name -> data.first_name
     * last_name  -> data.last_name
     */
    public function transform_userdata( $data ) {
        $this->userdata = [];

        if ( ! is_object( $data ) ) {
            return false;
        }

        if ( ! empty( $data->email ) ) {
            $this->userdata['email'] = $data->email;
        }

        if ( ! empty( $data->first_name ) ) {
            $this->userdata['first_name'] = $data->first_name;
        }

        if ( ! empty( $data->last_name ) ) {
            $this->userdata['last_name'] = $data->last_name;
        }
    }
}