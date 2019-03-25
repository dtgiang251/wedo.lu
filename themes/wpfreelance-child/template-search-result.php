<?php /* Template name: Search Result */
get_header();?>
<div class="full-width">
        <div class="site-content page-id-2182" id="content">
	  
			<div class="container categories-wrapper default-sidebar">
				<div class="row">
				   
					<div class="col-xl-12 col-lg-12 col-sm-12" id="main">
						<div class="box1">
						
							<?php echo do_shortcode('[search-project-form]'); ?>
						
							<?php if( isset( $_GET['q'] ) && !empty( $_GET['q'] ) ) : ?>
						
							<?php
								$search_key = $_GET['q'];
								// $projects = get_posts( array(
									// 'posts_per_page'	=> -1,
									// 'post_type'			=> 'project',
									// 's'					=> $search_key
								// )); 
								$terms = get_terms( array( 
									'taxonomy' => 'skill',
									'search' => $search_key
								) );
							?> 
						
							<div class="search-count"><?php printf( __( '%s search results for: <b>%s</b>', 'wpfreelance' ), sizeof( $terms ),  $_GET['q'] ); ?></div>
							
							<div class="search-results">
							
								<ul class="list-unstyled list7 sub-category-list garagistes-mecanique ">
								
								<?php if( $terms ) foreach( $terms as $term ) { ?>
									<?php
										$project_cats = get_terms( array( 
											'taxonomy' => 'project_cat'
										) );
										if( $project_cats ) foreach( $project_cats as $cat ) {
											$skills = get_field( 'skills', $cat );
											foreach( $skills as $skill ) {
												if( $skill->term_id == $term->term_id ) { ?>
													<li>
														<a class="skill-slug" href="<?php echo home_url('/quote/').$cat->slug.'/'.$skill->slug;?>"><?php echo $term->name; ?></a>
													</li>
												<?php
												}
											}
										}
									?>
									
								<?php } ?>
								
								</ul>
								
							</div>
							
							<?php endif; ?>
						</div>

					</div>

				</div>
			</div>
			
			<style type="text/css">
				.search-count {
					color: #ffa602;
					font-size: 26px;
					margin-bottom: 22px;
				}
				#sign-in-model {
					display: none !important;
				}
			</style>
        </div>
    </div>
<?php get_footer();?>
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