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

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans|Raleway|Noto+Sans|Roboto|Josefin+Sans" rel="stylesheet">
	
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
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	$html_logo = get_custom_logo();
	$default_logo = '<img class="logo style-svg" alt="'.get_bloginfo( 'name','display' ).'" src="'.get_template_directory_uri().'/img/logo.png'.'" />';
?>
<?php do_action('before_header_menu' );?>
<div class="row-nav full-width header" id="full_header">
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
</div>

