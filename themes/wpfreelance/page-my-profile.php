<?php
/**
 *	Template Name: Profile of current user.
 */
?>
<?php get_header(); ?>
<?php global $current_user, $profile, $profile_id, $user_ID, $current_user,$skills;
					$role = bx_get_user_role();					
					/*$args = array(
						'post_type' => 'profile',
						'author' => $user_ID
					);
					$query = new WP_Query( $args );
					if($query->have_posts()): 
					while($query->have_posts()): $query->the_post();
					update_user_meta( $user_ID, 'profile_id', $query->post->ID );
					endwhile; 
				    endif; wp_reset_query(); */
					$profile_id = get_user_meta($user_ID,'profile_id', true);
					$current_user = wp_get_current_user();
					
					if( $profile_id ){
						$profile = BX_Profile::get_instance()->convert($profile_id);
						if( $role == FREELANCER ){?>

 <div class="full-width">
        <div class="site-content" id="content">
            <div id="quote-page-head">
                <figure class="page-head-image">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/skill-banner.png" alt="image">
                </figure>
                <div class="container">
                    <div class="description">
                        <h1><?php _e('Recevoir des demandes de devis pour vos competences','boxtheme');?></h1>
                    </div>
                </div>
            </div>
			<!-- Drop Your New code-->
			<?php 	global $user_ID;
	$profile_id 	= get_user_meta($user_ID,'profile_id', true);
	$profile 		= BX_Profile::get_instance()->convert($profile_id);
	$user_data = get_userdata($user_ID );
	$is_subscriber = $profile->is_subscriber;


   	$txt_country = $slug = $skill_val = $country_select = $phone_number = $address ='';
   	$pcountry = get_the_terms( $profile_id, 'country' );
   	if( !empty($pcountry) ){
    	$txt_country =  $pcountry[0]->name;
      	$slug = $pcountry[0]->slug;
   	}

   	$countries = get_terms( 'country', array(
    	'hide_empty' => false)
   	);

   if ( ! empty( $countries ) || ! is_wp_error( $countries ) ){
      	$country_select.= '<select name="country" id="country" class="chosen-select form-control" data-placeholder="Choose a country" data-no_results_text="'.__('No results match','boxtheme').'">';
      	foreach ( $countries as $country ) {
        	$country_select .= '<option value="'.$country->slug.'" '. selected($country->slug, $slug, false) .' >' . $country->name . '</option>';
      	}
      	$country_select.= '</select>';
   } else {
   	$country_select == __('List country is empty','boxtheme');
   }


   	$list_ids = array();
   	$skills = get_the_terms( $profile_id, 'skill' );

   	if ( $skills && ! is_wp_error( $skills ) ){

      	$draught_links = array();

      	foreach ( $skills as $term ) {
        	$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
         	$list_ids[] = $term->term_id;
      	}
      	$skill_val = join( ", ", $draught_links );
   	}

   	$skills = get_terms( 'skill', array(
    	'hide_empty' => false));
   	$skill_list = '';

   	if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){

    	$skill_list .=  '<select name="skill" multiple  id="skill" class="chosen-select form-control" data-placeholder="'.__('Select your skills','boxtheme').'" data-no_results_text="'.__('No results match','boxtheme').'">';
      	foreach ( $skills as $skill ) {
        	$selected = "";
         	if( in_array($skill->term_id, $list_ids) ){
            	$selected = ' selected ';
         	}
        	$skill_list .= '<option '.$selected.' value="'.$skill->slug.'" >' . $skill->name . '</option>';
      	}
      $skill_list.='</select>';
   }?>
            <div class="quote-wrapper">
                <div class="row">
                    <div class="col-lg-12 text-center notification-box">
                        <p><?php _e('Select your practice areas','boxtheme');?> <span class="dash">-</span> <?php _e('Provide your email address','boxtheme');?> <span class="dash">-</span> <?php _e('Receive notifications','boxtheme');?></p>
                    </div>
                </div>
                <form id="update_profile_meta" class="update-profile" novalidate>
                    <div class="container-fluid default-sidebar">
                        <div class="row same-height">
                            <div class="col-xl-3 col-lg-4 col-sm-5 sidebar-nav col" id="sidebar">
						<?php $pcats = get_terms( array(
					'taxonomy' => 'project_cat',
					'hide_empty' => false,
					)
				);
				if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){ ?>
                                <nav id="sidebar-navigation">
                                    <ul>
									<?php  $first_category = ''; $i=0; foreach ( $pcats as $cat ) {
            $selected = '';
           
            if($i==0){
                $first_category = $cat;
                $selected = 'class="active"';
            }
			 ?>
                                        <li <?php echo $selected;?>>
                                            <a href="#" class="category-select">
												<span class="icon"><img class="svg-inject" src="<?php echo get_field('icon_image',$cat);?>" alt="image"></span><span><?php echo $cat->name;?></span>
												<input type="hidden" class="category-slug" value="<?php echo $cat->slug;?>">
                                            </a>
										</li>
		<?php $i++; } ?>
                                        
                                    </ul>
								</nav>
				<?php } ?>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-sm-7 col" id="main">
                                <div class="box1 categories-wrapper">
								<?php if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){ ?>
                                <?php  $i=0; foreach ( $pcats as $cat ) { ?>
                                <?php if(get_field('skills',$cat)){
                                $skills = get_field('skills',$cat);
                                    ?>
									<ul class="list-unstyled skill-list <?php echo $cat->slug;?> <?php if($i!=0){ echo 'hidden';}?>">
									<?php $j=0; foreach($skills as $skill){ ?>
                                    <?php if($i==0 && $j==0){ 
                                    $first_skill = $skill;
                                    }
                                    ?>
                                        <li>

                                            <label class="label-container"><?php echo $skill->name;?>
                                                        
								<input type="checkbox"  <?php if( in_array($skill->term_id, $list_ids) ){?> checked="checked" <?php } ?> name="skill" value="<?php echo $skill->slug;?>">
                                                        <span class="checkmark"></span>
                                                      </label>

                                        </li>
										<?php $j++; } ?>
									</ul>
									<?php } $i++; } }?>


                                </div>

                            </div>

                        </div>
                        <div class="row notification-wrapper">
                            <div class="col-sm-12">
                                <div class="notification-form">
								<label><?php _e('Adresse email pour les notifications','boxtheme');?> </label>
				                <?php $secondary_email_notification = get_user_meta($user_ID, 'secondary_notification_email', true);?>
                                    <input type="text" name="secondary-notification-email" class="update" value="<?php echo $secondary_email_notification;?>" placeholder="Votre adresse email">
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="notification-form text-right">
								<input type="hidden"  class="update form-control" value="<?php echo $user_data->user_email;?>" name="user_email">
								<input type="hidden" class="update form-control " value="<?php echo $profile->phone_number;?>" name="phone_number">
								<input type="hidden" class="update form-control" value="<?php echo $profile->address;?>" name="address">
								<div class="hide">
								<?php echo $country_select;?>
								<input type="checkbox" value="1" checked class="update " name="is_subscriber" id ="is_subscriber">
								</div>
								<input type="hidden" name="ID" value="<?php echo $profile_id;?>" >
								<?php if(ICL_LANGUAGE_CODE=='en'){
									$url = 'https://wedo.lu/en/dashboard/';
								} elseif(ICL_LANGUAGE_CODE=='de'){
									$url = 'https://wedo.lu/de/dashboard/';
								}else{
									$url = 'https://wedo.lu/dashboard/';
								} ?>
									<a href="<?php echo $url;?>" class="btn btn-orange"><?php _e('Retour tableau de bord','boxtheme');?></a>
                                    <input class="btn  btn-orange" type="submit" value="<?php _e('Save','boxtheme');?>">
									
									<p class="message" style="display:none;"><?php _e('Your Profile has been updated', 'boxtheme'); ?></p>
                                </div>
                            </div>
                        </div>



                    </div>
                </form>
            </div>
			<style type="text/css">
				p.message {
					margin-top: 10px;
				}
			</style>
            <!-- /Drop Your New code-->
        </div>
    </div>


						<?php } } else { ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >

				<?php
					global $current_user, $profile, $profile_id, $user_ID, $current_user,$skills;
					$role = bx_get_user_role();
					
					$profile_id = get_user_meta($user_ID,'profile_id', true);
					$current_user = wp_get_current_user();
					if( $profile_id ){
						$profile = BX_Profile::get_instance()->convert($profile_id);
						if( $role == FREELANCER ){?>

							<ul class="box-tab nav nav-tabs hide">
								<li class="active" ><a   href="#panel1" role="tab"><?php _e('My Profile','boxtheme');?></a></li>
								<li><a  href="#panel2" role="tab"><?php _e('My Subscriber','boxtheme');?></a></li>
							</ul>
							<div class="tab-content">
								<div class="  tab-pane  fade in active" id="panel1" role="tabpanel">
								<?php
								get_template_part( 'template-parts/profile/edit', 'fre-overview' );
								get_template_part( 'template-parts/profile/edit', 'fre-freelancer' );
								?>
								</div>

								<div class="tab-pane fade" id="panel2" role="panel2">
									<?php get_template_part( 'template-parts/profile/edit', 'fre-subscriber-form' ); ?>

								</div>
							</div> <?php
						}
					} else {
						get_template_part( 'template-parts/profile/edit', 'emp-overview' );
					}

				?>

			</div>
		</div>
	</div>
</div>
				<?php } ?>
<?php
	/**
	 * Add modal and json for js query.
	*/
	get_template_part( 'template-parts/profile/edit', 'profile-footer' );
?>
<?php get_footer();?>