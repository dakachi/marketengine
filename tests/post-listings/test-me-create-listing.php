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
    }
    /**
     * @covers ME_Listing_Handle::insert
     */
    public function test_create_listing_with_empty_listing_title() {
        $listing_data = array(
            'listing_title' => '',
            'listing_content' => 'abc',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '1',
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
            'listing_content' => 'abc',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '1',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_title', 'The listing title may not be greater than 150 characters.'), $p1);
    }

    public function test_create_listing_with_empty_listing_content() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => '',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => '22',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
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
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
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
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_type', 'The selected listing type is invalid.'), $p1);
    }

    public function test_create_listing_with_empty_listing_category() {
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_content' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => 22,
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
            'listing_content' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                'price' => 22,
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
            'listing_content' => 'Sample content',
            'listing_type' => 'contact',
            'meta_input' => array(
                'listing_price' => '222a',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::insert($listing_data);
        $this->assertEquals(new WP_Error('listing_price', 'The listing price must be a number.'), $p1);
    }

    // TODO: view test_media_handle_upload_sets_post_excerpt in tests/media.php
}