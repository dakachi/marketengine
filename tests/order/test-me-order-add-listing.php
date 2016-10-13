<?php
class Tests_ME_Order_Handle extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
        $this->order_data = array(
            //'post_author' => 10,
            'customer_note' => 'Order note',
        );

        $this->order_id = me_insert_order($this->order_data);

        $this->parent_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 1',
            )
        );

        $this->sub_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Sub Cat 1',
                'parent' => $this->parent_cat,
            )
        );

        $listing_data = array(
            'listing_title' => 'Listing 1',
            'listing_description' => 'abc',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '1000',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->listing = me_get_listing($p1);
    }

    public function tearDown() {
        wp_delete_term($this->parent_cat , 'listing_category');
        wp_delete_term($this->sub_cat , 'listing_category');
    }

    /**
     * @cover ME_Order::add_listing()
     */
    public function test_order_add_listing_success() {

        $order = new ME_Order($this->order_id);
        $item_id = $order->add_listing($this->listing);
        $listing_id = me_get_order_item_meta($item_id, '_listing_id', true);
        $price = me_get_order_item_meta($item_id, '_listing_price', true);

        $this->assertEquals($this->listing->ID, $listing_id);
        $this->assertEquals(1000, $price);

    }
    /**
     * @cover ME_Checkout_Handle::create_order
     */
    public function test_create_order_invalid_payment_method() {
        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertEquals($order, new WP_Error('invalid_payment_method', 'The selected payment method is not available now.'));
    }

    public function test_create_order_empty_cart() {
        $this->order_data['payment_method'] = 'ppadaptive';
        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertEquals($order, new WP_Error('empty_cart', 'The order is empty.'));
    }

    public function test_create_order_invalid_listing() {
        
        $this->order_data['listing_item'] = array( 313 => array('id' => 313, 'qty' => 0));
        $this->order_data['payment_method'] = 'ppadaptive';

        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertEquals($order, new WP_Error('invalid_listing', 'The selected listing is invalid.'));
    }

    public function test_create_order_invalid_quantity() {
        $this->order_data['listing_item'] = array($this->listing->ID => array('id' => $this->listing->ID, 'qty' => 0));
        $this->order_data['payment_method'] = 'ppadaptive';

        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertEquals(new WP_Error('invalid_qty', 'The listing quantity must be greater than 1.'), $order);
    }

    public function test_create_order_success() {
        $this->order_data['listing_item'] = array($this->listing->ID => array('id' => $this->listing->ID, 'qty' => 1));
        $this->order_data['payment_method'] = 'ppadaptive';

        $order_data = $this->order_data;
        $order = ME_Checkout_Handle::create_order($order_data);
        $this->assertInstanceOf(ME_Order::class, $order);
    }
}