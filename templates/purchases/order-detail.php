<?php
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $transaction->post_date ) );

$order_number = '#' . $transaction->get_order_number();
$order_status = get_post_status( $transaction->id );

$listing_items = $transaction->get_listing_items();
$order_item = array_pop($listing_items);

$listing = me_get_listing($order_item['ID']);
?>
<div class="me-order-detail">
<?php
me_get_template( 'purchases/order-info', array( 'order_number' => $order_number, 'payment_date' => $payment_date ) );
me_get_template( 'purchases/order-status', array( 'order_status' => $order_status ) );
me_get_template( 'purchases/order-item', array( 'order_item' => $order_item, 'listing' => $listing, 'transaction' => $transaction ) );
me_get_template( 'purchases/order-bill-info', array('transaction' => $transaction) );
?>
</div>