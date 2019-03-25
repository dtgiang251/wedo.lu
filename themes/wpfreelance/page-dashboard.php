<?php
/**
 *	Template Name: My Projects
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" >
			<div id="profile" class="col-md-12">
				<div class="tab-content clearfix">
					<?php
					if( is_user_logged_in() ){
						global $user_ID;
						$profile_id = get_user_meta($user_ID,'profile_id', false);

						if( $profile_id ){
							get_template_part( 'template-parts/dashboard/list', 'bids' );
						} else {
							get_template_part( 'template-parts/dashboard/list', 'projects' );
						}
					} else {
						_e('This content only availble for user logged in','boxtheme');
					}

					?>
				</div>
			</div> <!-- end left !-->

		</div>
	</div>
</div>
<style type="text/css">
	.dashboard-filter{
		width: 100%;
		margin-bottom: 20px;
	}
	.dashboard-filter select{
		border-radius: 5px;

	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			$( ".dashboard-filter select" ).change(function(ev) {
			  	console.log(ev);
			  	var url = $(this).find(":checked").val();
			  	window.location.href = url;
			});
		})
	})(jQuery);
</script>
<?php get_footer();?>

