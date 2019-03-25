<?php
	global $user_ID;

	$user_data = get_userdata($user_ID );

	$country_id  = get_user_meta( $user_ID, 'location', true );
	$txt_country = 'Unset';
	$ucountry = get_term( $country_id, 'country' );

	if( ! is_wp_error($ucountry ) && ! empty( $ucountry ) ){
		$txt_country = $ucountry->name;
	}

	$country_select = '';
	$countries = get_terms( 'country', array(
    	'hide_empty' => false)
   	);

   if ( ! empty( $countries ) || ! is_wp_error( $countries ) ){
      	$country_select.= '<select name="country" id="country" class="chosen-select form-control" data-placeholder="Choose a country" >';
      	$country_select.= '<option value="">Select your country</option>';
      	foreach ( $countries as $country ) {
        	$country_select .= '<option value="'.$country->term_id .'" '. selected($country->term_id , $country_id, false) .' >' . $country->name . '</option>';
      	}
      	$country_select.= '</select>';
   } else {
   	$country_select == __('List country is empty','boxtheme');
   }
?>
<div id="profile" class="col-md-12 edit-profile-section edit-em-profile">
	<form id="update_profile" class="frm-overview-emp">
		<div class="form-group "><div class="col-md-3 text-center"> <h2><?php _e('Your Profile','boxtheme');?></h2></div></div>
	    <div class="form-group ">
	    	<div class="col-md-3 update-avatar">
	    		<?php
	    		$url = get_user_meta($user_ID,'avatar_url', true);

	    		if ( ! empty($url ) ){
	    			echo '<img class="avatar" src=" '.$url.'" />';
	    		}else {
	    			echo get_avatar($user_ID);
	    		}
	    		?>
	    	</div>
	      	<div class="col-md-9 col-sm-12">
	      		<div class="col-sm-12"><span class="btn-edit btn-edit-default btn-emp-edit"> Edit</span></div>
	      		<div class="full">
		      		<div class="form-group ">
		      			<label class="col-md-2"><?php _e('First name','boxtheme');?>: </label>
		      			<div class="col-md-9">
		      				<div class="line default-show"><span><?php echo $user_data->first_name;?></span> </div>
		      				<div class="line default-hidden">
			      				<input class="form-control" type="text" required name="first_name" value="<?php  echo $user_data->first_name;?>"  placeholder="<?php _e('First Name','boxtheme');?> " id="first-text-input">
			      			</div>
		      			</div>
		      		</div>
		      		<div class="form-group ">
		      			<label class="col-md-2"><?php _e('Last name','boxtheme');?></label>
			      		<div class="col-md-9">
			      			<div class="line default-show"><span><?php echo $user_data->last_name;?></span></div>
		      				<div class="line default-hidden">
			      				<input class="form-control " type="text" required name="last_name" value="<?php  echo $user_data->last_name;?>"  placeholder="<?php _e('Last Name','boxtheme');?> " id="last-text-input">
			      			</div>
			      		</div>
		      		</div>

		      		<div class="form-group ">
		      			<label class="col-md-2"><?php _e('Display name','boxtheme');?></label>
		      			<div class="col-md-9">
		      				<div class="line default-show"><span><?php echo $user_data->display_name ;?></span></div>
		      				<div class="line default-hidden">
			      				<input class="form-control " type="text" required name="display_name" value="<?php  echo $user_data->display_name;?>"  placeholder="<?php _e('Display name','boxtheme');?> " id="display-text-input">
			      			</div>
			      		</div>
		      		</div>

		      		<div class="form-group ">
		      			<label class="col-md-2"><?php _e('Email','boxtheme');?></label>
		      			<div class="col-md-9">
		      				<div class="line default-show"><span><?php echo $user_data->user_email ;?></span></div>
		      				<div class="line default-hidden">
			      				<input class="form-control " type="text" disabled required name="user_email" value="<?php  echo $user_data->user_email;?>"  placeholder="<?php _e('Your email','boxtheme');?> " id="user_email-text-input">
			      			</div>
			      		</div>
		      		</div>

		      		<div class="form-group ">
		      			<label class="col-md-2"><?php _e('Country','boxtheme');?></label>
		      			<div class="col-md-9">
		      				<div class="line default-show"><span><?php echo $txt_country; ?></span></div>
		      				<div class="line default-hidden">
			      				<?php echo $country_select;?>
			      			</div>
			      		</div>
		      		</div>
		      		<input type="hidden" name="is_emp" value="1">
		      	</div>
		      	<div class="is-edit full">
					<div class="form-group">
				      	<div class="offset-sm-10 col-sm-12 pull-right align-right no-padding-right">
				        	<button type="submit" class="btn btn-primary update hide "> &nbsp; <?php _e('Save','boxtheme');?> &nbsp;</button>
				      	</div>
				    </div>
		      	</div>
	      	</div>

	    </div>
	</form>
</div> <!-- end left !-->
<style type="text/css">
	.default-hidden{
		display: none;
	}
	.is-edit .default-hidden{
		display: block;
	}
	.default-show{
		width: 100%;
		display: block;
	}
	.is-edit .default-show{
		display: none;
	}
	.1frm-overview-emp .col-md-9{
		height: 30px;
		overflow: hidden;
		display: block;
		float: left;
	}
	.edit-em-profile .form-group{
		min-height: 23px;
	}
</style>