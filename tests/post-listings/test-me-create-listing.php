<?php
class Tests_ME_Create_Listing extends WP_UnitTestCase {
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

        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        update_user_meta( $this->user_1, 'paypal_email', 'dinhle1987-per@yahoo.com' );
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
    }

    /**
     * @covers ME_Listing_Handle::insert
     */
    public function test_create_listing_with_empty_listing_title() {
        $listing_data = array(
            'listing_title' => '',
            'listing_description' => 'abc',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '1',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_title', 'The listing title field is required.'), $p1);
    }

    public function test_create_listing_with_listing_title_over_150_character() {
        $listing_data = array(
            'listing_title' => 'Note: When using the regex pattern, it may be necessary to specify rules in an array instead of using pipe delimiters, especially if the regular expression contains a pipe character.',
            'listing_description' => 'abc',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '1',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_title', 'The listing title may not be greater than 150 characters.'), $p1);
    }

    public function test_create_listing_with_empty_listing_description() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => '',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '22',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_description', 'The listing description field is required.'), $p1);
    }

    public function test_create_listing_with_empty_listing_type() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => '',
            'meta_input' => array(
                'listing_price' => 22,
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_type', 'The listing type field is required.'), $p1);
    }
    /**
     * Me support three listing type: purchasion, purchasion, rental
     */
    public function test_create_listing_with_invalid_listing_type() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'invalid_listing_type',
            'meta_input' => array(
                'listing_price' => 22,
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_type', 'The selected listing type is invalid.'), $p1);
    }

    public function test_create_listing_with_empty_listing_category() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => 22,
            ),
            'parent_cat' => '',
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_category', 'The listing category field is required.'), $p1);
    }

    public function test_create_listing_with_invalid_listing_category() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => 22,
            ),
            'parent_cat' => 213,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('invalid_listing_category', 'The selected listing category is invalid.'), $p1);
    }

    public function test_create_listing_with_invalid_price() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '222a',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_price', 'The listing price must be a number.'), $p1);
    }

    public function test_create_listing_with_price_less_than_zero() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => -10,
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_price', 'The listing price must be greater than 0.'), $p1);
    }

    public function test_create_listing_with_invalid_contact_info() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                'contact_email' => '222a',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('contact_email', 'The contact email must be a valid email address.'), $p1);
    }

    public function test_create_purchasion_listing_with_empty_paypal_email() {
        wp_set_current_user( $this->user_2 );
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => 10,
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('empty_paypal_email', 'You must input paypal email in your profile to start selling.'), $p1);
    }

    /**
     * test create listing base on listing type available category
     */
    public function test_create_purchasion_listing_in_not_support_cat() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => 10,
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        add_filter( 'marketengine_listing_type_categories', array($this, 'filter_listing_type_category' ) );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('unsupported_type', 'The listing type Selling is not supported in category Cat 1.'), $p1);
    }

    /**
     * test create listing base on listing type available category
     */
    public function test_create_contact_listing_in_not_support_cat() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                
            ),
            'parent_cat' => $this->parent_cat_2,
            'sub_cat' => $this->sub_cat,
        );
        add_filter( 'marketengine_listing_type_categories', array($this, 'filter_listing_type_category' ) );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('unsupported_type', 'The listing type Offering is not supported in category Cat 2.'), $p1);
    }

    /**
     * test create listing base on listing type available category
     */
    public function test_create_listing_contact_success() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => 10,
            ),
            'parent_cat' => $this->parent_cat_2,
            'sub_cat' => $this->sub_cat,
        );
        add_filter( 'marketengine_listing_type_categories', array($this, 'filter_listing_type_category' ) );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertInternalType('integer', $p1);
    }

    /**
     * test create listing base on listing type available category
     */
    public function test_create_listing_purchase_success() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        add_filter( 'marketengine_listing_type_categories', array($this, 'filter_listing_type_category' ) );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertInternalType('integer', $p1);
    }

    public function filter_listing_type_category($category) {
        return array(
            'contact' => array($this->parent_cat),
            'purchasion' => array($this->parent_cat_2)
        );
    }
}   