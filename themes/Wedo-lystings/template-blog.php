<?php /* Template Name: Blog Page */ ?>
<?php get_header();?>
	<?php while(have_posts()): the_post(); ?>
		<!-- Inner Banner -->
		<section class="jobboard-banner p-blog-banner" style="background-image: url('<?= get_stylesheet_directory_uri(); ?>/assets/images/Conseils_luxembourg.jpg">
		  	<div class="inner-content">
				<h1><?php echo __('Our advice', 'wedo-listing'); ?></h1>
				<p><?php echo __('All the information you need to develop your projects is here.', 'wedo-listing'); ?></p>
		  	</div>
		</section>
		<?php
			$cookie_name = 'template-blog_php_' . ICL_LANGUAGE_CODE;
		?>
		<input type="hidden" class="p-page-name" value="template-blog.php">
		<input type="text" class="p-current-page" value="<?php if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != 1) echo $_COOKIE[$cookie_name]; ?>">
		<input type="hidden" class="ICL_LANGUAGE_CODE" value="<?= ICL_LANGUAGE_CODE ?>">
		<main class="main-content jobboard-content p-blog-content">
			<div class="wrap-content clearfix">
				<div class="filter col-lg-3 col-sm-4">
					<div class="inner-filter">
						<p class="title"><?php echo __('All our advice', 'wedo-listing'); ?></p>
						<div class="item category">
							<?php
								$args = array(
									'hide_empty' => 1,
									'parent' => 0
								);
								$terms = get_terms( 'category', $args );

								if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									foreach ( $terms as $term ) {
										echo '<label>' . $term->name . '<input type="checkbox" value="' . $term->term_id . '"></label>';
									}
								}
							?>
						</div>
						<p class="title"><?php echo __('Featured Articles', 'wedo-listing'); ?></p>
						<div class="item">
							<div class="featured-articles">
							<?php
								$args = array(
									'post_type'  => 'post',
									'posts_per_page' => 4,
									'post_status' => 'publish',
									'orderby' => 'rand'
								);
								$query = new WP_Query( $args );
								if($query->have_posts()) :
									while($query->have_posts()) :
										$query->the_post();
										$post_id = $post->ID;

							?>
								<div class="article">
									<div class="wrapper">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<div class="bottom-text">
											<span class="date"><?php echo get_the_date( 'j M, Y' ); ?></span>
											<?php
												$categories = wp_get_post_categories( $post_id );
												if($categories) {
													$cat = get_category( $categories[0] );
											?>
												<a href="<?= get_term_link($cat->slug, 'category') ?>" class=tag><?= $cat->name ?></a>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php endwhile; endif; wp_reset_postdata(); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="right-content col-lg-9 col-sm-8">
					<div class="inner-right-content">
						<div class="search-form">
							<form class="clearfix" id="blog-search-form">
								<input type="text" name="" placeholder="<?php echo __('What are you looking for ?', 'wedo-listing'); ?>" required class="keyword">
								<input type="submit" name="" value="<?php echo __('Search', 'wedo-listing'); ?>">
							</form>
						</div>
						<div id="ajax_load_content">
							<div class="outer-posts">
								<div class="p-loading"><div class="loader"></div></div>
								<div class="posts">
									<?php
										$args = array(
											'post_type'  => 'post',
											'posts_per_page' => 12,
											'post_status' => 'publish',
										);
										$query = new WP_Query( $args );
										$max_result = 12;
										$total_row = $query->found_posts;
										$total_page = ceil($total_row/$max_result);
										if($query->have_posts()) :
											while($query->have_posts()) :
												$query->the_post();
												$post_id = $post->ID;
												$image = c27()->featured_image($post_id, 'large');
												if (!$image) $image = c27()->get_setting('blog_default_post_image');
												$style='';
												if($image){$style='';}else{$style='background: #ffa602;opacity:0.4;height:125px';}
									?>
										<div class="item">
											<div class="wrapper">
												<?php
													$categories = wp_get_post_categories( $post_id );
													if($categories) {
														$cat = get_category( $categories[0] );
												?>
													<a href="<?= get_term_link($cat->slug, 'category') ?>" class="tag"><?= $cat->name ?></a>
												<?php } ?>
												<a href="<?php the_permalink(); ?>">
													<div class="img-wrap" style="<?php echo $style; ?>">
														<?php if ($image): ?>
															<img src="<?php echo esc_url( $image ) ?>" alt="wedo.lu" />
														<?php endif ?>
													</div>
													<div class="bottom-text">
														<h3><?= get_the_title(); ?></h3>
														<div class="description">
															<p><?php c27()->the_excerpt(125) ?></p>
														</div>
														<div class="bottom">
															<span class="date"><?php echo get_the_date( 'j M, Y' ); ?></span>
															<span class="read-more"><?php echo __('Read More', 'wedo-listing'); ?></span>
														</div>
													</div>
												</a>
											</div>
										</div>
									<?php endwhile; endif; ?>
								</div>
							</div>
							<?php if($total_row > 12) : ?>
							<div class="pagination">
								<a href="#" class="arrow prev disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
								<a href="#" class="current">1</a>
								<?php
									if($total_page > 9) {
										echo '<a href="#" class="active" data-number="2">2</a>';
										echo '<a href="#" class="active" data-number="3">3</a>';
										echo '<a href="#" class="active" data-number="4">4</a>';
										echo '<a href="#" class="active" data-number="5">5</a>';
										echo '<a href="#" class="dots disabled">...</a>';
										echo '<a href="#" class="active" data-number="' . $total_page . '">' . $total_page . '</a>';
									} else {
										for ($i=2; $i <= $total_page; $i++) {
											echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
										}
									}
								?>
								<a href="#" class="arrow next active" data-number="2"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</main>
	<?php endwhile;?>
<?php get_footer();?>