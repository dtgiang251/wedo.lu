<?php
// $role = get_role( 'freelancer' );
// echo '<pre>';
// var_dump($role);
// echo '</pre>';
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
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans|Raleway|Noto+Sans|Roboto|Josefin+Sans|Crimson+Text" rel="stylesheet">
	<style type="text/css">
		body{
			23font-family: 'Raleway', sans-serif;
			font-family: 'Roboto', sans-serif;
			font-size: 14px !important;
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
<?php do_action('before_header_menu' );?>
<div class="row-nav full-width header" id="full_header">
	<div class="container">
		<div class="row">
			<div  itemscope itemtype="http://schema.org/Organization" class="col-logo">
				<?php box_logo();?>
				
			</div>
			<div class=" col-nav ">
				<?php if ( has_nav_menu( 'top' ) ) { get_template_part( 'template-parts/navigation', 'top' ); } ?>
			</div>

			<div class="col-searchform hidden-sm-down hidden-md-down hidden-xs">
				<form method="GET" action="<?php echo get_post_type_archive_link('project');?>">
					<input class="keyword" type="text" name="s" placeholder="<?php _e('Search','boxtheme');?>"  /><i class="fa fa-search" aria-hidden="true"></i>
				</form>
			</div>

			<div class="col-account-menu">
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
			</div>

		</div>
	</div>	<!-- .navigation-top -->
</div>