<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME_Order_Handle
 *
 * Handling buyer order order behavior
 *
 * @class       ME_Order_Handle
 * @version     1.0
 * @package     Includes/Orders
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_Order_Handle {
    /**
     * Insert Order
     *
     * Insert Order to database
     *
     * @since 1.0
     *
     * @see wp_insert_post()
     * @param array $order_data
     *              - items array the array of item id
     *              - note String 
     *              - payment String The payment gateway name buyer choose to process order
     *
     * @return WP_Error| ME_Order
     */
    public static function insert($order_data) {
        if(!is_user_logged_in()) {
            return new WP_Error('login_required', __("You must login to order order.", "enginethemes"));
        }

        if (isset($order_data['ID'])) {
            if (($order_data['post_author'] != $user_ID) && !current_user_can('edit_others_posts')) {
                return new WP_Error('edit_others_posts', __("You are not allowed to edit order as this user.", "enginethemes"));
            }
            $post = wp_update_post($order_data);
            /**
             * Do action after update order
             *
             * @param object|WP_Error $post
             * @param array $order_data
             * @since 1.0
             */
            do_action('marketengine_after_update_order', $post, $order_data);
        } else {
            if (!self::current_user_can_create_order()) {
                return new WP_Error('create_posts', __("You are not allowed to create order as this user.", "enginethemes"));
            }
            $post = wp_insert_post($order_data);
            /**
             * Do action after insert order
             *
             * @param object|WP_Error $post
             * @param array $order_data
             * @since 1.0
             */
            do_action('marketengine_after_insert_order', $post, $order_data);
        }

        if(is_wp_error( $post )) return $post;

        $order = new ME_Order($post);
        foreach ($items as  $listing) {
            $order->add_listing($listing);
        }

        $order->add_payment_gateway($gateway);

        return $order;

    }

    /**
     * Update order data
     * 
     * @since 1.0
     *    
     * @param array $order_data
     *  - shipping
     *  - gateway
     *  - fee
     *  - ID
     *
     * return WP_Error | WP_Order
     */
    public static function update($order_data) {

    }
}