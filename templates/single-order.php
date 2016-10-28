<?php

$order_id = get_the_ID();
$order = new ME_Order($order_id);
$buyer = $order->post_author == get_current_user_id();

get_header();
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <div class="marketengine-page-title">
            <?php if($buyer) : ?>
                <p><?php _e('MY TRANSACTIONS'); ?></p>
            <?php else : ?>
                <p><?php _e('MY ORDERS'); ?></p>
            <?php endif; ?>
            </div>

            <div class="">
            <?php //TODO: style lai cho nay ?>
            <?php if( $buyer ) : ?>
                <a href="<?php echo me_get_auth_url('purchases'); ?>"><?php _e('My Transactions'); ?></a>
            <?php else: ?>
                <a href="<?php echo me_get_auth_url('orders'); ?>"><?php _e('My Orders'); ?></a>
            <?php endif; ?>
                <span><?php echo ' > #' . $order->id; ?></span>
            </div>

            <?php
            if( $buyer ) {
                if(!empty($_GET['action']) && 'review' == $_GET['action'] && !empty($_GET['id'])) {
                    me_get_template('purchases/review', array('transaction' => $order, 'listing_id' => $_GET['id']));
                }else {
                    me_get_template('purchases/transaction', array('transaction' => $order));
                }
            } else {
                me_get_template('purchases/order', array('order' => $order));
            }
?>
        </div>
    </div>
</div>
<?php get_footer();