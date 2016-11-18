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

$user_id = get_current_user_id();
$user_data = get_userdata($user_id);

$order_id = get_the_ID();
$order = new ME_Order($order_id);

$buyer = $order->post_author == $user_id;

$seller = me_get_order_items($order_id)[1]->order_item_name;

if( !$buyer && !($seller == $user_data->user_login) ) {
    return load_template(get_404_template());
}

$title = $buyer ? __('My Transactions') : __('My Orders');
$url = $buyer ? me_get_auth_url('purchases') : me_get_auth_url('orders');

get_header();
?>
<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <div class="marketengine-page-title me-have-breadcrumb">
                <h2><?php echo strtoupper($title); ?></h2>
                <a href="<?php echo $url; ?>"><?php echo strtoupper($title); ?></a>
                <ol class="me-breadcrumb">
                    <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                    <li><a href="#"><?php printf( '#%s', $order->id ); ?></a></li>
                </ol>
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