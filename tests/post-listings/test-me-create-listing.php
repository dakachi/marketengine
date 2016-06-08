<?php
class Tests_ME_Create_Listing extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_create_listing_with_empty_post_title() {
        $listing_data = array(
            'post_title' => '',
            'post_content' => 'abc',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '1',
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('post_title', 'The post title field is required.'), $p1);
    }

    public function test_create_listing_with_empty_post_content() {
        $listing_data = array(
            'post_title' => 'Listing A',
            'post_content' => '',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '22',
            ),
            'tax_input' => array(
                'listing_category' => '1',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('post_content', 'The post content field is required.'), $p1);
    }

    public function test_create_listing_with_empty_listing_contact() {
        $listing_data = array(
            'post_title' => 'Listing A',
            'post_content' => 'Sample content',
            'listing_type' => 'contacts',
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
            'post_title' => 'Listing A',
            'post_content' => 'Sample content',
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