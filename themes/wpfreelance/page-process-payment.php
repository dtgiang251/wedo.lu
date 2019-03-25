<?php
/**
 *Template Name: Process payment
 */

$type  = isset($_GET['type']) ? $_GET['type'] : '';
$order = array();
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

box_log('page-process-payment.php');
box_log($_POST);

$order = BX_Order::get_instance()->get_order($order_id);
$order_type = $order->order_type; // buy_credit, premium_post,


if( empty($type) )
	$type = $order->payment_type; // paypal, stripe,

if ( ENABLE_LOG ){
	box_log('Order type: '.$type);
}
if( $type == 'cash'){
	global $user_ID;

	$is_access = get_post_meta($order->ID,'is_access', true);

	if( $user_ID == $order->post_author && !$is_access ){
		$credit = BX_Credit::get_instance();
		$credit->increase_credit_pending($order->post_author, $order->amout);
		update_post_meta($order->ID,'is_access', 1);
	}
} else {
	if( $type == 'pp_adaptive' ){
		box_log($_REQUEST);
		$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : 0;
		box_log('$_GET["project_id"] : '.$project_id);
		if( $project_id ){
			PP_Adaptive::get_instance()->award_complete( $project_id );
		}

	} else {
		box_log($_POST);
		$verified = BX_Paypal::get_instance()->verifyIPN();
		if ( $verified ) {
			// all action buy_creddit, prmium_post will access on this.
			box_log('verified');
			// appove order_status and add amout of this order to ballance of payer.
			//box_log('Verified successful');
			bx_process_payment( $order_id , $type);
		    /*
		     * Process IPN
		     * A list of variables is available here:
		     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
		     */
		 } else {
		 	box_log('Verified fail');
		 }
	}

}

?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="site-content" id="content" style="background-color: transparent1 !important;" >
			<div class="col-md-12 detail-project text-justify" style="padding-top: 30px;">
				<div class="" style="width: 450px; min-height: 300px; margin: 0 auto; border:1px solid #ccc; background-color: #fff; border-radius: 5px; padding: 15px 20px;">


					<?php
					// echo '<pre>';
					// var_dump($order);
					// echo '</pre>';
					if( is_user_logged_in() && $order->payer_id == $user_ID ){ ?>
						<h2 class="primary-color" style="padding-bottom: 35px;"> Payment Complete <i class="fa fa-check" aria-hidden="true"></i></h2>
						<p> We've sent you an email with all the details of your order</p>
						<p> Price($): <label><?php echo  $order->amout;?></label></p>
						<p> Order ID:<label> <?php echo $order->ID;?></label></p>

						<?php
						if( $order_type == 'buy_credit' ){
							if( $type == 'cash'){ ?>

								<?php

								if( $order->post_status == 'publish') {
									_e('Your order is approved ','boxtheme');
								} else { ?>

									<?php
										$option = BX_Option::get_instance();
										$payment = $option->get_group_option('payment');
		    							$cash = (object) $payment->cash;
		            					if ( ! empty( $cash->description) ) {
		            						echo $cash->description;
		            					}
					 			}
					 		} else {
				 			_e('Your order is completed. The credit is deposited to your balance and you can use your credit now.','boxtheme');
				 			}
				 		} else if ($order_type == 'premium_post' ){
				 			$project_id =  get_post_meta( $order->ID, 'pay_premium_post', true );
				 			printf( __('Your order is completed. Check detail job <a href="%s">Detail Project</a>','boxtheme'),get_permalink($project_id) );
				 		}
					}
			 		?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php get_footer();?>
