<?php
/**
 * Invoice class.
 *
 * Handling invoice specific functionality.
 *
 * @author      Bas Elbers
 * @category    Class
 * @package     BE_WooCommerce_PDF_Invoices_Premium/Class
 * @version     0.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BEWPIP_Invoice' ) ) {
	/**
	 * Class BEWPIP_Invoice.
	 */
	class BEWPIP_Invoice {

		/**
		 * Initialize hooks.
		 */
		public static function init_hooks() {
			self::add_settings();

			// Advanced Table Content.
			if ( WPI()->templater()->has_advanced_table_content() ) {
				self::advanced_table_content();
			} else {
				self::table_content();
			}

			add_filter( 'wpi_delete_invoice_confirm_message', array(
				__CLASS__,
				'change_delete_invoice_confirm_message',
			) );
			add_action( 'wpi_watermark_end', array( __CLASS__, 'add_watermark' ), 10, 2 );
			add_filter( 'woocommerce_email_headers', array( __CLASS__, 'add_recipients' ), 10, 2 );
			add_filter( 'bewpi_mpdf_after_write', array( __CLASS__, 'add_pdf_to_invoice' ), 10, 2 );

			// Request Invoice.
			if ( WPI()->get_option( 'premium', 'request_invoice' ) ) {
				add_action( 'woocommerce_after_order_notes', array( __CLASS__, 'add_request_invoice_checkout_field' ) );
				add_action( 'woocommerce_checkout_update_order_meta', array(
					__CLASS__,
					'process_request_invoice_checkout_field',
				) );
				add_filter( 'bewpi_skip_invoice_generation', array( __CLASS__, 'skip_invoice_generation' ), 10, 3 );
			}
		}

		/**
		 * Change WooCommerce PDF Invoices confirm message when deleting invoice.
		 *
		 * @param string $message free version confirm message.
		 *
		 * @return string $message
		 */
		public static function change_delete_invoice_confirm_message( $message ) {
			$message = __( 'Instead consider creating a Cancelled PDF invoice by changing the order status to Cancelled.', 'woocommerce-pdf-invoices' );

			return $message;
		}

		/**
		 * Add invoice settings.
		 */
		private static function add_settings() {
			add_filter( 'wpi_template_sections', array( __CLASS__, 'add_template_sections' ) );
			add_filter( 'wpi_template_settings', array( __CLASS__, 'add_template_settings' ), 10, 2 );
		}

		/**
		 * Initialize table content.
		 */
		private static function table_content() {
			add_action( 'bewpi_line_item_headers_after_quantity', array(
				__CLASS__,
				'display_line_item_tax_headers',
			) );
			add_action( 'bewpi_line_item_after_quantity', array( __CLASS__, 'display_line_item_tax' ), 10, 3 );
		}

		/**
		 * Initialize advanced table content.
		 */
		private static function advanced_table_content() {
			add_action( 'wpi_order_item_meta_start', array( __CLASS__, 'display_sku_as_meta_data' ), 10, 2 );
			add_filter( 'wpi_get_invoice_columns', array( __CLASS__, 'get_columns' ), 10, 2 );
			add_filter( 'wpi_get_invoice_columns_data_row', array( __CLASS__, 'get_columns_data' ), 10, 4 );
			add_filter( 'wpi_get_invoice_total_rows', array( __CLASS__, 'get_total_rows' ), 10, 2 );
		}

		/**
		 * Add Cancelled watermark for cancelled orders.
		 *
		 * @param WC_Order               $order WC order object.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		public static function add_watermark( $order, $invoice ) {
			if ( 'cancelled' === $order->get_status( 'edit' ) ) {
				printf( '<h2 class="red">%s</h2>', esc_html__( 'Cancelled', 'woocommerce-pdf-invoices' ) );
			}
		}

		/**
		 * Add advanced table content section.
		 *
		 * @param array $sections Sections.
		 *
		 * @return array.
		 */
		public static function add_template_sections( $sections ) {
			$sections['advanced_table_content'] = array(
				'title'       => __( 'Advanced Table Content', 'woocommerce-pdf-invoices' ),
				'description' => __( 'Enable Advanced Table Content settings to fully customize line item columns and total rows. When enabled the standard Table Content settings will be ignored. When using a custom template, make sure to update it! Micro template is not supported.', 'woocommerce-pdf-invoices' ),
			);

			return $sections;
		}

		/**
		 * Add advanced table content checkbox to enable it.
		 *
		 * @param array                   $settings Settings fields.
		 * @param BEWPI_Template_Settings $template_settings object template settings.
		 *
		 * @return array
		 */
		public static function add_template_settings( $settings, $template_settings ) {
			$ex_tax_or_vat                = WC()->countries->ex_tax_or_vat();
			$inc_tax_or_vat               = WC()->countries->inc_tax_or_vat();
			$woocommerce_tax_display_cart = get_option( 'woocommerce_tax_display_cart' );

			$advanced_settings = array(
				array(
					'id'       => 'bewpi-enable-advanced-table-content',
					'name'     => 'bewpi_enable_advanced_table_content',
					'title'    => '',
					'callback' => array( $template_settings, 'input_callback' ),
					'page'     => $template_settings->settings_key,
					'section'  => 'advanced_table_content',
					'type'     => 'checkbox',
					'desc'     => __( 'Enable Advanced Table Content', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-checkbox-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-show-sku-meta',
					'name'     => 'bewpi_show_sku_meta',
					'title'    => '',
					'callback' => array( $template_settings, 'input_callback' ),
					'page'     => $template_settings->settings_key,
					'section'  => 'advanced_table_content',
					'type'     => 'checkbox',
					'desc'     => __( 'Show SKU as meta data', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-checkbox-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-tax-total-display',
					'name'     => 'bewpi_tax_total_display',
					'title'    => __( 'Display tax totals', 'woocommerce-pdf-invoices' ),
					'callback' => array( $template_settings, 'select_callback' ),
					'page'     => $template_settings->settings_key,
					'section'  => 'advanced_table_content',
					'type'     => 'select',
					'desc'     => '',
					'default'  => get_option( 'woocommerce_tax_total_display' ),
					'options'  => array(
						'itemized' => __( 'Itemized', 'woocommerce-pdf-invoices' ),
						'single'   => __( 'As a single total', 'woocommerce-pdf-invoices' ),
					),
				),
				array(
					'id'       => 'bewpi-columns',
					'name'     => 'bewpi_columns',
					'title'    => __( 'Line item columns', 'woocommerce-pdf-invoices' ),
					'callback' => array( $template_settings, 'multi_select_callback' ),
					'page'     => $template_settings->settings_key,
					'section'  => 'advanced_table_content',
					'type'     => 'multiple_select',
					'desc'     => '',
					'class'    => 'bewpi-columns',
					'options'  => array(
						'description'    => array(
							'name'    => __( 'Description', 'woocommerce-pdf-invoices' ),
							'value'   => 'description',
							'default' => 1,
						),
						'cost_ex_vat'    => array(
							'name'    => __( 'Cost', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'cost_ex_vat',
							'default' => 0,
						),
						'cost_incl_vat'  => array(
							'name'    => __( 'Cost', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'cost_incl_vat',
							'default' => 0,
						),
						'quantity'       => array(
							'name'    => __( 'Quantity', 'woocommerce-pdf-invoices' ),
							'value'   => 'quantity',
							'default' => 1,
						),
						'vat'            => array(
							'name'    => WC()->countries->tax_or_vat(),
							'value'   => 'vat',
							'default' => 0,
						),
						'total_ex_vat'   => array(
							'name'    => __( 'Total', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'total_ex_vat',
							'default' => absint( 'excl' === get_option( 'woocommerce_tax_display_cart' ) ),
						),
						'total_incl_vat' => array(
							'name'    => __( 'Total', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'total_incl_vat',
							'default' => absint( 'incl' === get_option( 'woocommerce_tax_display_cart' ) ),
						),
					),
				),
				array(
					'id'       => 'bewpi-totals',
					'name'     => 'bewpi_totals',
					'title'    => __( 'Total rows', 'woocommerce-pdf-invoices' ),
					'callback' => array( $template_settings, 'multi_select_callback' ),
					'page'     => 'bewpi_template_settings',
					'section'  => 'advanced_table_content',
					'type'     => 'multiple_select',
					'desc'     => '',
					'class'    => 'bewpi-totals',
					'options'  => array(
						'discount_ex_vat'   => array(
							'name'    => __( 'Discount', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'discount_ex_vat',
							'default' => absint( 'excl' === $woocommerce_tax_display_cart ),
						),
						'shipping_ex_vat'   => array(
							'name'    => __( 'Shipping', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'shipping_ex_vat',
							'default' => absint( 'excl' === $woocommerce_tax_display_cart ),
						),
						'fee_ex_vat'        => array(
							'name'    => __( 'Fee', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'fee_ex_vat',
							'default' => absint( 'excl' === $woocommerce_tax_display_cart ),
						),
						'subtotal_ex_vat'   => array(
							'name'    => __( 'Subtotal', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'subtotal_ex_vat',
							'default' => absint( 'excl' === $woocommerce_tax_display_cart ),
						),
						'subtotal_incl_vat' => array(
							'name'    => __( 'Subtotal', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'subtotal_incl_vat',
							'default' => absint( 'incl' === $woocommerce_tax_display_cart ),
						),
						'discount_incl_vat' => array(
							'name'    => __( 'Discount', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'discount_incl_vat',
							'default' => absint( 'incl' === $woocommerce_tax_display_cart ),
						),
						'shipping_incl_vat' => array(
							'name'    => __( 'Shipping', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'shipping_incl_vat',
							'default' => absint( 'incl' === $woocommerce_tax_display_cart ),
						),
						'fee_incl_vat'      => array(
							'name'    => __( 'Fee', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'fee_incl_vat',
							'default' => absint( 'incl' === $woocommerce_tax_display_cart ),
						),
						'vat'               => array(
							'name'    => WC()->countries->tax_or_vat(),
							'value'   => 'vat',
							'default' => 1,
						),
						'total_ex_vat'      => array(
							'name'    => __( 'Total', 'woocommerce-pdf-invoices' ) . ' ' . $ex_tax_or_vat,
							'value'   => 'total_ex_vat',
							'default' => absint( 'excl' === $woocommerce_tax_display_cart ),
						),
						'total_incl_vat'    => array(
							'name'    => __( 'Total', 'woocommerce-pdf-invoices' ) . ' ' . $inc_tax_or_vat,
							'value'   => 'total_incl_vat',
							'default' => absint( 'incl' === $woocommerce_tax_display_cart ),
						),
					),
				),
			);

			return array_merge( $settings, $advanced_settings );
		}

		/**
		 * Add line item tax headers to the invoice.
		 *
		 * @param BEWPI_Invoice $invoice Invoice object.
		 */
		public static function display_line_item_tax_headers( $invoice ) {
			$template_options = get_option( 'bewpi_template_settings' );

			if ( wc_tax_enabled() && $template_options['bewpi_show_tax'] && $invoice->order->get_taxes() > 0 ) {
				foreach ( $invoice->order->get_taxes() as $tax_item ) {
					printf( '<th>%s</th>', $tax_item['label'] );
				}
			}
		}

		/**
		 * Add line item tax to the invoice.
		 *
		 * @param int               $item_id Tax item ID.
		 * @param WC_Order_Item_Tax $item Tax item.
		 * @param BEWPI_Invoice     $invoice Invoice object.
		 */
		public static function display_line_item_tax( $item_id, $item, $invoice ) {
			$template_options = get_option( 'bewpi_template_settings' );

			if ( wc_tax_enabled() && $template_options['bewpi_show_tax'] && $invoice->order->get_taxes() > 0 ) {
				foreach ( self::get_line_item_tax_data( $invoice->order, $item ) as $tax_total ) {
					printf( '<td>%s</td>', $tax_total );
				}

				$colspan = count( $invoice->order->get_taxes() ) + 1;
				WPI()->templater()->invoice->set_colspan( $colspan );
			}
		}

		/**
		 * Display SKU as item meta.
		 *
		 * @param WC_Order_Item_Product $item order item object.
		 * @param WC_Order              $order order object.
		 */
		public static function display_sku_as_meta_data( $item, $order ) {
			if ( ! WPI()->templater()->has_sku_as_meta_data() ) {
				return;
			}

			$product = BEWPI_WC_Order_Compatibility::get_product( $order, $item );
			$sku     = $product && BEWPI_WC_Product_Compatibility::get_prop( $product, 'sku' ) ? BEWPI_WC_Product_Compatibility::get_prop( $product, 'sku' ) : '-';
			?>
			<br>
			<ul>
				<li>
					<strong><?php esc_html_e( 'SKU:', 'woocommerce-pdf-invoices' ); ?></strong> <?php echo esc_html( $sku ); ?>
				</li>
			</ul>
			<?php
		}

		/**
		 * Add VAT to column headers.
		 *
		 * @param array                  $data column headers data.
		 * @param BEWPI_Abstract_Invoice $invoice invoice object.
		 *
		 * @return array $data.
		 */
		public static function add_vat_column( $data, $invoice ) {
			foreach ( $invoice->order->get_taxes() as $code => $tax ) {
				// add rate percentage if not exists.
				if ( false === strpos( $tax['label'], '%' ) ) {
					$label = $tax['label'] . ' ' . WC_Tax::get_rate_percent( $tax['rate_id'] );
				} else {
					$label = $tax['label'];
				}

				$data['vat'][ sanitize_title( $code ) ] = $label;
			}

			return $data;
		}

		/**
		 * Add line item column headers.
		 *
		 * @param array                  $data Column header data.
		 * @param BEWPI_Abstract_Invoice $invoice invoice object.
		 *
		 * @return array $data.
		 */
		public static function get_columns( $data, $invoice ) {
			$data             = array();
			$selected_columns = (array) WPI()->get_option( 'template', 'columns' );

			foreach ( $selected_columns as $column ) {
				switch ( $column ) {
					case 'description':
						$invoice->add_column( $data, $column, __( 'Description', 'woocommerce-pdf-invoices' ) );
						break;

					case 'quantity':
						$invoice->add_column( $data, $column, __( 'Qty', 'woocommerce-pdf-invoices' ) );
						break;

					case 'cost_ex_vat':
						$invoice->add_column( $data, $column, __( 'Cost', 'woocommerce-pdf-invoices' ), 'excl' );
						break;

					case 'cost_incl_vat':
						$invoice->add_column( $data, $column, __( 'Cost', 'woocommerce-pdf-invoices' ), 'incl' );
						break;

					case 'vat':
						$data = self::add_vat_column( $data, $invoice );
						break;

					case 'total_ex_vat':
						$invoice->add_column( $data, $column, __( 'Total', 'woocommerce-pdf-invoices' ), 'excl' );
						break;

					case 'total_incl_vat':
						$invoice->add_column( $data, $column, __( 'Total', 'woocommerce-pdf-invoices' ), 'incl' );
						break;
				}
			}

			// Sort by setting.
			$data = array_merge( array_flip( $selected_columns ), $data );

			return $data;
		}

		/**
		 * Add VAT column data.
		 *
		 * @param array                  $row Column data.
		 * @param int                    $item_id Item ID.
		 * @param WC_Order_Item          $item Item object.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_vat_column_data( &$row, $item_id, $item, $invoice ) {
			foreach ( self::get_line_item_tax_data( $invoice->order, $item ) as $code => $tax ) {
				$row['vat'][ sanitize_title( $code ) ] = $tax;
			}
		}

		/**
		 * Get line item tax data.
		 *
		 * @param WC_Order      $order Order object.
		 * @param WC_Order_Item $item Order item object.
		 *
		 * @return array.
		 */
		private static function get_line_item_tax_data( $order, $item ) {
			$line_item_tax_data = array();
			$line_tax_data      = isset( $item['line_tax_data'] ) ? $item['line_tax_data'] : '';
			$tax_data           = maybe_unserialize( $line_tax_data );

			foreach ( $order->get_taxes() as $code => $tax ) {
				$tax_item_id    = $tax['rate_id'];
				$tax_item_total = isset( $tax_data['total'][ $tax_item_id ] ) ? $tax_data['total'][ $tax_item_id ] : '';

				if ( ! empty( $tax_item_total ) ) {
					$line_item_tax_data[ sanitize_title( $code ) ] = wc_price( wc_round_tax_total( $tax_item_total ), array(
							'currency' => WPI()->get_currency( $order ),
						)
					);
				} else {
					$line_item_tax_data[ sanitize_title( $code ) ] = '&ndash;';
				}
			}

			return $line_item_tax_data;
		}

		/**
		 * Add Cost column data.
		 *
		 * @param array                  $row Column data.
		 * @param int                    $item_id Item ID.
		 * @param object                 $item Item object.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 * @param bool                   $incl_tax Including tax.
		 */
		private static function add_cost_column_data( &$row, $item_id, $item, $invoice, $incl_tax = false ) {
			$key                = 'cost_' . ( $incl_tax ? 'incl' : 'ex' ) . '_vat';
			$row[ $key ] = wc_price( $invoice->order->get_item_subtotal( $item, $incl_tax ), array(
					'currency' => WPI()->get_currency( $invoice->order ),
				)
			);
		}

		/**
		 * Adds line item total incl. tax to columns data array.
		 *
		 * @param array                  $row Column data.
		 * @param int                    $item_id Item ID.
		 * @param object                 $item Item object.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 * @param bool                   $incl_tax Including tax.
		 */
		private static function add_total_column_data( &$row, $item_id, $item, $invoice, $incl_tax = false ) {
			$key         = 'total_' . ( $incl_tax ? 'incl' : 'ex' ) . '_vat';
			$row[ $key ] = wc_price( $invoice->order->get_line_subtotal( $item, $incl_tax ), array(
					'currency' => WPI()->get_currency( $invoice->order ),
				)
			);
		}

		/**
		 * Add column data to rows.
		 *
		 * @param array                  $row Column data.
		 * @param int                    $item_id Item ID.
		 * @param object                 $item Item object.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 *
		 * @return array.
		 */
		public static function get_columns_data( $row, $item_id, $item, $invoice ) {
			$row              = array();
			$selected_columns = (array) WPI()->get_option( 'template', 'columns' );

			foreach ( $selected_columns as $column ) {
				switch ( $column ) {
					case 'description':
						$invoice->add_description_column_data( $row, $item_id, $item );
						break;
					case 'quantity':
						$invoice->add_quantity_column_data( $row, $item_id, $item );
						break;

					case 'cost_ex_vat':
						self::add_cost_column_data( $row, $item_id, $item, $invoice );
						break;

					case 'vat':
						self::add_vat_column_data( $row, $item_id, $item, $invoice );
						break;

					case 'cost_incl_vat':
						self::add_cost_column_data( $row, $item_id, $item, $invoice, true );
						break;

					case 'total_ex_vat':
						self::add_total_column_data( $row, $item_id, $item, $invoice );
						break;

					case 'total_incl_vat':
						self::add_total_column_data( $row, $item_id, $item, $invoice, true );
						break;
				}
			}

			// Sort by setting.
			$row = array_merge( array_flip( $selected_columns ), $row );

			return $row;
		}

		/**
		 * Add total row for subtotal.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_subtotal_total_row( &$total_rows, $tax_display, $invoice ) {
			$subtotal = $invoice->order->get_subtotal();

			if ( $subtotal ) {
				$incl_tax = 'incl' === $tax_display;

				if ( $incl_tax ) {

					$formatted_subtotal = strip_tags( $invoice->order->get_subtotal_to_display( false, 'incl' ) );

				} else {

					foreach ( WPI()->get_totals_before_subtotal() as $total ) {
						switch ( $total ) {
							case 'discount_ex_vat':
								$subtotal -= $invoice->order->get_total_discount();
								break;

							case 'shipping_ex_vat':
								$subtotal += WPI()->get_prop( $invoice->order, 'shipping_total', 'edit' );
								break;

							case 'fee_ex_vat':
								/**
								 * Fee Annotation.
								 *
								 * @var WC_Order_Item_Fee $fee
								 */
								foreach ( $invoice->order->get_items( 'fee' ) as $fee ) {
									$subtotal += (float) $fee['line_total'];
								}
								break;
						}
					}

					$formatted_subtotal = wc_price( $subtotal, array(
							'currency' => WPI()->get_currency( $invoice->order ),
						)
					);
				}

				$total_rows['cart_subtotal'] = array(
					/* translators: tax or vat label */
					'label' => sprintf( __( 'Subtotal %s', 'woocommerce-pdf-invoices' ), WPI()->tax_or_vat_label( $incl_tax ) ),
					'value' => $formatted_subtotal,
				);
			} // End if().
		}

		/**
		 * Add total row for discounts.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_discount_total_row( &$total_rows, $tax_display, $invoice ) {
			if ( $invoice->order->get_total_discount() > 0 ) {
				$incl_tax               = 'incl' === $tax_display;
				$total_rows['discount'] = array(
					/* translators: tax or vat label */
					'label' => sprintf( __( 'Discount %s', 'woocommerce-pdf-invoices' ), WPI()->tax_or_vat_label( $incl_tax ) ),
					'value' => '-' . wc_price( $invoice->order->get_total_discount( ! $incl_tax ), array(
								'currency' => WPI()->get_currency( $invoice->order ),
							)
						)
				);
			}
		}

		/**
		 * Add total row for shipping.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_shipping_total_row( &$total_rows, $tax_display, $invoice ) {
			if ( $invoice->order->get_shipping_method() ) {
				$incl_tax       = 'incl' === $tax_display;
				$shipping_total = WPI()->get_prop( $invoice->order, 'shipping_total', 'edit' );

				if ( $incl_tax ) {
					$shipping_total += (float) WPI()->get_prop( $invoice->order, 'shipping_tax', 'edit' );
				}

				$total_rows['shipping'] = array(
					/* translators: tax or vat label */
					'label' => sprintf( __( 'Shipping %s', 'woocommerce-pdf-invoices' ), WPI()->tax_or_vat_label( $incl_tax ) ),
					'value' => wc_price( $shipping_total, array(
							'currency' => WPI()->get_currency( $invoice->order ),
						)
					),
				);
			}
		}

		/**
		 * Add total row for fees.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_fee_total_row( &$total_rows, $tax_display, $invoice ) {
			$fees = $invoice->order->get_fees();
			if ( $fees ) {
				$incl_tax = 'incl' === $tax_display;
				/**
				 * Fee annotations.
				 *
				 * @var string            $id WooCommerce ID.
				 * @var WC_Order_Item_Fee $fee WooCommerce Fee.
				 */
				foreach ( $fees as $id => $fee ) {
					if ( apply_filters( 'woocommerce_get_order_item_totals_excl_free_fees', empty( $fee['line_total'] ) && empty( $fee['line_tax'] ), $id ) ) {
						continue;
					}

					$total_rows[ 'fee_' . $id ] = array(
						/* translators: Fee name and tax or vat label */
						'label' => sprintf( __( '%1$s %2$s', 'woocommerce-pdf-invoices' ), $fee['name'], WPI()->tax_or_vat_label( $incl_tax ) ),
						'value' => wc_price( ! $incl_tax ? $fee['line_total'] : (double) $fee['line_total'] + (double) $fee['line_tax'], array( 'currency' => WPI()->get_currency( $invoice->order ) ) ),
					);
				}
			}
		}

		/**
		 * Get taxes, merged by code, formatted ready for output.
		 *
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 *
		 * @return array
		 */
		private static function get_tax_totals( $invoice ) {
			$tax_totals = array();

			/**
			 * Tax annotation.
			 *
			 * @var WC_Order_Item_Tax $tax Tax object.
			 */
			foreach ( $invoice->order->get_items( 'tax' ) as $key => $tax ) {
				$code = $tax->get_rate_code();

				if ( ! isset( $tax_totals[ $code ] ) ) {
					$tax_totals[ $code ]         = new stdClass();
					$tax_totals[ $code ]->amount = 0;
				}

				$tax_totals[ $code ]->id          = $key;
				$tax_totals[ $code ]->rate_id     = $tax->get_rate_id();
				$tax_totals[ $code ]->is_compound = $tax->is_compound();
				$tax_totals[ $code ]->label       = $tax->get_label();
				$tax_totals[ $code ]->amount      += (float) $tax->get_tax_total( 'edit' );

				if ( WPI()->templater()->has_advanced_table_content() ) {
					$rate_id = $tax->get_rate_id( 'edit' );

					foreach ( WPI()->get_option( 'template', 'totals' ) as $total ) {
						switch ( $total ) {
							case 'discount_ex_vat':
								if ( $invoice->order->get_discount_tax( 'edit' ) > 0 ) {
									$tax_totals [ $code ]->amount += self::get_discount_tax_by_rate_id( $invoice, $rate_id );
								}
								break;

							case 'shipping_ex_vat':
								// Make sure the total tax per rate includes shipping tax.
								$tax_totals[ $code ]->amount += (float) $tax->get_shipping_tax_total();
								break;

							case 'fee_incl_vat':
								$tax_totals[ $code ]->amount -= self::get_fee_tax_by_rate_id( $invoice, $rate_id );
								break;
						}
					}
				} else {
					$tax_totals[ $code ]->amount += (float) $tax->get_shipping_tax_total( 'edit' );
				}

				$tax_totals[ $code ]->formatted_amount = wc_price( wc_round_tax_total( $tax_totals[ $code ]->amount ), array(
						'currency' => WPI()->get_currency( $invoice->order ),
					)
				);
			} // End foreach().

			return $tax_totals;
		}

		/**
		 * Get discount tax amount per tax class/percentage.
		 *
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 * @param int                    $rate_id Tax rate id.
		 *
		 * @return float
		 */
		private static function get_discount_tax_by_rate_id( $invoice, $rate_id ) {
			$discount_tax = 0;

			foreach ( $invoice->order->get_items( 'line_item' ) as $item_id => $item ) {
				$line_tax_data = isset( $item['line_tax_data'] ) ? $item['line_tax_data'] : '';
				$tax_data      = maybe_unserialize( $line_tax_data );

				$tax_item_id       = $rate_id;
				$tax_item_total    = (float) isset( $tax_data['total'][ $tax_item_id ] ) ? $tax_data['total'][ $tax_item_id ] : 0;
				$tax_item_subtotal = (float) isset( $tax_data['subtotal'][ $tax_item_id ] ) ? $tax_data['subtotal'][ $tax_item_id ] : 0;

				if ( $tax_item_total !== $tax_item_subtotal ) {
					$discount_tax += $tax_item_subtotal - $tax_item_total;
				}
			}

			return (float) $discount_tax;
		}

		/**
		 * Get discount tax amount per tax class/percentage.
		 *
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 * @param int                    $rate_id Tax rate id.
		 *
		 * @return float
		 */
		private static function get_fee_tax_by_rate_id( $invoice, $rate_id ) {
			$tax_item_total = 0;

			foreach ( $invoice->order->get_items( 'fee' ) as $item_id => $item ) {
				$line_tax_data = isset( $item['line_tax_data'] ) ? $item['line_tax_data'] : '';
				$tax_data      = maybe_unserialize( $line_tax_data );

				$tax_item_id    = $rate_id;
				$tax_item_total += (float) isset( $tax_data['total'][ $tax_item_id ] ) ? (float) $tax_data['total'][ $tax_item_id ] : 0;
			}

			return (float) $tax_item_total;
		}

		/**
		 * Add total row for taxes.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_tax_total_row( &$total_rows, $tax_display, $invoice ) {
			// Tax for tax exclusive prices.
			if ( 'excl' === $tax_display ) {
				if ( 'itemized' === WPI()->get_option( 'template', 'tax_total_display' ) ) {
					foreach ( self::get_tax_totals( $invoice ) as $code => $tax ) {
						$total_rows[ sanitize_title( $code ) ] = array(
							'label' => $tax->label,
							'value' => $tax->formatted_amount,
						);
					}
				} else {
					$total_rows['tax'] = array(
						'label' => WC()->countries->tax_or_vat(),
						'value' => wc_price( $invoice->order->get_total_tax(), array(
								'currency' => WPI()->get_currency( $invoice->order ),
							)
						),
					);
				}
			}
		}


		/**
		 * Gets order total - formatted for display.
		 *
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 *
		 * @return string
		 */
		private static function get_formatted_order_total( $invoice ) {
			$total          = $invoice->order->get_total();
			$total_refunded = $invoice->order->get_total_refunded();

			if ( $total_refunded ) {
				$total -= $total_refunded;
			}

			return wc_price( $total, array(
					'currency' => WPI()->get_currency( $invoice->order ),
				)
			);
		}

		/**
		 * Add total row for grand total.
		 *
		 * @param array                  $total_rows totals.
		 * @param string                 $tax_display 'excl' or 'incl'.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 */
		private static function add_total_total_row( &$total_rows, $tax_display, $invoice ) {
			$incl_tax                  = 'incl' === $tax_display;
			$total_rows['order_total'] = array(
				/* translators: tax or vat label */
				'label' => sprintf( __( 'Total %s', 'woocommerce-pdf-invoices' ), WPI()->tax_or_vat_label( $incl_tax ) ),
				'value' => self::get_formatted_order_total( $invoice ),
			);
		}

		/**
		 * Get order item totals.
		 *
		 * @param array                  $total_rows Order item totals.
		 * @param BEWPI_Abstract_Invoice $invoice Invoice object.
		 *
		 * @return array
		 */
		public static function get_total_rows( $total_rows, $invoice ) {
			$total_rows = array();

			foreach ( (array) WPI()->get_option( 'template', 'totals' ) as $total_row ) {
				switch ( $total_row ) {
					case 'discount_ex_vat':
						self::add_discount_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'shipping_ex_vat':
						self::add_shipping_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'fee_ex_vat':
						self::add_fee_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'subtotal_ex_vat':
						self::add_subtotal_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'subtotal_incl_vat':
						self::add_subtotal_total_row( $total_rows, 'incl', $invoice );
						break;
					case 'discount_incl_vat':
						self::add_discount_total_row( $total_rows, 'incl', $invoice );
						break;
					case 'shipping_incl_vat':
						self::add_shipping_total_row( $total_rows, 'incl', $invoice );
						break;
					case 'fee_incl_vat':
						self::add_fee_total_row( $total_rows, 'incl', $invoice );
						break;
					case 'total_ex_vat':
						self::add_total_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'vat':
						self::add_tax_total_row( $total_rows, 'excl', $invoice );
						break;
					case 'total_incl_vat':
						self::add_total_total_row( $total_rows, 'incl', $invoice );
						break;
				}
			} // End foreach().

			return $total_rows;
		}

		/**
		 * Add multiple recipients enabled emails.
		 *
		 * @param string $headers WooCommerce email headers.
		 * @param string $status WooCommerce email type.
		 *
		 * @return string
		 */
		public static function add_recipients( $headers, $status ) {
			// Check if current email type is enabled.
			if ( ! WPI()->is_email_enabled( $status ) ) {
				return $headers;
			}

			// comma separated suppliers email addresses.
			$recipients = WPI()->get_option( 'premium', 'suppliers' );
			if ( ! $recipients ) {
				return $headers;
			}

			$recipients = explode( ',', $recipients );
			foreach ( $recipients as $recipient ) {
				$headers .= 'BCC: <' . $recipient . '>' . "\r\n";
			}

			return $headers;
		}

		/**
		 * Add additional PDF file to invoice.
		 *
		 * @param mPDF                    $mpdf Library object.
		 * @param BEWPI_Abstract_Document $document PDF document class.
		 *
		 * @return mixed
		 */
		public static function add_pdf_to_invoice( $mpdf, $document ) {
			// Only add to invoice.
			if ( 'invoice/simple' !== $document->get_type() ) {
				return $mpdf;
			}

			// PDF attachment added?
			$pdf_attachment = WPI()->get_option( 'premium', 'pdf_attachment' );
			if ( ! $pdf_attachment ) {
				return $mpdf;
			}

			$mpdf->SetImportUse();

			$page_count = $mpdf->SetSourceFile( $pdf_attachment );
			for ( $i = 1; $i <= $page_count; $i ++ ) {
				$mpdf->AddPage( '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', - 1, 0, - 1, 0 );
				$mpdf->showWatermarkText = false;
				$template_id             = $mpdf->ImportPage( $i );
				$mpdf->UseTemplate( $template_id );
			}

			return $mpdf;
		}

		/**
		 * Add Request Invoice checkout field.
		 *
		 * @param WC_Checkout $checkout Checkout object.
		 */
		public static function add_request_invoice_checkout_field( $checkout ) {
			woocommerce_form_field( '_bewpi_request_invoice', array(
				'type'  => 'checkbox',
				'class' => array( 'bewpi_request_invoice form-row-wide' ),
				'label' => __( 'Request invoice', 'woocommerce-pdf-invoices' ),
			), apply_filters( 'wpi_bewpi_request_invoice_default_value', 0 ) );
		}

		/**
		 * Process Request Invoice checkout field.
		 *
		 * @param int $order_id WC Order ID.
		 */
		public static function process_request_invoice_checkout_field( $order_id ) {
			if ( isset( $_POST['_bewpi_request_invoice'] ) ) {
				update_post_meta( $order_id, '_bewpi_request_invoice', sanitize_text_field( $_POST['_bewpi_request_invoice'] ) );
			}
		}

		/**
		 * Skip invoice generation.
		 *
		 * @param bool     $skip To skip.
		 * @param string   $status WC Email status.
		 * @param WC_Order $order Order object.
		 *
		 * @return bool true to skip.
		 */
		public static function skip_invoice_generation( $skip, $status, $order ) {
			if ( ! WPI()->templater()->get_meta( '_bewpi_request_invoice' ) ) {
				return true;
			}

			return $skip;
		}
	}
}
