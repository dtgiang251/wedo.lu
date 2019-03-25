<?php get_header(); ?>
<?php
global $author_id;
$symbol = box_get_currency_symbol();

$author 	= get_user_by( 'slug', get_query_var( 'author_name' ) );
$author_id = $author->ID;
$status = '';
$profile_id = get_user_meta($author_id,'profile_id', true);
if( $profile_id ){
	$profile 	= BX_Profile::get_instance()->convert($profile_id);
	$skills 	= get_the_terms( $profile_id, 'skill' );
	$skill_text = '';
	$status = $profile->post_status;

	if ( $skills && ! is_wp_error( $skills ) ){
		$draught_links = array();
		foreach ( $skills as $term ) {
			$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
		}
		$skill_text = join( "", $draught_links );
	}
	$url = get_user_meta($author_id,'avatar_url', true);
	$projects_worked = (int) get_user_meta($author_id,PROJECTS_WORKED, true);
	$earned = (int) get_user_meta($author_id, EARNED, true);
	$pcountry = get_the_terms( $profile_id, 'country' );
	global $post;
	$post = $profile;
	setup_postdata($profile);
	//var_dump($status);
	//die();
	?>
	<div class="full-width">


		<div class="container site-container">
			<?php
			if ( is_current_box_administrator() ){ ?>
				<div class="row">
					<div class="bg-section float-right admin-act">
						<?php

						if($status == 'inactive'){ ?>
						<p class="text-right"><?php _e('This account is inactive','boxtheme');?><button class="btn approve float-right" value="<?php echo $profile_id;?>"><i class="fa fa-check"></i> <?php _e('Approve','boxtheme');?> </button> </p>
						<?php } else if( $status == 'publish' ){ ?>
						<p class="text-right"><?php _e('This account is active','boxtheme');?> <button class="btn decline float-right" value="<?php echo $profile_id;?>"> <i class="fa fa-eye-slash"></i> <?php _e('Deactivate','boxtheme');?></button></p>
						<?php } ?>
					</div>
				</div>

			<?php }	?>

			<div class="row site-content" id="content" >
				<div class="bg-section">
					<div id="author-view" class=" author-view">
						<div class="full bd-bottom">
							<div class="col-md-3 update-avatar align-center no-padding-right">
					    		<?php
					    		if ( ! empty( $url ) ) { echo '<img title="'.$profile->post_title.'" alt="'.$profile->post_title.'" class="avatar" src=" '.$url.'" />';}
					    		else {	echo get_avatar($author_id);	}
					    		?>
					    	</div>
					      	<div class="col-md-9">
					      		<div class="col-md-10 col-xs-10 no-padding"><h1 class="profile-title no-margin"> <?php echo $profile->post_title;?></12></div>
					      		<div class="col-md-2 col-xs-2 no-padding align-right">
					      			<span class="absolute1 top right align-right hour-rate"><?php echo $symbol .' '.$profile->hour_rate;?>/hr</span>
					      		</div>
					      		<div class="full clear">
					        		<h4 class="professional-title no-margin primary-color" ><?php echo !empty ($profile->professional_title) ? $profile->professional_title : __('WordPress Developer','boxtheme');?></h4>
					        	</div>
					        	<div class="full">
					        		<span class="clear block author-address"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo ! empty( $profile->address ) ? $profile->address .',' : ''; if( !empty( $pcountry ) ){ echo $pcountry[0]->name; };?></span>
					        		<span class="clear author-skills"><?php echo $skill_text;;?></span>
					        	</div>
					      	</div>
				      	</div> <!-- .full !-->

						<!-- Ovreview line !-->
						<div class="full bd-bottom">
							<div class="col-sm-8 text-justify">
								<h3>  <?php _e('Overviews','boxtheme');?> </h3>
								<div class="full author-overview  second-font1"><?php the_content();?></div>
								<?php
								//$video_id = get_post_meta($profile->ID, 'video_id', true);
								$video_id = '';
								if( !empty( $video_id ) ){ ?>
									<div class="video-container">
									  <iframe width="635" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id;?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
									</div>
								<?php } ?>
							</div>
							<div class="col-md-4">

								<ul class="work-status">
									<li><?php printf(__("<label>Job worked:</label> %d",'boxtheme'), $projects_worked);?></li>
									<li><?php printf(__("<label>Total earn:</label> %s",'boxtheme'), box_get_price_format(max(0,$earned)));?></li>
							      	<li><label> Language:</label> English </li>
								</ul>
							</div>
						</div><!-- End Ovreview !-->
					</div> <!-- .end author-view !-->
				</div> <!-- end bg section !-->

				<!-- Line work history !-->
				<div class="bg-section">
					<div class="col-md-8">
						<div class="header-title"><h3> <?php _e('Work History and Feedback','boxtheme');?></h3></div>
						<?php

						$args = array(
							'post_type' 	=> BID,
							'author' 		=> $author_id,
							'post_status' 	=> DONE,
						);
						$result =  new WP_Query($args);

						if( $result->have_posts() ){ ?>
							<div class ="full-width" >
								<div class="row row-heading">
									<div class="col-md-3 no-padding-right"><?php _e('Date','boxtheme');?> </div>
									<div class="col-md-7"> <?php _e('Description','boxtheme');?>	</div>
									<div class="col-md-2 align-right">	<?php _e('Price','boxtheme');?>	</div>
								</div> <?php
								while( $result->have_posts()){ $result->the_post();
									global $post;
									get_template_part( 'template-parts/profile/list-bid-done', 'loop' ); // list-bid-done-loop.php
								} ?>

							</div> <!-- end list_bidding !-->
							<?php bx_pagenate($result);

						} else {
							echo '<p>';	echo '<br />'; _e('There is not any feedback','boxtheme'); echo '</p>';
						}?>
					</div>
					<div class="col-md-4 p-activity">
						<div class="header-title"><h3 class=""> &nbsp;</h3></div> <br />
						<p> <label> Profile link</label> <br /><a class="nowrap" href="<?php get_author_posts_url($profile->post_author);?>"><?php echo get_author_posts_url($profile->post_author);?></a> </p>
						<p> <label>Activity</label> <br /> <span>24X7 hours</span> </p>
					</div>
				</div>

				<!-- end history + feedback line !-->
				<!-- Line portfortlio !-->

				<?php
				$args = array(
					'post_type' 	=> 'portfolio',
					'author' 		=> $author_id,
					'posts_per_page' => 6
				);
				$result =  new WP_Query($args);
				$i = 1;

				if( $result->have_posts() ){ ?>
					<div class="bg-section">

						<div class="col-md-12"> <div class="header-title"><h3><?php _e('Portfolio','boxtheme');?> </h3></div></div>
						<div class=" res-line"> <?php
							while ( $result->have_posts() ) {
								$result->the_post();
								$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(),'full' ); ?>

								<a href="<?php echo $thumbnail_url; ?>?image=<?php echo $i;?>" data-toggle="lightbox" data-gallery="portfolio-gallery" type="image" data-title="<?php the_title();?>" data-footer="<?php the_content();?>" class="col-md-4 port-item ">
										<img class="img-fluid" src="<?php echo $thumbnail_url;?>?image=<?php echo $i;?>" />
										<div class="full"><h5 class="h5 port-title"><?php the_title();?></h5></div>
								</a>
									<?php //the_post_thumbnail('full' ); ?>
									<!--<div class="full"><h5 class="h5 port-title"><?php the_title();?></h5></div> !-->
								<?php
								$i++;
							} ?>
						</div>
					</div> <?php
				} else {
					echo '<p>';	echo '<br />';	echo '</p>';
				}	?>
			</div><!-- container site-container !-->
		</div><!-- full-width !--> <?php
} ?>
<?php get_footer();?>