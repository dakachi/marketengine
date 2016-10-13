<?php
class Tests_ME_Create_Order extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
        $this->order_data = array(
            //'post_author' => 10,
            'customer_note' => 'Order note',
        );
    }
    /**
     * @cover me_insert_order()
     */
    public function test_create_order_author() {

        $order_id = me_insert_order($this->order_data);

        $post = get_post($order_id);
        $this->assertEquals('me_order', $post->post_type);
        $this->assertEquals($this->user_1, $post->post_author);
        $this->assertEquals('me-pending', $post->post_status);
    }

    public function test_create_order_customer_note() {
        $order_id = me_insert_order($this->order_data);
        $post     = get_post($order_id);
        $this->assertEquals('Order note', $post->post_excerpt);
    }

    public function test_create_order_key() {
        $order_id = me_insert_order($this->order_data);
        $this->assertStringStartsWith('marketengine', get_post_meta($order_id, '_me_order_key', true));
    }

    public function test_create_order_currency_code() {
        add_filter('marketengine_currency_code', array($this, 'get_currency_code'), 9999);
        $order_id = me_insert_order($this->order_data);
        $this->assertEquals('GBP', get_post_meta($order_id, '_order_currency_code', true));
        remove_filter('marketengine_currency_code', array($this, 'get_currency_code'), 9999);
    }

    /**
     * @cover ME_Checkout_Handle::create_order
     */
    public function test_marketengine_create_order() {
        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertEquals($order, new WP_Error('invalid_payment_method', 'The selected payment method is not available now.'));
    }

    public function get_currency_code($code) {
        return 'GBP';
    }
    //
}