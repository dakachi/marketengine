<?php
class Tests_ME_Create_Listing extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_create_listing_with_empty_listing_title() {
        $listing_data = array(
            'listing_title' => '',
            'listing_content' => 'abc',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '1',
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_title', 'The listing title field is required.'), $p1);
    }

    public function test_create_listing_with_empty_listing_content() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => '',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '22',
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_content', 'The listing content field is required.'), $p1);
    }

    public function test_create_listing_with_empty_listing_type() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => 'Sample content',
            'listing_type' => '',
            'meta_input' => array(
                'price' => 22,
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_type', 'The listing type field is required.'), $p1);
    }
    /**
     * Me support three listing type: contact, purchasion, rental
     */
    public function test_create_listing_with_invalid_listing_type() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => 'Sample content',
            'listing_type' => 'invalid_listing_type',
            'meta_input' => array(
                'price' => 22,
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_type', 'The selected listing type is invalid.'), $p1);
    }

    public function test_create_listing_with_invalid_price() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                'listing_price' => '222a',
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_price', 'The listing price must be a number.'), $p1);
    }


    // TODO: view test_media_handle_upload_sets_post_excerpt in tests/media.php
}