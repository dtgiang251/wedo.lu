<?php
/**
 *	Template Name: Inbox
 */
?>
<?php get_header(); ?>
<?php
global $user_ID;
$sql = "SELECT *
	FROM  {$wpdb->prefix}box_conversations cv
	INNER JOIN {$wpdb->prefix}box_messages  msg
	ON  cv.ID = msg.cvs_id
	WHERE  ( msg.sender_id = {$user_ID} OR msg.receiver_id = {$user_ID} )
	GROUP BY msg.cvs_id ORDER BY cv.date_modify DESC";
$conversations = $wpdb->get_results($sql); // list conversations
$avatars = array();
?>
<div class="full-width">
	<div class="container site-container ">
		<div class="site-content" id="content" >
			<div class="col-md-12 top-line">&nbsp;</div>
			<div class="col-md-4 list-conversation">
				<div class="full-content ">

					<?php if( $conversations ){?>
						<div class="full search-msg-wrap">
							<div class="col-md-12">
								<form>
										<input type="text" name="s" placeholder="<?php _e('Search conversations','boxtheme');?>" class="form-control" />
								</form>
							</div>
						</div>

					<?php }?>
					<ul class="none-style" id="list_converstaion">
					<?php
					if( $conversations) {
						$i = 0;
						foreach ( $conversations as $key=>$cv ) {

							$user = array();
							$date = date_create( $cv->date_modify );
							$date = date_format($date,"m/d/Y");
							$user = 0;

							if( (int) $cv->sender_id == $user_ID ){

								$user = get_userdata($cv->receiver_id);
							}else{
								$user = get_userdata($cv->sender_id);
							}

							$avatars[$cv->cvs_id] = get_avatar($user->ID );
							$project = get_post($cv->project_id);

							$profile_link = '#';
							$profile_id = is_box_freelancer( $user->ID );
							if( $profile_id ){
								$profile_link = get_author_posts_url($user->ID); // only available for freelancer account.
							}
							if( $user && $project ){
								$class = ''; if($key == 0){	$class = 'acti';	} ?>

								<li class="cv-item <?php echo $class;?>">
									<div class="cv-left"><?php echo get_avatar($user->ID);?></div>
									<div class="cv-right">
										<small class="mdate"><?php echo $date; ?></small>
										<a has_profile="<?php echo $profile_id;?>" href="<?php echo $profile_link;?>" disable class="render-conv" id="<?php echo $cv->cvs_id;?>"><?php echo $user->display_name;?></a>
										<span>( <?php  echo $cv->msg_unread;?>)</span>
										<p><small><?php echo $project->post_title; ?></small></p>
									</div>
								</li><?php
							}
						} // end foreach
					} else { ?>
						<li class="no-item"><?php _e('There is no any conversations yet.','boxtheme');?> </li>
					<?php }?>
				</ul>
				</div>
			</div>
			<div id="box_chat" class="col-md-8 right-message no-padding-right"><?php
				if( $conversations ){
					$first_cvs = 0;
					if( isset($conversations[0]) ){

						$first_cvs = $conversations[0]->cvs_id;
						$first_user_id = $conversations[0]->sender_id;
						if($conversations[0]->sender_id == $user_ID){
							$first_user_id = $conversations[0]->receiver_id;
						}
						$profile_link = '#';
						$first_user = get_userdata($first_user_id);

						if( is_box_freelancer( $first_user_id ) ){
							$profile_link = get_author_posts_url($first_user_id);
							echo '<span class="msg-receiver-name"> To: <a target="_blank" href="'.$profile_link.'" id="display_name">'.$first_user->display_name.'</span></a>';
						} else {
							echo '<span class="msg-receiver-name"> To: <span id="display_name">'.$first_user->display_name.'</span></span>';
						}

						echo '<input type="hidden" value="'.$first_cvs.'" id="first_cvs" />';

					}
					?>

					<div id="container_msg">
						<?php

						if($first_cvs){

							$msgs = BX_Message::get_instance()->get_converstaion( array( 'id' => $first_cvs) );
							foreach ($msgs as $key => $msg) {

								$date = date_create( $msg->msg_date );
								if( $msg->sender_id != $user_ID ){
									$user_label = get_avatar($msg->sender_id  ); ?>
									<div class="msg-record msg-item">
										<div class="col-md-1 no-padding"><?php echo $user_label;?></div>
										<div class="col-md-10 no-padding-left">
											<span class="wrap-text ">
												<span class="triangle-border left"><?php echo $msg->msg_content;?></span>
												<small class="msg-mdate"><?php echo date_format($date,"m/d/Y");?></small>
											</span>
										</div>
									</div><?php
								} else { ?>
									<div class="msg-record msg-item">
										 <div class="col-md-9 pull-right text-right"><span class="wrap-text-me"><span class="my-reply"><?php echo $msg->msg_content;?></span><br /><small class="msg-mdate"><?php echo date_format($date,"m/d/Y");?></small></div>
									</div><?php
								}
							}
						}
						?>
					</div>
					<div id="form_reply">
						<?php if($first_cvs){?>
							<form class="frm-send-message" ><textarea name="msg_content" class="full msg_content required" required rows="3" placeholder="Write a message"></textarea><button type="submit" class="btn btn-send-message align-right f-right">Send</button>
							</form>
						<?php } ?>
					</div>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/html" id="tmpl-msg_record">
	<div class="row">{{{username_sender}}}: {{{msg_content}}} {{{msg_date}}}</div>
</script>
<script type="text/html" id="tmpl-msg_record_not_me"> <!-- use for not current user !-->
	<div class="msg-record msg-item">
		<div class="col-md-1 no-padding">{{{data.avatar}}}</div>
		<div class="col-md-10 no-padding-left"><span class="wrap-text "><span class="triangle-border left">{{{data.msg_content}}} </span> <br /><small class="msg-mdate">{{{data.msg_date}}}</small></span></div>
	</div>
</script>
<script type="text/html" id="tmpl-msg_record_me"> <!-- use for not current user !-->
	<div class="msg-record msg-item">
		<div class="col-md-9 pull-right text-right"><span class="wrap-text-me"><span class="my-reply">{{{data.msg_content}}}</span><br /><small class="msg-mdate">{{{data.msg_date}}}</small> </span></div>
	</div>

</script>
<script type="text/template" id="json_avatar"><?php  echo json_encode($avatars); ?></script>
<style type="text/css">
	.search-msg-wrap{
		background: #f9f9f9;
		padding: 15px 0;
		float: left;
	}
	.site-content{
		background: transparent;
		padding-top: 0;
		padding-bottom: 0;
		min-height: auto;
	}
	.triangle-border.left {
	    margin-left: 30px;
	}

	.triangle-border {
		width: 95%;
		float: left;
	    position: relative;
	    padding: 3px 15px;
	    margin: 0;
	    border: 5px solid #ecf8ff;
	    color: #616161;
	    background: #ecf8ff;
	    -webkit-border-radius: 10px;
	    -moz-border-radius: 10px;
	    border-radius: 10px;
	}
	.triangle-border.left:before {
	    top: -5px;
	    bottom: auto;
	    left: -30px;
	    border-width: 7px 38px 6px 0px;
	    border-color: transparent #ecf8ff;
	}

	.triangle-border:before {
	    content: "";
	    position: absolute;
	    bottom: -20px;
	    left: 40px;
	    border-width: 20px 20px 0;
	    border-style: solid;
	    border-color: #ecf8ff transparent;
	    display: block;
	    width: 0;
	}
	.wrap-text-me{
		float: right;
		clear: both;
	}
	.my-reply{
		float: right;
	    background: rgba(0, 157, 175, 0.95);
	    padding: 5px 15px;
	    color: #fff;
	    border-radius: 5px;
	}
	.my-reply small{
		float: right;
		clear: both;
	}
	.msg-mdate{
		font-size: 13px;
		display: block;
		clear: both;
	}
	#list_msg{
		height: 200px;
		padding-left: 15px;
		padding-left: 15px;
		border:1px solid #e6e6e6;

	}
	.top-line{
		height: 30px;
		border-bottom: 1px solid #e2e2e2;
		background: #fff;
	}
	#container_msg{
		height: 364px;
	    border: 0;
	    padding-left: 15px;
	    overflow-y: auto;
	    border-bottom: 1px solid #e6e6e6;
	    border-right: 1px solid #e6e6e6;
	    margin-bottom: 0;
	}
	.list-conversation{
		background: #fff;
		border-right: 1px solid #e6e6e6;
		padding: 0;
	}
	ul#list_converstaion{
		height: 408px;
		float: left;
		width: 100%;
		padding: 0;
		overflow-y: auto;
		margin: 0;
	}
	.list-conversation .full-content{
		background: #fff;
		overflow: hidden;
		min-height: 486px;
		padding: 15px 0;
		padding-bottom: 0;
	}
	.right-message{
		background: #fff;
		padding-bottom: 0;
		padding-left: 0;
	}
	.msg-item{
		overflow: hidden;
		padding-bottom: 15px;
		width: 100%;
		clear: both;
		margin-bottom: 10px;
	}
	.msg-item img.avatar{
		width: 50px;
		height: 50px;
		margin-right: 13px;
		float: left;
		border-radius: 50%;
	}
	.msg-item .wrap-text{
		position: relative;
		float: left;
		min-width: 120px;
		padding-bottom: 20px;
	}
	.msg-item .wrap-text small{
		position: absolute;
		right: 0;
		bottom: 0;
	}
	.cv-item{
		clear: both;
		display: block;
		width: 100%;
		float: left;
		border-bottom: 1px solid #f1f1f1;
		padding: 9px 10px;
		position: relative;
		border-left:3px solid transparent;
	}
	.cv-item.acti{
		border-left:3px solid #54bf03;
		background-color: #f3f6f8;
	}
	.cv-item:hover{
		background-color: #f3f6f8;
	}
	.cv-item img{
		width: 55px;
		height: 55px;
		border-radius: 50%;
		vertical-align: top;
	}
	.no-item{
		padding-bottom: 21px;
		padding-left: 15px;
	}
	.cv-left{
		width: 25%;
		float: left;
	}
	.cv-right{
		width: 75%;
		float: left;
		overflow: hidden;
		position: relative;
	}
	.mdate{
		position: absolute; top:0;
		right: 0px;
	}
	.msg-record{
		width: 100%;
		clear: both;
	}
	.cv-right small{
		display: inline-block;
	    overflow: hidden;
	    text-overflow: ellipsis;
	    white-space: nowrap;
	}
	textarea{
		border-color: #ececec;
	}
	#form_reply{
		background: #f9f9f9;
		overflow: hidden;
		padding: 17px 30px 17px 30px;
		border:1px solid #e6e6e6;
		border-left: 0;
		border-top: 0;
	}

	.frm-send-message .btn-send-message {
	    right: 2px;
	    top: 2px;
	}
	.msg-receiver-name{
		display: block;
		padding: 15px;
	}

</style>
<?php get_footer();?>

