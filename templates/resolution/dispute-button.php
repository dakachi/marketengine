<?php
	$dispute_time_limit = $transaction->get_dispute_time_limit() ;
?>

<?php if( 'me-disputed' === $transaction->post_status) : ?>

<div class="me-orderwarning-info">
	<p><?php echo __('This order has been disputed by buyer.', 'enginethemes'); ?></p>
	<a href="#" class="me-resolution-center"><?php _e('TO RESOLUTION CENTER', 'enginethemes'); ?></a>
</div>

<?php elseif ('me-pending' !== $transaction->post_status && $dispute_time_limit > 0 ) : ?>

<div class="me-transaction-dispute">

	<p>
		<?php printf( __('You have %s to dispute this order.', 'enginethemes'), $dispute_time_limit); ?></p>
	<a href="<?php echo me_get_option_page_id('dispute'); ?>" class=""><?php _e('DISPUTE', 'enginethemes'); ?></a>

</div>
<?php endif; ?>