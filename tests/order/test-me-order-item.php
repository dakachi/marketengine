<?php
class Tests_ME_Order_Item extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'marketengine_order_items';

        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
    }

    public function test_me_add_order_item() {
        global $wpdb;
        $item_id = me_add_order_item(1, 'Order item data', 'listing_item');

        $order_item = $wpdb->get_row("SELECT * FROM {$this->table} WHERE order_item_id = {$item_id}");

        $this->assertEquals('Order item data', $order_item->order_item_name);
        $this->assertEquals('listing_item', $order_item->order_item_type);
    }

    public function test_me_update_order_item() {
        global $wpdb;
        $item_id = me_add_order_item(1, 'Order item data', 'listing_item');

        me_update_order_item(
            $item_id,
            array(
                'order_item_type' => 'ship',
                'order_item_name' => 'flat_rate',
            )
        );

        $order_item = $wpdb->get_row("SELECT * FROM {$this->table} WHERE order_item_id = {$item_id}");

        $this->assertEquals('flat_rate', $order_item->order_item_name);
        $this->assertEquals('ship', $order_item->order_item_type);
    }

    public function test_me_delete_order_item() {
        me_update_order_item_meta(1, 'order_meta_data', 'Order meta data');
        me_delete_order_item_meta(1, 'order_meta_data');
        $meta_value = me_get_order_item_meta(1, 'order_meta_data', true);
        $this->assertEmpty($meta_value);
    }
}