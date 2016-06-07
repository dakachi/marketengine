<?php
class Tests_ME_Create_Listing extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_create_listing_with_empty_post_title() {
        $listing_data = array(
            // 'post_title' => '',
            'post_content' => 'abc',
            'listing_type' => 'contact',
            'meta_input' => array(
                // 'price' => '',
            ),
            'tax_input' => array(
                'listing_category' => '',
            )
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertWPError($p1, 'The 22 field listing title is required.');
    }
}