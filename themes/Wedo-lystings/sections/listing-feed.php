<?php
	$data = c27()->merge_options([
			'template' => 'grid',
			'posts_per_page' => 6,
			'category' => '',
			'tag' => '',
			'region' => '',
			'include' => '',
			'listing_types' => '',
            'is_edit_mode' => false,
            'columns' => ['lg' => 3, 'md' => 3, 'sm' => 2, 'xs' => 1],
            'order_by' => 'date',
            'order' => 'DESC',
            'behavior' => 'default',
            'show_promoted_badge' => 'yes',
		], $data);

	// Basic args for get_posts().
	$args = [
		'post_type' => 'job_listing',
		'post_status' => 'publish',
		'posts_per_page' => $data['posts_per_page'],
		'ignore_sticky_posts' => false,
		'meta_query' => [],
		'tax_query' => [],
	];

	// Filter by 'job_listing_category' taxonomy.
	if ($data['category']) {
		$args['tax_query'][] = [
			'taxonomy' => 'job_listing_category',
			'terms' => $data['category'],
			'field' => 'term_id',
		];
	}

	// Filter by 'region' taxonomy.
	if ($data['region']) {
		$args['tax_query'][] = [
			'taxonomy' => 'region',
			'terms' => $data['region'],
			'field' => 'term_id',
		];
	}

	// Filter by 'case27_job_listing_tags' taxonomy.
	if ($data['tag']) {
		$args['tax_query'][] = [
			'taxonomy' => 'case27_job_listing_tags',
			'terms' => $data['tag'],
			'field' => 'term_id',
		];
	}

	// Only display the selected listings.
	if ($data['include']) {
		$args['post__in'] = $data['include'];
	}

	// dump($data['include']);

	// Filter by the listing type.
	if ($data['listing_types']) {
		$args['meta_query']['c27_listing_type_clause'] = [
			'key' => '_case27_listing_type',
			'value' => $data['listing_types'],
			'compare' => 'IN',
		];
	}

	if ($data['order_by']) {
		if ($data['order_by'][0] === '_') {
			// Order by meta key.
			$args['meta_query']['c27_orderby_clause'] = [
				'key' => $data['order_by'],
				'compare' => 'EXISTS',
				'type' => 'DECIMAL(10, 2)',
			];

			$args['orderby'] = 'c27_orderby_clause';
		} else {
			$args['orderby'] = $data['order_by'];
		}
	}

	if ( ! in_array( $data['order'], ['ASC', 'DESC'] ) ) {
		$data['order'] = 'DESC';
	}

	$args['order'] = $data['order'];

	if ($data['behavior'] == 'show_promoted_first') {
		$args['meta_query']['c27_promoted_clause'] = CASE27_WP_Job_Manager_Queries::instance()->promoted_first_clause();

		$args['orderby'] = 'c27_promoted_clause_end_date ' . $args['orderby'];
	}

	if ($data['behavior'] == 'show_promoted_only') {
		$args['meta_query']['c27_promoted_only_clause'] = CASE27_WP_Job_Manager_Queries::instance()->promoted_only_clause();
	}

	if ($data['behavior'] == 'hide_promoted') {
		$args['meta_query']['c27_hide_promoted_clause'] = CASE27_WP_Job_Manager_Queries::instance()->hide_promoted_clause();
	}

	// dump($args);

	$listings = get_posts( apply_filters( 'mylisting\sections\listing-feed\args', $args, $data ) );
	$blogloop = new \WP_Query( apply_filters( 'mylisting\sections\listing-feed\args', $args, $data ) );
?>

<?php if (!$data['template'] || in_array( $data['template'], ['grid', 'fluid-grid'] ) ): ?>
	<section class="i-section listing-feed">
		<div class="container-fluid">
			<div id="listing-grid" class="row section-body">
				<?php foreach ($listings as $listing): $listing->_c27_show_promoted_badge = $data['show_promoted_badge'] == true; ?>
					<?php 
						delete_post_meta( $listing->ID, '_listing_preview_cache');
						c27()->get_partial('listing-preview', [
						'listing' => $listing,
						'wrap_in' => sprintf(
										'col-lg-%1$d col-md-%2$d col-sm-%3$d col-xs-%4$d reveal grid-item',
										12 / absint( $data['columns']['lg'] ), 12 / absint( $data['columns']['md'] ),
										12 / absint( $data['columns']['sm'] ), 12 / absint( $data['columns']['xs'] )
									),
						]) ?>
				<?php endforeach ?>
			</div>
			
			<?php
				$number_loadmore = isset( $data['loadmore_count'] ) ? absint( $data['loadmore_count'] ) : 8;
				$is_pages = $blogloop->found_posts - $data['posts_per_page'];
				$max_pages = $is_pages > 0 ? max( ceil( ( $blogloop->found_posts - $data['posts_per_page'] ) / $number_loadmore ) + 1, 2 ) : 1;
				if( $blogloop->max_num_pages > 1 ) { ?>
				
				<a href="javascript:;" data-total="<?php echo $blogloop->found_posts; ?>" data-paged="2" data-disable="0" data-count-ajax="0" data-max-paged="<?php echo esc_attr($max_pages) ?>" data-query='<?php echo json_encode($args); ?>' data-settings='<?php echo json_encode($data); ?>' style="opacity:0" class="listing_loadmore"><?php esc_html_e('Load more','my-listing') ?></a>
				
				<!--<div class="lds-dual-ring"></div>-->
				
				<?php
				}
			?>
			
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					'use strict';
					
					// Click Load more
					$(document).on('click', '.listing_loadmore', function(e){
						e.preventDefault();
						var _this = $(this);
						var paged = parseFloat(_this.attr('data-paged'));
						var max_paged = parseFloat(_this.attr('data-max-paged'));
						var query = _this.attr('data-query');
						var settings = _this.attr('data-settings');
						
						_this.attr('data-disable', parseFloat( _this.attr('data-disable')*1 + 1 ) );
						
						if( parseFloat( _this.attr('data-disable') ) == 1 ){
							
							$.ajax({
								type: "POST",
								url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
								data: { 
									'action' : 'loadmore_listing',
									'query' : query,
									'settings' : settings,
									'paged' : paged
								}
							}).done(function(data){
								when_images_loaded( jQuery(data), function(){
								
									_this.attr( 'data-disable', 0 );
									_this.attr( 'data-count-ajax', 0 );
									
									var items = jQuery(data);
									items.appendTo( $('#listing-grid') );
									items.find('.grid-item').addClass('reveal_visible');
									
									if( paged < max_paged ) {
										_this.attr( 'data-paged', parseFloat(paged) + 1 );
									} 
									else {
										_this.remove();
										$('.lds-dual-ring').remove();
									}

								});
							});
						}
					});
					
					// Scroll Window Load more
					$(window).scroll(function(event){
						$('.listing_loadmore').each(function(index){

							if ( $(window).scrollTop() >= ($(this).offset().top - $(window).height()) - 500 ){
								if( $(this).attr('data-count-ajax') == 0 ) {
									$(this).click().attr('data-count-ajax','1');
								}
							}
						});
					});
					
				});
				
				function when_images_loaded($img_container, callback) { 
					//do callback when images in $img_container are loaded. Only works when ALL images in $img_container are newly inserted images.
					var img_length = $img_container.find('img').length,
						img_load_cntr = 0;

					if (img_length) { //if the $img_container contains new images.
						$img_container.find('img').load(function() { //then we avoid the callback until images are loaded
							img_load_cntr++;
							if (img_load_cntr == img_length) {
								callback();
							}
						});
					}
					else { //otherwise just do the main callback action if there's no images in $img_container.
						callback();
					}
				}
				
				</script>
				
				<style type="text/css">
					a.video_loadmore {
						border: 1px solid;
						border-radius: 5px;
						padding: 12px 30px;
						display: block;
						max-width: 140px;
						text-align: center;
						margin: 10px auto 0;
					}
					.lds-dual-ring {
						display: block;
						width: 64px;
						height: 64px;
						margin: 0 auto;
					}
					.lds-dual-ring:after {
					  content: " ";
					  display: block;
					  width: 46px;
					  height: 46px;
					  margin: 1px;
					  border-radius: 50%;
					  border: 5px solid #ffa602;
					  border-color: #ffa602 transparent #ffa602 transparent;
					  animation: lds-dual-ring 1.2s linear infinite;
					}
					@keyframes lds-dual-ring {
					  0% {
						transform: rotate(0deg);
					  }
					  100% {
						transform: rotate(360deg);
					  }
					}

				</style>
			
		</div>
	</section>
<?php endif ?>

<?php if ($data['template'] == 'carousel'): ?>
	<section class="i-section listing-feed-2">
		<div class="container">
			<div class="row section-body">
				<div class="owl-carousel listing-feed-carousel">
					<?php foreach ($listings as $listing): $listing->_c27_show_promoted_badge = $data['show_promoted_badge'] == true; ?>
						<div class="item reveal">
							<?php c27()->get_partial('listing-preview', ['listing' => $listing]) ?>
						</div>
					<?php endforeach ?>

					<?php if (count($listings) <= 3): ?>
						<?php foreach (range(0, absint(count($listings) - 4)) as $i): ?>
							<div class="item reveal c27-blank-slide"></div>
						<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<div class="lf-nav <?php echo $data['invert_nav_color'] ? 'lf-nav-light' : '' ?>">
				<ul>
					<li>
						<a href="#" class="listing-feed-prev-btn">
							<i class="material-icons">keyboard_arrow_left</i>
						</a>
					</li>
					<li>
						<a href="#" class="listing-feed-next-btn">
							<i class="material-icons">keyboard_arrow_right</i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</section>
<?php endif ?>

<?php if ($data['is_edit_mode']): ?>
    <script type="text/javascript">case27_ready_script(jQuery);</script>
<?php endif ?>
