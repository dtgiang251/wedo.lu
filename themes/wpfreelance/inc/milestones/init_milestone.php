<?php

Class Box_Milestone  {
	function __construct(){

		add_action('init', array( $this,'init_milestone') );
		add_action('box_add_milestone_html',array($this,'add_mistoles_form'));

	add_action( 'wp_enqueue_scripts', array( $this, 'add_milestone_scripts' ));
	}
	function get_instance(){

	}
	function add_milestone_scripts() {

	    if( is_page_template( 'page-post-project.php') ) {
	    	wp_enqueue_script( 'milestone-js', get_template_directory_uri(). '/inc/milestones/js/front.js' ,  array( 'front' ) );
	    	wp_enqueue_style( 'milestone-css', get_template_directory_uri(). '/inc/milestones/css/milestone.css' , array( 'boxtheme-style' ), BX_VERSION );
		}

	}
	static function init_milestone(){

	    $labels = array(
		'name'               => _x( 'Milestones', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Milestone', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Milestones', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Milestone', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'milestone', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Milestone', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Milestone', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Milestone', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Milestone', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Milestones', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Milestones', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Milestones:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No milestones found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No milestones found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'milestone' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'milestone', $args );

	}
	function insert($args){
		return wp_insert_post($args);
	}
	function update($args){
		return wp_update_post($args);

	}
	function add_mistoles_form($project){	global $symbol;?>
		<label class="btn-add-milestone"><i class="fa fa-plus text-color "></i> &nbsp; Add Milestone <span>?</span></label>
		<div class="form-group">
			<label for="post-title-input" class="col-3  col-form-label"><?php _e('Milestone name:','boxtheme');?></label>
			<input class="form-control required" type="text" required name="milestone_name" value="<?php echo !empty($project) ? $project->milestone_name:'';?>"  placeholder="<?php _e('Ex: Step 1.','boxtheme');?> " id="post-title-input">
		</div>
		<div class="form-group ">
		 	<label for="budget-text-input" class="col-3  col-form-label"><?php printf(__('Budget of this milestone(%s)?','boxtheme'), '<small>'.$symbol.'</small>');?></label>
		 	<input class="form-control" type="number" step="any" value="<?php echo !empty($project) ? $project->{BUDGET}:'';?>" required name="<?php echo BUDGET;?>"   placeholder="<?php printf(__('Ex: 100','boxtheme'), $symbol);?> " id="budget-text-input">
		</div>
		<div class="form-group ">
		 	<label for="example-text-input" class="col-3  col-form-label"><?php _e('DESCRIBE OF THIS MILESTONE','boxtheme');?></label>
		 	<textarea name="post_content" class="form-control required no-radius" required rows="6" cols="43" placeholder="<?php _e('Describe this milestone here...','boxtheme');?>"><?php echo !empty($project) ? $project->post_content :'';?></textarea>
		</div>
		<?php
	}
}
new Box_Milestone();