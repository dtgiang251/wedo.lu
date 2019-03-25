<?php
add_shortcode( 'search-project-form', 'giang_search_project_shortcode' );
function giang_search_project_shortcode( $atts, $content="") {
	ob_start();
	?>
	<form class="search-project-form" action="<?php echo get_permalink(2317); ?>" method="get">
		<div class="searchbar searchbar--bordered">
			<div class="searchbar__field">
				<input type="search" name="q" placeholder="ex : Carrelage, peinture d’intérieur..." autocomplete="off" tabindex="1"> 
				<button tabindex="3" type="button" class="searchbar__field-clear" style="display: none;">
					<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1175 1321l146-146q10-10 10-23t-10-23l-233-233 233-233q10-10 10-23t-10-23l-146-146q-10-10-23-10t-23 10L896 704 663 471q-10-10-23-10t-23 10L471 617q-10 10-10 23t10 23l233 233-233 233q-10 10-10 23t10 23l146 146q10 10 23 10t23-10l233-233 233 233q10 10 23 10t23-10zm617-1033v1216q0 66-47 113t-113 47H160q-66 0-113-47T0 1504V288q0-66 47-113t113-47h1472q66 0 113 47t47 113z"></path></svg>
				</button>
			</div>
			
			<div class="searchbar__action">
				<button tabindex="2">
					<svg viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" class="x2"><path d="M22 20.85l-8.51-8.51c2.53-3.14 2.16-7.713-.84-10.408-3-2.695-7.586-2.572-10.438.28C-.64 5.064-.763 9.65 1.932 12.65c2.695 3 7.267 3.37 10.408.84l8.5 8.51L22 20.85zM3.21 12C1.13 9.918.81 6.657 2.447 4.21c1.635-2.446 4.77-3.396 7.49-2.27 2.72 1.126 4.264 4.015 3.69 6.902-.572 2.886-3.104 4.966-6.047 4.968-1.64.006-3.214-.646-4.37-1.81z"></path></svg>
					<span>
						<?php echo __('Search', 'wpfreelance'); ?>
					</span>
				</button>
			</div>
		</div>
		<div class="search-result">
			
		</div>
	</form>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".search-project-form .searchbar__field input").on('change keyup paste', function () {
				var element = $(this);
				if( element.val().length >= 3 ) {
					$.ajax({
						type : 'POST',
						data : {
						   'action' : 'hr_search_project', 
						   'lang' : '<?php echo ICL_LANGUAGE_CODE; ?>',
						   'search_key' :  element.val()
						},
						url : '<?php echo admin_url( "admin-ajax.php" ); ?>',
						success : function (result){
							if( result != '' ) {
								$('.search-project-form .search-result').html( result ).show();
							}
						}
					});
				}
			});
			
			$(".search-project-form .searchbar__field input").focus(function() {
				if( $.trim( $('.search-project-form .search-result').html() ) != '' ) {
					$('.search-project-form .search-result').show();
				}
				else {
					$('.search-project-form .search-result').hide();
				}
			});
			
			// $(".search-project-form .searchbar__field input").focusout(function() {
				// $('.search-project-form .search-result').hide();
			// });
			
			$(document).on('click', '.search-project-form .search-result a', function(e){
				e.preventDefault();
				var element = $(this);
				$('.search-project-form .searchbar__field input').val( element.text() );
				$('.search-project-form .search-result').hide();
			});

			
		});
	</script>
	<style type="text/css">
		form.search-project-form {
			margin-bottom: 30px;
			position: relative;
		}
		form.search-project-form .search-result {
			display: none;
		}
		form.search-project-form .search-result {
			border: 1px solid #e4e4e4;
			padding: 15px;
			border-radius: 4px;
			position: absolute;
			left: -.5rem;
			right: -.5rem;
			width: auto;
			top: 125%;
			height: auto;
			background: #fff;
			z-index: 1;
		}
		.search-project-form .searchbar {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-orient: horizontal;
			-webkit-box-direction: normal;
			-ms-flex-flow: row wrap;
			flex-flow: row wrap;
			margin-bottom: 1rem;
			position: relative!important;
			-webkit-box-align: center;
			-ms-flex-align: center;
			align-items: center;
			min-height: 55px;
		}
		.search-project-form .search-result p:last-child {
			margin: 0;
		}
		.search-project-form .search-result a {
			color: #5c5c68;
		}
		.search-project-form .search-result a:hover {
			color: #ffa602;
		}
		.search-project-form .searchbar:after {
			content: "";
			background: #fff;
			border-radius: 4px;
			position: absolute;
			top: -.5rem;
			left: -.5rem;
			bottom: -.5rem;
			right: -.5rem;
			z-index: 1;
		}
		.search-project-form .searchbar.searchbar--bordered:after {
			border: 1px solid #e4e4e4;
		}
		.search-project-form .searchbar__field {
			position: relative;
			-webkit-box-flex: 1;
			-ms-flex: 1 1 0px;
			flex: 1 1 0px;
			width: 70%;
			z-index: 3;
		}
		.search-project-form .searchbar__action {
			-webkit-box-flex: 0;
			-ms-flex: 0 0 auto;
			flex: 0 0 auto;
			width: auto;
			margin-right: .625rem;
			margin-left: .625rem;
			margin: 0;
			z-index: 3;
		}
		.search-project-form .searchbar__field input {
			border-top-right-radius: 0;
			border-bottom-right-radius: 0;
			border-right: 0;
			height: 100%;
			margin-bottom: 0;
			padding-left: 1em;
			padding-right: 3rem;
			min-height: 55px;
			border-color: transparent;
		}
		.search-project-form .searchbar__field-clear {
			position: absolute;
			top: 50%;
			-webkit-transform: translateY(-50%);
			-ms-transform: translateY(-50%);
			transform: translateY(-50%);
			right: 1rem;
			width: 1rem;
			cursor: pointer;
		}
		.search-project-form .searchbar__field-clear svg {
			fill: #e4e4e4;
		}
		.search-project-form .searchbar__action button {
			display: inline-block;
			vertical-align: middle;
			margin: 0 0 1rem;
			font-family: inherit;
			padding: .85em 1em;
			-webkit-appearance: none;
			border: 1px solid transparent;
			border-radius: 4px;
			-webkit-transition: background-color .25s ease-out,color .25s ease-out;
			transition: background-color .25s ease-out,color .25s ease-out;
			font-size: .9rem;
			line-height: 1;
			text-align: center;
			cursor: pointer;
			background-color: #ffa602;
			color: #fefefe;
			display: block;
			width: 100%;
			margin-right: 0;
			margin-left: 0;
			margin-bottom: 0;
			text-transform: uppercase;
			font-weight: 700;
			min-height: 55px;
		}
		.search-project-form .searchbar__action svg {
			display: none!important;
		}
		.search-project-form .searchbar__action span {
			white-space: nowrap;
		}
	</style>
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;

}

add_action('wp_ajax_hr_search_project', 'hr_search_project_action');
add_action('wp_ajax_nopriv_hr_search_project', 'hr_search_project_action');

function hr_search_project_action() {
	global $sitepress;
	
	$search_key = $_POST['search_key'];
	$lang = $_POST['lang'];
	$sitepress->switch_lang($lang);
	
	// $projects = get_posts(array(
		// 'posts_per_page'	=> 5,
		// 'post_type'			=> 'project',
		// 's'					=> $search_key
	// ));
	
	$terms = get_terms( array( 
		'taxonomy' => 'skill',
		'hide_empty' => false,
		'search' => $search_key
	) );
	// var_dump($terms);
	if( $terms ) foreach( $terms as $term ) {
		echo '<p><a href="#">'. $term->name .'</a></p>';
	}
	die();
}

add_action( 'init', 'wpml_hreflangs_init', 10 );
function wpml_hreflangs_init() {
	
	add_filter( 'wpml_hreflangs', 'giang_wpml_hreflangs', 10 );
	function giang_wpml_hreflangs( $hreflangs ) {
		global $wp_query;
		global $sitepress;
		
		if ( isset( $wp_query->query['skill'] ) && isset( $wp_query->query['quote-categories'] ) ) {
			
			$hreflangs = array();
			// $skills_object = get_term_by('slug', $wp_query->query['skill'] , 'skill');
			
			$languages = icl_get_languages('skip_missing=0&orderby=code');
			
			$project_cat_slug = '';
			
			$old_lang = ICL_LANGUAGE_CODE;
			
			if( $languages ) foreach( $languages as $lang=>$language ) {
				$sitepress->switch_lang($lang);
				
				$skills = get_term_by('slug', $wp_query->query['skill'] , 'skill');
				$categorues = get_term_by('slug', $wp_query->query['quote-categories'], 'project_cat');
		
				$skill_slug = $wp_query->query['skill'];
				if( $skills ) {
					$current_language_skill_id = icl_object_id($skills->term_id, 'skill', true, $l['language_code']);
					$current_language_skill = get_term( $current_language_skill_id , 'skill' );
					$skill_slug = $current_language_skill->slug;
					if( $lang == $old_lang && $skill_slug != $wp_query->query['skill'] ) {
						$skill_slug = $wp_query->query['skill'];
					}
				}
				
				$category_slug = $wp_query->query['quote-categories'];
				if( $categorues ) {
					$current_language_categories_id = icl_object_id($categorues->term_id, 'project_cat', true, $l['language_code']);
					remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
					$current_language_categories = get_term( $current_language_categories_id , 'project_cat' );
					$category_slug = $current_language_categories->slug;
					if( $lang == $old_lang && $category_slug != $wp_query->query['quote-categories'] ) {
						$category_slug = $wp_query->query['quote-categories'];
					}
				}
				
				$permalink_url = $sitepress->convert_url( home_url('/quote/'), $l['language_code'] ) . $category_slug . '/'. $skill_slug . '/';
				
				$hreflangs[$lang] = apply_filters( 'wpml_permalink', $permalink_url , $lang );
			}
			
			$sitepress->switch_lang($old_lang);
			
		}
		
		$hreflangs['x-default'] = $hreflangs['fr'];
		return $hreflangs;
	}
}

add_action('wp_ajax_project_update_customer_contact', 'project_update_customer_contact_action');
add_action('wp_ajax_nopriv_project_update_customer_contact', 'project_update_customer_contact_action');

function project_update_customer_contact_action() {
	$user_id = get_current_user_id();
	$project = $_POST['project'];
	$contact_the_customer = get_post_meta( $project, 'project_contact_the_customer', true );
	if( !is_array( $contact_the_customer ) ) $contact_the_customer = array();
	
	$contact_the_customer[] = $user_id;
	
	update_post_meta( $project, 'project_contact_the_customer', $contact_the_customer );
	?>
	<p><?php echo sprintf( __(' The client was contacted %s times', 'wedo' ), sizeof($contact_the_customer) ); ?></p>
	<?php
	die();
}

add_filter( 'wpseo_title', 'giang_wpseo_title', 10 );
function giang_wpseo_title( $title ) {
	if( is_page_template('quote.php') || is_tax( 'skill' ) ) {
		global $wp_query;
		$tag = $wp_query->get_queried_object();
		$options = get_option( 'wpseo_taxonomy_meta' );
		
		if( ! isset( $options[$tag->taxonomy][$tag->term_id]['wpseo_title'] ) ) {
			$title = sprintf( __( '%s  | 6 free quotations from craftsmen', 'wedo-listing' ), $tag->name );
		}
	}
	return $title;
}

add_filter( 'wpseo_metadesc', 'giang_wpseo_metadesc', 10 );
function giang_wpseo_metadesc( $description ) {
	if( is_page_template('quote.php') || is_tax( 'skill' ) ) {
		global $wp_query;
		$tag = $wp_query->get_queried_object();
		$description = get_field('page_description',$tag);
		$options = get_option( 'wpseo_taxonomy_meta' );
		
		// if( isset($_GET['giang']) ) {
			// var_dump($options[$tag->taxonomy][$tag->term_id]);
		// }
		// if( ! $description ) {
		if( ! isset( $options[$tag->taxonomy][$tag->term_id]['wpseo_desc'] ) ) {
			$description = sprintf( __( '%s in Luxembourg | Ask for up to 6 free quotes from Luxembourg artisans | Quotation in 2 minutes', 'wedo-listing' ), get_field('page_title',$tag) );
		}
		else {
			$description = $options[$tag->taxonomy][$tag->term_id]['wpseo_desc'];
		}
	}
	return $description;
}

add_action( 'edited_term', 'do_something_after_update', 10, 3 ); 
function do_something_after_update( $term_id, $tt_id, $taxonomy ) {
    
	if( $taxonomy == 'project_cat' ) {
		
		$term = get_term( $term_id, 'project_cat' );
		
		$icon_image = get_term_meta( $term->term_id, 'icon_image', true );
		$skills = get_term_meta( $term->term_id, 'skills', true );
		
		$term_lang = wpml_element_language_details_filter('', array('element_id'=> $term_id, 'element_type'=> 'project_cat') );
		
		
		
		if( is_object($term_lang) && isset( $term_lang->language_code ) ) {
			$all_lang = array( 'en', 'de', 'fr' );
			$current_lang = $term_lang->language_code;
			
			foreach( $all_lang as $key=>$lang ) {
				if( $lang == $current_lang ) unset( $all_lang[$key] );
			}
			foreach( $all_lang as $key=>$lang ) {
				$original_id = icl_object_id( $term->term_id, $term->taxonomy, true, $lang );
				if( $icon_image ) {
					update_term_meta( $original_id, 'icon_image', $icon_image );
				}
				if( is_array( $skills ) ) {
					$new_skills = array();
					foreach( $skills as $skill ) {
						$skill_lang = icl_object_id( $skill, 'skill', true, $lang );
						if( $skill_lang != $skill ) {
							$new_skills[] = $skill_lang;
						}
					}
					update_term_meta( $original_id, 'skills', $new_skills );
				}
			}
				// exit;
			
		}
	}
}


add_action('transition_post_status', 'giang_transition_project_status',10,3);
function giang_transition_project_status( $new_status, $old_status,$post){
	if( $post->post_type == 'project' && $new_status == 'publish' ) {
		$project = new BX_Project();
		$skill = wp_get_post_terms( $post->ID , 'skill', array("fields" => "ids") );
		$args = array(
			'skill'	=> $skill
		);
		BX_Project::get_instance()->do_after_insert_job( $post->ID, $args );
	}
}