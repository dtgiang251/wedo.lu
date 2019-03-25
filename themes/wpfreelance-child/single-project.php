<?php
	global $post;
	$user = wp_get_current_user();
    $role = ( array ) $user->roles;
    if (!empty($role)):
		if ( !in_array( 'freelancer', (array) $user->roles ) ) :
			$author =  get_post_field( 'post_author', $post_id );
			if ($author != get_current_user_id()):
				wp_redirect(home_url());
				exit;
			endif;
		endif;
	endif;
	$cviews = (int) get_post_meta( $post->ID, BOX_VIEWS, true );

	if ( $post->post_status == 'publish' ) {
		$cookie = 'cookie_' . $post->ID . '_visited';
		if ( ! isset( $_COOKIE[$cookie] ) ) {
			$cviews = $cviews + 1;
			update_post_meta( $post->ID, BOX_VIEWS , $cviews );
			setcookie( $cookie, 'is_visited', time() + 10 );
		}
	}
	global $post, $project, $user_ID, $is_owner, $winner_id, $can_access_workspace, $is_workspace, $is_dispute, $role, $cvs_id, $list_bid, $bidding, $is_logged , $current_user_can_bid, $bid_query;

	get_header();

	$cvs_id = $is_owner = $can_access_workspace =  $bidding = 0;

	$role = bx_get_user_role();

	$project = BX_Project::get_instance()->convert($post);

	$current_user_can_bid  = current_user_can_bid( $project);

	$winner_id = $project->{WINNER_ID};

	$is_workspace = isset($_GET['workspace']) ? (int) $_GET['workspace'] : 0;

	if( can_access_workspace($project) )
		$can_access_workspace = 1;


	if ( in_array ( $project->post_status, array('publish','pending','archived' ) ) || ! $can_access_workspace ){
		$is_workspace = 0;
	}

	$is_dispute = isset($_GET['dispute']) ? (int) $_GET['dispute'] : 0;

	if( is_owner_project( $project ) )
		$is_owner = $project->post_author;

	if( $current_user_can_bid ){
		$bidding = is_current_user_bidded($project->ID);
	}

	the_post();


	$user = wp_get_current_user();
    $role = ( array ) $user->roles;
    if (!empty($role)):
		if ( in_array( 'freelancer', (array) $user->roles ) ) :
			$args = array(
				'post_type' => BID,
				'post_parent' => $project->ID,
				'posts_per_page' => -1,
				'author' => get_current_user_id()
			);
		else:
		$args = array(
			'post_type' => BID,
			'post_parent' => $project->ID,
			'posts_per_page' => -1,
		);
		endif;
    endif; 
	

	$bid_query = new WP_Query($args);
	wp_reset_query();
	$status = $project->post_status;
?>

<div class="quote-wrapper">
    <div class="page-head">
       <div class="container">
          <div class="row">
             <div class="col-sm-7">
                <h2><?php the_title();?></h2>
                <p><?php if( ! empty( $_expired_date) ){?>
					      					 <?php printf(__('%s left','boxtheme'), human_time_diff( time(), strtotime($_expired_date)) ); ?>
					      				<?php } else {
					      					printf(__('Posted %s ago','boxtheme'), human_time_diff( get_the_time('U'), time() ) );
										  } ?>
				<span><?php echo box_project_status($project->post_status);?></span></p>
             </div>
             <div class="col-sm-5">
			 <?php
			 
			 if(is_current_box_administrator() || $author == get_current_user_id()){
			if ( in_array($status, array( 'pending','publish','archived' ) ) ) { ?>
					<div class=" float-right admin-act">
						<?php
						$active_class = $archived_class = 'disabled';
						if( $status == 'archived' || $status == 'pending' ){
							$active_class = ' approveproject';
						} else if( $status == 'publish' ){
							$archived_class = ' archived';
						}
						?>
						<button class="btn buttons button-2 <?php echo $active_class;?> float-right" value="<?php echo $project->ID;?>"> <?php _e('Publier','boxtheme');?> </button>

						<button class="btn buttons button-2 <?php echo $archived_class;?> float-right" value="<?php echo $project->ID;?>">  <?php _e('Archive','boxtheme');?></button>

					</div>

			<?php }	}?>
				<?php/*
			if ( is_current_box_administrator() && in_array($status, array( 'pending','publish','archived' ) ) ) { ?>
						<?php
						$active_class = $archived_class = 'disabled';
						if( $status == 'archived' || $status == 'pending' ){
							$active_class = ' approveproject';
						} else if( $status == 'publish' ){
							$archived_class = ' archived';
						}
						?>
						

						<button class="btn buttons button-2 <?php echo $archived_class;?> float-right" value="<?php echo $project->ID;?>"> <?php _e('Archived','boxtheme');?></button>
						<button class="btn buttons button-2 <?php echo $active_class;?> float-right" value="<?php echo $project->ID;?>"> <?php _e('Approve','boxtheme');?> </button>

			<?php }	*/?>
             </div>
          </div>
       </div>
    </div>
    <div class="employer-details">
       <div class="container">
          <div class="row">
             <div class="col-sm-6 col">
                 <h3>
				 <?php _e('Job Details','boxtheme');?>
                 </h3>
				  <?php the_content();?>
				  <?php $terms = get_the_terms( $project, 'skill' );
				 if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { 
				  ?>
                 <hr>
                 <h3>
				 <?php _e('Métier requis','boxtheme');?>
				 </h3>
				 <?php foreach ( $terms as $term ) { ?>
				 <span class="buttons button-grey"> <?php echo $term->name;?></span>
				 <?php } }?>
		<?php 	 $cats = get_the_terms( $project, 'project_cat' );
		         if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){ ?>
                 <hr>
                 <h3>
                 <?php _e('Categories','boxtheme');?>
				 </h3>
				 <?php foreach ( $cats as $cat ) { ?>
				 <span class="buttons button-grey"> <?php echo $cat->name;?></span>
				 <?php } ?>
				 <?php } ?>
             </div>
             <div class="col-sm-5  col-sm-offset-1 col">
			 <?php $user = get_userdata($project->post_author ); ?>
                 <?php /*<div class="info-box text-center">
                     <h3>Informations client</h3>
                     <hr>
                     <?php echo get_avatar( $user->ID, 94);?>
                     <h4><?php echo $user->display_name ;?></h4>
                     <p><?php printf( __("Member Since %s",'boxtheme'), date( "M d, Y", strtotime($user->user_registered) ) );?></p>
                 </div> */ ?>
				 <h3 class="text-center"><?php _e('Informations client','boxtheme');?></h3>
				        <?php if(get_field('votre_nom')):?>
                        <div class="line">
                           <p><?php _e('Nom du client:','boxtheme');?></p>
                           <span><?php echo get_field('votre_nom');?></span>
						</div>
						<?php endif;?>
						<?php if(get_field('votre_mail')):?>
                        <div class="line">
                           <p><?php _e('Adresse email :','boxtheme');?></p>
                           <span><?php echo get_field('votre_mail');?></span>
						</div>
						<?php endif;?>
						<?php if(get_field('n_de_tel')):?>
                        <div class="line">
                           <p><?php _e('Numéro de téléphone:','boxtheme');?></p>
                           <span><?php echo get_field('n_de_tel');?></span>
						</div>
						<?php endif;?>
						<?php if(get_field('adresse_des_travaux')):?>
                        <div class="line">
                           <p><?php _e('Adresse des travaux:','boxtheme');?></p>
                           <span><?php echo get_field('adresse_des_travaux');?></span>
						</div>
						<?php endif;?>
						<?php if(get_field('adresse')):?>
                        <div class="line">
                           <p><?php _e('Adresse du client:','boxtheme');?></p>
                           <span><?php echo get_field('adresse');?></span>
						</div>
						<?php endif;?>
						<?php if(get_field('expired_date')):?>
                        <div class="line">
                           <p><?php _e("Date d'expiration:",'boxtheme');?></p>
                           <span><?php echo get_field('expired_date');?></span>
						</div>
						<?php endif;?>
					<?php 	$args = array(
							'post_status' => 'inherit',
							'post_type'   => 'attachment',
							'post_parent' => $project->ID,
							'suppress_filters' => true
								);
								$att_query = new WP_Query( $args );
								if( $att_query->have_posts() ){
									echo '<div class="line">';
									echo '<p>'.__('Files attach: ','boxtheme').'</p>';
									$files = array();
									while ( $att_query-> have_posts()  ) {
										global $post;
										$att_query->the_post();
										$feat_image_url = wp_get_attachment_url( $post->ID );
										$files[] = '<span><i class="fa fa-paperclip primary-color" aria-hidden="true"></i>&nbsp;<a class="text-color " href="'.$feat_image_url.'" download>'.get_the_title().'</a></span> ';
									}
									echo join(",",$files);
									echo '</div>';
								} wp_reset_query();?>
						<div class="customer-contacted">
							<?php
								$check_current_customer = false;
								$contact_the_customer = get_post_meta( $post->ID, 'project_contact_the_customer', true );
								if( !is_array( $contact_the_customer ) ) $contact_the_customer = array();
								if( in_array( get_current_user_id(), $contact_the_customer ) ) {
									$check_current_customer = true;
								}
							?>
							<?php if( sizeof($contact_the_customer) == 0 ) { ?>
							<p><?php echo __('Be the First to Contact the Customer', 'wedo'); ?></p>
							<?php } else { ?>
							<p><?php echo sprintf( __(' The client was contacted %s times', 'wedo' ), sizeof($contact_the_customer) ); ?></p>
							<?php } ?>
							
							<?php if( !$check_current_customer ) : ?>
							<button class="btn buttons button-2 first-contact" type="button"><?php echo __('Click me', 'wedo'); ?></button>
							<?php endif; ?>
							
						</div>
						<style type="text/css">
							.customer-contacted p {
								font-size: 14px;
								margin: 20px 0 8px 0;
								font-weight: 600;
								color: #171717;
							}
							.customer-contacted.loading button {
								cursor: wait;
							}
						</style>
						<script type="text/javascript">
							jQuery(document).ready(function($){
								$(document).on('click', '.customer-contacted .first-contact', function(e){
									e.preventDefault();
									var _this = $(this);
									_this.attr('disabled', 'disabled');
									_this.parents('customer-contacted').addClass('loading');
									$.ajax({
										type : 'POST',
										data : {
										   'action' : 'project_update_customer_contact',
										   'project' : <?php echo $post->ID; ?>
										},
										url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
										success : function(result){											   
										   $('.customer-contacted').html( result );
										   $('.customer-contacted').removeClass('loading');
										}
									});
								});
								$(document).on('click', '.customer-contacted .contacted', function(e){
									e.preventDefault();
								});
							});
						</script>

             </div>
          </div>
       </div>
    </div>
 </div>

<?php /* <div <?php post_class('container single-project site-container');?>>
	<div id="content" class="site-content">

        <div class="col-md-12 wrap-project-title">
        	<h1 class="project-title"><?php the_title();?></h1>
        	<?php
			if ( is_current_box_administrator() && in_array($status, array( 'pending','publish','archived' ) ) ) { ?>
					<div class=" float-right admin-act">
						<?php
						$active_class = $archived_class = 'disabled';
						if( $status == 'archived' || $status == 'pending' ){
							$active_class = ' approveproject';
						} else if( $status == 'publish' ){
							$archived_class = ' archived';
						}
						?>
						<button class="btn <?php echo $active_class;?> float-right" value="<?php echo $project->ID;?>"><i class="fa fa-check"></i> <?php _e('Approve','boxtheme');?> </button>

						<button class="btn <?php echo $archived_class;?> float-right" value="<?php echo $project->ID;?>"> <i class="fa fa-eye-slash"></i> <?php _e('Archived','boxtheme');?></button>

					</div>

			<?php }	?>
        </div>
        	<div class="full heading">
        		<div class="full value-line">
        			<div class="col-md-5 col-xs-12 right-top-heading">

				      	<div class="col-md-3 col-xs-4"><span class="heading-label"><?php printf(__('Budget(%s)','boxtheme'), $symbol);?> </span><span class="primary-color large-label"> <?php echo $project->_budget; ?> </span></div>
				      	<div class="col-md-2 col-xs-4"> <span class="heading-label">Bids </span> <span class="primary-color large-label"><?php echo $bid_query->found_posts;?></span></div>
				      	<div class="col-md-3 col-xs-4"> <span class="heading-label">Views  </span><span class="primary-color large-label"> <?php echo $cviews;?> </span></div>
			      	</div>
			      	<?php

	      			if( $can_access_workspace ){
	      				if( in_array( $project->post_status, array('awarded','done','disputing', 'disputed','resolved') ) ){?>
	      					<div class="col-md-2 pull-right no-padding-left col-xs-6">
			      				<ul class="job-process-heading">

	      						<?php

	      						if( ! $is_workspace ||  $project->post_status == 'resolved'   ) { ?>
			      					<li class=" text-center "><a href="?workspace=1" class="primary-color"><i class="fa fa-clipboard" aria-hidden="true"></i> <?php _e('Go to Workspace','boxtheme');?></a>	</li>
			      				<?php } else { ?>
			      					<li class=""><a href="<?php echo get_permalink();?>" class="primary-color"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> <?php _e('Back to Detail','boxtheme');?></a></li>
			      					<?php if( $project->post_status == 'disputing' ){ ?>
			      						<li class=""><a href="?dispute=1" class="primary-color"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> <?php _e('Disputing section','boxtheme');?></a></li>
			      					<?php } ?>
			      				<?php } ?>
			      				</ul>
			      			</div> <?php
			      		}
					  }
					  /*
			      	$_expired_date = get_post_meta( $project->ID,'expired_date', true );
					$exp = get_post_meta($project->ID, $_expired_date, true);
					$current_date = date('m/d/Y');
					  if ($current_date > $exp ):
						wp_delete_post($project->ID);
						wp_redirect(home_url());
						exit;
					  endif;
					  */
			     /* 	?>

			      	<div class="col-md-3 pull-right left-top-heading col-xs-12">
				      		<div class="job-status">
				      				<span class="time-job-left">
					      				<?php if( ! empty( $_expired_date) ){?>
					      					 <?php printf(__('%s left','boxtheme'), human_time_diff( time(), strtotime($_expired_date)) ); ?>
					      				<?php } else {
					      					printf(__('Posted %s ago','boxtheme'), human_time_diff( get_the_time('U'), time() ) );
					      				} ?>
				      				</span>
				      				<span class="hide _expired_date">
				      				<?php
				      					 //echo $_expired_date;
				      					// $exp = get_post_meta($project->ID, $_expired_date, true);
				      					 //echo ' - '.$exp;
				      				?>
				      				</span>
				      				<span class="label-status primary-color"><?php echo box_project_status($project->post_status);?></span>
				      		</div>
			      	</div>
			    </div>
			</div> <!-- full !-->
        <div class="detail-project second-font">
            <div class="wrap-content"> <?php

       			if ( $can_access_workspace && ( $is_workspace || $is_dispute ) ){

       				$cvs_id = is_sent_msg($project->ID, $winner_id);
       				if( $is_workspace ) {
       					get_template_part( 'template-parts/workspace'); //workspace.php
      				} else if( $is_dispute ){
      					get_template_part( 'template-parts/dispute' ); //dispute.php
			   		}
			   	} else {

			    	$apply  = isset($_GET['apply']) ? $_GET['apply'] : '';   ?>

			    	<div class="full row-detail-section row-project-content">
				    	<div class="col-md-8 column-left-detail">
		   					<?php 	get_template_part('template-parts/single','project-detail' ); // single-project-detail.php ?>
		   					<?php if ( $apply == 1 ){?>
		   						<?php 	get_template_part('template-parts/single','project-detail-bid-form' ); //single-project-detail-bid-form.php ?>
		   					<?php } ?>
				       	</div> <!-- .col-md-8  Job details !-->
					    <div class="col-md-4 sidebar column-right-detail" id="single_sidebar"> <?php  	get_sidebar('project');?></div>
					</div>
					<div class="full row-detail-section row-list-bid">
		  				<?php get_template_part( 'template-parts/list', 'bid' ); ?>
	  				</div>
			    <?php } ?>
            </div> <!-- .wrap-content !-->
        </div> <!-- .detail-project !-->

	</div>
</div>
*/ ?>
<?php get_template_part( 'template-parts/single','template-js' ); ?>

<?php get_footer();?>
<?php

// $trans_id = get_post_meta( $project->ID, 'transaction_id', true );
// var_dump($trans_id);
?>