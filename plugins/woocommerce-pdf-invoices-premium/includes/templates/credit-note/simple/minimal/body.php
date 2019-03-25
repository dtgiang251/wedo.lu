<?php
/**
 * PDF Credit Note template body.
 *
 * This template can be overridden by copying it to youruploadsfolder/woocommerce-pdf-invoices/templates/credit-note/simple/yourtemplatename/body.php.
 *
 * HOWEVER, on occasion WooCommerce PDF Invoices will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author  Bas Elbers
 * @package WooCommerce_PDF_Invoices_Premium/Templates
 * @version 0.0.1
 */

$templater                      = WPI()->templater();
$order                          = $templater->order;
/** @var BEWPIP_Credit_Note $credit_note */
$credit_note                    = $templater->invoice;
$formatted_shipping_address     = $order->get_formatted_shipping_address();
$formatted_billing_address      = $order->get_formatted_billing_address();
$refunds                        = $order->get_refunds();
$refunded_order                 = $refunds[0];
/** @var WC_Order_Refund $refunded_order */
$line_items                     = $refunded_order->get_items();
$color                          = $templater->get_option( 'bewpi_color_theme' );
$terms                          = $templater->get_option( 'bewpi_terms' );
?>

<table cellpadding="0" cellspacing="0">
	<tr class="title">
		<td colspan="3">
			<h2><?php _e( 'Credit Note', 'woocommerce-pdf-invoices' ); ?></h2>
		</td>
	</tr>
	<tr class="information">
		<td width="50%">
			<?php echo nl2br( $templater->get_option( 'bewpi_company_address' ) ); ?>
		</td>

		<td>
			<?php
			if ( $templater->get_option( 'bewpi_show_ship_to' ) && ! empty( $formatted_shipping_address ) && $formatted_shipping_address !== $formatted_billing_address && ! $templater->has_only_virtual_products( $line_items ) ) {
				printf( '<strong>%s</strong><br />', __( 'Ship to:', 'woocommerce-pdf-invoices' ) );
				echo $formatted_shipping_address;
			}
			?>
		</td>

		<td>
			<?php echo $formatted_billing_address; ?>
		</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0">
	<thead>
		<tr class="heading" bgcolor="<?php echo $color; ?>;">
			<th width="50%">
				<?php _e( 'Product', 'woocommerce-pdf-invoices' ); ?>
			</th>

			<th>
				<?php _e( 'Qty', 'woocommerce-pdf-invoices' ); ?>
			</th>

			<?php do_action( 'bewpi_line_item_headers_after_quantity', $credit_note ); ?>

			<th>
				<?php _e( 'Price', 'woocommerce-pdf-invoices' ); ?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php

	foreach ( $line_items as $item_id => $item ) {
		?>
		<tr class="item">
			<td width="50%">
				<?php
				echo $item['name'];

				do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order );

				$templater->wc_display_item_meta( $item, true );
				$templater->wc_display_item_downloads( $item, true );

				do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order );
				?>
			</td>

			<td>
				<?php echo $item['qty']; ?>
			</td>

			<?php do_action( 'bewpi_line_item_after_quantity', $item_id, $item, $credit_note ); ?>

			<td>
				<?php echo $order->get_formatted_line_subtotal( $item ); ?>
			</td>
		</tr>

	<?php } ?>

	<tr class="spacer">
		<td></td>
	</tr>

	<?php
	foreach ( $refunded_order->get_order_item_totals() as $key => $total ) {
		$class = str_replace( '_', '-', $key );
		?>

		<tr class="total">
			<td></td>
			<td class="border <?php echo $class; ?>" colspan="<?php echo $credit_note->colspan; ?>"><?php echo $total['label']; ?></td>
			<td class="border <?php echo $class; ?>"><?php echo $total['value']; ?></td>
		</tr>

	<?php } ?>
	</tbody>
</table>

<table class="notes" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?php
			// Customer notes.
			if ( $templater->get_option( 'bewpi_show_customer_notes' ) ) {
				// Note added by customer.
				$customer_note = BEWPI_WC_Order_Compatibility::get_customer_note( $order );
				if ( $customer_note ) {
					printf( '<strong>' . __( 'Note from customer: %s', 'woocommerce-pdf-invoices' ) . '</strong><br />', nl2br( $customer_note ) );
				}

				// Notes added by administrator on 'Edit Order' page.
				foreach ( $order->get_customer_order_notes() as $custom_order_note ) {
					printf( '<strong>' . __( 'Note to customer: %s', 'woocommerce-pdf-invoices' ) . '</strong><br />', nl2br( $custom_order_note->comment_content ) );
				}
			}
			?>
		</td>
	</tr>

	<tr>
		<td>
			<?php
			// Zero Rated VAT message.
			if ( 'true' === $templater->get_meta( '_vat_number_is_valid' ) && count( $order->get_tax_totals() ) === 0 ) {
				_e( 'Zero rated for VAT as customer has supplied EU VAT number', 'woocommerce-pdf-invoices' );
				printf( '<br />' );
			}
			?>
		</td>
	</tr>
</table>

<?php if ( $terms ) { ?>
	<div class="terms">
		<table>
			<tr>
				<td style="border: 1px solid #000;">
					<?php echo nl2br( $terms ); ?>
				</td>
			</tr>
		</table>
	</div>
<?php }
