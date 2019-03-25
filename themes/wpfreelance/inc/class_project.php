<?php
if ( ! defined( 'ABSPATH' ) ) exit;

Class BX_Project extends BX_Post{
	static protected $instance;
	function __construct(){
		$this->post_type = PROJECT;
		add_action( 'after_insert_'.$this->post_type, 'do_after_insert');
	}
	static function get_instance(){
		if (null === static::$instance) {
        	static::$instance = new static();
    	}
    	return static::$instance;
	}
	function get_meta_fields(){
		return array( BUDGET,WINNER_ID,'priority');
	}
	function get_taxonomy_fields(){
		return array('project_cat', 'skill');
	}

	function get_hierarchica_taxonomy(){
		return array('project_cat');
	}
	function get_nonhierarchica_taxonomy(){
		return array('skill');
	}

	function insert($args){		
		if(is_user_logged_in()) {
			global $user_ID;
			$user_ID = $user_ID;
		} else{
			$email = $args['acf']['field_5ab8ab1066c9e'];
			$name = $args['acf']['field_5ab8aa6eceb92'];
			$exists = email_exists( $email );
			if($exists){
				$user_ID = $exists;
			} else{
				$userdata = array(
					'user_login'  =>  $email,
					'user_email'  =>  $email,
					'first_name' => $name
				);
				$user_ID = wp_insert_user( $userdata ) ;
			}
			if($user_ID){
				// wp_clear_auth_cookie();
                // wp_set_current_user ( $user_ID );
                // wp_set_auth_cookie  ( $user_ID );
			}

		}
		$args['post_author'] 	= $user_ID;
		$args['post_status'] 	= 'draft';
		$args['post_type'] 		= $this->post_type;
		$args['meta_input'] 	= array();
		$metas 			= $this->get_meta_fields();
		$taxonomies 	= $this->get_taxonomy_fields();

		foreach ($metas as $key) {
			if ( !empty ( $args[$key] )  ){
				$args['meta_input'][$key] = $args[$key];
			}

		}
		$nonhierarchica = $this->get_nonhierarchica_taxonomy();
		$hierachice 	= $this->get_hierarchica_taxonomy();
		foreach ($taxonomies as $tax) {
			if ( !empty ( $args[$tax] )  ){
				$args['tax_input'][$tax] = $args[$tax];
			}
		}
		foreach ( $hierachice as $tax ) {
			if ( !empty ( $args['tax_input'][$tax] )  ){
				$args['tax_input'][$tax] = array_map('intval', $args['tax_input'][$tax]); // auto insert tax if admin post project. #111
			}
		}
		 
	
		//https://developer.wordpress.org/reference/functions/wp_insert_post/
		$check = $this->check_before_insert( $args );
		if ( ! is_wp_error( $check ) ){
			$skill = $args['tax_input']['skill'];
			if( isset( $skill ) && !empty( $skill ) ) {
				$skill_term = get_term_by('id', absint($skill), 'skill');
				if( $skill_term ) {
					$args['tax_input']['skill'] = $skill_term->slug;
				}
			}
			$project_id = wp_insert_post($args);
	
			if ( ! is_wp_error( $project_id ) ){
				if( isset($args['attach_ids']) ){
					foreach ($args['attach_ids'] as $attach_id) {
						wp_update_post( array(
							'ID' => $attach_id,
							'post_parent' => $project_id
							)
						);
					}
				}
				if(isset($args['project_cat'])){
					$term_taxonomy_ids = wp_set_object_terms( $project_id, intval($args['project_cat']), 'project_cat' );
				}
				
				// if( !current_user_can( 'manage_option' ) ){
					$this->update_post_taxonomies($project_id, $args); // #222 - back up for #111 when employer post project.
				// }

				$count_posted = (int) get_user_meta( $user_ID,'project_posted', true ) + 1;
				update_user_meta( $user_ID, 'project_posted', $count_posted);
				do_action('update_acf_fields', $project_id, $args);
				// $this->do_after_insert_job( $project_id, $args);
				$user = get_userdata( $user_ID );
				$to = 'info@wedo.lu';
				$subject = $user->user_login .' has posted project, please see/approve this project';
				$link = admin_url() . 'post.php?post='. $project_id .'&action=edit';
				$body = 'Project URL: <a href="'. $link .'">'. $link .'</a>';
				$headers = array('Content-Type: text/html; charset=UTF-8');
				 
				wp_mail( $to, $subject, $body, $headers );

				return $project_id;

			}
			return new WP_Error( 'insert_fail',  $project_id->get_error_message() );

		} else {

			return new WP_Error( 'insert_fail',$check->get_error_message()  );
		}

		return $id;
	}
	/**
	 * send email to subscriber .
	 * @since 1.0
	*/
	function do_after_insert_job($project_id, $args){
		/* $is_translated = apply_filters( 'wpml_element_has_translations', NULL, $project_id, 'project' );
 
        if ( !$is_translated ) {
         do_action( 'wpml_admin_make_post_duplicates', $project_id );
		} */
		$skills = isset($args['skill']) ? $args['skill']:'';


		if ( ! empty($skills)) {
			$args  = array(
				'post_type' => 'profile',
				'post_status' => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'skill',
						'field'    => 'term_id',
						// 'field'    => 'slug',
						'terms'    => $skills,
						'operator' => 'IN'
					),
				),

				'meta_query' => array(
					array(
						'key'     => 'is_subscriber',
						'value'   => 1,
					),
				),
				'posts_per_page' => -1,
			);

			$profiles = new WP_Query($args);
			
			if ( $profiles->have_posts() ) {
				$emails = array();
				$admin_email = get_option( 'admin_email' );
				$headers[] = 'From: '.get_bloginfo( 'name', 'display' ).' <'.$admin_email.'>';
				while($profiles->have_posts()){
					global $post;
					$profiles->the_post();
					$freelancer_data = get_userdata( $post->post_author );
					$secondary_notification_email = get_user_meta($freelancer_data->ID,'secondary_notification_email', true);
					if($secondary_notification_email){
					$headers[] = 'Bcc: '.$freelancer_data->user_email.','.$secondary_notification_email;
					} else {
					$headers[] = 'Bcc: '.$freelancer_data->user_email;
					}
				}

				Box_ActMail::get_instance()->subscriber_match_skill($project_id, implode("\r\n", $headers), $admin_email);
			}
		}
	}

	/**
	 * [convert description]
	 * This is a cool function
	 * @author boxtheme
	 * @version 1.0
	 * @return  [type] [description]
	 */
	function convert($post){

		$result = parent::convert($post);

		$profile_id =get_user_meta($post->post_author,'profile_id', true);
		global $currency_sign;
		$total_spent = (float) get_user_meta( $post->post_author, TOTAL_SPENT_TEXT, true);


		$result->total_spent_txt = sprintf( __( 'Spent %s','boxtheme'),box_get_price_format($total_spent) );
		$result->budget_txt = sprintf( __( 'Budget: %s','boxtheme'), box_get_price_format($result->_budget) );

		$result->location_txt =  get_user_meta( $post->post_author, 'location_txt', true); // country of emplo

		$not_set = __('Not set','boxtheme');
		$result->country = $not_set;
		$result->time_txt = bx_show_time($result);
		$result->short_des = wp_trim_words( $result->post_content, 62);
		$result->posted_time = human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago';
		$result->address = get_field('adresse_des_travaux');
		$result->mail = get_field('votre_mail');

		if( $profile_id ){

			$pcountry = get_the_terms( $profile_id, LOCATION_CAT );

			if( !empty ( $pcountry ) ) {
				$result->location_txt =  $pcountry[0]->name;
			}

		}

		return $result;
	}
	function update_status($data){

		if( is_current_box_administrator() ){
			$project_id = $data['ID'];
			$t = wp_update_post( array('ID' => $project_id,'post_status' => $data['post_status']) );
			if( ! is_wp_error( $t ) ){
				return true;
			}
			return $t;
		}
		return new WP_Error('deny',__('You are not allowed to perform this action','boxtheme') );

	}

	function check_before_post($args){

		if( !is_user_logged_in() ){
			return new WP_Error( 'not_logged', __( "Please log in your account again.", "boxtheme" ) );
		}
		return true;
	}
}