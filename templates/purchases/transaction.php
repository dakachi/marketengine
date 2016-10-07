<?php
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $transaction->post_date ) );
// TODO: Replace with transaction id.
$order_number = '#' . $transaction->get_order_number();
$listing_meta = me_get_order_item_meta($transaction->id);
$listing_post = get_post($listing_meta['_listing_id'][0]);
$author_id = $listing_post->post_author;
?>
<div class="marketengine-content">
	<div class="me-order-detail">
		<?php
			me_get_template( 'purchases/transaction-info', array( 'order_number' => $order_number, 'payment_date' => $payment_date ) );
			me_get_template( 'purchases/order-status' );
			me_get_template( 'purchases/order-item', array( 'listing_meta' => $listing_meta) );
			me_get_template( 'purchases/order-bill-info', array('transaction' => $transaction) );
		?>
	</div>
	<div class="me-row">
		<div class="me-col-md-9">
			<?php
				me_get_template( 'purchases/order-listing', array('listing_meta' => $listing_meta) );
				me_get_template( 'seller-info', array('class' => 'me-authors-xs me-visible-sm me-visible-xs', 'author_id' => $author_id ) );
			?>

			<div class="me-transaction-dispute">
				<p><?php echo __('In the case you find out something unexpected. Please tell us your problems.', 'enginethemes'); ?></p>
				<a href="#" class="">DISPUTE</a>
			</div>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<?php
				me_get_template( 'seller-info', array('author_id' => $author_id)  );
			?>
		</div>
	</div>
	<?php
		me_get_template( 'purchases/listing-slider' );
	?>
</div>
<!--// marketengine-content -->