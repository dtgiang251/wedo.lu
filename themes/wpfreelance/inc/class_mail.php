<?php
Class Box_Email{
	static $_instance;
	public $option;
	function __construct(){
		$this->option = BX_Option::get_instance()->get_mailing_setting();
	}
	static function get_instance(){
		if ( ! isset(self::$instance) ){
			 self::$_instance = new self();
		}
		return self::$_instance;
	}
	function get_header($option){
		//font-family: 'Roboto Condensed', sans-serif;
		//font-family: 'Roboto', sans-serif;
		//font-family: 'Raleway', sans-serif;
		//font-family: 'Open Sans', sans-serif;
		$rlt =  is_rtl() ? "rtl" : "ltr";
		$rightmargin = is_rtl() ? 'rightmargin' : 'leftmargin';
		$header = '<!DOCTYPE html>
		<html dir="'.$rlt.'">
			<body '.$rightmargin.'="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#ececec">
				<div id="wrapper" dir="'.$rlt.'">
					<table border="0" cellpadding="0" class="main-body" cellspacing="0" height="100%" width="100%" bgcolor="#ececec">
						<tr>
							<td align="center" valign="top" cellpadding="0" cellspacing="0" >
								<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" bgcolor="#fff">';
									$header .='<tr>
									</tr>
									<tr>
										<td align="center" valign="top">
											<!-- Body -->
											<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
												<tr>
													<td valign="top" id="body_content">
														<!-- Content -->
														<table border="0" cellpadding="20" cellspacing="0" width="100%">
															<tr>
																<td valign="top">
																	<div id="body_content_inner">';
		return $header;
	}
	function get_footer( $option ){
		$foo_txt = wpautop( wp_kses_post( wptexturize( apply_filters( 'box_email_footer_text', get_option( 'box_email_footer_text' ) ) ) ) );

														$foo_txt = 	'</div>
																</td>
															</tr>
														</table>
														<!-- End Content -->
													</td>
												</tr>
											</table>
											<!-- End Body -->
										</td>
									</tr>
								

								</table>
							</td>
						</tr>
					</table>
				</div>
			</body>
		</html>';
		return $foo_txt;
	}
	function send_mail( $to, $subject, $message, $header  ){

		$header_mail = $this->get_header($this->option);
		$footer_mail = $this->get_footer($this->option);
		$msg = $header_mail.$message.$footer_mail;


		//add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		return wp_mail( $to, $subject, $msg , $header);

		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}
	public function get_content_type() {
		return 'text/plain';
		// switch ( $this->get_email_type() ) {
		// 	case 'html' :
		// 		return 'text/html';
		// 	case 'multipart' :
		// 		return 'multipart/alternative';
		// 	default :
		// 		return 'text/plain';
		// }
	}
	function get_from_name(){

		return wp_specialchars_decode( esc_html( $this->option->from_name ), ENT_QUOTES );
	}
	public function get_from_address() {

		return sanitize_email( $this->option->from_address );
	}

}
function box_mail( $to, $subject, $message, $header = '' ) {


	return Box_Email::get_instance()->send_mail( $to, $subject, $message, $header );
}
class Box_ActMail {
	static $_instance;
	public static function get_instance(){
		if ( ! isset(self::$instance) ){
			 self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * send 2 emails. 1 to register. 1 to admin.
	**/
	function act_signup_mail( $user, $mail_to ){


		$verify_link = box_get_static_link('verify');

		$activation_key =  get_password_reset_key( $user);

		$link = add_query_arg(
			array(
				'user_login' => $user->user_login,
				'key' => $activation_key
			) ,
			$verify_link
		);


		$mail = BX_Option::get_instance()->get_mail_settings('new_account_confirm');

		$subject = $mail->subject;
		$content = $mail->content;

		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ( $subject ) );

		$content = str_replace('#display_name', $user->display_name, $content);
		$content = str_replace('#home_url', home_url(), $content );
		$content = str_replace('#user_login', $user->user_login, $content);
		$content = str_replace('#link', esc_url($link), $content);

		// send to register.
		box_mail( $mail_to, $subject, stripslashes($content) );

		$mail = BX_Option::get_instance()->get_mail_settings('new_account_noti' );

		$admin_email = get_option( 'admin_email');

		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ( $mail->subject ) );

		$noti_content = str_replace('#user_login', $user->user_login, $mail->content);
		$noti_content = str_replace('#blog_name', get_bloginfo('name'), $noti_content);
		$noti_content = str_replace( '#user_email', $user->user_email, $noti_content );
		//$content = str_replace('#user_', $user->user_login, $mail->content);

		box_mail( $admin_email, $subject, $noti_content);
	}
	function verified_success( $user ){
		$mail = BX_Option::get_instance()->get_mail_settings('verified_success');

		$subject = $mail->subject;
		$content = $mail->content;

		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ( $subject ) );

		$content = str_replace('#display_name', $user->display_name, $content);
		$content = str_replace('#blog_name', get_bloginfo('name'), $content);
		$content = str_replace('#user_login', $user->user_login, $content);
		$content = str_replace('#user_email', $user->user_email, $content);
		$content = str_replace('#home_url', home_url(), $content );


		return box_mail( $user->user_email, $subject, stripslashes($content) );
	}
	function send_reconfirm_email( $current_user ){

		$activation_key = get_password_reset_key($current_user);
		$link = box_get_static_link('verify');
		$link = add_query_arg( array( 'user_login' => $current_user->user_login ,  'key' => $activation_key) , $link );
		if ( ! is_wp_error( $activation_key ) ){
			$subject = sprintf( __('Re-confirmation email from %s','boxtheme'), get_bloginfo('name') );
			$message = sprintf( __( 'Hello %s,<p>This is new confirmation email from %s.</p>Kindly click <a href="%s">here</a> to active your account.<p>Regards,','boxtheme'), $current_user->display_name, get_bloginfo('name'), $link );
			return box_mail( $current_user->user_email, $subject, $message );
		}
		return $activation_key;
	}


	function mail_reset_password( $user){
		//$mail = BX_Option::get_instance()->get_mail_settings('new_account');
		$activation_key =  get_password_reset_key( $user);
		$link = box_get_static_link('reset-password');
		$link = add_query_arg( array('user_login' => $user->user_login,  'key' => $activation_key) , $link );


		$mail =BX_Option::get_instance()->get_mail_settings('reset_password');
		$subject = str_replace('#blog_name', get_bloginfo('name'), stripslashes ($mail->subject) );

		$content = str_replace('#user_login', $user->display_name, $mail->content);

		$content = str_replace('#display_name', $user->display_name, $content);
		$content = str_replace('#blog_name', get_bloginfo('name'), $content);
		$content = str_replace('#home_url', home_url(), $content);
		$content = str_replace('#reset_link', esc_url($link), $content);


		box_mail( $user->user_email, $subject, stripslashes($content) );
	}
	/**
	 * Send an email to owner project let he know has new bidding in his project.
	 **/
	function has_new_bid($project){


		$mail = BX_Option::get_instance()->get_mail_settings('new_bidding');

		$content = str_replace("#project_link", get_permalink( $project->ID), $mail->content);
		$content = str_replace("#project_name", $project->post_title, $content);

		$author = get_userdata( $project->post_author );

		$content = str_replace("#display_name", $author->display_name, $content);

		box_mail( $author->user_email, $mail->subject, $content );

	}

	/**
	 * send an email to freelancer when employer create a conversion with this freelancer
	**/
	function has_new_conversation($freelancer_id, $employer, $project){

		$mail = BX_Option::get_instance()->get_mail_settings('new_converstaion');
		$freelancer = get_userdata($freelancer_id);

		$subject =  $mail->subject;

		$content = str_replace("#project_name", $project->post_title, $mail->content);
		$content = str_replace("#project_link", get_permalink( $project->ID), $content);

		$content = str_replace("#employer_name", $employer->display_name, $content);

		$content = str_replace("#display_name", $freelancer->display_name, $content);

		box_mail( $freelancer->user_email, $subject, $content );

	}
	function assign_job( $freelancer_id, $project_id ){
		$mail = BX_Option::get_instance()->get_mail_settings('assign_job');
		$subject =  $mail->subject;

		$content = str_replace("#project_name", $project->post_title, $mail->content);
		$content = str_replace("#project_link", get_permalink( $project->ID), $content);

		$author = get_userdata( $freelancer_id );
		box_mail( $author->user_email, $subject, $content );

	}
	function subscriber_match_skill($project_id, $header, $admin_email){
		$project = get_post($project_id);
		$mail = BX_Option::get_instance()->get_mail_settings('subscriber_skill');
		$subject =  $mail->subject;
		// $terms = get_the_terms( $project, 'skill' );
		$terms = wp_get_post_terms($project_id, 'skill', array("fields" => "all"));
		$description = $project->post_content;
		$name = get_field('votre_nom',$project_id);
		$emailclient = get_field('votre_mail',$project_id);
		$dateproject = get_field('expired_date',$project_id);
		$phoneclient = get_field('n_de_tel',$project_id);
		$addressproject = get_field('adresse_des_travaux',$project_id);

		$skill_html = '';
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
			  	$skill_html.='<a class="link-skill  link-skill" href="' . get_term_link($term).'">' . $term->name . '</a>, ';
			}

		}

		$employer = get_userdata($project->post_author);
		$time = date( 'H:i', current_time( 'timestamp', 1 ));
		$date = date( 'F n, Y', current_time( 'timestamp', 1 ));
		$content = str_replace("#project_name", $project->post_title, $mail->content);
		$content = str_replace("#project_link", get_permalink( $project->ID), $content);
		$content = str_replace("#author_name", $employer->display_name, $content);
		$content = str_replace("#skill_list", $skill_html, $content);
		$content = str_replace("#description", $description, $content);
		$content = str_replace("#date", $dateproject, $content);
		$content = str_replace("#nameclient", $name, $content);
		$content = str_replace("#emailclient", $emailclient, $content);
		$content = str_replace("#phoneclient", $phoneclient, $content);
		$content = str_replace("#addressproject", $addressproject, $content);
		$content = str_replace("%admin_email%", $admin_email, $content);
		$content = str_replace("%time%", $time, $content);
		$content = str_replace("%date%", $date, $content);
		box_mail( $admin_email, $subject, stripslashes($content), $header);
	}

}