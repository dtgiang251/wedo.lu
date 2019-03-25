<?php
// refer https://support.advancedcustomfields.com/forums/topic/conditional-statements-in-frontend-acf-form/
// http://www.telegraphicsinc.com/2013/07/how-to-add-new-post-title-using-aacf_form/
//ajax form: https://support.advancedcustomfields.com/forums/topic/using-acf-form-in-ajax-call/
//wp-content\plugins\advanced-custom-fields-pro-master\includes\forms\form-front.php
//function acf_init(){


if( ! class_exists('acf_pro') )
	return ;


$option = BX_Option::get_instance();
$plugin_setting = (object)$option->get_plugins_settings();
$acfsetting = (object)$plugin_setting->acf_pro;
$project_group_id = $acfsetting->project_group_id;

if(empty($project_group_id))
	return;


acf_register_form(array(
	'id'		=> 'new-event',
	'post_id'	=> 'new_post',
	'field_groups' => array($project_group_id),
	'new_post'	=> array(
		'post_type'		=> 'event',
		'post_status'	=> 'publish'
	),
	'form' => false,
	//'post_title'=> true,
	//'post_content'=> true,
));
//}
//add_action('init','acf_init');
global $post_args;
$post_args = array(
		//'post_id' => 0,
		'field_groups' => array($project_group_id),
		'form' => false,
		'return' => false,
	);
function show_acf_form($project){
	global $post, $post_args;
	_e('<h3> Custom Fields Addon</h3>','boxtheme');
	//acf_form_head();
	//acf_form( $post_args );
	acf_form('new-event');
	//acf_get_fields();

}
add_action('box_post_job_fields','show_acf_form');

add_action('wp_head','acf_script', 1);
function acf_script(){ ?>
	<script type="text/javascript">
		(function($){

			acf.o.post_id = 111;

		});
	</script>
	<?php
}

function show_acf_fields($project){
	global $post;

	$fields = get_field_objects($project->ID);
	if( $fields ){
		echo '<h3 class="default-label">' . __('Advances Custom Fields Pro','boxtheme').'</h3>';
		foreach( $fields as  $field_name =>$field )
		{
			if( empty( $field['value'] ))
				continue;
				
			if($field_name == 'adresse_email')
			continue;

			if($field_name == 'expired_date')
			continue;

			echo '<div class="acf-row row">';
				echo '<label class="col-md-3 lb-meta-field">'.acf_get_field_label($field).':</label> ';
				echo '<div class="col-md-9">';
				if( ! is_array( $field['value'] ) ){
					if( $field['type'] == 'date_picker'){
						//$date= date_create($field['value']);
						//echo date_format( $date, get_option( 'date_format') );
						echo $field['value'];
						//echo date( get_option('date_format'), $date );
					} else {
						echo $field['value'];
					}
				} else if ( $field['type'] == 'file'){
					$f = $field['value'];
					echo '<span><i class="fa fa-paperclip primary-color" aria-hidden="true"></i>&nbsp;<a class="text-color " href="'.$f['url'].'">'.$f['filename'].' 123</a></span>';
				} else {
					$f = $field['value'];

					if( $f['type'] == 'image' ){
						echo '<img src ="'.$f['url'].'">';
					}
				}
				echo '</div>';

			echo '</div>';
		}
	}

}
add_action( 'show_acf_fields','show_acf_fields', 10 , 1);

function acf_save_post_replace( $post_id = 0, $values = null ) {

	// override $_POST
	if( $values !== null ) {
		$_POST['acf'] = $values['acf'];
	}

	// set form data
	acf_set_form_data(array(
		'post_id'	=> $post_id
	));
	//var_dump($_POST);

	// hook for 3rd party customization
	do_action('acf/save_post', $post_id);


	// return
	return true;

}
function box_update_acf_fields( $project_id, $request ){

 	acf_save_post_replace( $project_id, $request );
}
add_action( 'update_acf_fields','box_update_acf_fields', 10 , 2);