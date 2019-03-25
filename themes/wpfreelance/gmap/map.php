<?php

function box_nearby_filter(){
	$request = $_REQUEST['request'];
	$result = get_list_freelancer_by_distance($request);
	$response = array('success' => true, 'data' => $result);
	wp_send_json( $response);
}
add_action( 'wp_ajax_nearby_filter','box_nearby_filter');
add_action('wp_ajax_nopriv_nearby_filter','box_nearby_filter');

function get_skill_html_profile($profile_id){
	$skills = get_the_terms( $profile_id, 'skill' );
	$skill_html = '';
	if ( $skills && ! is_wp_error( $skills ) ){

	  	$draught_links = array();

	  	foreach ( $skills as $term ) {
	    	//$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
	    	$draught_links[] = '<span >'.$term->name.'</span>';
	     	$list_ids[] = $term->term_id;
	  }
	  $skill_html = join( ", ", $draught_links );
	}
	return $skill_html;
}

function get_list_freelancer_by_distance($request){
	$distance = $request['distance'];
	$skills = $request['skill'];
	$keywords = isset($request['keywords']) ? sanitize_text_field($request['keywords']) : '';
	$center_lat = '51.507351';
	$center_lng = '-0.127758'; //London

	global $wpdb;
	$data = array();

	if( isset($request['lat_geo']) ){
		$center_lat = sanitize_text_field($request['lat_geo']);
		$center_lng = sanitize_text_field($request['lng_geo']);
	}
	$data['center_lat'] = $center_lat;
	$data['center_lng'] = $center_lng;

	$grouby= $where_term = false;

	$sql = sprintf("SELECT p.ID , p.post_title,p.post_author, ex.*, ( 3959 * acos( cos( radians('%s') ) * cos( radians( ex.lat_geo ) ) * cos( radians( ex.lng_geo ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( ex.lat_geo ) ) ) ) AS distance", $center_lat, $center_lng,  $center_lat );
	$grouby = true;






	$sql .= sprintf(" FROM $wpdb->posts p ");
	$sql.=" LEFT JOIN  {$wpdb->prefix}profile_extra  ex on p.ID = ex.profile_id ";

	if( ! empty ( $skills) ) {
		$skills = join(",",$skills);
		$sql.= " LEFT JOIN $wpdb->term_relationships t ON p.ID = t.object_id ";
		$grouby = true;
		$where_term = true;
	}
	$where = " WHERE 1 = 1 AND p.post_type = 'profile' AND p.post_status = 'publish' ";
	if( ! empty( $keywords ) ){
		$where .= " AND  p.post_title LIKE '%".$keywords."%' OR  p.post_content LIKE '%".$keywords."%' OR  p.post_excerpt LIKE '%".$keywords."%' ";
		if($where_term){
			$where .= sprintf(" AND (	t.term_taxonomy_id IN (%s) )", $skills);
		}
	} else {
		if($where_term){
			$where .= sprintf("  AND (	t.term_taxonomy_id IN (%s) )", $skills);
		}
	}

	$sql .= $where;

	$sql.=" GROUP BY p.ID ";


	if( $distance > 0 ){
		$sql .=sprintf(" HAVING distance < %s ", sanitize_title($distance)  );
	}
	$sql .= " ORDER BY  distance ";
	$results = $wpdb->get_results($sql);

	$data['rows_txt'] = __( 'No freelancer found.','boxtheme');
	if( $results ){
		foreach ( $results as $profile ){

			$marker = array();
			$profile_id = $profile->ID;
			$professional_title = get_post_meta($profile_id, 'professional_title', true);
			$skill_html = get_skill_html_profile($profile_id);

			$marker['html'] = '<div class="user-marker profile-id-'.$profile_id.'"><div class="marker-avatar half-left">'.get_avatar($profile->post_author).'</div><div class="half-right half"><h2>'.$profile->post_title.'</h2><h3>'.$professional_title.'</h3><div class="full mk-skils">'.$skill_html.'</div></div>';

			$marker['title'] =   $profile->post_title;
			$marker['lat_geo'] = $profile->lat_geo;
			$marker['lng_geo'] = $profile->lng_geo;

			$marker['sql'] = $sql;
			$data[$profile_id] = $marker;


		}
		$data['rows_txt'] = sprintf(__(' %s freelancers found.','boxtheme'), count($results) );
		if( empty($data) ){
			$data['slq'] = $sql;
		}
	} else {
		$data['slq'] = $sql;
	}


	//echo $sql;

	return $data;
}
function get_sample_markers(){
	return array(
		308 => array('lat_geo' => '-38.416097','lng_geo' => '-63.616672'), //argentina
		234 => array('lat_geo' => '52.355518','lng_geo' => '-1.174320'), //England
		232 => array('lat_geo' => '37.663998','lng_geo' => '127.978458'),//korea
		230 => array('lat_geo' => '51.165691','lng_geo' => '10.451526'), //germany
		228 => array('lat_geo' => '46.227638','lng_geo' => '2.213749'),//france
		226 => array('lat_geo' => '36.204824','lng_geo' => '138.252924'), //japan
		209 => array('lat_geo' => '51.507351','lng_geo' => '-0.127758'), //london
		206 => array('lat_geo' => '-14.235004','lng_geo'=> '-51.925280'),//
		204 => array('lat_geo' => '-22.906847','lng_geo' => '-43.172896'),//Brazil - Rop de janeiro
		202 => array('lat_geo' => '-34.603684','lng_geo' => '-58.381559'), //argentina
		200 => array('lat_geo' => '37.090240','lng_geo' => '-95.712891'), //usa
		199 => array('lat_geo' => '53.480759','lng_geo' => '-2.242631'), //machester
		135 => array('lat_geo' => '56.130366','lng_geo' => '-106.346771'), //canada

		67 => array('lat_geo' => '-48.270148','lng_geo' => '-68.225799'), //argentio
		65 => array('lat_geo' => '47.113870','lng_geo' => '-1.512423'), //nante -france
		61 => array('lat_geo' => '-34.607044', 'lng_geo'=>'-60.593863'), //
		63 => array('lat_geo' => '-17.979815','lng_geo' => '-62.462554'), //Bolivia

		58 => array('lat_geo' => '-48.824350','lng_geo' => '-68.075053'), //Argentina
		56 => array('lat_geo' => '51.644772','lng_geo' => '-1.185306'), //Oxford England

		54 => array('lat_geo' => '48.135125','lng_geo' => '11.581980'), //gemany munich

		52 => array('lat_geo' => '49.281513','lng_geo' => '3.466190'), //France

		50 => array('lat_geo' => '-22.705755','lng_geo' => '-47.327906'), //decarr-france

		48 => array('lat_geo' => '44.071110','lng_geo' => '2.235722'), //France
		46 => array('lat_geo' => '52.203307','lng_geo' => '0.134415'), //England

	);
}
function map_remove_all_sample(){
	global $wpdb;
	$sql  ="DELETE  FROM {$wpdb->prefix}profile_extra";
	$wpdb->query($sql);
	update_option('is_inserted_markers','0');
}
function insert_markers_sample(){
	$markers = get_sample_markers();
	global $wpdb;
	$check = get_option('is_inserted_markers', true);

	if( $check !== '5'){
		foreach ($markers as $key => $marker) {
			$sql = sprintf("INSERT INTO {$wpdb->prefix}profile_extra (`extra_id`, `profile_id`, `lat_geo`, `lng_geo`) VALUES (NULL, '%s', '%s', '%s')",$key, $marker['lat_geo'],$marker['lng_geo'] );
			$wpdb->query($sql);
		}
		update_option('is_inserted_markers','5');
	}


}
function creata_extra_table(){

		global $wpdb;
		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}
		$tables = "	CREATE TABLE {$wpdb->prefix}profile_extra (
		  	extra_id bigint(20) NOT NULL AUTO_INCREMENT,
		  	profile_id bigint(20) NOT NULL,
		  	lat_geo  float(10,7)  NOT NULL,
		  	lng_geo  float(10,7) NOT NULL,
		  	PRIMARY KEY  (extra_id),
		 	UNIQUE KEY extra_id (extra_id)
		) $collate";

		$is_added = get_option('is_added_extra_table', true);


		if(  $is_added !== '2'){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$insert = dbDelta( $tables );
			if( $insert ){
				update_option( 'is_added_extra_table', '2');
			}
		}
}

function box_create_table_extra(){
	//drop_profile_extra_table();
	creata_extra_table();
	// change_column_name();
}
function drop_profile_extra_table($table_name = 'profile_extra'){

    global $wpdb;
    $table_name_prepared = $wpdb->prefix . $table_name;
    $the_removal_query = "DROP TABLE IF EXISTS {$table_name_prepared}";

    $wpdb->query( $the_removal_query );
    update_option('is_inserted_markers', 0 );
    update_option('is_added_extra_table', 0 );


}
function change_column_name(){
	global $wpdb;
 	$sql = "ALTER TABLE {$wpdb->prefix}profile_extra RENAME COLUMN 'lat' TO 'lat_geo' ";
 	$sql2 = "ALTER TABLE {$wpdb->prefix}profile_extra RENAME COLUMN 'lng' TO 'lng_geo' ";
 	$wpdb->query($sql);
 	$wpdb->query($sql2);
}
add_action('after_setup_theme','box_create_table_extra');

function update_geo_location($profile_id, $lat_geo, $lng_geo){

	global $wpdb;
	$profile = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}profile_extra WHERE profile_id = ".$profile_id );
	if( ! $profile ){
		//$sql = sprintf("INSERT INTO {$wpdb->prefix}profile_extra (`extra_id`, `profile_id`, `lat_geo`, `lng_geo`) VALUES ( NULL, '%s', '%s', '%s')",$profile_id, $lat_geo,$lng_geo );
		$wpdb->prepare("INSERT INTO {$wpdb->prefix}profile_extra (`extra_id`, `profile_id`, `lat_geo`, `lng_geo`) VALUES ( NULL, '%s', '%s', '%s')",  $lat_geo, $lng_geo, $profile_id) ;

	}else {
		$sql  = $wpdb->prepare("UPDATE {$wpdb->prefix}profile_extra	SET lat_geo = %s, lng_geo = %s	WHERE profile_id = %s	",  $lat_geo, $lng_geo, $profile_id) ;
	}

	$wpdb->query( $sql);
}
?>