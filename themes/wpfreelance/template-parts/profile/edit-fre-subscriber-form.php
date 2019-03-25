<?php
	global $skills, $profile_id,$user_ID;
	//$subscriber_skills = get_user_meta($user_ID,'subscriber_skills', true);
	$subscriber_skills = get_post_meta($profile_id,'subscriber_skills', true);
	$skills_followed = explode(";", $subscriber_skills);

   	$skills = get_terms( 'skill', array(
    	'hide_empty' => false));
   	$skill_list = $activate_class = '';
   	$activate_class = 'empty;';

   	if( ! empty( $subscriber_skills) ) {
   		$activate_class = 'not-empty';
   	}

   	if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){

    	$skill_list .=  '<select name="skill" multiple  id="skills_follow" class="skill-follwing form-control " data-placeholder="'.__('Select your skills','boxtheme').'" >';
      	foreach ( $skills as $skill ) {
        	$selected = "";
         	if( in_array($skill->term_id, $skills_followed) ){
            	$selected = ' selected ';
         	}
        	$skill_list .= '<option '.$selected.' value="'.$skill->term_id.'" >' . $skill->name . '</option>';
      	}
      $skill_list.='</select>';
   }
   ?>
<div class="follow-setting edit-profile-section">
	<div class="col-md-12 clear">
		<form class="frm-subscriber-skills">

			<div class="form-group <?php echo $activate_class;?>">
				<div class="col-md-12">
					<h2>Subscriber form</h2>
				</div>
				<div class="col-md-10">
					<?php echo  $skill_list ;?>
				</div>
				<div class="col-md-2"><button class="btn full"><?php _e('Update','boxtheme');?></button></div>
				<input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
			</div>
			<div class="form-group ">
				<div class="col-md-12">
					<p>&nbsp; </p>
					<?php if(  empty( $subscriber_skills) ) { ?>
					<div class="msg-new-job-robot" style="display: block;">
						<p class="msg-alert"><?php _e("Don't miss your next job!",'boxtheme');?></p>
						<p><?php _e('Add your skill then click "Update". We\'ll email you suitable new job.','boxtheme');?></p>
					</div>
					<?php } ?>

				</div>
			</div>
		</form>
	</div>
</div>