<?php
get_header();
$order_id = get_the_ID();
$order = new ME_Order($order_id);
$buyer = $order->post_author;
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">
            <?php
            if( $buyer == get_current_user_id() ) {
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