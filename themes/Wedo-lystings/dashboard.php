<?php /* Template name: Dashboard */
get_header();?>
<div id="pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pagehead11.jpg" alt="image">
    <?php $current_user = wp_get_current_user();?>
    <div class="container">
        <h5><?php _e('Dashboard','wedo-listing');?></h5>
        <h2><?php _e('Welcome','wedo-listing');?> <?php echo $current_user->user_firstname.' '.$current_user->user_lastname;?></h2>
    </div>
</div>


<div class="wrap-content package-option">
    <div class="container">
        <?php  $current_user = wp_get_current_user();
		// echo 'test';
        if(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 57165, 'product' ),'active')){
            $package = 'Power';
            $package_subcribe = 57165;
        }elseif( wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 57177, 'product' ),'active')){
            $package = 'Plus';
            $package_subcribe = 57177;
        }elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11834, 'product' ),'active')){
            $package = 'Expert';
            $package_subcribe = 11834;
        }elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 12225, 'product' ),'active')){
            $package = 'Pro-shop';
            $package_subcribe = 12225;
		}
        elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11742, 'product' ),'active')){
            $package = 'Pro';
            $package_subcribe = 11742;
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11676, 'product' ),'active')){
            $package = 'Start';
            $package_subcribe = 11676;
        } elseif(wcs_user_has_subscription($current_user->ID,apply_filters( 'wpml_object_id', 11347, 'product' ),'active')){
            $package = 'Free';
        } else {
            $package = 'User';
        }
        ?>
        <p class="package-selected"><?php _e('Account Details Package','wedo-listing');?>: <span><?php echo $package;?></span></p>
        <?php  if(ICL_LANGUAGE_CODE=="en"){
                        $url = 'https://devis.wedo.lu/en/';
                        $my_account = 'my-account';
                    } elseif(ICL_LANGUAGE_CODE=="fr"){
                        $url = 'https://devis.wedo.lu/';
                        $my_account = 'my-account';
                    }elseif(ICL_LANGUAGE_CODE=="de"){
                        $url = 'https://devis.wedo.lu/de/';
                        $my_account = 'mein-konto';
                    } ?>
        <ul class="list11 clearfix group">
			
            <li <?php if($package == "Free" ){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/my-listings/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon25.svg" alt="image">
                        </figure>                
                        <p><?php _e('My content','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                    </a>
                    </div>
                </div>                
            </li>
          <?php if($package == "User"){ ?>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                        <a href="<?php echo $url;?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon21.svg" alt="image">
                        </figure>                
                        <p><?php _e('Get a quote','wedo-listing');?></p>                        
                        </a>
                    </div>
                </div>                
            </li>                      
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/reservation/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon23.svg" alt="image">
                        </figure>                
                        <p><?php _e('My appointments','wedo-listing');?></p>    
                        </a>                    
                    </div>
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/my-bookmarks/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon24.svg" alt="image">
                        </figure>                
                        <p><?php _e('Favorites','wedo-listing');?></p>    
                     </a>                    
                    </div>
                </div>                
            </li>           
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/edit-address/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon26.svg" alt="image">
                        </figure>                
                        <p><?php _e('My addresses','wedo-listing');?></p>      
                    </a>                    
                    </div>
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo $url;?>projects/">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon32.svg" alt="image">
                        </figure>                
                        <p><?php _e('My projects','wedo-listing');?></p>
                    </a>
                    </div>
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/edit-account/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon-edit-password.svg" alt="image">
                        </figure>                
                        <p><?php _e('Change Password','wedo-listing');?></p>
                    </a>
                    </div>
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo wc_logout_url();?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon27.svg" alt="image">
                        </figure>                
                        <p><?php _e('Logout','wedo-listing');?></p>    
                    </a>                   
                    </div>
                </div>                
            </li>   
          <?php } else { ?>
            
          <?php   $args = array(
  'posts_per_page' => -1,
  'post_type' => 'job_listing',
  'author' => $current_user->ID,
  'meta_query' => array(
    'relation' => 'AND',
    array(
        'key'     => '_case27_listing_type',
        'value'   => 'place',
        'compare' => '==',
    ),
  ),
);
$the_query = new WP_Query( $args ); 
if($the_query->have_posts()):?>
<?php while($the_query->have_posts()): $the_query->the_post(); ?>
            
			<?php if( 0 ) : ?>
			<li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/my-listings/');?>?action=edit&job_id=<?php echo $post->ID;?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon22.svg" alt="image">
                        </figure>                
                        <p><?php _e('Company profile','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                    </a>
                    </div>
                </div>                
            </li>
			<?php endif; ?>
			
<?php endwhile;?>
           <?php endif;?>     
		   
		   <?php if( 0 ) : ?>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/reservation/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon23.svg" alt="image">
                        </figure>                
                        <p><?php _e('My appointments','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                        </a>
                    </div>
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/my-bookmarks/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon24.svg" alt="image">
                        </figure>                
                        <p><?php _e('Favorites','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                    </a>
                    </div>
                   
                </div>                
            </li>
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">

                    <a href="<?php echo home_url('/'.$my_account.'/edit-address/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon26.svg" alt="image">
                        </figure>                
                        <p><?php _e('My addresses','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                   </a>
                    </div>
                </div>                
            </li>
			<?php endif;?>   
           
            <li <?php if($package == "Free"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <?php $french_post = get_page_by_path( 'place', OBJECT, 'case27_listing_type' );
			          $cuurent_language_id  = apply_filters( 'wpml_object_id', $french_post->ID, 'case27_listing_type' );?>
			         <?php if($cuurent_language_id){
                     $current_laguage_post = get_post($cuurent_language_id);
                     $key = $current_laguage_post->post_name;}
                     else{
                         $key = 'place';
                     }
                     ?>
                    <a  href="<?php echo home_url('/ajouter-votre-annonce/');?>?listing_type=<?php echo $key;?>&new=1">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon28.svg" alt="image">
                        </figure>                
                        <p><?php _e('Add another room','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: start </p>  -->
                    </a>
                    
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <?php $french_post = get_page_by_path( 'promotions', OBJECT, 'case27_listing_type' );
			          $cuurent_language_id  = apply_filters( 'wpml_object_id', $french_post->ID, 'case27_listing_type' );?>
			         <?php if($cuurent_language_id){
                     $current_laguage_post = get_post($cuurent_language_id);
                     $key = $current_laguage_post->post_name;}
                     else{
                         $key = 'promotions';
                     }
                     ?>
                    <a  href="<?php echo home_url('/ajouter-votre-annonce/');?>?listing_type=<?php echo $key;?>&new=1">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon29.svg" alt="image">
                        </figure>                
                        <p><?php _e('Add promotion','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: start </p>  -->
                    </a>
                   
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <?php $french_post = get_page_by_path( 'offre-demploi', OBJECT, 'case27_listing_type' );
			          $cuurent_language_id  = apply_filters( 'wpml_object_id', $french_post->ID, 'case27_listing_type' );?>
			         <?php if($cuurent_language_id){
                     $current_laguage_post = get_post($cuurent_language_id);
                     $key = $current_laguage_post->post_name;}
                     else{
                         $key = 'offre-demploi';
                     }
                     ?>
                    <a href="<?php echo home_url('/ajouter-votre-annonce/');?>?listing_type=<?php echo $key;?>&new=1">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon28.svg" alt="image">
                        </figure>                
                        <p><?php _e('Add job offer','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: start </p>  -->
                    </a>
                  
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <?php $french_post = get_page_by_path( 'event', OBJECT, 'case27_listing_type' );
			          $cuurent_language_id  = apply_filters( 'wpml_object_id', $french_post->ID, 'case27_listing_type' );?>
			         <?php if($cuurent_language_id){
                     $current_laguage_post = get_post($cuurent_language_id);
                     $key = $current_laguage_post->post_name;}
                     else{
                         $key = 'event';
                     }
                     ?>
                    <a href="<?php echo home_url('/ajouter-votre-annonce/');?>?listing_type=<?php echo $key;?>&new=1">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon29.svg" alt="image">
                        </figure>                
                        <p><?php _e('Add Event','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: start </p>  -->
                    </a>
                    
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free" || $package == "Start"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/wedo-websites/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon30.svg" alt="image">
                        </figure>                
                        <p><?php _e('Landing page','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Pro </p>  -->
                    </a>
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free" || $package == "Start"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo $url;?>projects/">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon31.svg" alt="image">
                        </figure>                
                        <p><?php _e('Quotation requests','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Pro </p>  -->
</a>            
                    </div>
                </div>                
            </li>
            <li <?php if($package == "Free" || $package == "Start"){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo $url;?>my-profile/">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon32.svg" alt="image">
                        </figure>                
                        <p><?php _e('Quotation Notifications','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Pro </p>  -->
                    </a>
                    </div>
                </div>                
            </li>
            <li <?php if( $package != "Expert" && $package != "Plus" && $package != "Power" ){ echo 'class="disable"';}?>>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/wedo-websites/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon34.svg" alt="image">
                        </figure>                
                        <p><?php _e('Website conception','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Expert </p>  -->
                        </a>
                    </div>
                </div>                
            </li>
           <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/'.$my_account.'/edit-account/');?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon-edit-password.svg" alt="image">
                        </figure>                
                        <p><?php _e('Change Password','wedo-listing');?> </p>
                    </a>
                    </div>
                </div>                
            </li>
			<li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo home_url('/my-account/');?>">
                        <figure>
                            <img class="svg"  src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon21.svg" alt="image">
                        </figure>                
                        <p><?php _e('Account Details','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                     </a>
                    </div>
                </div>                
            </li>	
            <li>
                <div class="vertical-align">
                    <div class="align-wrapper">
                    <a href="<?php echo wc_logout_url();?>">
                        <figure>
                            <img class="svg" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/icon27.svg" alt="image">
                        </figure>                
                        <p><?php _e('Logout','wedo-listing');?></p>
                        <!-- <p class="small">Forfait: Free </p>  -->
                    </a>
                    </div>
                </div>                
            </li>
          <?php  } ?>
        </ul>                    
    </div>
</div>
<?php get_footer();?>