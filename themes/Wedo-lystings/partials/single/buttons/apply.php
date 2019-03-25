<?php
/**
 * call button in listing cover section.
 *
 * @since 1.6.0
 */
 
?>
<li>
    <a href="#_tab_2" class="buttons <?php echo esc_attr( join( ' ', $button['classes'] ) ) ?> medium show-dropdown apply-button" type="button" id="<?php echo esc_attr( $button['id'] ) ?>" >
        <?php echo do_shortcode( $button['label'] ) ?>
    </a>
</li>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.apply-button').click(function(e){
			e.preventDefault();
			$('.tabs-menu a[href="#_tab_2"]').click();
			$('html,body').animate({scrollTop: $('#_tab_2').offset().top-200}, 500);
		});
	});
</script>