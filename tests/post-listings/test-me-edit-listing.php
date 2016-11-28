<?php
class Tests_ME_Edit_Listing extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp()
    {
        parent::setUp();
        $this->parent_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name'     => 'Cat 1',
            )
        );

        $this->parent_cat_2 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name'     => 'Cat 2',
            )
        );

        $this->sub_cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name'     => 'Sub Cat 1',
                'parent'   => $this->parent_cat,
            )
        );
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        update_user_meta($this->user_1, 'paypal_email', 'dinhle1987-per@yahoo.com');
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        update_user_meta($this->user_2, 'paypal_email', 'dinhle1987-per@yahoo.com');

        wp_set_current_user($this->user_1);

        add_filter( 'marketengine_listing_type_categories', array($this, 'filter_listing_type_category' ) );
        $listing_data = array(
            'listing_title'       => 'listing title',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->sub_cat,
        );
        $p1               = ME_Listing_Handle::insert($listing_data);
        $this->listing_id = $p1;
    }

    public function filter_listing_type_category($category) {
        return array(
            'all' => array ($this->parent_cat, $this->parent_cat_2),
            'contact' => array($this->parent_cat, $this->parent_cat_2 ),
            'purchasion' => array($this->parent_cat_2, $this->parent_cat)
        );
    }

    /**
     * @covers ME_Listing_Handle::update
     */
    public function test_edit_listing_by_another_author()
    {
        
        $listing_data = array(
            'edit'                => $this->listing_id,
            'listing_title'       => '',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::update($listing_data);
        $this->assertEquals(new WP_Error('listing_title', 'The listing title field is required.'), $p1);
    }

    // edit listing permission
    /**
     * @covers ME_Listing_Handle::update
     */
    public function test_edit_listing_with_empty_listing_title()
    {
        wp_set_current_user($this->user_2);
        $listing_data = array(
            'edit'                => $this->listing_id,
            'listing_title'       => 'listing title',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::update($listing_data);
        $this->assertEquals(new WP_Error('edit_others_posts', 'You are not allowed to edit listing as this user.'), $p1);
    }

    // change parent cat
    /**
     * @covers ME_Listing_Handle::update
     */
    public function test_edit_listing_change_parent_cat()
    {
        $listing_data = array(
            'edit'                => $this->listing_id,
            'listing_title'       => 'listing title',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat_2,
            'sub_cat'             => $this->sub_cat,
        );
        $p1 = ME_Listing_Handle::update($listing_data);
        $this->assertEquals(new WP_Error('permission_denied', 'You can not change the listing category.'), $p1);
    }

    // change sub cat
    /**
     * @covers ME_Listing_Handle::update
     */
    public function test_edit_listing_change_sub_cat()
    {
        $listing_data = array(
            'edit'                => $this->listing_id,
            'listing_title'       => 'listing title',
            'listing_description' => 'abc',
            'listing_type'        => 'purchasion',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->parent_cat_2,
        );
        $p1 = ME_Listing_Handle::update($listing_data);
        $this->assertEquals(new WP_Error('permission_denied', 'You can not change the listing category.'), $p1);
    }

    // change listing type
    /**
     * @covers ME_Listing_Handle::update
     */
    public function test_edit_listing_change_listing_type()
    {
        $listing_data = array(
            'edit'                => $this->listing_id,
            'listing_title'       => 'listing title',
            'listing_description' => 'abc',
            'listing_type'        => 'contact',
            'meta_input'          => array(
                'listing_price' => '1',
            ),
            'parent_cat'          => $this->parent_cat,
            'sub_cat'             => $this->parent_cat_2,
        );
        $p1 = ME_Listing_Handle::update($listing_data);
        $this->assertEquals(new WP_Error('permission_denied', 'You can not change the listing type.'), $p1);
    }

}
