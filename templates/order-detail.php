<?php
/**
 *  The Template for displaying details of a order.
 *  This template can be overridden by copying it to yourtheme/marketengine/order-detail.php.
 *
 * @author      EngineThemes
 * @package     MarketEngine/Templates
 * @version     1.0.0
 */
//TODO: tam thoi lam the nay
if( !current_user_can('edit_posts') ) {
    $login_url = me_get_auth_url();
    wp_redirect( $login_url );
}

$order_id = get_the_ID();
$order = new ME_Order($order_id);
$buyer = $order->post_author == get_current_user_id();

$title = $buyer ? __('My Transactions') : __('My Orders');
$url = $buyer ? me_get_auth_url('purchases') : me_get_auth_url('orders');

get_header();
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <div class="marketengine-page-title">
                <p><?php echo strtoupper($title); ?></p>
            </div>

            <?php //TODO: style lai cho nay ?>
            <div class="">
                <a href="<?php echo $url; ?>"><?php echo $title; ?></a><span><?php printf( ' > #%s', $order->id ); ?>
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