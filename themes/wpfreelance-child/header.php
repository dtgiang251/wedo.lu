<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://boxthemes.net *
 * @package BoxThemes
 * @subpackage BoxThemes
 * @since 1.0
 * @version 1.0
 */
global $role; // visitor, FREELANCER, EMPLOYER, administrator;
$role = bx_get_user_role();
$logged_in_class = "";
if ( !is_user_logged_in() ) {
	if(!(is_front_page() || is_page_template('quote.php') || is_page_template('project-success.php') )):
	$logged_in_class = "model-popup";
	endif;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg <?php echo $logged_in_class;?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<?php if( false && !is_page_template('quote.php')){ ?>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<?php } ?>
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans|Raleway|Noto+Sans|Roboto|Josefin+Sans" rel="stylesheet">
	<meta name="ahrefs-site-verification" content="7d3c8dbe6c131ae381402dcaae77b9f698e1e693ddf8a0b84597cbe600f5b0f7">
	
	<style type="text/css">
		body{
			font-family: 'Raleway', sans-serif;
			2font-family: 'Roboto', sans-serif;
			font-size: 14px;
			color: #666;
			/*font-family: 'Josefin Sans', sans-serif !important;
			font-family: 'Noto Sans', sans-serif !important;
			font-family: 'Lato', sans-serif !important;
			*/
		}
	</style>
	<style>
	@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
		.material-icons  {
			 display: none !important
		}
	}
	</style>
	<script type="text/javascript">
		<?php
		global $app_api;

		$gg_captcha = (object) $app_api->gg_captcha;
		$enable = (int) $gg_captcha->enable;
		?>

		var bx_global = {
			'home_url' : '<?php echo home_url() ?>',
			'admin_url': '<?php echo admin_url() ?>',
			'ajax_url' : '<?php echo admin_url().'admin-ajax.php'; ?>',
			'selected_local' : '',
			'is_archive': <?php echo is_archive() ? 1:0;?>,
			'is_free_submit_job' : true,
			'user_ID':'<?php global $user_ID; echo $user_ID ?>',
			'enable_capthca': <?php echo $enable;?>,

		}
	</script>
	
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N3ZSXBS');</script>
<!-- End Google Tag Manager -->

<?php
	global $wp_query;
	$check = false;
	
	if ( isset( $wp_query->query['skills'] ) && isset( $wp_query->query['categories'] ) && isset( $wp_query->query['page_id'] ) ) {
		$check = true;
		$_SESSION["old_query"] = $wp_query->query;
		
		$wp_query->query( array(
			'skill' => $wp_query->query['skills'],
			'quote-categories' => $wp_query->query['categories'],
		) );
	}
	
	// if( isset($_GET['giang_test']) ) {
		// var_dump( $wp_query->query['skills'] );
		// var_dump( $wp_query->query['categories'] );
		// var_dump( $wp_query->query['page_id'] );
		// var_dump( $wp_query->query );
		// var_dump( $wp_query );
		// var_dump( is_page() );
		// var_dump( is_tax() );
	// }
	
?>
<?php wp_head(); ?>
<?php 
	if ( $check ) {
		$wp_query->query( $_SESSION["old_query"] );
	} 
?> 

<?php if(is_front_page() || is_page_template('quote.php') || is_page_template('project-success.php')):
$logged_in_class = "no-popup";
endif;?>

<script type="text/javascript">(function(o){var b="https://api.autopilothq.com/anywhere/",t="c8cb5e1d6548483a90754e1d8fea91ad94a1fce4ea7243ef820cf97c915601fa",a=window.AutopilotAnywhere={_runQueue:[],run:function(){this._runQueue.push(arguments);}},c=encodeURIComponent,s="SCRIPT",d=document,l=d.getElementsByTagName(s)[0],p="t="+c(d.title||"")+"&u="+c(d.location.href||"")+"&r="+c(d.referrer||""),j="text/javascript",z,y;if(!window.Autopilot) window.Autopilot=a;if(o.app) p="devmode=true&"+p;z=function(src,asy){var e=d.createElement(s);e.src=src;e.type=j;e.async=asy;l.parentNode.insertBefore(e,l);};y=function(){z(b+t+'?'+p,true);};if(window.attachEvent){window.attachEvent("onload",y);}else{window.addEventListener("load",y,false);}})({});</script>
</head>
<body <?php body_class(array(ICL_LANGUAGE_CODE,$logged_in_class)); ?>>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N3ZSXBS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php if( is_home() || is_front_page() ) : ?>
<div class="center_point" style="display: none;">
	<div id="step_popup" class="step_popup_section modal fade in">
	<div class="modal-dialog">

	   <!-- popup content-->
	   <div class="modal-content">
		  <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal"></button>
			 <h4 class="modal-title"><?php echo __('Get a quote in 3 easy steps', 'wedo-listing'); ?></h4>
		  </div>

		  <div class="modal-body">
			 <ul class="step_middle_section">
				<li>
				   <span class="step_number">1</span>
				   <h4><?php echo __('Choose a category', 'wedo-listing'); ?></h4>
				   <span class="icon_pop"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_popup_catefory.svg" alt="#"></span>
				</li>
				<li>
				   <span class="step_number">2</span>
				   <h4><?php echo __('Provide details', 'wedo-listing'); ?></h4>
				   <span class="icon_pop"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_popup_details.svg" alt="#"></span>
				</li>
				<li>
				   <span class="step_number">3</span>
				   <h4><?php echo __('Receive your quotes', 'wedo-listing'); ?></h4>
				   <span class="icon_pop"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ico_popup_quotes.svg" alt="#"></span>
				</li>
			 </ul>
		  </div>

		  <div class="modal-footer">
			 <a class="btn_gotit" href="#"><?php echo __('All right, I got it', 'wedo-listing'); ?></a>
		  </div>
		  
	   </div>
	</div>
	</div>
</div>

<style type="text/css">
#step_popup {
    display: block;
}
</style>

<script type="text/javascript">
	jQuery(document).ready(function($){
		
		if( Cookies.get('_first_visit_website') == 1 ) {
			$('.center_point').remove();
		}
		else {
			$('.center_point').show();
			$('#cookie-notice').hide();
		}
		
		Cookies.set('_first_visit_website', '1', { expires: 99999 });
		
		$('.btn_gotit, #step_popup .close').click(function() {
			$('.center_point').remove();
		});
	});
</script>

<?php endif; ?>   
<?php
	$html_logo = get_custom_logo();
	$default_logo = '<img class="logo style-svg" alt="'.get_bloginfo( 'name','display' ).'" src="'.get_template_directory_uri().'/img/logo.png'.'" />';
?>
<?php do_action('before_header_menu' );?>
<header id="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-lg-2  col-sm-5 col-xs-7 col">
                    <button type="button" class="menu-btn"> <span class="bar"></span> <span class="bar"></span> <span class="bar"></span></button>
                    <figure class="logo">
					<?php if(ICL_LANGUAGE_CODE=='en'){
						$url = 'https://www.wedo.lu/en/';
					} elseif(ICL_LANGUAGE_CODE=='de'){
						$url = 'https://www.wedo.lu/de/';
					}else{
						$url = 'https://www.wedo.lu/';
					} ?>
					<a href="<?php echo $url;?>"><img src="<?php echo get_stylesheet_directory_uri();?>/header-assets/assets/images/logo1.svg" alt="Wedo"></a>
                    </figure>

                </div>
				<?php if(ICL_LANGUAGE_CODE=='en'){
						$url = 'https://wedo.lu/en/directory/';
					} elseif(ICL_LANGUAGE_CODE=='de'){
						$url = 'https://wedo.lu/de/verzeichnis/';
					}else{
						$url = 'https://wedo.lu/annuaire-2/';
					} ?>
                <div class="col-xl-8 col-lg-10 col-sm-7 col-xs-5 text-right col">
                        <div class="quick-search-instance text-left">
                                <form method="GET" action="<?php echo $url;?>">
                                   <div class="header-search is-focused">
                                    <i class="fa fa-search" aria-hidden="true"></i> <input type="search" placeholder="<?php _e('Que cherchez vous?','boxtheme');?>" name="search_keywords" autocomplete="off"> <!---->
                                   </div> 
                                </form>
                             </div>
                    <div class="d-inline-block">
                        
                        <nav id="main-navigation">
						<?php wp_nav_menu( array(
		            'theme_location' => 'main_menu_new',
                    'menu_class'        => 'main-menu clearfix',
                    'container' => '',
				) ); ?>
				<?php  if (! is_user_logged_in() ) { ?>
				<div class="user-area signin-area"> <i class="material-icons user-area-icon">perm_identity</i> <a href="https://wedo.lu/my-account">Connectez-vous</a> <span>|</span> <a href="https://wedo.lu/my-account">S'inscrire</a></div>
				
				<?php } ?>
				<?php  $languages = icl_get_languages('skip_missing=1');?>
			    <div class="language-selector">
				<?php foreach($languages as $l){ 
					if($l['active']){ 
					?>
							<?php $active_url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-selected.png';
							} elseif($l['language_code']=="fr"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-selected.png';
							}elseif($l['language_code']=="de"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-selected.png';
							}

							?>
							<span class="hidden-xs hidden-md hidden-sm"><img src="<?php echo $active_url;?>"></span>
				<?php } }?>
               <ul>
			   <?php foreach($languages as $l){ ?>
				<?php $url = $l['country_flag_url'];
				$permalink_url = $l['url'];
							if($l['language_code']=="en"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
							} elseif($l['language_code']=="fr"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
							}elseif($l['language_code']=="de"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
							}
							if(get_query_var( 'skills')):
								global $sitepress;
								$skills = get_term_by('slug', get_query_var( 'skills') , 'skill');
								$categorues = get_term_by('slug', get_query_var( 'categories') , 'project_cat');
								$current_language_skill_id = icl_object_id($skills->term_id, 'skill', true, $l['language_code']);
								$current_language_categories_id = icl_object_id($categorues->term_id, 'project_cat', true, $l['language_code']);
								remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
								$current_language_skill = get_term( $current_language_skill_id , 'skill' );
								$current_language_categories = get_term( $current_language_categories_id , 'project_cat' );
								$permalink_url = $sitepress->convert_url( home_url('/quote/'), $l['language_code'] ).$current_language_categories->slug.'/'.$current_language_skill->slug;
								add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
							endif;
							
                         ?>

					<li <?php if($l['active']){ echo 'class="active hidden-lg"';}?>><a href="<?php echo $permalink_url;?>"><img src="<?php echo $url;?>"></a></li>
			 <?php   } ?>
                </ul>
                            </div>
						</nav>
						<?php  if ( is_user_logged_in() ) { $current_user = wp_get_current_user(); ?>
                        <div class="user-area">
                            <div class="user-profile-dropdown">
                                <a class="user-profile-name" href="#" type="button" id="user-dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <div class="avatar">
									<?php echo get_avatar($current_user->ID);?>
                                    </div>
                                    <span><?php echo $current_user->display_name;?></span>
                                </a>
                                <ul class="dropdown">
								<?php if(ICL_LANGUAGE_CODE=='en'){
						$url = 'https://wedo.lu/en/dashboard/';
					} elseif(ICL_LANGUAGE_CODE=='de'){
						$url = 'https://wedo.lu/de/dashboard/';
					}else{
						$url = 'https://wedo.lu/dashboard/';
					} ?>
								<li><a href="<?php echo $url;?>"><?php _e('Tableau de bord','boxtheme');?></a></li>
                                 <li><a href="<?php echo wp_logout_url( 'https://wedo.lu' ); ?>"><?php _e('Déconnexion','boxtheme');?></a></li>
                                </ul>
                            </div>
						</div>
						<?php } ?>
						
						<?php  $languages = icl_get_languages('skip_missing=1');?>
						<div class="language-selector mobile-language">
						<?php foreach($languages as $l){ 
							if($l['active']){ 
							?>
									<?php $active_url = $l['country_flag_url'];
									if($l['language_code']=="en"){
										$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-selected.png';
									} elseif($l['language_code']=="fr"){
										$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-selected.png';
									}elseif($l['language_code']=="de"){
										$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-selected.png';
									}

									?>
									<span><img src="<?php echo $active_url;?>"></span>
						<?php } }?>
						
						<?php if( 0 ) : ?>
						<!-- OLD CODE -->
					   <ul>
					   <?php foreach($languages as $l){ ?>
						<?php $url = $l['country_flag_url'];
									if($l['language_code']=="en"){
										$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
									} elseif($l['language_code']=="fr"){
										$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
									}elseif($l['language_code']=="de"){
										$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
									}
									if(!$l['active']){
										$permalink_url1 = $l['url'];
										
										// if ( get_query_var( 'explore_category' ) && ( $term1 = get_term_by( 'slug', sanitize_title( get_query_var( 'explore_category'  ) ), 'job_listing_category' ) ) ) {
											// $data1 = icl_object_id($term1->term_id, 'job_listing_category', true, $l['language_code']);
											// global $sitepress;
											// remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
											// $original_ob = get_term( $data1, 'job_listing_category' );
											// $permalink_url1 = get_term_link($data1,'job_listing_category');
											// add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
											
										// }
										$taxonomies = [
											['tax' => 'region',                  'query_var' => 'explore_region',   'name_filter' => 'single_term_title'],
											['tax' => 'job_listing_category',    'query_var' => 'explore_category', 'name_filter' => 'single_cat_title'],
											['tax' => 'case27_job_listing_tags', 'query_var' => 'explore_tag',      'name_filter' => 'single_tag_title'],
										];
										foreach ( $taxonomies as $tax ) {
											if ( get_query_var( $tax['query_var'] ) && ( $term1 = get_term_by( 'slug', sanitize_title( get_query_var( $tax['query_var'] ) ), $tax['tax'] ) ) ) {
												$data1 = icl_object_id($term1->term_id, $tax['tax'], true, $l['language_code']);
												
												global $sitepress;
												remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
												$original_ob = get_term( $data1, $tax['tax'] );
												$permalink_url1 = get_term_link($data1,$tax['tax']);
												add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
											} 
										}
								 ?>

							<li <?php if($l['active']){ echo 'class="active"';}?>><a href="<?php echo $permalink_url1;?>"><img src="<?php echo $url;?>"></a></li>
					 <?php   } }?>
						</ul>
						<?php endif; ?>
						
						<ul>
					   <?php foreach($languages as $l){ ?>
						<?php $url = $l['country_flag_url'];
							$permalink_url = $l['url'];
							if($l['language_code']=="en"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
							} elseif($l['language_code']=="fr"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
							}elseif($l['language_code']=="de"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
							}
							if(get_query_var( 'skills')):
								global $sitepress;
								$skills = get_term_by('slug', get_query_var( 'skills') , 'skill');
								$categorues = get_term_by('slug', get_query_var( 'categories'), 'project_cat');
								
								$skill_slug = get_query_var( 'skills');
								if( $skills ) {
									$current_language_skill_id = icl_object_id($skills->term_id, 'skill', true, $l['language_code']);
									$current_language_skill = get_term( $current_language_skill_id , 'skill' );
									$skill_slug = $current_language_skill->slug;
								}
								
								$category_slug = get_query_var( 'categories');
								if( $categorues ) {
									$current_language_categories_id = icl_object_id($categorues->term_id, 'project_cat', true, $l['language_code']);
									remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
									$current_language_categories = get_term( $current_language_categories_id , 'project_cat' );
									$category_slug = $current_language_categories->slug;
								}
								
								$permalink_url = $sitepress->convert_url( home_url('/quote/'), $l['language_code'] ) . $category_slug . '/'. $skill_slug . '/';
								add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
							endif;
							
						 ?>

							<li <?php if($l['active']){ echo 'class="active hidden-lg"';}?>><a href="<?php echo $permalink_url;?>"><img src="<?php echo $url;?>"></a></li>
					 <?php   } ?>
						</ul>
						</div>
						
						
						<?php if(ICL_LANGUAGE_CODE=='en'){
						$url = 'https://wedo.lu/en/add-your-entries/';
						} elseif(ICL_LANGUAGE_CODE=='de'){
							$url = 'https://wedo.lu/de/eintrag-beanspruchen/';
						}else{
							$url = 'https://wedo.lu/ajouter-votre-annonce/';
						} ?>
						<?php  if (! is_user_logged_in() ) { ?>
					   <div class="mob-sign-in"> <a href="#" data-toggle="modal" data-target="#sign-in-modal"><i class="material-icons">perm_identity</i></a></div>
						<?php } ?>
                        <div class="header-button">
                            <a href="<?php echo $url;?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                        </div>
                        <a href="<?php echo $url;?>" class="buttons button-2"><i class="icon-add-circle-1"></i> <?php _e('Inscription artisan','boxtheme');?></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php /* <div class="row-nav full-width header" id="full_header">
	<div class="container">
		<div class="row">
			<div  itemscope itemtype="http://schema.org/Organization" class="col-md-2 col-logo col-xs-6">
				<?php if( ! empty( $html_logo ) ){ echo $html_logo; } else { ?>
				<a itemprop="logo"  class="logo" title="<?php echo get_bloginfo( 'name','display' ); ?>"  href="<?php echo home_url();?>"> <?php echo $default_logo; ?>	</a>
				<?php }?>
			</div>
			<div class="no-padding col-nav col-md-6 ">
				<?php if ( has_nav_menu( 'top' ) ) { get_template_part( 'template-parts/navigation', 'top' ); } ?>
			</div>
			<!-- seach form here !-->
			<div class="col-md-4 col-xs-3 col-account-menu">
				<div class="f-right align-right no-padding-left header-action">
					<?php
						if ( is_user_logged_in() ) { box_account_dropdow_menu(); } else { ?>
						<ul class="main-login">
							<li class="login text-center desktop-only ">
								<a href="<?php echo box_get_static_link('login');?>" class="sign-text btn btn-login"><?php _e('Log In','boxtheme');?></a>
							</li>
							<li class=" sign-up desktop-only">
								<a href="<?php echo box_get_static_link('signup');?>" class="btn btn-signup sign-text"> <?php _e('Sign Up','boxtheme');?></a>
							</li>
							<li class=" mobile-only">
								<button type="button" class="btn btn-login " data-toggle="modal" data-target="#loginModal">
			  						<i class="fa fa-user-circle-o login-icon" aria-hidden="true"></i>
								</button>
							</li>
						</ul>
					<?php } ?>
				</div>
			</div> <!-- .header-action !-->
		</div>
	</div>	<!-- .navigation-top -->
</div> */?>

