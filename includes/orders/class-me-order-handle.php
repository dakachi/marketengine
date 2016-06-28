<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME_Order_Handle
 *
 * Handling buyer order listing behavior
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
     * @param int $listing_id
     *
     * @return WP_Error| WP_Post
     */
    public static function insert($listing_id) {
        if(!is_user_logged_in()) {
            return new WP_Error('login_required', __("You must login to order listing.", "enginethemes"));
        }
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
     * return WP_Error | WP_Post
     */
    public static function update_order($order_data) {

    }
}