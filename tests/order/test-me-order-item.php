<?php
class Tests_ME_Order_Item extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $this->user_1  = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
    }

    public function test_me_add_order_item() {
        $result = me_add_order_item_meta(1, 'order_meta_data', 'Order meta data');
        // $this->assertTrue($result);
        $meta_value = me_get_order_item_meta(1, 'order_meta_data', true);
        $this->assertEquals('Order meta data', $meta_value);    
    }

    public function test_me_update_order_item() {
        $result = me_update_order_item_meta(1, 'order_meta_data', 'Order meta data');

        $meta_value = me_get_order_item_meta(1, 'order_meta_data', true);
        $this->assertEquals('Order meta data', $meta_value); 
    }

    public function test_me_delete_order_item() {
        me_update_order_item_meta(1, 'order_meta_data', 'Order meta data');
        me_delete_order_item_meta(1, 'order_meta_data');
        $meta_value = me_get_order_item_meta(1, 'order_meta_data', true);
        $this->assertEmpty($meta_value); 
    }
}