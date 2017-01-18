<?php
class Tests_ME_Order_Item extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        parent::setUp();
        global $wpdb;
        $this->table = $wpdb->prefix . 'marketengine_order_items';

        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
    }

    public static function wpTearDownAfterClass() {
        global $wpdb;
        $order_item_table = $wpdb->prefix . 'marketengine_order_items';
        $order_item_meta_table = $wpdb->prefix . 'marketengine_order_itemmeta';
        
        $wpdb->query("DELETE FROM $order_item_table");
        $wpdb->query("DELETE FROM $order_item_meta_table");
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
        global $wpdb;
        $item_id = me_add_order_item(1, 'Order item data', 'listing_item');
        me_delete_order_item($item_id);
        $order_item = $wpdb->get_row("SELECT * FROM {$this->table} WHERE order_item_id = {$item_id}");
        $this->assertEmpty($order_item);
    }

    /**
     * @cover me_get_order_items()
     */
    public function test_get_order_items() {
        global $wpdb;
        $item_id_1 = me_add_order_item(2, 'Order item data', 'listing_item');
        $item_id_2 = me_add_order_item(2, 'Order item data 2', 'listing_item');
        $results = me_get_order_items(2, 'listing_item');
        $expect  = array(
            (object) array(
                'order_item_id'   => (string)$item_id_1,
                'order_item_name' => 'Order item data',
                'order_item_type' => 'listing_item',
                'order_id' => '2'
            ),
            (object) array(
                'order_item_id'   => (string)$item_id_2,
                'order_item_name' => 'Order item data 2',
                'order_item_type' => 'listing_item',
                'order_id' => '2'
            )
        );
        $this->assertEquals($expect, $results);
    }
}