<?php
/**
 * Plugin Name: Fast Speed Index
 * Plugin URI: https://ruana.co.jp/fast-speed-index
 * Description: This is a better way to launch your website when your blog is updated.
 * Version: 1.1.0
 * Author: Ruana LLC
 * Author URI: https://ruana.co.jp/
 * Text Domain: fast-speed-index
 * Domain Path: /languages/
 *
 * Copyright 2018 Ruana LLC (email : info@ruana.co.jp)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Initialize plugin and all settings
 */
function fsi_init() {
	require_once( dirname( __FILE__ ) . '/includes/functions.php' );

	/**
	 * Publisher
	 */
	require_once( dirname( __FILE__ ) . '/includes/class-fsi-pubsubhubbub.php' );

	add_action( 'publish_post', array( 'FSI_Pubsubhubbub', 'publish_post' ) );

	/**
	 * Feed customize (optimize pubsubhubbub)
	 */
	add_action( 'atom_head', array( 'FSI_Pubsubhubbub', 'add_atom_link_tag' ) );
	add_action( 'rdf_header', array( 'FSI_Pubsubhubbub', 'add_rss_link_tag' ) );
	add_action( 'rss2_head', array( 'FSI_Pubsubhubbub', 'add_rss_link_tag' ) );
	add_action( 'comments_atom_head', array( 'FSI_Pubsubhubbub', 'add_atom_link_tag' ) );
	add_action( 'commentsrss2_head', array( 'FSI_Pubsubhubbub', 'add_rss_link_tag' ) );
	add_action( 'rdf_ns', array( 'FSI_Pubsubhubbub', 'add_rss_ns_link' ) );
	add_action( 'template_redirect', array( 'FSI_Pubsubhubbub', 'template_redirect' ) );

	/**
	 * Remove every edit time ping option.
	 * Ping when publish post.
	 */
	remove_action('do_pings', 'do_all_pings');
	remove_action("publish_post", "generic_ping");

	/**
	 * Ping Optimize
	 */
	require_once( dirname( __FILE__ ) . '/includes/class-fsi-pingoptimize.php' );

	add_action( 'transition_post_status', array( 'FSI_PingOptimize', 'fsi_ping' ), 10, 3 );
	do_action('do_fsi_pings');
	add_action( 'do_fsi_pings', array( 'FSI_PingOptimize', 'do_fsi_pings' ));
}

function fsi_load_plugin_textdomain(){
	load_plugin_textdomain('fast-speed-index', false, basename(dirname(__FILE__)).'/languages/' );
}


add_action( 'plugins_loaded', 'fsi_init' );
add_action( 'plugins_loaded', 'fsi_load_plugin_textdomain' );
