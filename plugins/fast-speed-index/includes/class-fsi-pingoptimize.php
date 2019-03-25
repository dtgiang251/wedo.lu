<?php
/**
 * The Fast Speed Index Ping Optimize class
 */
class FSI_PingOptimize {
	/**
	 * Get the endpoints (ping url)
	 *
	 * @return get_ping_lists
	 */
	public static function get_ping_lists() {
		$ping_lists = array(
			'http://blog.goo.ne.jp/XMLRPC',
			'http://www.blogpeople.net/servlet/weblogUpdates',
			'http://ping.blo.gs/',
			'http://blogsearch.google.co.jp/ping/RPC2',
			'http://blogsearch.google.com/ping/RPC2',
			'http://rpc.reader.livedoor.com/ping',
			'http://ping.fc2.com/',
			'http://ping.feedburner.com/',
			'http://ping.rss.drecom.jp/',
			'http://wpdocs.sourceforge.jp/Update_Services',
			'http://rpc.pingomatic.com/',
			'http://ping.blogranking.net/',
			'http://ranking.kuruten.jp/ping',
			'http://www.blogstyle.jp/',
			'http://www.blogpeople.net/ping/',
			'http://ping.freeblogranking.com/xmlrpc/',
			'http://rpc.weblogs.com/RPC2',
			'http://services.newsgator.com/ngws/xmlrpcping.aspx',
			'http://ping.dendou.jp/',
			'http://blog.with2.net/ping.php/',
			'http://ping.cocolog-nifty.com/xmlrpc',
			'http://ping.sitecms.net',
			'http://pingoo.jp/ping/',
			'http://taichistereo.net/xmlrpc/',
			'http://ping.blogmura.com/xmlrpc/hidmbp2r256f'
		);
		return $ping_lists;
	}

	public static function fsi_ping($new_status, $old_status, $post){
		global $wpdb;
		if($old_status != 'publish' && $old_status != 'future' && $new_status == 'publish'){
			$post_id=$post->ID;
			$row = $wpdb->get_row("SELECT ID,post_date,post_date_gmt,post_modified,post_status FROM $wpdb->posts WHERE id=$post_id", ARRAY_A);
			wp_schedule_single_event(time(), 'do_fsi_pings',array($post_id));
		}else if($old_status != 'publish' && $new_status == 'future'){
			$post_id=$post->ID;
			$row = $wpdb->get_row("SELECT ID,post_date,post_date_gmt,post_modified,post_status FROM $wpdb->posts WHERE id=$post_id", ARRAY_A);
			wp_schedule_single_event(strtotime($row['post_date_gmt'].' GMT'), 'do_fsi_pings',array($post_id));
		}
	}


	/**
	 * Do Fast Speed Index ping.If publish update , stop ping
	 * @param  integer $post_id the post id
	 *
	 */
	public static function do_fsi_pings($post_id) {
		global $wpdb;
        // Do pingbacks
		while ($ping = $wpdb->get_row("SELECT ID, post_content, meta_id FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = '_pingme' LIMIT 1")) {
			delete_metadata_by_mid( 'post', $ping->meta_id );
			pingback( $ping->post_content, $ping->ID );
		}

        // Do Enclosures
		while ($enclosure = $wpdb->get_row("SELECT ID, post_content, meta_id FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id AND {$wpdb->postmeta}.meta_key = '_encloseme' LIMIT 1")) {
			delete_metadata_by_mid( 'post', $enclosure->meta_id );
			do_enclose( $enclosure->post_content, $enclosure->ID );
		}

        // Do Trackbacks
		$trackbacks = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE to_ping <> '' AND post_status = 'publish'");
		if ( is_array($trackbacks) )
			foreach ( $trackbacks as $trackback )
				do_trackbacks($trackback);

        //Do Update Services/Generic Pings
			self::fsi_generic_ping();
		}


	/**
	 * Fast Speed Index generic ping
	 * @param  integer $post_id the post id
	 * @return int postid
	 */
	public static function fsi_generic_ping( $post_id = 0 ) {
		$services = get_option('ping_sites');

		$services = explode("\n", $services);
		$services = array_merge($services,self::get_ping_lists());


		// clean out any blank values
		foreach ( $services as $key => $value ) {
			if ( empty( $value ) ) {
				unset( $services[ $key ] );
			} else {
				$services[ $key ] = trim( $services[ $key ] );
			}
		}

		foreach ( (array) $services as $service ) {
			$service = trim($service);
			if ( '' != $service )
				weblog_ping($service);
		}

		return $post_id;
	}

}
