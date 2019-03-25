<div class="col-md-12 custom-res">

  	<h5> <?php _e('History of credit','boxtheme');?> </h5>
  	<div class="none-style row history-order">
  		<div class="full line-heading">
  			<div class="col-md-4 col-xs-5">Date </div>
  			<div class="col-md-2 col-xs-3 ">Type </div>
  			<div class="col-md-2 hidden-xs">Payment </div>
  			<div class="col-md-2 hidden-xs">Status </div>
  			<div class="col-md-2 align-center col-xs-4 ">Balance </div>
  			<!-- <div class="col-md-2"> </div> -->
  		</div>
  		<?php
  		// query order of this user.
  		$args = array(
  			'post_type' =>'_order',
  			'post_status' => array('pending','publish'),
  			'author' => $user_ID,
  			'posts_per_page' => -1,
  		);
  		$status = array('pending' => __('Pending','boxtheme'),'publish' => __('Approved','boxtheme'),'draft' => __('Draft','boxtheme') );
		  $types = array(
        'buy_credit' => __('Buy credit','boxtheme'),
        'withdraw' => __('Withdraw','boxtheme') ,
        'none' =>'None',
        'deposit' => __('Deposit','boxtheme'),
        'undeposit' => __('Refund','boxtheme'),
        'receive' => __('Receive','boxtheme'),
      );

  		$query = new WP_Query($args);
  		if( $query->have_posts() ){
  			while ( $query->have_posts() ) {
  				$check = '(+)';

  				global $post;
  				$query->the_post();
  				$order = BX_Order::get_instance()->get_order($post);
  				if( in_array($order->order_type, array('withdraw','pay_service','deposit') ) )
  					$check = '(-)';
  				?>
  				<div class="line full row-order-item">
	  				<div class="col-md-4 col-xs-5"><?php echo get_the_date();?> </div>
	  				<div class="col-md-2 col-xs-3 hidden-xs"><?php echo isset($types[$order->order_type]) ? $types[$order->order_type] : 'Unknow';?> </div>
	      			<div class="col-md-2 col-xs-3"><?php echo $order->payment_type;?> </div>
	      			<div class="col-md-2 hidden-xs"><?php echo $status[$order->post_status];?> </div>
	      			<div class="col-md-2 align-center col-xs-4"><?php echo $order->amout . $check;?>  </div>
      			</div>
      			<!-- <div class="col-md-2"><button>Arhive</button> </div> -->
  				<?php
  			}
  		}
  		?>
  	</div>
</div>
<style type="text/css">
	.history-order{
		border:1px solid #e6e6e6;
	}
	.history-order .line.full{
		padding: 8px 0;
		border-bottom: 1px solid #e6e6e6;
		overflow: hidden;
	}
	div.full.line-heading{
		border-bottom: 1px solid #e6e6e6;
		overflow: hidden;
		padding: 10px 0;
		font-weight: bold;
	}
</style>