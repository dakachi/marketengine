<?php
/**
 *  The Template for displaying details of a order.
 *  This template can be overridden by copying it to yourtheme/marketengine/order-detail.php.
 *
 * @author      EngineThemes
 * @package     MarketEngine/Templates
 * @version     1.0.0
 */

$user_id = get_current_user_id();
$user_data = get_userdata($user_id);

$order_id = get_the_ID();
$order = new ME_Order($order_id);

$is_buyer = $order->post_author == $user_id;

$is_seller = me_get_order_items($order_id)[1]->order_item_name;

if( !$is_buyer && !($is_seller == $user_data->user_login) ) {
    return load_template(get_404_template());
}

$title = $is_buyer ? __('MY TRANSACTIONS', 'enginethemes') : __('MY ORDERS', 'enginethemes');
$url = $is_buyer ? me_get_auth_url('purchases') : me_get_auth_url('orders');
get_header();
?>

<?php do_action('marketengine_before_main_content');?>

<div id="marketengine-page">
    <div class="me-container">
        <div class="marketengine-content-wrap">

            <div class="marketengine-page-title me-have-breadcrumb">
                <h2><?php echo $title; ?></h2>
                <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
                <ol class="me-breadcrumb">
                    <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                    <li><a href="#"><?php printf( '#%s', $order->id ); ?></a></li>
                </ol>
            </div>

            <?php
            
            if( $is_buyer && !empty($_GET['action']) && 'review' == $_GET['action'] && !empty($_GET['id'])) {
                me_get_template('purchases/review', 
                    array(
                        'transaction' => $order, 
                        'listing_id' => $_GET['id']
                    )
                );
            }else {
                me_get_template('purchases/transaction', array('transaction' => $order));
            }
            ?>
        </div>
    </div>
</div>

<?php do_action('marketengine_after_main_content');?>

<?php get_footer();