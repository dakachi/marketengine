<?php
class Tests_ME_Create_Order extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $this->user_1  = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
    }
    /**
     * @cover me_insert_order()
     */
    public function test_create_order() {
        $order_data = array(
            //'post_author' => 10,
            'note' => 'Order note'
        );
        
        $order_id = me_insert_order($order_data);

        $post = get_post($order_id);
        $this->assertEquals('me_order', $post->post_type);
        $this->assertEquals($this->user_1, $post->post_author);
    }
}