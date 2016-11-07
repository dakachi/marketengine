<div class="me-cancel-payment">
	<h3><?php _e("Cancelling Payment", "enginethemes"); ?></h3>
	<p class="me-cancel-payment-1"><?php _e("There was something went wrong with your payment!", "enginethemes"); ?></p>
	<p class="me-cancel-payment-2"><?php _e("Your payment can be completed in the order detail", "enginethemes"); ?></p>
	<a href="" class="marketengine-btn"><?php printf(__('TO ORDER DETAIL', 'enginethemes'), $order->get_order_detail_url()); ?></a>
</div>
