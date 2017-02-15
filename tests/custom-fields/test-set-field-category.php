<?php
class Tests_Set_Field_Category extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp()
    {
        parent::setUp();
        $this->field_data = array(
            'field_name'          => 'field_1',
            'field_title'         => 'Field 1',
            'field_type'          => 'text',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->field_id = $result;

        $this->field_data['field_id'] = $result;

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

        $this->parent_cat_3 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 3',
            )
        );
    }

    public function tearDown() {

        parent::tearDown();
        wp_delete_term($this->parent_cat, 'listing_category');
        wp_delete_term($this->parent_cat_2, 'listing_category');
        wp_delete_term($this->parent_cat_3, 'listing_category');

        marketengine_cf_remove_field_category($this->field_id, $this->parent_cat);

        global $wpdb;

        $field_table = $wpdb->prefix . 'marketengine_custom_fields';
        // delete field
        $deleted = $wpdb->query("DELETE FROM $field_table WHERE 1=1");

    }

    public function test_me_set_feild_category()
    {
        marketengine_cf_set_field_category($this->field_id, $this->parent_cat, 1);
        $fields = marketengine_cf_get_fields($this->parent_cat);
        $field = array_pop($fields);

        $count = get_term_meta( $this->parent_cat, '_me_cf_count', true );

        $this->assertEquals($this->field_id, $field['field_id']);
        $this->assertEquals(1, $count);
    }

    public function test_me_remove_field_category() {
        marketengine_cf_set_field_category($this->field_id, $this->parent_cat, 1);

        marketengine_cf_remove_field_category($this->field_id, $this->parent_cat);

        $fields = marketengine_cf_get_fields($this->parent_cat);

        $this->assertEmpty($fields);

        $count = get_term_meta( $this->parent_cat, '_me_cf_count', true );
        $this->assertEquals(0, $count);

    }
}
