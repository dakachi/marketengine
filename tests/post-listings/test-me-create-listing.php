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


    // TODO: view test_media_handle_upload_sets_post_excerpt in tests/media.php
}