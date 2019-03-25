<?php
/**
 * Premium settings class.
 *
 * @author      Bas Elbers
 * @category    Admin
 * @package     BE_WooCommerce_PDF_Invoices/Admin
 * @version     1.0.0
 */

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'BEWPIP_Premium_Settings' ) ) {

	/**
	 * Class BEWPIP_Premium_Settings.
	 */
	class BEWPIP_Premium_Settings extends BEWPI_Abstract_Settings {

		/**
		 * BEWPIP_Premium_Settings constructor.
		 */
		public function __construct() {
			$this->settings_key = 'bewpipremium_settings';
			$this->settings_tab = __( 'Premium', 'woocommerce-pdf-invoices' );
			$this->fields       = $this->get_fields();
			$this->sections     = $this->get_sections();
			$this->defaults     = $this->get_defaults();

			parent::__construct();
		}

		/**
		 * Initialize hooks.
		 */
		public static function init_hooks() {
			if ( is_admin() ) {
				self::admin_init_hooks();
			}

			add_filter( 'bewpi_option', array( __CLASS__, 'get_option' ), 10, 3 );
		}

		/**
		 * Initialize admin hooks.
		 */
		private static function admin_init_hooks() {
			add_action( 'wpi_email_types', array( __CLASS__, 'add_email_types' ) );
			add_filter( 'bewpi_settings', array( __CLASS__, 'add_setting' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_admin_scripts' ) );
			add_filter( 'bewpi_sidebar_path', array( __CLASS__, 'remove_sidebar' ) );
			add_action( 'admin_notices', array( __CLASS__, 'admin_expire_notice' ) );
		}

		/**
		 * Display license expiration/renew message.
		 */
		public static function admin_expire_notice() {
			// notice needs to be inactive.
			if ( ! BEWPI_Admin_Notices::is_admin_notice_active( 'expire-forever' ) ) {
				return;
			}

			$premium_options = get_option( 'bewpipremium_settings' );
			if ( empty( $premium_options['bewpi_license_key'] ) || empty( $premium_options['bewpi_license_email'] ) ) {
				return;
			}

			$url = add_query_arg( array(
				'request'        => 'activate',
				'license_key'    => sanitize_key( $premium_options['bewpi_license_key'] ),
				'api_product_id' => 'woocommerce-pdf-invoices-premium',
				'email'          => sanitize_email( $premium_options['bewpi_license_email'] ),
				'instance'       => get_site_url(),
			), 'https://wcpdfinvoices.com/wc-api/wp_plugin_licencing_activation_api'
			);

			$response = wp_safe_remote_get( $url );

			if ( is_array( $response ) ) {

				$body = json_decode( $response['body'] );

				if ( property_exists( $body, 'error' ) ) {

					set_transient( 'wpi_license_error', $body->error_code );

					if ( 110 !== absint( $body->error_code ) ) {
						return;
					}

					$renew_url = add_query_arg( array(
						'renew_license'    => $premium_options['bewpi_license_key'],
						'activation_email' => sanitize_email( $premium_options['bewpi_license_email'] ),
					), 'https://wcpdfinvoices.com'
					);

					printf( '<div class="error notice notice-error is-dismissible" data-dismissible="expire-forever"><p>' );
					printf( __( 'Whoops, your license for %1$s has expired. To keep receiving updates and premium support, we offer you a 30%% discount when you <a href="%2$s" target="_blank">renew your license</a>.', 'woocommerce-pdf-invoices' ), '<strong>WooCommerce PDF Invoices Premium</strong>', esc_url( $renew_url ) );
					printf( '</p></div>' );
				}
			}
		}

		/**
		 * Show all email types from WC to attach invoice to.
		 *
		 * @param array $email_types Email types from settings.
		 *
		 * @return array
		 */
		public static function add_email_types( $email_types ) {
			$new_email_types = array();

			/** @var WC_Email $email */
			foreach ( WC()->mailer()->get_emails() as $email ) {
				$default = 0;

				// Search default for current email.
				if ( isset( $email_types[ $email->id ] ) ) {
					$default = $email_types[ $email->id ]['default'];
				}

				$new_email_types[ $email->id ] = array(
					'name'    => $email->get_title(),
					'value'   => $email->id,
					'default' => $default,
				);
			}

			return $new_email_types;
		}

		/**
		 * Get premium option.
		 *
		 * @param string $value Option value.
		 * @param string $group Option group name.
		 * @param string $name Option name.
		 *
		 * @return bool/mixed false or option value.
		 */
		public static function get_option( $value, $group, $name ) {
			if ( ! in_array( $group, array( 'bewpipremium_settings', 'premium' ), true ) ) {
				return $value;
			}

			$options = get_option( 'bewpipremium_settings' );
			if ( ! $options ) {
				return $value;
			}

			$name = 'bewpi_' . $name;
			if ( ! isset( $options[ $name ] ) ) {
				return $value;
			}

			return $options[ $name ];
		}

		/**
		 * Add setting to WooCommerce PDF Invoices' settings.
		 *
		 * @param array $settings This class.
		 *
		 * @return array $settings.
		 */
		public static function add_setting( $settings ) {
			$settings[] = new self();

			return $settings;
		}

		/**
		 * Load admin scripts.
		 *
		 * @param string $hook To check current page.
		 */
		public static function load_admin_scripts( $hook ) {
			if ( 'woocommerce_page_bewpi-invoices' !== $hook ) {
				return;
			}

			wp_enqueue_script( 'bewpip_settings_js', BEWPIP_URL . '/assets/js/admin.js', array(), BEWPIP_VERSION, true );
			wp_register_style( 'bewpip_settings_css', BEWPIP_URL . '/assets/css/admin.css', false, BEWPIP_VERSION );
			wp_enqueue_style( 'bewpip_settings_css' );
		}

		/**
		 * Remove sidebar from settings page.
		 *
		 * @return string
		 */
		public static function remove_sidebar() {
			return '';
		}

		/**
		 * Get all default values from the settings array.
		 *
		 * @return array
		 */
		public function get_defaults() {
			$defaults = parent::get_defaults();

			// Add license option.
			$defaults['bewpi_license'] = false;

			return $defaults;
		}

		/**
		 * Adds all the different settings sections.
		 */
		private function get_sections() {
			$reminder_email_page_url = add_query_arg( array(
				'page'    => 'wc-settings',
				'tab'     => 'email',
				'section' => 'bewpi_wc_email_customer_invoice_reminder',
			), admin_url( 'admin.php' )
			);

			$sections = array(
				'premium'            => array(
					'title' => __( 'Premium Options', 'woocommerce-pdf-invoices' ),
				),
				'template'           => array(
					'title' => __( 'Template Options', 'woocommerce-pdf-invoices' ),
				),
				'suppliers'          => array(
					'title'       => __( 'Supplier Options', 'woocommerce-pdf-invoices' ),
					'description' => __( 'Send customer invoice automatically to your supplier(s).', 'woocommerce-pdf-invoices' ),
				),
				'credit_note'        => array(
					'title' => __( 'Credit Note Options', 'woocommerce-pdf-invoices' ),
				),
				'credit_note_number' => array(
					'title' => __( 'Credit Note Number Options', 'woocommerce-pdf-invoices' ),
				),
				'global'             => array(
					'title'       => __( 'Global Invoice Options', 'woocommerce-pdf-invoices' ),
					'description' => __( 'Generate global invoices on Orders page by selecting multiple orders and applying action or let customers generate periodically from My Account page. <strong>Global invoices are only supported when using the micro template!</strong>', 'woocommerce-pdf-invoices' ),
				),
				'reminder'           => array(
					'title'       => __( 'Reminder Options', 'woocommerce-pdf-invoices' ),
					'description' => sprintf( __( 'Automatically send PDF invoice after a specific period of time. When enabled, a new <a href="%s">Customer invoice reminder</a> email will be used to send the PDF invoice.', 'woocommerce-pdf-invoices' ), $reminder_email_page_url ),
				),
				'request_invoice'    => array(
					'title'       => __( 'Request Invoice Options', 'woocommerce-pdf-invoices' ),
					'description' => __( 'Let a customer decide to generate a PDF invoice. When enabled, a checkbox field will be added on the checkout page so customers can request a PDF invoice.', 'woocommerce-pdf-invoices' ),
				)
			);

			return $sections;
		}

		/**
		 * The settings array.
		 *
		 * @return array
		 */
		private function get_fields() {
			$settings = array(
				array(
					'id'       => 'bewpi-license-email',
					'name'     => 'bewpi_license_email',
					'title'    => __( 'Activation email', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'premium',
					'type'     => 'text',
					'desc'     => sprintf( __( 'Enter your activation email from %s.', 'woocommerce-pdf-invoices' ), '<a href="https://wcpdfinvoices.com/my-account/" target="_blank">wcpdfinvoices.com</a>' ),
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-license-key',
					'name'     => 'bewpi_license_key',
					'title'    => __( 'License', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'license_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'premium',
					'type'     => 'text',
					'desc'     => sprintf( __( 'Enter your license key from %s to receive updates.', 'woocommerce-pdf-invoices' ), '<a href="https://wcpdfinvoices.com/my-account/" target="_blank">wcpdfinvoices.com</a>' ),
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-pdf-attachment',
					'name'     => 'bewpi_pdf_attachment',
					'title'    => __( 'PDF attachment', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'pdf_attachment_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'template',
					'type'     => 'file',
					'desc'     => __( 'Add for example a PDF with your terms & conditions.', 'woocommerce-pdf-invoices' ),
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-suppliers',
					'name'     => 'bewpi_suppliers',
					'title'    => __( 'Suppliers', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'textarea_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'suppliers',
					'type'     => 'text',
					'desc'     => __( '<b>Hint</b>: Send customer invoices to suppliers\' Cloud Storages by simply adding their Email It In email addresses. Email addresses need to be seperated by comma\'s.', 'woocommerce-pdf-invoices' ),
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-credit-note-email-types',
					'name'     => 'bewpi_credit_note_email_types',
					'title'    => __( 'Attach to Emails', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'multi_select_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'credit_note',
					'type'     => 'multiple_select',
					'desc'     => '',
					'options'  => BEWPIP_Credit_Note::get_email_types(),
				),
				array(
					'id'       => 'bewpi-credit-note-number-prefix',
					'name'     => 'bewpi_credit_note_number_prefix',
					'title'    => __( 'Prefix', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'credit_note_number',
					'type'     => 'text',
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-credit-note-number-suffix',
					'name'     => 'bewpi_credit_note_suffix',
					'title'    => __( 'Suffix', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'credit_note_number',
					'type'     => 'text',
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'bewpi-credit-note-number-format',
					'name'     => 'bewpi_credit_note_number_format',
					'title'    => __( 'Format', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'credit_note_number',
					'type'     => 'text',
					'desc'     => sprintf( __( 'Available placeholders: %s.', 'woocommerce-pdf-invoices' ), self::formatted_number_placeholders() )
					              . '<br>'
					              . sprintf( __( '<b>Note:</b> %s is required and slashes aren\'t supported.', 'woocommerce-pdf-invoices' ), '<code>[number]</code>' ),
					'default'  => '[number]-[Y]',
					'attrs'    => array( 'required' ),
				),
				array(
					'id'       => 'bewpi-customer-generation',
					'name'     => 'bewpi_customer_generation',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'checkbox',
					'desc'     => __( 'Enable customer generation', 'woocommerce-pdf-invoices' )
					              . '<br/><div class="bewpi-notes">'
					              . __( 'Let customers generate a global invoice from their account', 'woocommerce-pdf-invoices' )
					              . '</div>',
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-customer-generation-period',
					'name'     => 'bewpi_customer_generation_period',
					'title'    => __( 'Customer generation period', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'select_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'text',
					'desc'     => __( 'Should your customers have the ability to generate a global invoice by month or by year?<br/><strong>Note:</strong> Customer generation should be enabled.', 'woocommerce-pdf-invoices' ),
					'options'  => array(
						'month' => __( 'Month', 'woocommerce-pdf-invoices' ),
						'year'  => __( 'Year', 'woocommerce-pdf-invoices' ),
					),
					'default'  => 'month',
				),
				array(
					'id'       => 'bewpi-global-invoice-to-email-it-in',
					'name'     => 'bewpi_global_invoice_to_email_it_in',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'checkbox',
					'desc'     => __( 'Send to your Cloud Storage', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-global-invoice-to-customer',
					'name'     => 'bewpi_global_invoice_to_customer',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'checkbox',
					'desc'     => __( 'Email to customer', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-global-invoice-to-suppliers',
					'name'     => 'bewpi_global_invoice_to_suppliers',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'checkbox',
					'desc'     => __( 'Email to supplier(s)', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-email-subject',
					'name'     => 'bewpi_global_invoice_email_subject',
					'title'    => __( 'Email subject', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'text',
					'desc'     => __( 'Subject for the global invoice email.', 'woocommerce-pdf-invoices' ),
					'default'  => 'Global invoice',
					'required' => true,
				),
				array(
					'id'       => 'bewpi-email-message',
					'name'     => 'bewpi_global_invoice_email_message',
					'title'    => __( 'Email message', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'textarea_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'global',
					'type'     => 'text',
					'desc'     => __( 'Message for the global invoice email.', 'woocommerce-pdf-invoices' ),
					'default'  => 'Attached the global invoice.',
					'required' => true,
				),
				array(
					'id'       => 'bewpi-enable-reminder',
					'name'     => 'bewpi_enable_reminder',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'reminder',
					'type'     => 'checkbox',
					'desc'     => __( 'Enable reminder', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
				array(
					'id'       => 'bewpi-days-until-due',
					'name'     => 'bewpi_days_until_due',
					'title'    => __( 'Days until due date', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'reminder',
					'type'     => 'number',
					'desc'     => __( 'Number of days from order or invoice date until due date.', 'woocommerce-pdf-invoices' ),
					'default'  => 14,
					'attrs'    => array(
						'min="0"'
					),
				),
				array(
					'id'       => 'bewpi-days-until-reminder',
					'name'     => 'bewpi_days_until_reminder',
					'title'    => __( 'Days until reminder', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'reminder',
					'type'     => 'number',
					'desc'     => __( 'Number of days from order or invoice date until reminder date.', 'woocommerce-pdf-invoices' ),
					'default'  => 7,
					'attrs'    => array(
						'min="0"'
					),
				),
				array(
					'id'       => 'bewpi-reminder-date-type',
					'name'     => 'bewpi_reminder_date_type',
					'title'    => __( 'Date type', 'woocommerce-pdf-invoices' ),
					'callback' => array( $this, 'select_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'reminder',
					'type'     => 'text',
					'desc'     => __( 'Choose the type of date to count from.', 'woocommerce-pdf-invoices' ),
					'options'  => array(
						'order_date'   => __( 'Order date', 'woocommerce-pdf-invoices' ),
						'invoice_date' => __( 'Invoice date', 'woocommerce-pdf-invoices' ),
					),
					'default'  => 'order_date',
				),
				array(
					'id'       => 'bewpi-request-invoice',
					'name'     => 'bewpi_request_invoice',
					'title'    => '',
					'callback' => array( $this, 'input_callback' ),
					'page'     => $this->settings_key,
					'section'  => 'request_invoice',
					'type'     => 'checkbox',
					'desc'     => __( 'Enable Request Invoice.', 'woocommerce-pdf-invoices' ),
					'class'    => 'bewpi-customer-notes-option-title',
					'default'  => 0,
				),
			);

			return $settings;
		}

		/**
		 * Sanitize settings.
		 *
		 * @param array $input settings.
		 *
		 * @return mixed
		 */
		public function sanitize( $input ) {
			$output = get_option( $this->settings_key );

			// set pdf attachment.
			$input['bewpi_pdf_attachment'] = $output['bewpi_pdf_attachment'];

			foreach ( $output as $key => $value ) {
				if ( ! isset( $input[ $key ] ) ) {
					$output[ $key ] = is_array( $output[ $key ] ) ? array() : '';
					continue;
				}

				if ( is_array( $output[ $key ] ) ) {
					$output[ $key ] = $input[ $key ];
					continue;
				}

				// Strip all html and properly handle quoted strings.
				$output[ $key ] = stripslashes( $input[ $key ] );
			}

			$output['bewpi_license'] = $this->activate_license( $output );

			// @todo Refactor PDF attachments.
			if ( isset( $_FILES['bewpi_pdf_attachment'] ) && 0 === $_FILES['bewpi_pdf_attachment']['error'] ) {
				$pdf_path = $this->upload_pdf_attachment( wp_unslash( $_FILES['bewpi_pdf_attachment'] ) );

				if ( $pdf_path ) {
					$output['bewpi_pdf_attachment'] = $pdf_path;
				}
			} elseif ( ! isset( $_POST['bewpi_pdf_filename'] ) ) {
				$output['bewpi_pdf_attachment'] = '';
			}

			if ( isset( $output['bewpi_enable_reminder'] ) ) {

				// Add schedule when enabled.
				if ( $output['bewpi_enable_reminder'] && ! wp_get_schedule( 'wpi_scheduled_reminder' ) ) {
					wp_schedule_event( time(), 'daily', 'wpi_scheduled_reminder' );
				}

				// Clear schedule when disabled.
				if ( ! $output['bewpi_enable_reminder'] && wp_get_schedule( 'wpi_scheduled_reminder' ) ) {
					wp_clear_scheduled_hook( 'wpi_scheduled_reminder' );
				}
			}

			return apply_filters( 'bewpi_sanitized_' . $this->settings_key, $output, $input );
		}

		/**
		 * Activate license.
		 *
		 * @param array $output Settings post values.
		 *
		 * @return bool.
		 */
		private function activate_license( $output ) {
			$activated = false;

			if ( isset( $output['bewpi_license_key'] ) && ! empty( $output['bewpi_license_key'] ) ) {

				if ( ! isset( $output['bewpi_license_email'] ) || empty( $output['bewpi_license_email'] ) ) {
					add_settings_error(
						$this->settings_key,
						'license_error',
						__( 'Activation email cannot be empty.', 'woocommerce-pdf-invoices' ),
						'error'
					);

					return $activated;
				}

				$url = add_query_arg( array(
					'request'        => 'activate',
					'license_key'    => sanitize_key( $output['bewpi_license_key'] ),
					'api_product_id' => 'woocommerce-pdf-invoices-premium',
					'email'          => sanitize_email( $output['bewpi_license_email'] ),
					'instance'       => get_site_url(),
				), 'https://wcpdfinvoices.com/wc-api/wp_plugin_licencing_activation_api'
				);

				$response = wp_safe_remote_get( $url );

				if ( is_array( $response ) ) {
					$body = json_decode( $response['body'] );
					if ( property_exists( $body, 'success' ) && property_exists( $body, 'activated' ) ) {
						delete_transient( 'wpi_license_error' );

						return $body->success && $body->activated;
					} elseif ( property_exists( $body, 'error' ) ) {
						set_transient( 'wpi_license_error', $body->error_code );
						add_settings_error(
							$this->settings_key,
							'license_error',
							$body->error,
							'error'
						);

						return false;
					}
				}

				add_settings_error(
					$this->settings_key,
					'license_error',
					__( 'Something went wrong with the activation of your license. Contact the author for support.', 'woocommerce-pdf-invoices' ),
					'error'
				);

			}

			return $activated;
		}

		/**
		 * Upload PDF attachment.
		 *
		 * @param array $file PDF file.
		 *
		 * @return string
		 */
		private function upload_pdf_attachment( $file ) {
			$size       = 10000000; // 10MB.
			$file_types = array( 'pdf' );

			if ( $file['size'] > $size ) {
				add_settings_error( $this->settings_key, 'file-to-large', __( 'File to large.', 'woocommerce-pdf-invoices' ) );

				return false;
			}

			if ( ! in_array( pathinfo( $file['name'], PATHINFO_EXTENSION ), $file_types, true ) ) {
				add_settings_error( $this->settings_key, 'file-only-pdf', __( 'Only PDF files are allowed.', 'woocommerce-pdf-invoices' ) );

				return false;
			}

			$pdf_file = wp_handle_upload( $file, array( 'test_form' => false ) );

			if ( ! $pdf_file || isset( $pdf_file['error'] ) ) {
				return false;
			}

			return $pdf_file['file'];
		}

		/**
		 * Add additional PDF file option callback.
		 *
		 * @param array $args Field arguments.
		 */
		public function pdf_attachment_callback( $args ) {
			$options      = get_option( $args['page'] );
			$pdf_filename = isset( $options['bewpi_pdf_attachment'] ) ? basename( $options['bewpi_pdf_attachment'] ) : '';
			?>
			<div class="custom-file-upload">
				<input id="pdf-filename-input" type="text" value="<?php echo esc_attr( $pdf_filename ); ?>" name="bewpi_pdf_filename" readonly/>
				<input id="remove-input" type="button" value="<?php _e( 'Remove', 'woocommerce-pdf-invoices' ); ?>" onclick="PremiumSettings.removeFilename( 'pdf-filename-input' );"/>
				<input id="file-input" type="file" name="bewpi_pdf_attachment" accept="application/pdf" onchange="PremiumSettings.changeFilename( this, 'pdf-filename-input' );"/>
				<input id="choose-input" type="button" value="<?php _e( 'Choose', 'woocommerce-pdf-invoices' ); ?>"/>
				<div class="bewpi-notes">
					<?php echo $args['desc']; ?>
				</div>
			</div>
			<?php
		}

		/**
		 * License option callback.
		 *
		 * @param array $args Field arguments.
		 */
		public function license_callback( $args ) {
			$options     = get_option( $args['page'] );
			$license_key = isset( $options['bewpi_license_key'] ) ? $options['bewpi_license_key'] : '';

			printf( '<input id="%1$s" title="%2$s" name="%3$s" type="text" value="%4$s" />',
				esc_attr( $args['id'] ),
				esc_attr__( 'License', 'woocommerce-pdf-invoices' ),
				esc_attr( $args['page'] . '[' . $args['name'] . ']' ),
				esc_attr( $license_key )
			);

			$email = WPI()->get_option( 'premium', 'license_email' );
			$key   = WPI()->get_option( 'premium', 'license_key' );

			if ( get_transient( 'wpi_license_error' ) || empty( $email ) || empty( $key ) ) {
				printf( '<div class="license-btn inactive">%1$s</div>', esc_attr__( 'Inactive', 'woocommerce-pdf-invoices' ) );
			} else {
				printf( '<div class="license-btn active">%1$s</div>', esc_attr__( 'Active', 'woocommerce-pdf-invoices' ) );
			}

			echo '<div class="bewpi-notes">' . $args['desc'] . '</div>';
		}
	}
}
