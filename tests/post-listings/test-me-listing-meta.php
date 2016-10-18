<?php
class Tests_ME_Listing extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp() {
        
        parent::setUp();
        $this->parent_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 1',
            )
        );

        $this->parent_cat_2 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 2',
            )
        );

        $this->sub_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Sub Cat 1',
                'parent' => $this->parent_cat,
            )
        );

        $user_id = self::factory()->user->create( array( 'role' => 'author' ) );
        update_user_meta( $user_id, 'paypal_email', 'dinhle1987-per@yahoo.com' );
        wp_set_current_user( $user_id );

        $this->listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '222',
                'pricing_unit' => 'none'
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );

        
        $p1 = ME_Listing_Handle::insert($this->listing_data);
        $this->listing_1 = new ME_Listing_Purchasion(get_post($p1));

        $this->listing_data['meta_input']['pricing_unit'] = 'per_unit';
        $p1 = ME_Listing_Handle::insert($this->listing_data);
        $this->listing_2 = new ME_Listing_Purchasion(get_post($p1));

        $this->listing_data['meta_input']['pricing_unit'] = 'per_hour';
        $p1 = ME_Listing_Handle::insert($this->listing_data);
        $this->listing_3 = new ME_Listing_Purchasion(get_post($p1));

        $this->listing_data['listing_type'] = 'contact';
        $this->listing_data['meta_input']['contact_email'] = 'david87dang@gmail.com';
        $p1 = ME_Listing_Handle::insert($this->listing_data);
        $this->listing_4 = new ME_Listing_Contact(get_post($p1));
        
    }

    public function test_get_price() {
        $price = $this->listing_1->get_price();
        $this->assertEquals('222', $price);
    }

    public function test_get_pricing_unit_text() {
        $none = $this->listing_1->get_pricing_unit();
        $this->assertEquals('', $none);

        $per_unit = $this->listing_2->get_pricing_unit();
        $this->assertEquals('/Unit', $per_unit);

        $per_hour = $this->listing_3->get_pricing_unit();
        $this->assertEquals('/Hour', $per_hour);
    }

    public function test_get_listing_type(){
        $listing_type = $this->listing_1->get_listing_type();
        $this->assertEquals('purchasion', $listing_type);
    }

    // public function test_get_review_count(){
    //     $review_count = $this->listing_1->get_review_count();
    //     $this->assertEquals(2, $review_count);
    // }

    // public function test_get_order_count() {
    //     $order_count = $this->listing_1->get_order_count();
    //     $this->assertEquals(2, $order_count);
    // }

    public function test_get_contact_email(){
        $contact_email = $this->listing_4->get_contact_info();
        $this->assertEquals('david87dang@gmail.com', $contact_email);
    }
    // TODO: view test_media_handle_upload_sets_post_excerpt in tests/media.php
}   