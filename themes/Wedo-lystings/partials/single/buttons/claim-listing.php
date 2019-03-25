<?php
global $post;
$listing = MyListing\Src\Listing::get( $post );
$claim_url = case27_paid_listing_claim_url( $listing->get_id() );
if ( ! $claim_url ) {
	return;
}

if ( ! is_user_logged_in() ) {
	$claim_url = home_url('ajouter-votre-annonce');
}

$button = array();
$button['action'] = 'claim-listing';
$button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/hand.svg" alt="image"></i>'.__('Proclamer','wedo-listing');
$button['label_l10n'] = array('locale' => 'en_US');
$button['style'] = 'outlined';
$button['icon'] = 'mi redo';
$button['id'] = 'cover-button--5ac36c5a188a7';
$button['classes'] = array('button-2');

?>
<li>
	<a class="buttons button-2 medium" href="<?php echo esc_attr( $claim_url ) ?>">
		<?php echo do_shortcode( $button['label'] ) ?>
	</a>
</li>