<?php
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $transaction->post_date ) );
$cart_items = me_get_cart_items();
// TODO: Replace with transaction id.
$order_number = '#' . $transaction->get_order_number();
?>
<div class="marketengine-content">
	<div class="me-order-detail">
		<?php
			me_get_template( 'purchases/transaction-info', array( 'order_number' => $order_number, 'payment_date' => $payment_date ) );
			me_get_template( 'purchases/order-status' );
			me_get_template( 'checkout/order-details', array('cart_items' => $cart_items, 'is_transaction' => true) );
			me_get_template( 'purchases/order-bill-info', array('transaction' => $transaction) );
		?>
	</div>
	<div class="me-row">
		<div class="me-col-md-9">
			<?php
				me_get_template( 'purchases/order-listing', array('cart_items' => $cart_items) );
				// me_get_template( 'seller-info', array('class' => 'me-authors-xs me-visible-sm me-visible-xs') );
			?>

			<div class="me-transaction-dispute">
				<p><?php echo __('In the case you find out something unexpected. Please tell us your problems.', 'enginethemes'); ?></p>
				<a href="#" class="">DISPUTE</a>
			</div>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<?php
				// me_get_template( 'seller-info', array('author_id' => $author_id) );
			?>
		</div>
	</div>
	<?php
		me_get_template( 'purchases/listing-slider' );
	?>
</div>
<!--// marketengine-content -->