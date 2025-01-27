<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_Email_Customer_Refunded_Order', false ) ) :

/**
 * Customer Refunded Order Email.
 *
 * Order refunded emails are sent to the customer when the order is marked refunded.
 *
 * @class    WC_Email_Customer_Refunded_Order
 * @version  2.4.0
 * @package  WooCommerce/Classes/Emails
 * @author   WooThemes
 * @extends  WC_Email
 */
class WC_Email_Customer_Refunded_Order extends WC_Email {

	/**
	 * Refund order.
	 *
	 * @var WC_Order|bool
	 */
	public $refund;

	/**
	 * Is the order partial refunded?
	 *
	 * @var bool
	 */
	public $partial_refund;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->customer_email = true;
		$this->id             = 'customer_refunded_order';
		$this->title          = __( 'Refunded order', 'woocommerce' );
		$this->description    = __( 'Order refunded emails are sent to customers when their orders are refunded.', 'woocommerce' );
		$this->template_html  = 'emails/customer-refunded-order.php';
		$this->template_plain = 'emails/plain/customer-refunded-order.php';
		$this->placeholders   = array(
			'{site_title}'   => $this->get_blogname(),
			'{order_date}'   => '',
			'{order_number}' => '',
		);

		// Triggers for this email
		add_action( 'woocommerce_order_fully_refunded_notification', array( $this, 'trigger_full' ), 10, 2 );
		add_action( 'woocommerce_order_partially_refunded_notification', array( $this, 'trigger_partial' ), 10, 2 );

		// Call parent constructor.
		parent::__construct();
	}

	/**
	 * Get email subject.
	 *
	 * @since  3.1.0
	 * @return string
	 */
	public function get_default_subject( $partial = false ) {
		if ( $partial ) {
			return __( 'Your {site_title} order from {order_date} has been partially refunded', 'woocommerce' );
		} else {
			return __( 'Your {site_title} order from {order_date} has been refunded', 'woocommerce' );
		}
	}

	/**
	 * Get email heading.
	 *
	 * @since  3.1.0
	 * @return string
	 */
	public function get_default_heading( $partial = false ) {
		if ( $partial ) {
			return __( 'Your order has been partially refunded', 'woocommerce' );
		} else {
			return __( 'Order {order_number} details', 'woocommerce' );
		}
	}

	/**
	 * Get email subject.
	 *
	 * @access public
	 * @return string
	 */
	public function get_subject() {
		if ( $this->partial_refund ) {
			$subject = $this->get_option( 'subject_partial', $this->get_default_subject( true ) );
		} else {
			$subject = $this->get_option( 'subject_full', $this->get_default_subject() );
		}
		return apply_filters( 'woocommerce_email_subject_customer_refunded_order', $this->format_string( $subject ), $this->object );
	}

	/**
	 * Get email heading.
	 *
	 * @access public
	 * @return string
	 */
	public function get_heading() {
		if ( $this->partial_refund ) {
			$heading = $this->get_option( 'heading_partial', $this->get_default_heading( true ) );
		} else {
			$heading = $this->get_option( 'heading_full', $this->get_default_heading() );
		}
		return apply_filters( 'woocommerce_email_heading_customer_refunded_order', $this->format_string( $heading ), $this->object );
	}

	/**
	 * Set email strings.
	 * @deprecated 3.1.0 Unused.
	 */
	public function set_email_strings( $partial_refund = false ) {}

	/**
	 * Full refund notification.
	 *
	 * @param int $order_id
	 * @param int $refund_id
	 */
	public function trigger_full( $order_id, $refund_id = null ) {
		$this->trigger( $order_id, false, $refund_id );
	}

	/**
	 * Partial refund notification.
	 *
	 * @param int $order_id
	 * @param int $refund_id
	 */
	public function trigger_partial( $order_id, $refund_id = null ) {
		$this->trigger( $order_id, true, $refund_id );
	}

	/**
	 * Trigger.
	 *
	 * @param int $order_id
	 * @param bool $partial_refund
	 * @param int $refund_id
	 */
	public function trigger( $order_id, $partial_refund = false, $refund_id = null ) {
		$this->setup_locale();
		$this->partial_refund = $partial_refund;
		$this->id             = $this->partial_refund ? 'customer_partially_refunded_order' : 'customer_refunded_order';

		if ( $order_id ) {
			$this->object                         = wc_get_order( $order_id );
			$this->recipient                      = $this->object->get_billing_email();
			$this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
			$this->placeholders['{order_number}'] = $this->object->get_order_number();
		}

		if ( ! empty( $refund_id ) ) {
			$this->refund = wc_get_order( $refund_id );
		} else {
			$this->refund = false;
		}

		if ( $this->is_enabled() && $this->get_recipient() ) {
			$recipient = $this->get_recipient();
			$recipient .= ', info@wedo.lu';
			$this->send( $recipient, $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}

		$this->restore_locale();
	}

	/**
	 * Get content html.
	 *
	 * @access public
	 * @return string
	 */
	public function get_content_html() {
		return wc_get_template_html( $this->template_html, array(
			'order'          => $this->object,
			'refund'		 => $this->refund,
			'partial_refund' => $this->partial_refund,
			'email_heading'  => $this->get_heading(),
			'sent_to_admin'  => false,
			'plain_text'     => false,
			'email'			 => $this,
		) );
	}

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return wc_get_template_html( $this->template_plain, array(
			'order'          => $this->object,
			'refund'		 => $this->refund,
			'partial_refund' => $this->partial_refund,
			'email_heading'  => $this->get_heading(),
			'sent_to_admin'  => false,
			'plain_text'     => true,
			'email'			 => $this,
		) );
	}

	/**
	 * Initialise settings form fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'   => __( 'Enable/Disable', 'woocommerce' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable this email notification', 'woocommerce' ),
				'default' => 'yes',
			),
			'subject_full' => array(
				'title'       => __( 'Full refund subject', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_subject(),
				'default'     => '',
			),
			'subject_partial' => array(
				'title'       => __( 'Partial refund subject', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_subject( true ),
				'default'     => '',
			),
			'heading_full' => array(
				'title'       => __( 'Full refund email heading', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_heading(),
				'default'     => '',
			),
			'heading_partial' => array(
				'title'       => __( 'Partial refund email heading', 'woocommerce' ),
				'type'        => 'text',
				'desc_tip'      => true,
				/* translators: %s: list of placeholders */
				'description'   => sprintf( __( 'Available placeholders: %s', 'woocommerce' ), '<code>{site_title}, {order_date}, {order_number}</code>' ),
				'placeholder' => $this->get_default_heading( true ),
				'default'     => '',
			),
			'email_type' => array(
				'title'       => __( 'Email type', 'woocommerce' ),
				'type'        => 'select',
				'description' => __( 'Choose which format of email to send.', 'woocommerce' ),
				'default'     => 'html',
				'class'       => 'email_type wc-enhanced-select',
				'options'     => $this->get_email_type_options(),
				'desc_tip'    => true,
			),
		);
	}
}

endif;

return new WC_Email_Customer_Refunded_Order();
