<?php
/**
 * The Fast Speed Index PubSubHubBub class
 */
class FSI_Pubsubhubbub {
	/**
	 * Function that is called whenever a new post is published
	 *
	 * @param int $post_id the post-id
	 */
	public static function publish_post( $post_id ) {
		// we want to notify the hub for every feed
		$feed_urls   = array();
		$feed_urls[] = get_bloginfo( 'atom_url' );
		$feed_urls[] = get_bloginfo( 'rdf_url' );
		$feed_urls[] = get_bloginfo( 'rss2_url' );

		if ( current_theme_supports( 'microformats2' ) ) {
			$feed_urls[] = site_url( '/' );
		}

		self::publish_to_hub( $feed_urls );
	}

	/**
	 * Accepts either a single url or an array of urls
	 *
	 * @param string|array $topic_urls a single topic url or an array of topic urls
	 */
	public static function publish_update( $topic_urls, $hub_url ) {
		if ( ! isset( $hub_url ) ) {
			return new WP_Error( 'missing_hub_url', __( 'Please specify a hub url', 'fast-speed-index' ) );
		}

		if ( ! preg_match( '|^https?://|i', $hub_url ) ) {
			/* translators: %s is the $hub_url */
			return new WP_Error( 'invalid_hub_url', sprintf( __( 'The specified hub url does not appear to be valid: %s', 'fast-speed-index' ), $hub_url ) );
		}

		if ( ! isset( $topic_urls ) ) {
			return new WP_Error( 'missing_topic_url', __( 'Please specify a topic url', 'fast-speed-index' ) );
		}

		// check that we're working with an array
		if ( ! is_array( $topic_urls ) ) {
			$topic_urls = array( $topic_urls );
		}

		// set the mode to publish
		$post_string = 'hub.mode=publish';
		// loop through each topic url
		foreach ( $topic_urls as $topic_url ) {
			// lightweight check that we're actually working w/ a valid url
			if ( preg_match( '|^https?://|i', $topic_url ) ) {
				// append the topic url parameters
				$post_string .= '&hub.url=' . esc_url( $topic_url );
			}
		}

		$wp_version = get_bloginfo( 'version' );
		$user_agent = apply_filters( 'http_headers_useragent', 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ) );

		$args = array(
			'timeout' => 100,
			'limit_response_size' => 1048576,
			'redirection' => 20,
			'user-agent' => "$user_agent",
			'body' => $post_string,
		);

		// make the http post request
		return wp_remote_post( $hub_url, $args );
	}

	/**
	 * The ability for other plugins to hook into the PuSH code
	 *
	 * @param array $feed_urls a list of feed urls you want to publish
	 */
	public static function publish_to_hub( $feed_urls ) {
		// remove dups (ie. they all point to feedburner)
		$feed_urls = array_unique( $feed_urls );

		// get the list of hubs
		$hub_urls = self::get_hubs();

		// loop through each hub
		foreach ( $hub_urls as $hub_url ) {
			// publish the update to each hub
			$response = self::publish_update( $feed_urls, $hub_url );
			do_action( 'pubsubhubbub_publish_update_response', $response );
		}
	}


	/**
	 * Get the endpoints from the WordPress options table
	 * valid parameters are "publish" or "subscribe"
	 *
	 * @return hub_urls
	 */
	public static function get_hubs() {
		$hub_urls = array(
			'https://pubsubhubbub.appspot.com',
			'https://pubsubhubbub.superfeedr.com',
		);
		return $hub_urls;
	}

	/**
	 * Add hub-<link> to the Atom feed
	 */
	public static function add_atom_link_tag() {
		// check if current url is one of the feed urls
		if ( ! fsi_show_discovery() ) {
			return;
		}

		$hub_urls = pubsubhubbub_get_hubs();

		foreach ( $hub_urls as $hub_url ) {
			printf( '<link rel="hub" href="%s" />', $hub_url ) . PHP_EOL;
		}
	}

	/**
	 * Add hub-<link> to the RSS/RDF feed
	 */
	public static function add_rss_link_tag() {
		// check if current url is one of the feed urls
		if ( ! fsi_show_discovery() ) {
			return;
		}

		$hub_urls = pubsubhubbub_get_hubs();

		foreach ( $hub_urls as $hub_url ) {
			printf( '<atom:link rel="hub" href="%s"/>', $hub_url ) . PHP_EOL;
		}
	}

	/**
	 * Add Atom namespace to rdf-feed
	 */
	public static function add_rss_ns_link() {
		echo ' xmlns:atom="http://www.w3.org/2005/Atom" ' . PHP_EOL;
	}

	/**
	 * Adds link headers as defined in the current v0.4 draft
	 */
	public static function template_redirect() {
		// check if current url is one of the feed urls
		if ( ! fsi_show_discovery() ) {
			return false;
		}

		$hub_urls = pubsubhubbub_get_hubs();
		// add all "hub" headers
		foreach ( $hub_urls as $hub_url ) {
			header( sprintf( 'Link: <%s>; rel="hub"', $hub_url ), false );
		}

		// add the "self" header
		header( sprintf( 'Link: <%s>; rel="self"', pubsubhubbub_get_self_link() ), false );
	}
}
