<?php
$total = '$' . $order->get_total();
me_print_price_html();
?>
<div class="marketengine">
	<div class="me-payment-complete">
		<p><?php printf(__('Your have canceled payment of %s.', 'enginethemes'), $total) ?></p>

		<div class="me-row">
			<div class="me-col-md-4 me-pc-redirect-1">
				<div class="">
					<h4><?php _e("Manage Transaction", "enginethemes"); ?></h4>
					<p><?php printf(__('To view further information of this transaction, or make reviews &amp; ratings for listings, open <a href="%s">Transaction Detail</a>.', 'enginethemes'), $order->get_order_detail_url()); ?></p>
				</div>
			</div>
			<div class="me-col-md-4 me-pc-redirect-2">
				<div class="">
					<h4><?php _e("Manage All Transaction", "enginethemes"); ?></h4>
					<p><?php printf(__('To view all of transactions and manage them, open <a href="%s">Manage Transactions</a>.', 'enginethemes'), me_get_auth_url( 'purchases' )); ?></p>
				</div>

			</div>
			<div class="me-col-md-4 me-pc-redirect-3">
				<div class="">
					<h4><?php _e("Keep Shopping", "enginethemes"); ?></h4>
					<p><?php printf(__('There are many cool products waiting for you to explore. Click <a href="%s">here</a> to continue shopping.', 'enginethemes'), me_get_page_permalink('listings') ); ?></p>
				</div>
			</div>
		</div>

	</div>
</div>