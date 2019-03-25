<?php
	$categories = c27()->get_terms(get_the_ID(), 'category');
?>
<div class="c27-top-content-margin"></div>
<!-- Inner Banner -->
<section class="jobboard-banner blog-banner" style="background-image: url('<?= get_the_post_thumbnail_url() ?>">
</section>

<div class="main-content p-single-blog">
	<div class="container">
		<div class="headline">
			<div class="row">
				<div class="col-sm-8 col-left">
					<h2><?php the_title(); ?></h2>
					<span class="publish-date"><?php echo __('Published on', 'wedo-listing') . ' ' . get_the_date( 'j M, Y' ); ?></span>
				</div>
				<div class="col-sm-4 col-right">
					<div class="share">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                              <g id="ico_share_default" transform="translate(-1255 -447)">
                                <rect id="bg_ico_share" width="40" height="40" transform="translate(1255 447)" fill="none"/>
                                <path id="ico_share" d="M97.645,132.873v-3.665a1.2,1.2,0,0,1,.691-1.108,1.066,1.066,0,0,1,1.221.26l7.84,8.4a1.26,1.26,0,0,1,0,1.7l-7.84,8.4a1.065,1.065,0,0,1-1.221.262,1.2,1.2,0,0,1-.691-1.11v-3.715c-.318-.024-.633-.035-.944-.035a11.912,11.912,0,0,0-9.365,4.476,1.073,1.073,0,0,1-1.247.412,1.2,1.2,0,0,1-.764-1.138C85.325,135.059,94.381,133.191,97.645,132.873Zm-1.238,7.282a14.266,14.266,0,0,1,2.1.182,1.209,1.209,0,0,1,1.053,1.153l-.266,3.093,6.181-6.975-6.181-6.824.266,3.285c0,.662-.848,1.255-1.466,1.255-1.019,0-8.979-.195-11.129,9.259C88.814,143.122,92.4,140.155,96.407,140.155Z" transform="translate(1178.557 329.151)" fill="#b9b9b9"/>
                              </g>
                            </svg>
                        </div>
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_face.png">Facebook</a></li>
                            <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_link.png">Linkedin</a></li>
                            <li><a href="https://twitter.com/share?url=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_tw.png">Twitter</a></li>
                        </ul>
                    </div>
				</div>
			</div>
		</div>
		<div class="body-content">
			<div class="row">
				<div class="col-sm-8 left-content">
					<div class="content-details">
						<?php the_content(); ?>
					</div>
					<div class="btn-post-link">
						<?php previous_post_link('%link', '<i class="fa fa-angle-left" aria-hidden="true"></i>' . esc_html__('Previous Article', 'my-listing')) ?>
						<?php next_post_link('%link', esc_html__('Next Article', 'my-listing') . '<i class="fa fa-angle-right" aria-hidden="true"></i>') ?>
					</div>
				</div>
				<div class="col-sm-4 right-content">
					<div class="wrapper">
						<?php if($categories) : ?>
						<div class="item tags">
							<h3 class="title"><?php echo __('Tags', 'wedo-listing') ?></h3>
							<div class="content">
								<?php foreach ( (array) $categories as $category ): ?>
									<a href="<?php echo esc_url( $category['link'] ) ?>"><?php echo esc_html( $category['name'] ) ?></a>
								<?php endforeach ?>
							</div>
						</div>
						<?php endif; ?>
						<div class="item more-articles">
							<h3 class="title"><?php echo __('More Articles', 'wedo-listing') ?></h3>
							<div class="content">
								<div class="list-article">
									<?php
										$args = array(
											'posts_per_page' => 6, // How many items to display
											'post__not_in'   => array( get_the_ID() ), // Exclude current post
											'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
										);
										// Check for current post category and add tax_query to the query arguments
										$cats = wp_get_post_terms( get_the_ID(), 'category' ); 
										$cats_ids = array();
										foreach( $cats as $wpex_related_cat ) {
											$cats_ids[] = $wpex_related_cat->term_id;
										}
										if ( ! empty( $cats_ids ) ) {
											$args['category__in'] = $cats_ids;
										}
										// Query posts
										$wpex_query = new wp_query( $args );
										// Loop through posts
										foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
											$image = c27()->featured_image(get_the_ID(), 'large');
											if (!$image) $image = c27()->get_setting('blog_default_post_image');
											$style='';
											if($image){$style='';}else{$style='background: #ffa602;opacity:0.4';}
											$categories = wp_get_post_categories( get_the_ID() );
									?>
									<div class="article">
										<div class="inner">
											<div class="p-thumbnail" style="<?= $style ?>">
												<?php if ($image): ?>
													<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $image ) ?>" alt="wedo.lu" /></a>
												<?php endif ?>
											</div>
											<div class="text">
												<h3><a href="<?php the_permalink(); ?>"><?= get_the_title(); ?></a></h3>
												<span class="date"><?php echo get_the_date( 'j M, Y' ); ?></span>
												<?php
													if($categories) {
														$cat = get_category( $categories[0] );
														echo '<a href="'. get_term_link($cat->slug, 'category') .'" class="tag">'. $cat->name .'</a>';
													}
												?>
												<div class="description mobile">
													<p><?php c27()->the_excerpt(100) ?></p>
												</div>
												<div class="bottom mobile">
													<span class="date"><?php echo get_the_date( 'j M, Y' ); ?></span>
													<span class="read-more"><?php echo __('Read More', 'wedo-listing'); ?></span>
												</div>
											</div>
										</div>
									</div>
									<?php
										// End loop
										endforeach;
										// Reset post data
										wp_reset_postdata(); 
									?>
								</div>
								<div class="all-articles">
									<a href="<?= home_url('/blog'); ?>"><?php echo __('All articles', 'wedo-listing'); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>