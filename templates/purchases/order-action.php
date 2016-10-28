<?php if( 'me-disputed' === $order->post_status) : ?>

<div class="me-orderwarning-info">
	<p><?php echo __('This order has been disputed by buyer.', 'enginethemes'); ?></p>
	<a href="#" class="me-resolution-center"><?php _e('TO RESOLUTION CENTER', 'enginethemes'); ?></a>
</div>

<?php elseif ('me-pending' !== $order->post_status ) : ?>

<div class="me-transaction-dispute">
	<p><?php echo __('You have XX days to dispute this order.', 'enginethemes'); ?></p>
	<a href="<?php echo me_get_page_id('dispute'); ?>" class=""><?php _e('DISPUTE', 'enginethemes'); ?></a>
</div>

<?php endif; ?>