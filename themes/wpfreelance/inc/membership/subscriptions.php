<?php
function box_update_subscription_profile($order){
	global $user_ID;
	
	$pack_id = $order->pack_id;
	$order_id = $order->ID;
	$value = $order_id.','.$pack_id;

	$user_id = $order->post_author;
	box_log('user_ID:'.$user_id);
	update_user_meta( $user_id, 'current_order_plan', $value );
	
}

function is_box_check_plan_available($user_id = 0){

	if( ! $user_id ){
		global $user_ID;
		$user_id = $user_ID;
	}
	$current_order_plan = get_user_meta( $user_id,'current_order_plan', true );
	if( ! empty( $current_order_plan ) ){
		$detail = explode(",", $current_order_plan);
		
		if( count($detail) == 2 ) {
			$order_id = $detail[0];
			$pack_id = $detail[1];

			$order = $order = BX_Order::get_instance()->get_order($order_id);
			$order_gmt_date = $order->post_date_gmt; //2018-05-10 06:21:23
			$day_purchase = date("Y-m-d",strtotime($order_gmt_date)); // 2012-01-30	
			$next_month = date( "Y-m-d", strtotime("$day_purchase +1 month") );
			$expired_time = strtotime($next_month);
			if( time() < $expired_time ){
				return $pack_id;
			}
		}

	}
	return 0;
}
function box_get_number_bid_of_plan($pack_id){
	$number_bids = get_post_meta($pack_id, 'number_bids', true);
	return $number_bids;
}


function box_get_number_free_bid_in_a_month(){
	return 15;
}
function box_get_number_bid_of_subscription(){
	$pack_value_id = is_box_check_plan_available();
	if( $pack_value_id ){
		return (int) get_post_meta($pack_value_id,'number_bids', true);
	}
	return 0;
}
function get_number_bid_remain(){
	
	global $user_ID;
	
	$bids_free = box_get_number_free_bid_in_a_month();	
	$subscription_bids = box_get_number_bid_of_subscription($user_ID);

	$total_bid_allow = $bids_free + $subscription_bids;
	$bidded_in_month = box_get_number_bidded_this_moth();
	$bids_remain = $total_bid_allow - $bidded_in_month;
	if( $bids_remain > 0)
		return $bids_remain;
	return 0;
}
function box_get_number_bidded_this_moth($user_id = 0){
	if($user_id == 0){
		global $user_ID;
		$user_id = $user_ID;
	}
	$month = box_get_current_month();
	$option_name = "number_bidded_of_".$month;
	$number_bidded =  (int)get_user_meta($user_id, $option_name, true);
	return $number_bidded;
}

function box_get_current_month(){
	return date('M');// jan,feb,may,april,june.
}