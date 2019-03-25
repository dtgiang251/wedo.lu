<?php
/**
 *	Template Name: Credit system
 */
?>
<?php get_header(); ?>

<div class="full-width">

	<div class="container site-container">
<?php

global $user_ID;
$bank_account = (OBJECT) array('account_name' => '', 'account_number' => '', 'bank_name'=>'' );
$ins_credit = BX_Credit::get_instance();
// $t1 = get_user_meta($user_ID,'_credit_total', 'true' );
// $t2 = get_user_meta($user_ID,'_sandbox_credit_available', 'true' );
// echo '<pre>';
// var_dump($t1);
// var_dump($t2);
// var_dump($ins_credit);
// echo '</pre>';

$credit = $ins_credit->get_ballance($user_ID);
$withdraw_info = $ins_credit->get_withdraw_info($user_ID);

$paypal_email= $account_number = '';

if( ! empty ($withdraw_info->paypal_email) )
	$paypal_email = $withdraw_info->paypal_email;
if( ! empty ($withdraw_info->bank_account) ){
	$bank_account = (object) $withdraw_info->bank_account;
	if( ! empty( $bank_account->account_number ) )
		$account_number = $bank_account->account_number;
}
// echo '<pre>';
// var_dump($withdraw_info);
// echo phpversion();
// echo '</pre>';
//

?>

		<div  id="content" class="site-content page-credit">

			<div class="col-md-12 line-item">
				<div class="form-group"><h3><?php _e('Your credit info','boxtheme');?></h3></div>
			  		<div class="col-md-6 col-xs-6"><?php printf(__('Avaibale: %s','boxtheme'), box_get_price($credit->available) );?></div>
			  		<div class="col-md-6 col-xs-6">	<a class="btn btn-radius btn-buy-credit" href="<?php echo home_url('buy-credit');?>"><?php _e('Buy Credit','boxtheme');?> </a>		</div>
			</div>

			<div class="col-md-12 line-item">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#withdraw"><?php _e('Widthdraw','boxtheme');?></a></li>
				  <li><a href="#paypal" href="#"><?php _e('PayPal','boxtheme');?></a></li>
				  <li><a href="#bank_info"><?php _e('Bank account','boxtheme');?></a></li>
				</ul>
				<div class="tab-content">
					<div id="withdraw" class="tab-content-item">
						<?php

						if( $credit->available > 30  ){
							if(  empty( $paypal_email ) && empty($account_number)  ){
								echo '<p>&nbsp;</p>';
								_e(' Please setup paypal email or bank account to widthdraw','boxtheme');
							} else {?>
								<form id="frm_withdraw" class="">
									<div class="form-group">
										<label for="withdraw_amout"><?php _e('Amout','boxtheme');?></label>
										<input type="number" class="form-control required" required id="withdraw_amout" name="withdraw_amout" aria-describedby="withdraw_amout" placeholder="<?php _e('How much you want to withdraw?','boxtheme');?>">
									</div>
									<div class="form-group">
										<label for="withdraw_type"><?php _e('Select Method','boxtheme');?></label>
										<select class="form-control required" required name="withdraw_method">
											<?php if( !empty( $paypal_email ) ) { ?>
												<option value="paypal_email"><?php _e('PayPal','boxtheme');?></option>
											<?php } ?>
											<?php if( !empty( $account_number ) ) { ?>
												<option value="bank_account"><?php _e('Bank Account','boxtheme');?></option>
											<?php } ?>

										</select>
									</div>
									<div class="form-group">
										<label for="withdraw_type"><?php _e('Note','boxtheme');?></label>
										<textarea class="form-control" name="withdraw_note" required></textarea>
										<small><?php _e('Add your phone or note some tips to help admin easy to transfer money to you.','boxtheme');?></small>
									</div>
									<button type="submit" class="btn btn-primary"><?php _e('Send request','boxtheme');?></button>
								</form>
							<?php } ?>
						<?php } else {?>
							<p></p>
							<?php _e('Your balance is not enough to withdraw','boxtheme');?>
						<?php } ?>
					</div>
					<div id="paypal" class="tab-content-item hidding">
						<form id="frm_paypal" class="withdraw-info">
							<span class="btn-edit-self 111"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
							<div class="form-group is-view">
								<span for="paypal_email"><strong><?php _e('PayPal Email','boxtheme');?></strong></span> <p><?php echo $paypal_email;?></p>
							</div>
							<div class="full is-edit">
								<div class="form-group">
									<label for="paypal_email"><?php _e('PayPal Email:','boxtheme');?></label>
									<input type="text" class="form-control required" id="paypal_email" name="paypal_email" required aria-describedby="paypal_email" value="<?php echo $paypal_email;?>" placeholder="<?php _e('Your PayPal Email','boxtheme');?>">

								</div>
								<button type="submit" class="btn btn-primary is-edit"><?php _e('Save','boxtheme');?></button>
							</div>

						</form>
					</div>

					<div id="bank_info" class=" tab-content-item hidding">
						<form id="frm_bank_info" class="withdraw-info">
							<div class="form-group"><h3><?php _e('Setup your bank account','boxtheme');?> <span class="btn-edit-self "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></h3></div>

							<div class="full is-view">
								<div class="form-group">
									<label for="account_name"><?php _e('Name on account','boxtheme');?></label>
									<p><span><?php echo !empty($bank_account->account_name) ? $bank_account->account_name : 'Not set';?></span></p>

								</div>
								<div class="form-group">
									<label for="account_number"><?php _e('Account number or IBAN','boxtheme');?></label>
									<p><?php echo !empty($bank_account->account_number) ? $bank_account->account_number : 'Not set'; ?></p>
								</div>

								<div class="form-group">
									<label for="exampleInputPassword1"><?php _e('Bank name','boxtheme');?></label>
									<p><?php echo !empty($bank_account->bank_name) ? $bank_account->bank_name :'Not set';?></p>
								</div>
							</div>

							<div class="full is-edit">
								<div class="form-group">
									<label for="account_name"><?php _e('Name on account','boxtheme');?></label>
									<input type="text" class="form-control required" id="account_name" required name="account_name" aria-describedby="account_name" value="<?php echo $bank_account->account_name;?>" placeholder="<?php _e('Name on account','boxtheme');?>">
									<small id="emailHelp" class="form-text text-muted"><?php _e('Your bank account name','boxtheme');?></small>
								</div>
								<div class="form-group">
									<label for="account_number"><?php _e('Account number or IBAN','boxtheme');?></label>
									<input type="text" class="form-control required" required id="account_number" name="account_number" value="<?php echo $bank_account->account_number;?>" aria-describedby="" placeholder="<?php _e('Account number or IBAN','boxtheme');?>">
								</div>

								<div class="form-group">
									<label for="exampleInputPassword1"><?php _e('Bank name','boxtheme');?></label>
									<input type="text" class="form-control required" id="bank_name" name="bank_name" value="<?php echo $bank_account->bank_name;?>" placeholder="Bank name">
								</div>
								<button type="submit" class="btn btn-primary"><?php _e('Save','boxtheme');?></button>
							</div>
						</form>
					</div>
				</div>


			</div>

			<div id="profile" class="col-md-12 line-item history-order-section"> <!-- start left !-->

			     <?php get_template_part( 'template-parts/dashboard/list', 'order' ); ?>
			</div> <!-- end left !-->
		</div>

	</div>
</div>
<?php get_footer();?>
<style type="text/css">
	.site-content{
		background-color: transparent;
	}

	.line-item{
		background: #fff;
		border:3px solid #e6e6e6;
		margin-bottom: 25px;
		padding-top:30px;
		padding-bottom: 30px;
		padding-left: 30px;
		padding-right: 30px;

	}
	.site-content{
		padding-top: 0;
	}
	.tab-content-item{
		min-height: 299px;
		position: relative;
	}
	.tab-content-item form{
		padding: 25px 15px;
		border1:1px solid #ddd;
		border-top: 0;
	}
	.tab-content-item h3{
		margin-top: 0;
		position: relative;
		padding-right: 20px;
	}
	.tab-withdraw{}
	.tab-content .hidding{
		visibility: hidden;
		display: none;
	}
	.page-credit .nav-tabs>li>a{
		border-radius: 0;
	}
	div.is-edit{
		visibility: hidden;
		display: none;
	}
	form.is-edit .is-edit{
		display: block;
		visibility: visible;
	}
	form.is-edit .is-view{
		display: none;
	}
	.btn-edit-self{
		position: absolute;
		right: 20px;
		top: 10px;
		cursor: pointer;
	}
	@media only screen and (max-width: 768px) {
		.line-item{
			overflow: hidden;
			padding-left: 10px;
			padding-right: 10px;
			border: 0;
			border-bottom: 1px solid #ccc;
			padding-top: 0;
		}
		.page-credit .nav-tabs > li > a{
			padding-left: 10px;
			padding-right: 10px;
		}
		.history-order{
			border: 0;
		}

		.history-order .line-heading .col-xs-5,
		.history-order .row-order-item .col-xs-5{
			padding-left: 0;
			padding-right: 0;
		}
		.tab-content-item{
			min-height: 0;
		}
		.tab-content-item form{
			border: 0;
			padding-left: 0;
			padding-right: 0;
		}
		.custom-res h5{
			margin-left: -15px;
		    font-weight: normal;
		    font-size: 16px;
		}
		.btn-buy-credit{
			float: right;
			position: relative;
   			top: -10px;
		}
		.line-item .col-md-6.col-xs-6{
			padding-left: 0;
		}
	}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){
			console.log('123');
			$(".nav-tabs a").click(function(event){
				$(".nav-tabs li").removeClass('active');
				var _this = $(event.currentTarget);
				_this.closest("li").addClass('active');
				var section = _this.attr('href');
				$(".tab-content-item").addClass('hidding');
				$(section).removeClass('hidding');
				return false;4
			});
			$(".btn-edit-self").click(function(event){
				var _this = $(event.currentTarget);
				_this.closest("form").toggleClass('is-edit');

			})

		})

	})(jQuery);
</script>
