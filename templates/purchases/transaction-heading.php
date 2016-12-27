<?php
/**
 *  The Template for displaying heading details of a order.
 *  This template can be overridden by copying it to yourtheme/marketengine/transaction-heading.php.
 *
 * @author      EngineThemes
 * @package     MarketEngine/Templates
 * @version     1.0.0
 */

$is_buyer = ($transaction->post_author == get_current_user_id());

$title = $is_buyer ? __('MY TRANSACTIONS', 'enginethemes') : __('MY ORDERS', 'enginethemes');
$url = $is_buyer ? me_get_auth_url('purchases') : me_get_auth_url('orders');

?>
<div class="marketengine-page-title me-have-breadcrumb">
    <h2><?php echo $title; ?></h2>
    <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
    <ol class="me-breadcrumb">
        <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
        <li><a href="#"><?php printf( '#%s', $transaction->id ); ?></a></li>
    </ol>
</div>