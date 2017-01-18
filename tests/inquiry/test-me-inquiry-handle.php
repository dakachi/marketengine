<?php
class Tests_ME_Inquiry_Handle extends WP_UnitTestCase {
	public function __construct($factory = null) {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        update_user_meta( $this->user_1, 'paypal_email', 'dinhle1987-per@yahoo.com' );
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
        $this->inquiry_data = array('customer_note' => 'Order note');

        $this->order_id   = me_insert_order($this->order_data);
        $this->parent_cat = $this->listing_category->create_object(array('taxonomy' => 'listing_category', 'name' => 'Cat 1'));
        $this->sub_cat    = $this->listing_category->create_object(array('taxonomy' => 'listing_category', 'name' => 'Sub Cat 1', 'parent' => $this->parent_cat));

        $listing_data = array(
            'listing_title'       => 'Listing 1',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1000',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->sub_cat,
        );
        $p1            = ME_Listing_Handle::insert($listing_data);
        $this->listing = me_get_listing($p1);

        $this->inquiry_data = array(
        	'inquiry_listing' => $p1,
        	'content' => 'Inquiry message 1'
        );
    }

    public function tearDown() {
        wp_delete_term($this->parent_cat, 'listing_category');
        wp_delete_term($this->sub_cat, 'listing_category');
    }

    public function test_me_handle_inquiry_message_content() {
    	wp_set_current_user($this->user_2);
    	$id = ME_Checkout_Handle::inquiry($this->inquiry_data);

    	$messages = me_get_messages(array('post_type' => 'message', 'post_parent' => $id));
    	$this->assertEquals('Inquiry message 1', $messages[0]->post_content);
        $this->assertEquals($id, $messages[0]->post_parent);
    }

    public function test_me_handle_inquiry_yourself() {
    	wp_set_current_user($this->user_1);
    	$id = ME_Checkout_Handle::inquiry($this->inquiry_data);
        $this->assertEquals(new WP_Error('send_to_yourself', 'You can not send message to your self.'), $id);
    }
}
// test get message