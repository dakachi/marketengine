<?php
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $transaction->post_date ) );

$order_number = '#' . $transaction->get_order_number();
$order_status = get_post_status( $transaction->id );

$listing_items = $transaction->get_listing_items();
$listing = array_pop($listing_items);

$listing_obj = marketengine_get_listing($listing['ID']);

marketengine_get_template( 'purchases/transaction-info', array( 'order_number' => $order_number, 'payment_date' => $payment_date ) );
marketengine_get_template( 'purchases/order-status', array( 'order_status' => $order_status ) );
marketengine_get_template( 'purchases/order-item', array( 'listing_item' => $listing, 'listing_obj' => $listing_obj, 'transaction' => $transaction ) );
marketengine_get_template( 'purchases/order-bill-info', array('transaction' => $transaction) );