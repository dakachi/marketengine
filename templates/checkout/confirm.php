<?php
$order_id = get_query_var( 'order-id' );
$order = new ME_Order($order_id);
$paypal = ME_Paypal_Simple::instance();
$paypal->complete_payment($_REQUEST);
?>
<div class="marketengine">
	<div class="me-payment-complete">
		<h3><?php _e("Thank for your payment", "enginethemes"); ?></h3>
		<p>Your payment of $<?php echo $order->get_total(); ?> has been received for your Lorem Ipsum is simply dummy text for printing on Tue, Jun, 28, 2016.</p>
		<p>Your transaction number is <span id="me-orderid">#<?php echo $order->get_order_number(); ?></span></p>
		<p><?php _e("A detailed summary of your transaction is sent to your mail.", "enginethemes"); ?></p>

		<div class="me-row">
			<div class="me-col-md-4 me-pc-redirect-1">
				<div class="">
					<h4><?php _e("Manage Transaction", "enginethemes"); ?></h4>
					<p>To view further information of this transaction, or make reviews &amp; ratings for listings, open <a href="">Transaction Detail</a>.</p>
				</div>
			</div>
			<div class="me-col-md-4 me-pc-redirect-2">
				<div class="">
					<h4><?php _e("Manage All Transaction", "enginethemes"); ?></h4>
					<p>To view all of transactions and manage them, open <a href="">Manage Transactions</a>.</p>
				</div>
				
			</div>
			<div class="me-col-md-4 me-pc-redirect-3">
				<div class="">
					<h4><?php _e("Keep Shopping", "enginethemes"); ?></h4>
					<p>There are many cool products waiting for you to explore. Click <a href="">here</a> to continue shopping.</p>
				</div>
			</div>
		</div>

	</div>
</div>