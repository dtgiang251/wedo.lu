<?php
// global $wpdb;
// $sql = "SELECT ID from $wpdb->posts WHERE post_type = '".PROFILE."'";

// $t = $wpdb->get_results($sql);

// foreach ($t as  $p){
//     //var_dump($p->ID);
//     update_post_meta($p->ID,'is_available', 'on');
// }
// die();

    global $box_general;
    $args = array( 'first'=>'','second' => '','third' => '');
    $label = array(
        'first_title' => __('Contact Us','boxtheme'),
        'second_title' => __('Help & Resources','boxtheme'),
        'third_title' => __('Commercial','boxtheme'),
    );
?>
<?php
	if( function_exists( 'box_debug') ){
		box_debug();
	}
function box_edit_icon(){?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg> <?php
}
?>
    <footer id="main-footer">
        <div class="pre-footer ">
            <nav class="footer-nav wrapper pure-g-r container"> <?php

                $customier_link = admin_url( 'customize.php?autofocus[section]=footer_setup');

                foreach( $args as $key => $value) {

                   	$title_key = $key.'_title';
            		$title =  $label[$title_key];

            		if( isset( $box_general->$title_key ) )
            			$title =  $box_general->$title_key; ?>

                    <div class="col-md-3 col-xs-4">
                		<h5 class="footer-list-header"> <?php echo $title; ?></h5> <?php
                        if( ! empty( $box_general->$key ) ) {
                			wp_nav_menu( array(
                        		'menu'        => $box_general->$key,
                        		'menu_class' =>'full',
                				'container' => '',
                        		)
                			);
                		} else if( current_user_can( 'manage_options' ) ) {

                			if( current_user_can( 'manage_options' ) ) { ?>
							    <a class="box-customizer-link" href="<?php echo $customier_link;?>"><?php box_edit_icon();?></a> <?php
							}
                		} ?>
                    </div> <?php
                } ?>

                <div class="col-md-3 col-xs-12"> <?php
                	if( ! empty ( $box_general->contact ) ) {
                        echo $box_general->contact;
                    } else {
                    	echo '<h5 class="footer-list-header">Contact Us</h5><p>Start a 14 Day Free Trial on any of our paid plans. No credit card required.</p>
								<p>Call us at <a href="tel:+1 855.780.6889">+1 179.170.6889</a></p>';
						if( current_user_can( 'manage_options' ) ) { ?>
						  <a class="box-customizer-link" href="<?php echo $customier_link;?>"><?php box_edit_icon();?></a>
						<?php }
    				} ?>
                </div>
            </nav>
        </div>
        <div class="footer-copyright">
            <div class="wrapper  container">
            	<div class="col-md-8 col-xs-12"> <p><?php echo stripslashes($box_general->copyright);?></p> </div>
                <div class="col-md-4 col-xs-12"> <?php box_social_link($box_general);?> </div>
            </div>
        </div>
    </footer>
    <div class="modal" id="sign-in-model">
        <div class="sign-in-box">
               <div class="title">
                   <i class="fa fa-user" aria-hidden="true"></i><h5><?php _e('Connexion','box-theme');?></h5>
               </div>
               <form id="modalloginform" action="#" method="POST" >
                   <div id="loginErrorMsg"  class="loginErrorMsg alert alert-error alert-warning hide"></div>
                   <div class="form-group">
                       <input type="text" name="user_login" id="username" value="" placeholder="<?php _e('Nom d’utilisateur','box-theme');?>" required>
                   </div>
                   <div class="form-group">
                       <input type="password" required name="user_password" id="password" placeholder="<?php _e('Mot de passe','box-theme');?>">
                   </div>
                   <div class="form-group">
                       <button type="submit" class="buttons button-2" name="login" value="Login">
                       <?php _e('Connexion','box-theme');?> <i class="fa fa-angle-right" aria-hidden="true"></i>
                       </button>
                   </div>
                   <div class="form-info">
                       <div class="md-checkbox">
                           <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                           <label for="rememberme" class=""><?php _e('Se souvenir de moi','box-theme');?></label>
                       </div>
                      <?php  if(ICL_LANGUAGE_CODE=="en"){
                        $url = 'https://wedo.lu/en/my-account/lost-password/';
                    } elseif(ICL_LANGUAGE_CODE=="fr"){
                        $url = 'https://wedo.lu/my-account/lost-password/';
                    }elseif(ICL_LANGUAGE_CODE=="de"){
                        $url = 'https://wedo.lu/de/mein-konto/lost-password/';
                    } ?>
                       <div class="forgot-password">
                           <a href="<?php echo $url;?>"><?php _e('Mot de passe oublié ?','box-theme');?></a>
                       </div>
                   </div>
				   <?php 
					$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				   ?>
				   <input type="hidden" name="redirect_url" value="<?php echo $actual_link; ?>" />
                   <?php wp_nonce_field( 'bx_login', 'nonce_login_field' );?>
                   <?php  if(ICL_LANGUAGE_CODE=="en"){
                        $url = 'https://wedo.lu/en/my-account/';
                    } elseif(ICL_LANGUAGE_CODE=="fr"){
                        $url = 'https://wedo.lu/my-account/';
                    }elseif(ICL_LANGUAGE_CODE=="de"){
                        $url = 'https://wedo.lu/de/mein-konto/';
                    } ?>
                   <a href="<?php echo $url;?>" class="link" ><?php _e("Vous n'avez pas de compte",'box-theme');?>&nbsp;?</a>
               </form>
        </div>
        <div class="modal-opacity">
       
        </div>
        </div>
    <?php get_template_part( 'modal/mobile', 'login' ); ?>
	
	<?php
		global $wp_query;
		$check = false;
		
		if ( isset( $wp_query->query['skills'] ) && isset( $wp_query->query['categories'] ) && isset( $wp_query->query['page_id'] ) ) {
			$check = true;
			$_SESSION["old_query"] = $wp_query->query;
			
			$wp_query->query( array(
				'categories' => $wp_query->query['categories'],
				'skill' => $wp_query->query['skills']
			) );
		} 
		// var_dump( $wp_query );
		// var_dump( is_page() );
		// var_dump( is_tax() );
	?>
    <?php wp_footer();?>
	<?php 
		if ( $check ) {
			$wp_query->query( $_SESSION["old_query"] );
		} 
	?> 
	
	
    <script type="text/javascript">
    (function($){

        $("#modalloginform").submit(function(event){
            event.preventDefault();
            var form    = $(event.currentTarget);
            var send    = {};
            form.find( 'input' ).each( function() {
                var key     = $(this).attr('name');
                send[key]   = $(this).val();
            });
            var captcha = '';

            if (typeof grecaptcha != "undefined") {
            	//captcha = grecaptcha.getResponse();
            }

          	$.ajax({
                emulateJSON: true,
                url : bx_global.ajax_url,
                data: {
                        action: 'bx_login',
                        request: send,
                        captcha: captcha,

                },
                beforeSend  : function(event){
                	form.attr('disabled', 'disabled');
                	//$(".btn-submit").
                	form.find(".btn-submit").addClass("loading");
                },
                success : function(res){
                	form.find(".btn-submit").removeClass("loading");
                    if ( res.success ){
                        if( res.redirect_url ){
                            window.location.href = res.redirect_url;
                        } else {
                            window.location.href= bx_global.home_url;
                        }
                    } else {
                    	$(".loginErrorMsg").html(res.msg);
                    	$(".loginErrorMsg").removeClass("hide");
                    	//if( bx_global.enable_capthca ){
	        				//grecaptcha.reset();
	        			//}
                    }
                }
            });
            return false;
        });
    })(jQuery);

</script>
</body>