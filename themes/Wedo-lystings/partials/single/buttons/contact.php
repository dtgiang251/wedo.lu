<?php
/**
 * contact button in listing cover section.
 *
 * @since 1.6.0
 */
 
?>
<li>
    <a href="#contact-form" class="buttons <?php echo esc_attr( join( ' ', $button['classes'] ) ) ?> medium show-dropdown contact-btn" type="button" id="<?php echo esc_attr( $button['id'] ) ?>">
        <?php echo do_shortcode( $button['label'] ) ?>
    </a>
</li>