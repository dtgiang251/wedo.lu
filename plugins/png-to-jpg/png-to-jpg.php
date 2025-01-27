<?php
/*
	Plugin Name: PNG to JPG
	Plugin URI: https://kubiq.sk
	Description: Convert PNG images to JPG, free up web space and speed up your webpage
	Version: 3.2
	Author: KubiQ
	Author URI: https://kubiq.sk
	Text Domain: png_to_jpg
	Domain Path: /languages
*/

class png_to_jpg {
	var $plugin_admin_page;
	var $settings;
	var $tab;
	var $new_extension;
	var $converted_stats;

	function __construct(){
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'admin_menu', array( $this, 'plugin_menu_link' ) );
		add_action( 'init', array( $this, 'plugin_init' ) );
		add_action( 'admin_notices', array( $this, 'server_gd_library' ) );
		add_filter( 'wp_handle_upload', array( $this, 'upload_converting' ) );
		add_action( 'wp_ajax_hasTransparency', array( $this, 'hasTransparency' ) );
		add_action( 'wp_ajax_convert_old_png', array( $this, 'convert_old_png' ) );
		add_action( 'add_attachment', array( $this, 'attachment_converted_meta' ) );
		add_action( 'attachment_updated', array( $this, 'attachment_converted_meta' ) );
		add_action( 'attachment_submitbox_misc_actions', array( $this, 'attachment_submitbox_misc_actions' ), 90, 1 );
		add_action( 'admin_init', array( $this, 'alter_media_template' ) );
	}

	function alter_media_template(){

		function convert_stats( $content ){
			return apply_filters( 'final_output', $content );
		}

		ob_start( 'convert_stats' );

		add_filter( 'final_output', array( $this, 'final_output' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'wp_prepare_attachment_for_js' ), 10, 3 );
	}

	function final_output( $content ){
		if( strpos( $content, "data.png_converted" ) === false ){
			$content = str_replace(
				"<# if ( 'image' === data.type && ! data.uploading ) { #>",
				"<# if ( data.png_converted && data.controller.el.getAttribute('class').indexOf('edit-attachment-frame') != -1 ){ #>{{{ data.png_converted }}}<# } #><# if ( 'image' === data.type && ! data.uploading ) { #>",
				$content
			);
		}
		return $content;
	}

	function wp_prepare_attachment_for_js( $response, $attachment, $meta ){
		if( $png_converted = get_post_meta( $attachment->ID, 'png_converted', 1 ) ){
			if( $png_converted < 0 ){
				$png_converted = abs( $png_converted );
				$png_converted = '<span style="color:#f00">-' . size_format( $png_converted, 2 ) . '</span>';
			}else{
				$png_converted = size_format( $png_converted, 2 );
			}
			$response['png_converted'] = '<div class="png_converted"><strong>' . __( 'PNG to JPG saved:', 'png_to_jpg' ) . '</strong> ' . $png_converted . '</div>';
		}
		return $response;
	}

	function attachment_converted_meta( $post_id ){
		if( $this->converted_stats ){
			update_post_meta( $post_id, 'png_converted', $this->converted_stats );
		}
	}

	function attachment_submitbox_misc_actions( $post ){
		if( $png_converted = get_post_meta( $post->ID, 'png_converted', 1 ) ){
			if( $png_converted < 0 ){
				$png_converted = abs( $png_converted );
				$png_converted = '<strong style="color:#f00">-' . size_format( $png_converted, 2 ) . '</strong>';
			}else{
				$png_converted = '<strong>' . size_format( $png_converted, 2 ) . '</strong>';
			}
			echo '<div class="misc-pub-section">' . __( 'PNG to JPG saved:', 'png_to_jpg' ) . ' ' . $png_converted . '</div>';
		}
	}

	function plugins_loaded(){
		load_plugin_textdomain( 'png_to_jpg', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	function activate(){
		if( ! get_option( 'png_to_jpg_settings', 0 ) ){
			$defaults = array(
				'general' => array(
					'upload_convert' => 0,
					'jpg_quality' => '90',
					'only_lower' => 'checked',
					'leave_original' => 'checked',
					'autodetect' => 'checked'
				)
			);
			update_option( 'png_to_jpg_settings', $defaults );
		}
	}
	
	function filter_plugin_actions( $links, $file ){
		$settings_link = '<a href="upload.php?page=' . basename( __FILE__ ) . '">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
	
	function plugin_menu_link(){
		$this->plugin_admin_page = add_submenu_page(
			'upload.php',
			__( 'PNG to JPG', 'png_to_jpg' ),
			__( 'PNG to JPG', 'png_to_jpg' ),
			'manage_options',
			basename( __FILE__ ),
			array( $this, 'admin_options_page' )
		);
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'filter_plugin_actions' ), 10, 2 );
	}
	
	function plugin_init(){
		$this->settings = get_option('png_to_jpg_settings');
	}
	
	function plugin_admin_tabs( $current = 'general' ){
		$tabs = array(
			'general' => __('General'),
			'convert' => __( 'Convert existing PNGs', 'png_to_jpg' ),
			'info' => __('Help')
		); ?>
		<h2 class="nav-tab-wrapper">
		<?php foreach( $tabs as $tab => $name ){ ?>
			<a class="nav-tab <?php echo $tab == $current ? 'nav-tab-active' : '' ?>" href="?page=<?php echo basename( __FILE__ ) ?>&amp;tab=<?php echo $tab ?>"><?php echo $name ?></a>
		<?php } ?>
		</h2><br><?php
	}

	function admin_options_page(){
		if( get_current_screen()->id != $this->plugin_admin_page ) return;
		$this->tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';
		if( isset( $_POST['plugin_sent'] ) ){
			$this->settings[ $this->tab ] = $_POST;
			update_option( 'png_to_jpg_settings', $this->settings );
		} ?>
		<div class="wrap">
			<h2><?php _e( 'PNG to JPG', 'png_to_jpg' ); ?></h2>
			<?php if( isset( $_POST['plugin_sent'] ) ) echo '<div class="updated"><p>' . __('Settings saved.') . '</p></div>'; ?>
			<form method="post" action="<?php echo admin_url( 'upload.php?page=' . basename( __FILE__ ) ) ?>">
				<input type="hidden" name="plugin_sent" value="1"><?php
				$this->plugin_admin_tabs( $this->tab );
				switch( $this->tab ):
					case 'general':
						$this->tab_general();
						break;
					case 'convert':
						$this->tab_convert();
						break;
					case 'info':
						$this->tab_info();
						break;
				endswitch; ?>
			</form>
		</div><?php
	}

	function server_gd_library(){
		if( ! function_exists('imagecreatefrompng') ){
			echo '<div class="error"><p>' . __( 'PNG to JPG requires gd library enabled!', 'png_to_jpg' ) . '</p></div>';
		}
	}
	
	function tab_general(){
		global $wpdb;
		$stats = $wpdb->get_row("SELECT COUNT(*) as converted, SUM( meta_value ) as saved FROM {$wpdb->postmeta} WHERE meta_key = 'png_converted'"); ?>
		<div class="below-h2 updated">
			<p><?php
				printf( __( '%d images converted', 'png_to_jpg' ), $stats->converted );
				if( $stats->saved < 0 ){
					$stats->saved = abs( $stats->saved );
					$stats->saved = '<span style="color:#f00">-' . size_format( $stats->saved, 2 ) . '</span>';
				}else{
					$stats->saved = size_format( $stats->saved, 2 );
				}
				echo '<br>';
				printf( __( '%s saved', 'png_to_jpg' ), $stats->saved ); ?>
			</p>
		</div>
		<table class="form-table">
			<tr>
				<th>
					<label for="q_field_1"><?php _e( 'JPG quality', 'png_to_jpg' ) ?></label> 
				</th>
				<td>
					<input type="number" min="1" max="100" step="1" name="jpg_quality" placeholder="90" value="<?php echo $this->settings[ $this->tab ]['jpg_quality'] ?>" id="q_field_1"> %
				</td>
			</tr>
			<tr>
				<th>
					<label for="q_field_2"><?php _e( 'Convert PNG to JPG during upload', 'png_to_jpg' ) ?></label> 
				</th>
				<td><?php
					$this->q_select(array(
						'name' => 'upload_convert',
						'id' => 'q_field_2',
						'value' => $this->settings[ $this->tab ]['upload_convert'],
						'options' => array(
							0 => __('No'),
							1 => __('Yes'),
							2 => __( 'Yes, but only images without transparency', 'png_to_jpg' )
						)
					)); ?>
				</td>
			</tr>
			<tr>
				<th>
					<label for="q_field_5"><?php _e( 'Only convert image if JPG filesize is lower than PNG filesize', 'png_to_jpg' ) ?></label> 
				</th>
				<td>
					<input type="checkbox" name="only_lower" value="checked" id="q_field_5" <?php echo isset( $this->settings[ $this->tab ]['only_lower'] ) ? $this->settings[ $this->tab ]['only_lower'] : '' ?>>
				</td>
			</tr>
			<tr>
				<th>
					<label for="q_field_3"><?php _e( 'Leave original PNG images on the server', 'png_to_jpg' ) ?></label> 
				</th>
				<td>
					<input type="checkbox" name="leave_original" value="checked" id="q_field_3" <?php echo isset( $this->settings[ $this->tab ]['leave_original'] ) ? $this->settings[ $this->tab ]['leave_original'] : '' ?>>
				</td>
			</tr>
			<tr>
				<th>
					<label for="q_field_4"><?php _e( 'Autodetect transparency for existing PNG images', 'png_to_jpg' ) ?></label> 
				</th>
				<td>
					<input type="checkbox" name="autodetect" value="checked" id="q_field_4" <?php echo isset( $this->settings[ $this->tab ]['autodetect'] ) ? $this->settings[ $this->tab ]['autodetect'] : '' ?>>
				</td>
			</tr>
		</table>
		<p class="submit"><input type="submit" class="button button-primary button-large" value="<?php _e('Save') ?>"></p><?php
	}

	function tab_convert(){
		global $wpdb;
		$nonce = wp_create_nonce('convert_old_png');
		wp_enqueue_media();
		$query_images = new WP_Query(array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image/png',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
			'no_found_rows' => 1
		)); ?>
		<div class="below-h2 error">
			<p>
				<?php _e( 'Converted images will be fixed only in these tables:', 'png_to_jpg' ) ?> 
				<em><?php echo "{$wpdb->prefix}posts, {$wpdb->prefix}postmeta, {$wpdb->prefix}options, {$wpdb->prefix}revslider_slides, {$wpdb->prefix}toolset_post_guid_id, {$wpdb->prefix}fpd_products, {$wpdb->prefix}fpd_views" ?></em>. 
				<?php _e( 'If you need support for more database tables from various plugins, let me know by mail to info@kubiq.sk', 'png_to_jpg' ) ?>
			</p>
		</div>
		<div class="below-h2 error"><p><?php _e( 'Do you have backup? This operation will alter your original images and cannot be undone!', 'png_to_jpg' ) ?></p></div>
		<?php if( isset( $this->settings['general']['autodetect'] ) ): ?>
			<div id="transparency_status_message" class="below-h2 updated"><p><img src="<?php echo admin_url('/images/loading.gif') ?>" alt="" style="vertical-align:sub">&emsp;<span><?php _e( "Please wait, I'm getting transparency status for images...", 'png_to_jpg' ) ?></span></p></div>
		<?php endif ?>
		<br>
		<button type="button" class="button button-primary convert-pngs"><?php _e( 'Convert selected PNGs', 'png_to_jpg' ) ?></button>
		&emsp;
		<button type="button" class="button button-default select-transparent"><?php _e( 'Select all transparent PNGs', 'png_to_jpg' ) ?></button>
		&emsp;
		<button type="button" class="button button-default select-non-transparent"><?php _e( 'Select all non-transparent PNGs', 'png_to_jpg' ) ?></button>
		<br><br>
		<table class="wp-list-table widefat striped media">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox"></th>
					<th><?php _e('Media') ?></th>
					<?php if( isset( $this->settings['general']['autodetect'] ) ): ?>
						<th><?php _e( 'Has transparency', 'png_to_jpg' ) ?></th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody><?php
				foreach( $query_images->posts as $image ){
					$image->link = wp_get_attachment_url( $image->ID ); ?>
					<tr data-id="<?php echo $image->ID ?>" data-url="<?php echo $image->link ?>" data-transparency="-">
						<th scope="row" class="check-column">
							<input type="checkbox" name="media[]" value="<?php echo $image->ID ?>" <?php if( isset( $this->settings['general']['autodetect'] ) ) echo 'disabled' ?>>
						</th>
						<td class="title column-title has-row-actions column-primary">
							<strong class="has-media-icon">
								<a href="<?php echo $image->link ?>">
									<span class="media-icon image-icon">
										<?php echo wp_get_attachment_image( $image->ID, 'thumbnail' ) ?>
									</span>
									<?php echo $image->post_title ?>
								</a>
							</strong>
							<p class="filename">
								<?php echo basename( $image->link ) ?>
							</p>
						</td>
						<?php if( isset( $this->settings['general']['autodetect'] ) ): ?>
							<td class="transparency"></td>
						<?php endif ?>
					</tr><?php
				} ?>
			</tbody>
		</table>
		<br>
		<button type="button" class="button button-primary convert-pngs"><?php _e( 'Convert selected PNGs', 'png_to_jpg' ) ?></button>
		&emsp;
		<button type="button" class="button button-default select-transparent"><?php _e( 'Select all transparent PNGs', 'png_to_jpg' ) ?></button>
		&emsp;
		<button type="button" class="button button-default select-non-transparent"><?php _e( 'Select all non-transparent PNGs', 'png_to_jpg' ) ?></button>

		<div id="png_preview" class="media-modal wp-core-ui" style="display:none">
			<button type="button" class="button-link media-modal-close"><span class="media-modal-icon"></span></button>
			<div class="media-modal-content">
				<div class="edit-attachment-frame mode-select hide-menu hide-router">
					<div class="media-frame-title"><h1><?php _e('Attachment Details') ?></h1></div>
					<div class="media-frame-content"></div>
				</div>
			</div>
		</div>

		<style type="text/css" media="screen">
			.widefat thead .check-column{
				padding: 10px 0 0 4px;
			}
			#png_preview .media-frame-content{
				background: -webkit-linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, -webkit-linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, -webkit-linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, -webkit-linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, #c4c4c4;
				background: -o-linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, -o-linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, -o-linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, -o-linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, #c4c4c4;
				background: linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, linear-gradient(135deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 15px 15px, linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 1) 0%) 0 0, #c4c4c4;
				background-size: 30px 30px;
			}
		</style>

		<script>
			jQuery(document).ready(function($) {
				$('.has-media-icon a').click(function(event) {
					event.preventDefault();
					$('#png_preview .media-frame-content').html('<img src="' + this.href + '" alt="">');
					$('#png_preview').show();
				});
				$(document).keyup(function(event) {
					if( $('#png_preview').is(':visible') ){
						var keycode = ( event.keyCode ? event.keyCode : event.which );
						if( keycode == 27 ){
							$('#png_preview').hide();
						}
					}
				});
				$('#png_preview .media-modal-close').click(function(event) {
					event.preventDefault();
					$('#png_preview').hide();
				});
				$('.select-transparent').click(function(event) {
					event.preventDefault();
					$('tr[data-transparency] input').prop( 'checked', false );
					$('tr[data-transparency=1] input').prop( 'checked', true );
				});
				$('.select-non-transparent').click(function(event) {
					event.preventDefault();
					$('tr[data-transparency] input').prop( 'checked', false );
					$('tr[data-transparency=0] input').prop( 'checked', true );
				});
				$('.convert-pngs').click(function(event) {
					event.preventDefault();
					$('#transparency_status_message span').text('<?php _e( 'Please wait, converting your PNG images is in progress...', 'png_to_jpg' ) ?>');
					$('#transparency_status_message').show();
					$('tbody tr input').prop( 'disabled', true );
					delete_selected_pngs();
				});

				<?php if( isset( $this->settings['general']['autodetect'] ) ): ?>
					get_transparency();

					function get_transparency(){
						var $el = $('tbody tr[data-transparency="-"]').first();
						if( $el.length ){
							$.post( '<?php echo admin_url('admin-ajax.php') ?>', {
								action: 'hasTransparency',
								id: $el.attr('data-id'),
								png_url: $el.attr('data-url')
							}, function(response){
								var transparency = parseInt(response);
								$el.attr('data-transparency', transparency);
								$el.find('.transparency').html( transparency == 1 ? 'YES' : 'NO' );
								get_transparency();
							});
						}else{
							$('#transparency_status_message').hide();
							$('tbody tr input').prop( 'disabled', false );
						}
					}
				<?php endif; ?>

				function delete_selected_pngs(){
					var $el = $('tbody tr input:checked').first();
					if( $el.length ){
						var $tr = $el.parent().parent();
						$.post( '<?php echo admin_url('admin-ajax.php') ?>', {
							action: 'convert_old_png',
							id: $tr.attr('data-id'),
							nonce: '<?php echo $nonce ?>'
						}, function(response){
							$tr.remove();
							delete_selected_pngs();
						});
					}else{
						$('#transparency_status_message').html('<p><?php _e('Done') ?>.</p>');
						$('tbody tr input').prop('disabled', false);
					}
				}
			});
		</script><?php
	}
	
	function tab_info(){ ?>
		<p><?php _e( 'Any ideas, problems, issues?', 'png_to_jpg' ) ?></p>
		<p>Ing. Jakub Novák</p>
		<p><a href="mailto:info@kubiq.sk" target="_blank">info@kubiq.sk</a></p>
		<p><a href="https://kubiq.sk" target="_blank">https://kubiq.sk</a></p><?php
	}

	function q_select( $field_data = array(), $print = 1, $cols = array( 'value' => 'ID', 'text' => 'post_title' ) ){
		if( ! is_object( $field_data ) ) $field_data = (object)$field_data;
		$field_data->value = is_array( $field_data->value ) ? $field_data->value : array( $field_data->value );
		$select = sprintf(
			'<select name="%s" id="%s" %s %s>',
			$field_data->name,
			$field_data->id,
			isset( $field_data->multiple ) ? 'multiple' : '',
			isset( $field_data->size ) ? 'size="' . $field_data->size . '"' : ''
		);
		if( isset( $field_data->placeholder ) ){
			$select .= '<option value="" disabled>' . $field_data->placeholder . '</option>';
		}
		foreach( $field_data->options as $option => $value ){
			if( isset( $value->ID ) || isset( $value->term_id ) ){
				$post_id = isset( $value->ID ) ? $value->ID : $value->term_id;
				$value = (array)$value;
				if( class_exists( 'PLL_Model' ) ){
					$post_lang = pll_get_post_language( $post_id );
					if( pll_default_language() != $post_lang ) continue;
				}
				$select .= sprintf(
					'<option value="%s" %s>%s</option>',
					$value[ $cols['text'] ],
					in_array( $value[ $cols['text'] ] , $field_data->value ) ? 'selected' : '',
					$value[ $cols['value'] ]
				);
			}else{
				$select .= sprintf(
					'<option value="%s" %s>%s</option>',
					$option,
					in_array( $option, $field_data->value ) ? 'selected' : '',
					$value
				);
			}
		}
		$select .= '</select>';
		if( $print )
			echo $select;
		else
			return $select;
	}

	function upload_converting( $params ){
		if( $params['type'] == 'image/png' ) {
			if( $this->settings['general']['upload_convert'] == 1 ){
				$new_params = $this->convert_image( $params );
				if( $new_params ) $params = $new_params;
			}elseif( $this->settings['general']['upload_convert'] == 2 ){
				if( ! $this->hasTransparency( $params ) ){
					$new_params = $this->convert_image( $params );
					if( $new_params ) $params = $new_params;
				}
			}
		}
		return $params;
	}

	function convert_image( $params ){
		$stats_before = filesize( $params['file'] );
		$img = imagecreatefrompng( $params['file'] );
		$bg = imagecreatetruecolor( imagesx( $img ), imagesy( $img ) );
		imagefill( $bg, 0, 0, imagecolorallocate( $bg, 255, 255, 255 ) );
		imagealphablending( $bg, 1 );
		imagecopy( $bg, $img, 0, 0, 0, 0, imagesx( $img ), imagesy( $img ) );

		$possible_extensions = array( 'jpg', 'jpeg', 'jpe', 'jif', 'jfi', 'jfif' );

		do{
			$this->new_extension = array_shift( $possible_extensions );
			$newPath = preg_replace( "/\.png$/", "." . $this->new_extension, $params['file'] );
		}while( file_exists( $newPath ) );
		
		if( ! file_exists( $newPath ) ){
			$newUrl = preg_replace( "/\.png$/", "." . $this->new_extension, $params['url'] );
			if ( imagejpeg( $bg, $newPath, $this->settings['general']['jpg_quality'] ) ){
				$this->converted_stats = $stats_before - filesize( $newPath );
				if(
					! isset( $this->settings['general']['only_lower'] )
					|| (
						isset( $this->settings['general']['only_lower'] )
						&& $this->converted_stats > 0
					)
				){
					if( ! isset( $this->settings['general']['leave_original'] ) ){
						unlink( $params['file'] );
					}
					$params['file'] = $newPath;
					$params['url'] = $newUrl;
					$params['type'] = 'image/jpeg';
					return $params;
				}else{
					$this->converted_stats = 0;
					unlink( $newPath );
				}
			}
		}
		return 0;
	}

	function hasTransparency( $params ){
		$transparent = 0;
		if( isset( $_POST['png_url'] ) ){
			$image = $this->getFullPath( $_POST['png_url'] );
		}else{
			$image = $params['file'];
		}
		$handle = fopen( $image, 'rb' );
		$contents = stream_get_contents( $handle );
		fclose( $handle );
		if( ord( file_get_contents( $image, false, null, 25, 1 ) ) & 4 ) $transparent = 1;
		if( stripos( $contents, 'PLTE' ) !== false && stripos( $contents, 'tRNS' ) !== false ) $transparent = 1;
		if( isset( $_POST['png_url'] ) ){
			echo $transparent;
			exit();
		}else{
			return $transparent;
		}
	}

	function getFullPath( $url ){
		return str_replace( home_url('/'), ABSPATH, $url );
	}

	function convert_old_png(){
		if( defined('DOING_AJAX') && DOING_AJAX ){
			if( ! wp_verify_nonce( $_POST['nonce'], 'convert_old_png' ) ) die ('Wrong nonce!');
			$image = get_post( $_POST['id'] );
			$image->link = wp_get_attachment_url( $image->ID );
			$image->path = $this->getFullPath( $image->link );
			$params = array(
				'ID' => $image->ID,
				'file' => $image->path,
				'url' => $image->link,
			);
			if( $this->convert_image( $params ) ){
				$this->update_image_data( $image );
			}
		}
		exit();
	}

	function update_image_data( $image ){
		global $wpdb;

		$replaces = array( basename( $image->link ) );

		$thumbs = wp_get_attachment_metadata( $image->ID );
		foreach( $thumbs['sizes'] as $img ){
			if( file_exists( dirname( $image->path ) . '/' . $img['file'] ) ){
				$replaces[] = $img['file'];
				unlink( dirname( $image->path ) . '/' . $img['file'] );
			}
		}

		wp_update_post(array(
			'ID' => $image->ID,
			'post_mime_type' => 'image/jpeg'
		));
		
		$wpdb->update( 
			$wpdb->posts, 
			array( 'guid' => preg_replace( "/\.png$/", "." . $this->new_extension, $image->guid ) ),
			array( 'ID' => $image->ID ), 
			array( '%s' ), 
			array( '%d' ) 
		);

		$meta = get_post_meta( $image->ID, '_wp_attached_file', 1 );
		$meta = preg_replace( "/\.png$/", "." . $this->new_extension, $meta );
		update_post_meta( $image->ID, '_wp_attached_file', $meta );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$newPath = preg_replace( "/\.png$/", "." . $this->new_extension, $image->path );
		$attach_data = wp_generate_attachment_metadata( $image->ID, $newPath );
		wp_update_attachment_metadata( $image->ID, $attach_data );

		foreach( $replaces as $image ){
			$new_image = substr( $image, 0, -3 ) . $this->new_extension;
			// WP: wp_posts
			$wpdb->query("
				UPDATE {$wpdb->posts} 
				SET post_content = REPLACE( post_content, '/{$image}', '/{$new_image}') 
				WHERE post_content LIKE '%/{$image}%'
			");
			// WP: wp_postmeta
			$wpdb->query("
				UPDATE {$wpdb->postmeta} 
				SET meta_value = REPLACE( meta_value, '/{$image}', '/{$new_image}') 
				WHERE meta_value LIKE '%/{$image}%'
			");
			// WP: wp_options
			$wpdb->query("
				UPDATE {$wpdb->options} 
				SET option_value = REPLACE( option_value, '/{$image}', '/{$new_image}') 
				WHERE option_value LIKE '%/{$image}%'
			");
			// Revolution Slider: wp_revslider_slides
			$table_name = $wpdb->prefix.'revslider_slides';
			if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ){
				$wpdb->query("
					UPDATE $table_name 
					SET params = REPLACE( params, '/{$image}', '/{$new_image}'), 
						layers = REPLACE( layers, '/{$image}', '/{$new_image}') 
					WHERE params LIKE '%/{$image}%' 
						OR layers LIKE '%/{$image}%'
				");
			}
			// Toolset Types: wp_toolset_post_guid_id
			$table_name = $wpdb->prefix.'toolset_post_guid_id';
			if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ){
				$wpdb->query("
					UPDATE $table_name 
					SET guid = REPLACE( guid, '/{$image}', '/{$new_image}') 
					WHERE guid LIKE '%/{$image}%'
				");
			}
			// Fancy Product Designer: wp_fpd_products
			$table_name = $wpdb->prefix.'fpd_products';
			if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ){
				$wpdb->query("
					UPDATE $table_name 
					SET thumbnail = REPLACE( thumbnail, '/{$image}', '/{$new_image}') 
					WHERE thumbnail LIKE '%/{$image}%'
				");
			}
			// Fancy Product Designer: wp_fpd_views
			$table_name = $wpdb->prefix.'fpd_views';
			if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name ){
				$wpdb->query("
					UPDATE $table_name 
					SET thumbnail = REPLACE( thumbnail, '/{$image}', '/{$new_image}'), 
						elements = REPLACE( elements, '/{$image}', '/{$new_image}') 
					WHERE thumbnail LIKE '%/{$image}%' 
						OR elements LIKE '%/{$image}%'
				");
			}
		}
	}
}

$png_to_jpg_var = new png_to_jpg();
register_activation_hook( __FILE__, array( $png_to_jpg_var, 'activate' ) );