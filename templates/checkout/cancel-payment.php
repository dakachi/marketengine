<div class="marketengine">
	<p><?php _e("Cancelling Payment", "enginethemes"); ?></p>
	<p><?php _e("There was something went wrong with your payment!", "enginethemes"); ?></p>
	<p><?php _e("Your payment can be completed in the order detail", "enginethemes"); ?></p>
	<p><a><?php printf(__('TO ORDER DETAIL', 'enginethemes'), $order->get_order_detail_url()); ?></a></p>
</div>
