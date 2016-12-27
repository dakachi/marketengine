<?php if( 'me-disputed' === $order->post_status) : ?>

<div class="me-orderwarning-info">
	<p><?php echo __('This order has been disputed by buyer.', 'enginethemes'); ?></p>
	<a href="#" class="me-resolution-center"><?php _e('TO RESOLUTION CENTER', 'enginethemes'); ?></a>
</div>

<?php elseif ('me-pending' !== $order->post_status ) : ?>

<div class="me-transaction-dispute">
	<?php
		$time_limit = $order->get_dispute_time_limit();
	?>

	<p><?php printf( __('You have %s to dispute this order.', 'enginethemes'), sprintf(_n('%d day', '%d days', $time_limit, 'enginethemes'), $time_limit) ); ?></p>
	<a href="<?php echo me_get_option_page_id('dispute'); ?>" class=""><?php _e('DISPUTE', 'enginethemes'); ?></a>

</div>
<?php endif; ?>