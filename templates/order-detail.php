<?php
/**
 *  The Template for displaying details of a order.
 *  This template can be overridden by copying it to yourtheme/marketengine/order-detail.php.
 *
 * @author      EngineThemes
 * @package     MarketEngine/Templates
 * @version     1.0.0
 */
$order = me_get_order();
get_header();
?>

<?php do_action('marketengine_before_main_content'); ?>

<div id="marketengine-page">

    <div class="me-container">
        
        <div class="marketengine-content-wrap">

            <?php me_get_template('purchases/transaction-heading', array('transaction' => $order)); ?>

            <?php
            
            if( $order->post_author == get_current_user_id() && !empty($_GET['action']) && 'review' == $_GET['action'] && !empty($_GET['id'])) {
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