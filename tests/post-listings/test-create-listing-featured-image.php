<?php
class Tests_ME_Create_Listing_Image extends WP_UnitTestCase {
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
        wp_set_current_user( $user_id );
    }

    public function test_create_listing_success_with_featured_image() {
        add_filter( 'marketengine_file_upload_overrides', array($this, 'upload_overrides') );
        $listing_data = array(
            'listing_title' => 'Listing A',
            'listing_description' => 'Sample content',
            'listing_type' => 'purchasion',
            'meta_input' => array(
                'listing_price' => '222',
            ),
            'parent_cat' => $this->parent_cat,
            'sub_cat' => $this->sub_cat,
        );

        // Make a copy of this file as it gets moved during the file upload
        // this image is smaller than the thumbnail size so it won't have one
        $iptc_file = DIR_TESTDATA . '/images/test-image-iptc.jpg';

        // Make a copy of this file as it gets moved during the file upload
        $tmp_name = wp_tempnam( $iptc_file );

        copy( $iptc_file, $tmp_name );

        $_FILES['listing_image'] = array(
            'tmp_name' => $tmp_name,
            'name'     => 'test-image-iptc.jpg',
            'type'     => 'image/jpeg',
            'error'    => 0,
            'size'     => filesize( $iptc_file )
        );
        
        $p1 = ME_Listing_Handle::insert($listing_data, $_FILES);
        $thumbnail_id = get_post_thumbnail_id( $p1 );
        
        $this->assertInternalType("int", intval($thumbnail_id));

        remove_filter( 'marketengine_file_upload_overrides', array($this, 'upload_overrides') );
    }

    

    function upload_overrides($overrides) {
        $overrides['action'] = 'test_iptc_upload';
        return $overrides;
    }
    // TODO: view test_media_handle_upload_sets_post_excerpt in tests/media.php
}   