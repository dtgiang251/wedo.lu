<?php
// include( get_stylesheet_directory() .'/includes/MathCaptcha.php');
session_start();

// if( isset($_GET['giang']) ) {
	// var_dump( get_post_meta( 61395, '_user_id', true ) );
	// var_dump( get_post_meta( 61395, '_product_id', true ) );
	// exit;
// }

add_action( 'get_job_listings_init', 'bi_get_job_listings_init', 10 );
function bi_get_job_listings_init() {
	$posts = get_posts( array(
		'post_type' => 'job_listing',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key'     => 'gi_premium_service',
				'compare' => 'NOT EXISTS'
			)
		)
	) );
	if( $posts ) foreach( $posts as $p ) {
		update_post_meta( $p->ID, 'gi_premium_service', 0 );
	}
}

define( 'CASE27_INTEGRATIONS_CHILD_DIR',  get_stylesheet_directory() . '/includes/integrations' );

add_filter('case27_job_manager_locate_template', 'bi_job_manager_locate_template', 10, 3);
function bi_job_manager_locate_template( $template, $template_name, $template_path ) {
	if ( locate_template( "includes/integrations/wp-job-manager/templates/{$template_name}" ) ) {
		if( file_exists( CASE27_INTEGRATIONS_CHILD_DIR . "/wp-job-manager/templates/{$template_name}" ) ) {
			$template = CASE27_INTEGRATIONS_CHILD_DIR . "/wp-job-manager/templates/{$template_name}";
		}
		else if( file_exists( CASE27_INTEGRATIONS_DIR . "/wp-job-manager/templates/{$template_name}" ) ) {
			$template = CASE27_INTEGRATIONS_DIR . "/wp-job-manager/templates/{$template_name}";
		}
	}
	return $template;
}

add_filter( 'get_job_listings_query_args', 'bi_get_job_listings_query_args', 10, 2 );
function bi_get_job_listings_query_args( $query_args, $args ) {
	global $wpdb, $job_manager_keyword;
	$posts_in = array();
	
	// order by paid listing
	$query_args['orderby'] = array( 'gi_premium_service' => 'DESC', "rand" => "ASC" );
	$query_args['meta_key'] = 'gi_premium_service';
	$query_args['meta_query']['gi_premium_service'] = array(
		'key'     => 'gi_premium_service',
		'compare' => 'EXISTS'
	); 
	$query_args['order'] = 'rand';
	if( isset( $_POST['form_data']['lang'] ) ) {
		$query_args['lang'] = $_POST['form_data']['lang'];
		
		global $sitepress;
		$lang = $_POST['form_data']['lang'];
		$sitepress->switch_lang($lang);
	}
	if( isset($query_args['s']) ) {
	// tag same 100%
		$tag = get_term_by('name', $query_args['s'], 'case27_job_listing_tags');
		if( $tag ) {
			// $query_args['tax_query'][] = array(
				// 'taxonomy' => 'case27_job_listing_tags',
				// 'field'    => 'term_id',
				// 'terms'    => array( $tag->term_id ),
			// );
			$tags = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'job_listing',
				// 'suppress_filters'	=> false,
				'tax_query' => array(
					array(
						'taxonomy' => 'case27_job_listing_tags',
						'field'    => 'term_id',
						'terms'    => array( $tag->term_id ),
					)
				)
			));
			
			if( sizeof( $tags ) ) {
				foreach( $tags as $mar ){
					$posts_in[] = $mar->ID;
				}
			}
		}
		
		
		// category same 100%
		$category = get_term_by('name', $query_args['s'], 'job_listing_category');
		
		if( $category ) {
			
			$tags = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'job_listing',
				// 'suppress_filters'	=> false,
				'tax_query' => array(
					array(
						'taxonomy' => 'job_listing_category',
						'field'    => 'term_id',
						'terms'    => array( $category->term_id ),
					)
				)
			));
			
			if( sizeof( $tags ) ) {
				foreach( $tags as $mar ){
					$posts_in[] = $mar->ID;
				}
			}
		}
		
		// marques same 100%
		$marques = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'job_listing',
			// 'suppress_filters'	=> false,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => '_produits-et-services',
					'value' => ', ' . $query_args['s'] . ',',
					'compare' => 'LIKE',
				),
				array(
					'key' => '_produits-et-services',
					'value' => ',' . $query_args['s'] . ',',
					'compare' => 'LIKE',
				),
				array(
					'key' => '_produits-et-services',
					'value' => ', ' . $query_args['s'] . ' ,',
					'compare' => 'LIKE',
				)
			)
		));
		
		if( sizeof( $marques ) ) {
			foreach( $marques as $mar ){
				$posts_in[] = $mar->ID;
			}
		}
		
		// end marques same 100%
		
		// job title same 100%
		$job_title = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'job_listing',
			// 'suppress_filters'	=> false,
			'meta_query' => array(
				array(
					'key' => '_job_title',
					'value' => $query_args['s']
				)
			)
		));
		
		if( sizeof( $job_title ) ) {
			foreach( $job_title as $mar ){
				$posts_in[] = $mar->ID;
			}
		}
		// end job title same 100%
		
		
		// job title same 100%
		$services = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'job_listing',
			// 'suppress_filters'	=> false,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => '_a-propos',
					'value' => ', ' . $query_args['s'] . ',',
					'compare' => 'LIKE',
				),
				array(
					'key' => '_a-propos',
					'value' => ',' . $query_args['s'] . ',',
					'compare' => 'LIKE',
				),
				array(
					'key' => '_a-propos',
					'value' => ', ' . $query_args['s'] . ' ,',
					'compare' => 'LIKE',
				),
				array(
					'key' => '_a-propos',
					'value' => '^' . $query_args['s'] . ' ,',
					'compare' => 'REGEXP',
				),
				array(
					'key' => '_a-propos',
					'value' => '^' . $query_args['s'] . ',',
					'compare' => 'REGEXP',
				),
				array(
					'key' => '_a-propos',
					'value' => '^,' . $query_args['s'] . '\no$',
					'compare' => 'REGEXP',
				),
				array(
					'key' => '_a-propos',
					'value' => '^, ' . $query_args['s'] . '\no$',
					'compare' => 'REGEXP',
				)
			)
		));
		if( sizeof( $services ) ) {
			foreach( $services as $mar ){
				$posts_in[] = $mar->ID;
			}
		}
		// end job title same 100%
		
		if( sizeof($posts_in) ) {
			$query_args['post__in'] = $posts_in;
			unset($query_args['s']);
			$job_manager_keyword = '';
		}
	
	}
	// var_dump($query_args);
	return $query_args;
}

add_filter('get_job_listings_cache_results', 'bi_get_job_listings_cache_results', 10);
function bi_get_job_listings_cache_results() {
	return false;
}

add_filter( 'woocommerce_min_password_strength', 'giang_change_password_strength', 1 );
function giang_change_password_strength( $strength ) {
	 return 2;
}
add_action( 'wp_enqueue_scripts', 'misha_deactivate_pass_strength_meter', 10 );
function misha_deactivate_pass_strength_meter() {
	wp_dequeue_script( 'wc-password-strength-meter' );
}

add_action('init', 'bi_init', 99);
function bi_init() {
	
// $GLOBALS['_wp_switched_stack'] = 'yes';

	if( isset( $_GET['giang_update_excerpt'] ) ) { 
		$listing = get_posts(array(
			'posts_per_page' => 100,
			'offset' => 200,
			'post_type' => 'job_listing'
		));
		$index=0;
		foreach( $listing as $post ) {
			$index++;
			$excerpt = get_post_meta( $post->ID, '_adresse', true );
			// $excerpt .= ' '. get_post_meta( $post->ID, '_produits-et-services', true );
			$region = wp_get_post_terms($post->ID, 'region', array("fields" => "all"));
			if( $region ) {
				foreach( $region as $re ) {
					$excerpt .= ' '. $re->name;
				}
			}
			$listing_post = array(
			    'ID'           => $post->ID,
			    'post_excerpt' => $excerpt,
			);
			wp_update_post( $listing_post );
		}

		var_dump( $post->ID );
		exit; 
	}
	
	// if( isset($_GET['giang1']) ) {
		// $posts = get_posts( array(
			// 'post_type' => 'job_listing',
			// 'posts_per_page' => -1
		// ) );
		// if( $posts ) foreach( $posts as $p ) {
			// $work_hours = get_post_meta( $p->ID, '_work_hours', true );
			// $work_hours['timezone'] = 'Europe/Luxembourg';
			// update_post_meta( $p->ID, '_work_hours', $work_hours );
		// }
	// }
	
	if( isset($_GET['giang2']) ) {
		// $posts = get_posts( array(
			// 'post_type' => 'job_listing',
			// 'posts_per_page' => -1,
			// 'meta_query' => array(
				// array(
					// 'key'     => 'gi_premium_service',
					// 'value' => 1
				// )
			// )
		// ) );
		// var_dump( sizeof($posts) );
		// var_dump( get_post_meta( 3561, 'gi_premium_service', true ) );
		// exit;
	}

	// if( isset($_GET['giang2']) ) {
		// $posts = get_posts( array(
			// 'post_type' => 'job_listing',
			// 'posts_per_page' => -1
		// ) );
		// if( $posts ) foreach( $posts as $p ) {
			// $url = get_post_meta($p->ID, '_job_website', true);
			// if( $url ) {
				// var_dump( $url );
			// }
		// }
		// exit;
	// }
// if( isset($_GET['giang2']) ) {
	// var_dump( get_post_meta( 36828, 'gi_premium_service', true) );
	// exit;
// }
	if( isset($_GET['giang_update_paid_listing']) || ( isset($_GET['post_type']) && $_GET['post_type'] == 'shop_order' ) ) {
		$posts = get_posts( array(
			'post_type' => 'shop_order',
			'posts_per_page' => 30,
			// 'include' => array(13862),
			// 'offset'		=> 200,
			'post_status'	=> array( 'wc-processing', 'wc-completed' )
		) );
		
		foreach( $posts as $order ) {
			
			$order = new WC_Order( $order->ID );
			$items = $order->get_items();
			$customer_id = $order->get_user_id();
			
			foreach( $items as $product ) {
				$product_id = $product['product_id'];
				// var_dump($product_id);
				// var_dump($customer_id);
				if( $product_id == '11676' || $product_id == '11742' || $product_id == '11834' || $product_id == '40138' || $product_id == '40137' || $product_id == '40140' || $product_id == '40139' || $product_id == '40131' || $product_id == '60887' ) {
					
					$listing = get_posts(array(
						'posts_per_page' => -1,
						'post_type' => 'job_listing',
						'suppress_filters' => 1,
						'author' =>  $customer_id,
					));
					if( $listing ) foreach( $listing as $p ) {
						update_post_meta( $p->ID, 'gi_premium_service', 1 );
					}
				}
				else {
					$listing = get_posts(array(
						'posts_per_page' => -1,
						'post_type' => 'job_listing',
						'suppress_filters' => 1,
						'author' =>  $customer_id,
					));
					if( $listing ) foreach( $listing as $p ) {
						update_post_meta( $p->ID, 'gi_premium_service', 0 );
					}
				}
			}
		}
	}

	if( isset($_GET['update_paid_listing']) && isset($_GET['offset']) ) {
		$posts = get_posts( array(
			'post_type' => 'job_listing',
			'posts_per_page' => 500,
			// 'include'		=> array( 4439 ),
			'offset'		=> absint( $_GET['offset'] )
		) );
		
		foreach( $posts as $post ) {
			$packeage_id = get_post_meta( $post->ID, '_user_package_id', true );
			var_dump($post->ID);
			if( $packeage_id ) {
				$product_id = get_post_meta( $packeage_id, '_product_id', true );
				
				if( $product_id == '11676' || $product_id == '11742' || $product_id == '11834' || $product_id == '40138' || $product_id == '40137' || $product_id == '40140' || $product_id == '40139' || $product_id == '40131' || $product_id == '60887' ) {
					update_post_meta( $post->ID, 'gi_premium_service', 1 );
				}
				else {
					update_post_meta( $post->ID, 'gi_premium_service', 0 );
				}
			}
			else {
				update_post_meta( $post->ID, 'gi_premium_service', 0 );
			}
		}
		exit;
	}
	
	
	function giang_add_meta_box_listing(){

		add_meta_box( 
			'premium_service', 
			'Premium Service', 
			'premium_service_render', 
			'job_listing'
		);
		function premium_service_render($post){
			$gi_premium_service = get_post_meta($post->ID, 'gi_premium_service', true);
			echo '<input style="width:99%;" name="gi_premium_service" value="'.$gi_premium_service.'" type="text" /><br />';
			?>
			<style type="text/css">
			#premium_service{display:none}
			</style>
			<?php
		}
	}

	add_action( 'add_meta_boxes', 'giang_add_meta_box_listing' );
	
	function giang_save_meta_listing(){
		global $post;
		if($post->post_type == 'job_listing'){
			update_post_meta($post->ID, 'gi_premium_service', $_POST['gi_premium_service']);
		}
	}

	add_action('save_post', 'giang_save_meta_listing');
	
	add_shortcode('listing_categories', 'henry_listing_categories'); 
	function henry_listing_categories( $atts, $content="" ) { 
		extract( shortcode_atts( array(
			'title' => '',
			'categories' => '',
		), $atts ) );
		
		ob_start(); 
		$categories = explode(',', $categories);
		if( sizeof($categories) ):
		?>
		<div class="section1 categories">
		  <?php if( $title ) : ?><h2 class="text-center"><?php echo $title; ?></h2><?php endif; ?>
		  <ul>
			<?php foreach( $categories as $cat ) : ?>
			<?php 
				$category = get_term( $cat, 'job_listing_category' );
				if( $category ) {
					$link = get_field('custom_url', 'term_'. $category->term_id) ? get_field('custom_url', 'term_'. $category->term_id) : get_term_link($category, 'job_listing_category');
			?>
				<li class="term-<?php echo $category->slug; ?>">
					<a href="<?php echo $link;?>">
						<?php if($icon_image = get_field('icon_image', 'term_'. $category->term_id)):?>
							<img src="<?php echo $icon_image['url'];?>" class="svg" alt="image">
						 <?php endif;?>
						<p><?php echo $category->name;?></p>
					</a>
				</li>
			<?php } ?>
			<?php endforeach; ?>
			</ul>
	   </div>
		<?php 
		endif;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	
	add_shortcode('listing_child_categories', 'henry_listing_child_categories'); 
	function henry_listing_child_categories( $atts, $content="" ) { 
		extract( shortcode_atts( array(
			'parent' => 0
		), $atts ) );
		
		ob_start(); 
		
		if( $parent == 0 ) {
		
			$categories = get_terms( 'job_listing_category', array(
				'hide_empty' 	=> false,
				'orderby' => 'term_order',
				// 'orderby' => 'count', 
				// 'order' => 'DESC',
				'hierarhical' => true,
				'parent'		=> $parent
			) );
			
			if( $categories ) {
				echo '<div class="categories-wrap">';
				echo '<div class="inner-main-wrap">';
				echo '<ul class="cat-main-list">';
				
				foreach( $categories as $category ) {
					
					echo '<li>';
						
						echo '<div class="cat-title"><h1>';
						if($icon_image = get_field('icon_image', $category)) {
							
							$media_id = giang_get_image_id($icon_image['url']); ;
							$alt = 'image';
							if($media_id) $alt = giang_get_media_alt( $media_id );
						
							echo '<img class="svg" src="'. $icon_image['url'] .'" alt="'. $alt .'">';
						}
						echo ' '. $category->name . '</h1> <i class="fa fa-angle-right" aria-hidden="true"></i></div>';
						
						$child_categories = get_terms( 'job_listing_category', array(
							'hide_empty' 	=> false,
							'orderby' => 'count', 
							'order' => 'DESC',
							'hierarhical' => true,
							'parent'		=> $category->term_id
						) );
						
						if( $child_categories ) {
							
							echo '<ul class="cat-sub-list">';
							
							foreach( $child_categories as $child ) {
								
								echo '<li><h2><a href="'. get_term_link( $child, 'job_listing_category' ) .'"><i class="fa fa-angle-right" aria-hidden="true"></i>' . $child->name . ' ('. $child->count .')</a></h2></li>';
								
							}
							
							echo '</ul>';
							
						}
						
					echo '</li>';
					
				}
				
				echo '</ul>';
				echo '</div>';
				echo '</div>';
				
			}
		
		}
		else {
			
			echo '<div class="categories-wrap">';
			echo '<div class="inner-main-wrap">';
			echo '<ul class="cat-main-list">';
				echo '<li>';	
					$parent = get_term( absint( $parent ), 'job_listing_category' );
					
					if( $parent ) {
					
						echo '<div class="cat-title"><h1>';
						if($icon_image = get_field('icon_image', $parent)) {
							
							$media_id = giang_get_image_id($icon_image['url']); ;
							$alt = 'image';
							if($media_id) $alt = giang_get_media_alt( $media_id );
						
							echo '<img class="svg" src="'. $icon_image['url'] .'" alt="'. $alt .'">';
						}
						echo ' '. $parent->name . '</h1> <i class="fa fa-angle-right" aria-hidden="true"></i></div>';
						
						$child_categories = get_terms( 'job_listing_category', array(
							'hide_empty' 	=> false,
							'parent'		=> $parent->term_id
						) );
						
						if( $child_categories ) {
							
							echo '<ul class="cat-sub-list">';
							
							foreach( $child_categories as $child ) {
								
								echo '<li><h2><a href="'. get_term_link( $child, 'job_listing_category' ) .'"><i class="fa fa-angle-right" aria-hidden="true"></i>' . $child->name . ' ('. $child->count .')</a></h2></li>';
								
							}
							
							echo '</ul>';
							
						}
					
					}
					
				echo '</li>';
			echo '</ul>';
			echo '</div>';
			echo '</div>';
			
		}
		?>
		<style type="text/css">
			.wrap-listing-categories .col-sm-4 {
				padding-left: 15px;
				padding-right: 15px;
			}
			.wrap-listing-categories {
				
			}
			.categry-item > ul {
				background: rgba(255,255,255,.95);
				padding: 30px 36px;
				box-shadow: 0 0 53px rgba(0,0,0,.1);
				background: rgba(255,255,255,.95);
				border: 0;
				border-radius: 3px;
				list-style: initial;
				padding-left: 60px;
				margin: 0;
			}
			.categry-item > ul > li {
				margin-bottom: 10px;
			}
			h3.parent-term {
				margin-top: 0;
				box-shadow: 0 0 53px rgba(0,0,0,.1);
				background: rgba(255,255,255,.95);
				border: 0;
				margin: 0;
				border-radius: 3px;
				padding: 50px 50px;
			}
		</style>
		<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
}

function bi_save_meta(){
	global $post, $wpdb;

	if( is_object($post) && $post->post_type == 'job_listing' ){
		// if( get_post_meta('_user_package_id', $post->ID, true) ) {
			// update_post_meta( $post->ID, 'gi_premium_service', 1 );
		// }
		
		delete_post_meta( $post->ID, '_listing_preview_cache' );
		delete_post_meta( $post->ID, '_listing_preview_top_cache' );
		
		$excerpt = get_post_meta( $post->ID, '_adresse', true );
		// $excerpt .= ' '. get_post_meta( $post->ID, '_produits-et-services', true );
		$region = wp_get_post_terms($post->ID, 'region', array("fields" => "all"));
		
		if( $region ) {
			foreach( $region as $re ) {
				$excerpt .= ' '. $re->name;
			}
		}

		$listing_post = array(
		    'ID'           => $post->ID,
		    'post_excerpt' => $excerpt
		);

		// wp_update_post( $listing_post );
		$wpdb->query( $wpdb->prepare( 
			"
			UPDATE $wpdb->posts 
			SET post_excerpt = %s
			WHERE ID = %d
			",
			$excerpt, $post->ID
		) );
		
		
		// NEW CODE FOR UPDATE AUTOMATIC TAGS
		$post_language_information = wpml_get_language_information( '', $post->ID );
		if( isset( $post_language_information['language_code'] ) ) {
			$all_lang = array( 'en', 'de', 'fr' );
			$current_lang = $post_language_information['language_code'];
			foreach( $all_lang as $key=>$lang ) {
				if( $lang == $current_lang ) unset( $all_lang[$key] );
			}
			
			$term_list = wp_get_post_terms( $post->ID, 'case27_job_listing_tags', array("fields" => "ids") );
			
			if( $term_list ) {
				foreach( $all_lang as $key=>$lang ) {
					
					$id = icl_object_id( $post_id, 'job_listing', false, $lang );
					$new_tags = array();
					foreach( $term_list as $tag ) {
						$original_id = icl_object_id( $tag, 'case27_job_listing_tags', true, $lang );
						if( $original_id != $tag ) {
							$new_tags[] = $original_id;
						}
					}
					
					if( $new_tags ) wp_set_post_terms( $id, $new_tags, 'case27_job_listing_tags' );
				}
			}
		}
	}
}

add_action('save_post', 'bi_save_meta');

add_action( 'woocommerce_order_status_completed', 'bi_update_listing_complete', 10 );
add_action( 'woocommerce_order_status_processing', 'bi_update_listing_complete', 10 );

function bi_update_listing_complete( $order_id = 0 ) {
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	$customer_id = $order->get_user_id();
	
	foreach( $items as $product ) {
		$product_id = $product['product_id'];
		if( $product_id == '11676' || $product_id == '11742' || $product_id == '11834' || $product_id == '40138' || $product_id == '40137' || $product_id == '40140' || $product_id == '40139' || $product_id == '40131' || $product_id == '60887' ) {
			$listing = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'job_listing',
				'author' =>  $customer_id,
				'suppress_filters' => 1
			));
			if( $listing ) foreach( $listing as $p ) {
				update_post_meta( $p->ID, 'gi_premium_service', 1 );
			}
		}
	}
}

add_action( 'woocommerce_order_status_completed_to_refunded', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_on-hold_to_refunded', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_processing_to_refunded', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_processing_to_cancelled', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_completed_to_cancelled', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_pending_to_cancelled', 'bi_revoke_listing_complete', 10 );
add_action( 'woocommerce_order_status_pending_to_failed', 'bi_revoke_listing_complete', 10 );

function bi_revoke_listing_complete( $order_id = 0 ) {
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	$customer_id = $order->get_user_id();
	
	foreach( $items as $product ) {
		$product_id = $product['product_id'];
		if( $product_id == '11676' || $product_id == '11742' || $product_id == '11834' || $product_id == '40138' || $product_id == '40137' || $product_id == '40140' || $product_id == '40139' || $product_id == '40131' || $product_id == '60887' ) {
			$listing = get_posts(array(
				'posts_per_page' => -1,
				'post_type' => 'job_listing',
				'author' =>  $customer_id,
				'suppress_filters' => 1
			));
			if( $listing ) foreach( $listing as $p ) {
				update_post_meta( $p->ID, 'gi_premium_service', 0 );
			}
		}
	}
}


add_action( 'xlwuev_on_email_verification', 'henry_xlwuev_on_email_verification', 10, 1 );
function henry_xlwuev_on_email_verification( $user_ID ) {
    global $wpdb;
    $wpdb->update( $wpdb->users, array( 'user_status' => 1 ), array( 'ID' => $user_ID ) );
}

add_action( 'woocommerce_checkout_after_terms_and_conditions', 'henry_woocommerce_checkout_after_terms_and_conditions', 10 );
function henry_woocommerce_checkout_after_terms_and_conditions() { ?>
	<p class="form-row terms wc-terms-and-conditions">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms-2" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms-2'] ) ), true ); ?> required id="terms-2" /> <span>J'accepte que mes données personnelles soient traitées conformément à la <a href="https://wedo.lu/mentions-legales/">notice de confidentialié publiée par FDA Services sàrl.</a></span>
		</label>
	</p><?php
}

add_filter('acf/settings/show_admin', '__return_true', 100);


if( isset($_GET['update_case27_user_package']) || ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'job_listing' ) || ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'case27_user_package' ) ) {
	global $wpdb;
	$posts = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_title = '' AND post_type = 'case27_user_package'" );
	if ( is_array( $posts ) && sizeof( $posts ) ) {
		foreach( $posts as $post ) {
			$wpdb->query( $wpdb->prepare( 
				"
				UPDATE $wpdb->posts 
				SET post_title = %s
				WHERE ID = %d
				",
				$post->ID, $post->ID
			) );
		}
	}
}

add_shortcode('wedo-pages', 'wedo_pages'); 
function wedo_pages() { 
	$content =" <link rel='stylesheet' id='psts-checkout-css' href='https://wedo.lu/wp-content/plugins/pro-sites/pro-sites-files/css/checkout.css?ver=1.2.3.1519070217' type='text/css' media='all' /> <div id='result' style='width: 80%;margin:0 auto;margin-top:10%;'></div> <script>jQuery('#result').load('https://wedo.lu/wedo-websites/?action=new_blog #prosites-checkout-table');</script>"; 
	return $content; 
}
add_filter( 'wpseo_canonical', 'giang_wpseo_canonical', 10 );
function giang_wpseo_canonical( $canonical ) {
	global $wp;
	$query_vars = $wp->query_vars;
	if( isset( $query_vars['explore_tab'] ) && ( $query_vars['explore_tab'] == 'tags' || $query_vars['explore_tab'] == 'categories' ) ) {
		$canonical = home_url( $wp->request );
	}
	return $canonical;
}

add_action('comment_form', 'giang_comment_form_captcha', 20);
function giang_comment_form_captcha($post_id) { ?>
	<div class="g-recaptcha" data-sitekey="6LcWjVkUAAAAAHpFkmaUkKMvZ6_5BdN1oby8nqR7"></div>
	<div class="error">Please fill reCAPTCHA</div>
	<script src='https://www.google.com/recaptcha/api.js?onload=reCaptchaCallback&render=explicithl=fr' async defer></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		jQuery("#commentform").submit(function(e){
			var recaptcha = jQuery("#commentform #g-recaptcha-response").val();
			if (recaptcha == "") {
				jQuery('#commentform .error').addClass('show');
				return false;
			}
		});
	});
	</script>
<?php
}

add_filter( 'woocommerce_checkout_fields' , 'giang_override_checkout_fields' );

function giang_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_state']);
    return $fields;
}

add_filter('posts_request_ids', 'henry_custom_posts_search', 10, 2);
add_filter('posts_request', 'henry_custom_posts_search', 10, 2);
function henry_custom_posts_search( $search, $query ) {
	global $wpdb;
	if( isset($query->query['s']) && isset($query->query['post_type']) && $query->query['post_type'] == 'job_listing' ) {
		$key = $query->query['s'];
		$search = str_replace( '.post_content', '.post_title', $search );
		
		// if( get_current_user_id() == 2 ) {
			// echo($search);
			// var_dump($query);
			// exit; 
		// }
	}
	return $search;
}

function giang_get_image_id( $attachment_url ) {
    
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

function giang_get_media_alt( $attachment_id ) {
	return get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
}

add_action( 'init', function() {
	remove_action( 'wp_head', [ mylisting()->sharer(), 'add_opengraph_tags' ], 5 );
	remove_action( 'wpseo_opengraph', [ mylisting()->sharer(), 'remove_yoast_duplicate_og_tags' ] );
	remove_action( 'add_meta_boxes', [ mylisting()->sharer(), 'remove_yoast_listing_metabox' ] );
	
} );


add_action('wp_ajax_hr_search_listing', 'hr_search_listing_action');
add_action('wp_ajax_nopriv_hr_search_listing', 'hr_search_listing_action');

function hr_search_listing_action() {
	global $sitepress;
	
	$search_key = $_POST['search_key'];
	$lang = $_POST['lang'];
	$sitepress->switch_lang($lang);
	
	$posts_in = array();
	
	// $query_args = array(
		// 'post_type' 	=> 'job_listing',
		// 'posts_per_page'	=> 5,
		// 'suppress_filters'	=> false,
		// 's'					=> $search_key,
		// 'meta_query'		=> array(
			// array(
				// 'key'	=> '_case27_listing_type',
				// 'value'   => 'place',
				// 'compare' => '='
			// )
		// )
	// );
	
	// if( !empty( $search_key ) ) {
	// // tag same 100%
		// $tag = get_term_by('name', $search_key, 'case27_job_listing_tags');
		// if( $tag ) {
			
			// $tags = get_posts(array(
				// 'posts_per_page' => -1,
				// 'post_type' => 'job_listing',
				// 'tax_query' => array(
					// array(
						// 'taxonomy' => 'case27_job_listing_tags',
						// 'field'    => 'term_id',
						// 'terms'    => array( $tag->term_id ),
					// )
				// )
			// ));
			
			// if( sizeof( $tags ) ) {
				// foreach( $tags as $mar ){
					// $posts_in[] = $mar->ID;
				// }
			// }
		// }
		
		
		// // category same 100%
		// $category = get_term_by('name', $search_key, 'job_listing_category');
		
		// if( $category ) {
			
			// $tags = get_posts(array(
				// 'posts_per_page' => -1,
				// 'post_type' => 'job_listing',
				// 'tax_query' => array(
					// array(
						// 'taxonomy' => 'job_listing_category',
						// 'field'    => 'term_id',
						// 'terms'    => array( $category->term_id ),
					// )
				// )
			// ));
			
			// if( sizeof( $tags ) ) {
				// foreach( $tags as $mar ){
					// $posts_in[] = $mar->ID;
				// }
			// }
		// }
	// }
	
	// if( sizeof($posts_in) ) {
		// $query_args['post__in'] = $posts_in;
		// unset( $query_args['s'] );
	// }
	
	// $posts = get_posts( $query_args );
	// $search_results = array();
	
	// if( $posts ) foreach( $posts as $p ) {
		// // echo '<p><a href="'. get_permalink( $p->ID ) .'">'. $p->post_title .'</a></p>';
		// $search_results[] = array(
			// 'length'=> strlen($p->post_title),
			// 'link'	=>  get_permalink( $p->ID ),
			// 'title'	=> $p->post_title
		// );
	// }
	
	$terms = get_terms( array(
		'taxonomy'	=> 'case27_job_listing_tags',
		'search' => $search_key,
	) );
	
	$count = 0;
	if( $terms ) foreach( $terms as $term ) {
		if( $count < 4 ) {
			if( strrpos( strtolower($term->name), strtolower($search_key) ) === 0 ) {
				$search_results[] = array(
					'length'=> strlen($term->name),
					'link'	=> get_term_link( $term, 'case27_job_listing_tags' ),
					'title'	=> $term->name
				);
				$count++;
			}
		}
	}
	
	// uasort( $search_results, "array_order_by_length" );
	
	// $second_array = array();
	// if( $search_results ) foreach( $search_results as $key=>$result ){
		// if( strrpos( strtolower($result['title']), strtolower($search_key) ) === 0 ) {
			// $second_array[] = $search_results[$key];
			// unset( $search_results[$key] );
		// }
	// }
	
	// uasort( $second_array, "array_order_by_length" );
	
	// $search_results = array_merge($second_array, $search_results);
	
	if( $search_results ) foreach( $search_results as $result ){
		echo '<p><a href="'. $result['link'] .'">'. $result['title'] .'</a></p>';
	}
	
	die();
}


add_filter( 'wpseo_metadesc', 'giang_wpseo_metadesc', 10 );
function giang_wpseo_metadesc( $description ) {
	if( is_tax('case27_job_listing_tags') ) {
		global $wp_query;
		$tag = $wp_query->get_queried_object();
		$options = get_option( 'wpseo_taxonomy_meta' );
		
		if( ! isset( $options[$tag->taxonomy][$tag->term_id]['wpseo_desc'] ) ) {
			$current_lang = apply_filters( 'wpml_current_language', NULL );
			if( $current_lang == 'fr' ) {
				$description = $tag->name . ' au Luxembourg sur Wedo.lu: Voir les numéros de Téléphone, Adresses, Photos des meilleurs Artisans en '. $tag->name .' au Luxembourg.  Trouvez le meilleur Artisan proche de chez vous maintenant et demandez votre devis en ligne.';
			}
			if( $current_lang == 'en' ) {
				$description = $tag->name . ' in Luxembourg on Wedo.lu : See Phone Numbers, Addresses, Photos of the best '. $tag->name .'’s  Craftsmen in Luxembourg.  Find the best Craftsman near you now and request an online quote.';
			}
			if( $current_lang == 'de' ) {
				$description = $tag->name . ' in Luxemburg auf Wedo.lu : Siehe Telefonnummern, Adressen, Fotos und mehr für die besten '. $tag->name .' Handwerker in Luxemburg.  Finden Sie jetzt den besten Handwerker in Ihrer Nähe und fordern Sie ein Online-Angebot an.';
			}
		}
	}
	return $description;
}

add_filter( 'wpseo_title', 'giang_wpseo_title', 10 );
function giang_wpseo_title( $title ) {
	if( is_tax('case27_job_listing_tags') ) {
		global $wp_query;
		$tag = $wp_query->get_queried_object();
		$options = get_option( 'wpseo_taxonomy_meta' );
		
		if( ! isset( $options[$tag->taxonomy][$tag->term_id]['wpseo_title'] ) ) {
			$current_lang = apply_filters( 'wpml_current_language', NULL );
			if( $current_lang == 'fr' ) {
				$title = $tag->name . ' - La liste des 30 meilleurs Artisans du Luxembourg avec Wedo.lu';
			}
			if( $current_lang == 'en' ) {
				$title = 'Best 30 ' . $tag->name . ' in Luxembourg with Wedo.lu';
			}
			if( $current_lang == 'de' ) {
				$title = 'Die besten 30 ' . $tag->name . ' in Luxemburg mit Wedo.lu';
			}
		}
	}
	return $title;
}

add_filter( 'wpseo_canonical', '__return_false' );


if( isset($_GET['giang_test']) ) {
	var_dump( get_post_meta( 4507 ) );
	exit;
}

add_filter( 'psts_setting_checkout_url', 'giang_psts_setting_checkout_url', 10 );
function giang_psts_setting_checkout_url( $setting ) {
	return apply_filters( 'wpml_permalink', $setting , ICL_LANGUAGE_CODE );
}

add_action( 'init', function() {
	
	add_action('wp_ajax_loadmore_listing', 'loadmore_listing_action');
	add_action('wp_ajax_nopriv_loadmore_listing', 'loadmore_listing_action');

	function loadmore_listing_action() {
		
		$args = str_replace('\"', '"', $_REQUEST['query'] );
		$args = json_decode($args,true);
		
		$data = str_replace('\"', '"', $_REQUEST['settings'] );
		$data = json_decode($data,true);
		
		$paged = $_REQUEST['paged'];
		
		$args['paged'] = 1;
		$number_loadmore = isset( $data['loadmore_count'] ) ? absint( $data['loadmore_count'] ) : 8;
		$args['offset'] = $args['offset'] + $args['posts_per_page'] + $number_loadmore*($paged-2);
		$args['posts_per_page'] = $number_loadmore;
		
		
		$listings = get_posts( apply_filters( 'mylisting\sections\listing-feed\args', $args, $data ) );
		?>
		
		<?php foreach ($listings as $listing): $listing->_c27_show_promoted_badge = $data['show_promoted_badge'] == true; ?>
			<?php c27()->get_partial('listing-preview', [
				'listing' => $listing,
				'wrap_in' => sprintf(
								'col-lg-%1$d col-md-%2$d col-sm-%3$d col-xs-%4$d reveal grid-item',
								12 / absint( $data['columns']['lg'] ), 12 / absint( $data['columns']['md'] ),
								12 / absint( $data['columns']['sm'] ), 12 / absint( $data['columns']['xs'] )
							),
				]) ?>
		<?php endforeach ?>			
		<?php
		exit;
	}
	
}, 10);

add_action( 'init', 'wpml_hreflangs_init', 10 );
function wpml_hreflangs_init() {
	
	if( isset( $_GET['get_all_listing_have_no_email'] ) ) {
		$posts = get_posts( array(
			'post_type' => 'job_listing',
			'posts_per_page' => -1,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key'     => '_job_email',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => '_job_email',
						'value'		=> '',
						'compare' => '='
					)
				),
				array(
					'key'	=> 'gi_premium_service',
					'value'	=> 1
				)
			)
		) );
		if( $posts ) foreach( $posts as $p ) {
			// echo get_permalink( $p->ID ) . '-' . $p->ID . '<br />';
			// var_dump( $p ); exit;
			echo 'https://wedo.lu/?post_type=job_listing&p=' . $p->ID . '<br />';
		}
		exit;
	}
	
	
	// if ( false === ( $wedo_update_permalink_5min = get_transient( 'wedo_update_permalink_5min' ) ) ) {
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'update_permalink' ) {
		flush_rewrite_rules();
		// $to = 'giang251@gmail.com';
		// $subject = 'Update Permalink automatic per 5 minutes';
		// $body = 'Update Permalink automatic per 5 minutes';
		// $headers = array('Content-Type: text/html; charset=UTF-8');
		 
		// wp_mail( $to, $subject, $body, $headers );
		
		// set_transient( 'wedo_update_permalink_5min', 1, 300 );
	}
	
	function giang_add_ending_slash($path){
		$last_char = substr($path, strlen($path)-1, 1);
		if ($last_char != '/') {
			$path .= '/';
		}
		return $path;
	}
	
	add_filter( 'wpml_hreflangs', 'giang_wpml_hreflangs', 10 );
	function giang_wpml_hreflangs( $hreflangs ) {
		global $wp_query;
		global $sitepress;
		$old_lang = ICL_LANGUAGE_CODE;
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if( isset( $hreflangs['en-us'] ) ) {
			$hreflangs['en'] = $hreflangs['en-us'];
			unset( $hreflangs['en-us'] );
		}
		if( isset( $hreflangs['fr-fr'] ) ) {
			$hreflangs['fr'] = $hreflangs['fr-fr'];
			unset( $hreflangs['fr-fr'] );
		}
		if( isset( $hreflangs['de-de'] ) ) {
			$hreflangs['de'] = $hreflangs['de-de'];
			unset( $hreflangs['de-de'] );
		}
		
		if ( isset( $wp_query->query['job_listing_category'] ) ) {
			$hreflangs = array();
			$skills_object = get_term_by('slug', $wp_query->query['job_listing_category'] , 'job_listing_category');
			
			$languages = icl_get_languages('skip_missing=0&orderby=code');
			if( $languages ) foreach( $languages as $lang=>$language ) {
				$term_id = apply_filters( 'wpml_object_id', $skills_object->term_id, 'job_listing_category', TRUE, $lang );
				$sitepress->switch_lang($lang);
				$term = get_term_by( 'term_id', $term_id, 'job_listing_category' );
				$term_url = home_url( '/category/' ) . $term->slug;
				$term_url = apply_filters( 'wpml_permalink', $term_url, $lang );
				
				$hreflangs[$lang] = apply_filters( 'wpml_permalink', giang_add_ending_slash( $term_url ) , $lang );
			}
			
			$sitepress->switch_lang($old_lang);
			
		}
		
		if( isset( $_GET['search_keywords'] ) ) {
			if( is_array($hreflangs) ) foreach( $hreflangs as $lang=>$hreflang ) {
				$query = substr( $actual_link, strrpos($actual_link, "?") );
				$hreflangs[$lang] = $hreflang . $query;
			}
		}
		
		if( is_array( $wp_query->query ) && sizeof( $wp_query->query ) == 1 && isset( $wp_query->query['region'] ) ) {
			$region_slug = $wp_query->query['region'];
			$region = get_term_by('slug', $region_slug , 'region');
			if( is_array($hreflangs) ) foreach( $hreflangs as $lang=>$hreflang ) {
				$term_id = apply_filters( 'wpml_object_id', $region->term_id, 'region', TRUE, $lang );
				$sitepress->switch_lang($lang);
				$hreflangs[$lang] = get_term_link( $term_id, 'region' );
			}
			$sitepress->switch_lang($old_lang);
		}
		
		if( is_array( $wp_query->query ) && sizeof( $wp_query->query ) == 1 && isset( $wp_query->query['case27_job_listing_tags'] ) ) {
			$region_slug = $wp_query->query['case27_job_listing_tags'];
			$region = get_term_by('slug', $region_slug , 'case27_job_listing_tags');
			if( is_array($hreflangs) ) foreach( $hreflangs as $lang=>$hreflang ) {
				$term_id = apply_filters( 'wpml_object_id', $region->term_id, 'case27_job_listing_tags', TRUE, $lang );
				$sitepress->switch_lang($lang);
				$hreflangs[$lang] = get_term_link( $term_id, 'case27_job_listing_tags' );
			}
			$sitepress->switch_lang($old_lang);
		}
		
		$hreflangs['x-default'] = isset( $hreflangs['fr'] ) ? $hreflangs['fr'] : $actual_link;
		
		// if( isset($_GET['giang']) ) {
			// var_dump( $wp_query->query );
		// }
		
		return $hreflangs;
	}
}
