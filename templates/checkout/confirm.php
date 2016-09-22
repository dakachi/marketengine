<?php
$total = '$' . $order->get_total();
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $order->post_date ) );
$order_number = '#' . $order->get_order_number();

if(!$order->has_status('me-pending')) :
?>
<div class="marketengine">
	<div class="me-payment-complete">		
		<p><?php printf(__('Your payment of %s has been received on %s', 'enginethemes'), $total, $payment_date) ?></p>
		<p><?php printf(__('Your transaction number is <span id="me-orderid">%s</span>', 'enginethemes'), $order_number); ?></p>
		<p><?php _e('A detailed summary of your transaction is sent to your mail.', 'enginethemes'); ?></p>

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
<?php else : ?>
	The order is onhold.
<?php endif; ?>

<?php var_dump(get_option( 'paypal_ipn' )); ?>