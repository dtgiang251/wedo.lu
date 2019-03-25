<?php
	global $user_ID, $current_user, $profile;
	$placehoder_txt = __('WordPress Developer','boxtheme');
	$professional_title = !empty( $profile->professional_title ) ? $profile->professional_title : $placehoder_txt;
	$url = get_user_meta($user_ID,'avatar_url', true);
	global $post;
	setup_postdata( $profile );
	$is_available = ($profile->post_status == 'publish') ? 'checked' : ''; //publish or inactive

?>
<div id="profile" class="col-md-12 edit-profile-section overview-section">
	<input type="hidden" name="profile_id"  id= "profile_id" value="<?php echo $profile->ID;?>" >
	<div class="form-group "><h2 class="col-md-12"> <?php _e('Overviews','boxtheme');?></h2></div>
	<div class="col-md-3 update-avatar">
		<?php if ( ! empty($url ) ){ echo '<img class="avatar" src=" '.$url.'" />'; } else {echo get_avatar($user_ID); } ?>
		<div class="full">
			<p> </p><p> </p>
		    <input class="tgl tgl-flat " rel="Title" id="is_available" <?php echo $is_available;?> type="checkbox"/>
		    <label class="tgl-btn" for="is_available"></label>

		</div>
	</div>
	<div class="col-md-9 col-sm-12">
		<form id="update_profile" class="row-section">
	      		<span class="btn-edit btn-edit-default"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</span>
	            <div class="form-group">
	        	   <h2 class="static visible-default" > <?php echo $current_user->display_name;?></h2>
	        	   <input class=" update hide form-control" type="text" value="<?php echo $current_user->display_name;?>" name="post_title">
	            </div>
	            <div class="form-group">
	            	<h3 class=" static visible-default no-padding primary-color" ><?php echo $professional_title;?></h3>
	            	<input type="text" class="update hide  form-control" placehoder = "<?php echo $placehoder_txt; ?>"  value="<?php echo $professional_title;?>" name="professional_title" >
	            	<input type="hidden" name ="ID" value="<?php echo $profile->ID;?>">
	            </div>
	            <div class="form-group ">
	            	<div class="static visible-default edit-profile-content author-overview"> <?php if( empty($profile->post_content) ) _e('Update your cover letter here','boxtheme'); else echo get_the_content(); ?></div>
	            	<textarea class="update hide form-control" name="post_content" cols="50" rows="6" placeholder="<?php _e("Update your cover letter here","boxtheme");?>" ><?php echo get_the_content();?></textarea>
	            </div>

	      	<div class="form-group">
		      	<div class="offset-sm-10 col-sm-12 align-right  no-padding-right">
		        	<button type="submit" class="btn btn-primary update hide"> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
		      	</div>
		    </div>
		</form>

	</div> <!-- end left !-->
</div>