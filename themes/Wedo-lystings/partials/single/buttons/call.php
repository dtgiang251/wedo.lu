<?php
/**
 * call button in listing cover section.
 *
 * @since 1.6.0
 */
 
?>
<?php if ( $listing->get_field( 'tlphone' ) ) { ?>
<li>
    <a href="tel:<?php echo $listing->get_field( 'tlphone' ); ?>" class="buttons <?php echo esc_attr( join( ' ', $button['classes'] ) ) ?> medium show-dropdown call-btn" type="button" id="<?php echo esc_attr( $button['id'] ) ?>" >
        <?php echo do_shortcode( $button['label'] ) ?>
    </a>
</li>
<?php } ?>