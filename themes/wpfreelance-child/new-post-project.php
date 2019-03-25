<?php /* Template name: New Project Post */
get_header();?>
<div class="full-width">
        <div class="site-content" id="content">
            <div id="quote-page-head">
                <figure class="page-head-image">
                    <?php if( 0 ) : ?><img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/banner-image2.jpg" alt="image"><?php endif; ?>
                </figure>
                <div class="container">
          <?php       
          
          $wpml_element_type = apply_filters( 'wpml_element_type', 'project' );
         
         // get the language info of the original post
         // https://wpml.org/wpml-hook/wpml_element_language_details/
         $get_language_args = array('element_id' => 2171, 'element_type' => 'project' );
         $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );
          
         $set_language_args = array(
             'element_id'    => $inserted_post_ids['translation'],
             'element_type'  => $wpml_element_type,
             'trid'   => $original_post_language_info->trid,
             'language_code'   => 'fr',
             'source_language_code' => $original_post_language_info->language_code
         );
  
         do_action( 'wpml_set_element_language_details', $set_language_args );
     ?>
                    <div class="description">
                     <?php while(have_posts()): the_post();?>
                        <?php the_content();?>
                    <?php endwhile;?>
                        <hr>
                        <ul class="list-unstyled row">
                            <li class="clearfix col-sm-4 step-wrapper">
                                <figure class="icon">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/settings-icon.svg" alt="icon">
                                </figure>
                                <div class="step-details">
                                    <h3><?php _e("Step 1",'box-theme');?></h3>
                                    <p><?php _e("Select a category",'box-theme');?></p>
                                </div>
                            </li>
                            <li class="clearfix col-sm-4 step-wrapper">
                                <figure class="icon">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/doc-icon.svg" alt="icon">
                                </figure>
                                <div class="step-details">
                                    <h3><?php _e("Step 2",'box-theme');?></h3>
                                    <p><?php _e("Provide details",'box-theme');?></p>
                                </div>
                            </li>
                            <li class="clearfix col-sm-4 step-wrapper">
                                <figure class="icon">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/sent-icon.svg" alt="icon">
                                </figure>
                                <div class="step-details">
                                    <h3><?php _e("Step 3",'box-theme');?></h3>
                                    <p><?php _e("Receive your quotes",'box-theme');?></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Drop Your New code-->
            <div class="quote-wrapper">
                <div class="container-fluid default-sidebar">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-sm-5 sidebar-nav" id="sidebar">
                        <?php
				$pcats = get_terms( array(
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
                                            <span class="icon"><img class="svg-inject" src="<?php echo get_field('icon_image',$cat);?>" alt="image"> </span><span><?php echo $cat->name;?></span>
                                            <input type="hidden" class="category-slug" value="<?php echo $cat->slug;?>">
                                        </a>
                                    </li>
                                    <?php $i++; } ?>
                                   

                                </ul>
                            </nav>
                <?php } ?>
                        </div>
                        <div class="col-xl-9 col-lg-8 col-sm-7" id="main">
                            <div class="box1 categories-wrapper">
							
							<?php echo do_shortcode('[search-project-form]'); ?>
							
                            <?php if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){ ?>
                                <?php  $i=0; foreach ( $pcats as $cat ) { ?>
                                <?php if(get_field('skills',$cat)){
                                $skills = get_field('skills',$cat);
                                    ?>
                                <ul class="list-unstyled list7 sub-category-list <?php echo $cat->slug;?> <?php if($i!=0){ echo 'hidden';}?>">
                                <?php $j=0; foreach($skills as $skill){ ?>
                                    <?php if($i==0 && $j==0){ 
                                    $first_skill = $skill;
                                    }
                                    ?>
                                    <li>
                                        <a class="skill-slug" href="<?php echo home_url('/quote/').$cat->slug.'/'.$skill->slug;?>">
                                        <?php echo $skill->name;?>
                                        <?php if( 0 ) : ?><input type="hidden" class="featured-image" value="<?php echo get_field('featured_image', $skill);?>"><?php endif; ?>
										</a>
                                    </li>
                                <?php $j++; } ?>
                                    
                                </ul>
                                <?php } $i++; } }?>
                                 
                                <figure <?php if(!get_field('featured_image', $first_skill)):?> class="hidden" <?php endif;?>>
                                    <?php if( 0 ) : ?><img class="img-responsive main-featured-image" src="<?php echo get_field('featured_image', $first_skill);?>" alt="image"><?php endif; ?>
                                </figure>
                                
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- /Drop Your New code-->
        </div>
    </div>
	<style type="text/css">
	@media screen and (min-width: 768px) {
		.home .quote-wrapper .default-sidebar > .row {
			display: flex;
		}
	}
	</style>
	 <script>
			jQuery(document).ready(function($) {
				$( ".skill-slug" ).mouseover(function() {
					var image_src = $(this).find(".featured-image").val();
					if(image_src){
					$('.main-featured-image').attr('src',image_src);
					$('.main-featured-image').parent().removeClass('hidden');
					} else {
						$('.main-featured-image').parent().addClass('hidden');
					}
				});

			});
		</script>
<?php get_footer();?>
           