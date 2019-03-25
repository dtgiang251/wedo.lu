<?php
global $thepostid;

if ( ! isset( $field['value'] ) ) {
	$field['value'] = get_post_meta( $thepostid, $key, true );
}
if ( ! empty( $field['name'] ) ) {
	$name = $field['name'];
} else {
	$name = $key;
}
?>
<p class="form-field listing-type-select">
	<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>: <?php if ( ! empty( $field['description'] ) ) : ?><span class="tips" data-tip="<?php echo esc_attr( $field['description'] ); ?>">[?]</span><?php endif; ?></label>
	<select name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $key ); ?>">
		<?php foreach ( $field['options'] as $key => $value ) : ?>
			 <?php $french_post = get_page_by_path( $key, OBJECT, 'case27_listing_type' );
			 $cuurent_language_id  = apply_filters( 'wpml_object_id', $french_post->ID, 'case27_listing_type' );?>
			 <?php if($cuurent_language_id){
				 $current_laguage_post = get_post($cuurent_language_id);?>
			<option value="<?php echo esc_attr( $current_laguage_post->post_name ); ?>" <?php if ( isset( $field['value'] ) ) selected( $field['value'], $current_laguage_post->post_name ); ?>><?php echo esc_html( $current_laguage_post->post_title ); ?></option>
			 <?php } else{ ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php if ( isset( $field['value'] ) ) selected( $field['value'], $key ); ?>><?php echo esc_html( $value ); ?></option>
			 <?php } ?>
		<?php endforeach; ?>
	</select>
</p>