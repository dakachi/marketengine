<?php
class Tests_Query_Fields extends WP_UnitTestCase
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
                'name' => 'Cat 1',
            )
        );

        $this->parent_cat_2 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 2',
            )
        );

        $this->field_data = array(
            array(
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
            ),
            array(
                'field_name'          => 'field_2',
                'field_title'         => 'Field 1',
                'field_type'          => 'text',
                'field_input_type'    => 'string',
                'field_placeholder'   => 'Field 1',
                'field_description'   => '',
                'field_help_text'     => 'Field help text',
                'field_constraint'    => 'required',
                'field_default_value' => '0',
                'count'               => 0,
            ),
            array(
                'field_name'          => 'field_3',
                'field_title'         => 'Field 1',
                'field_type'          => 'text',
                'field_input_type'    => 'string',
                'field_placeholder'   => 'Field 1',
                'field_description'   => '',
                'field_help_text'     => 'Field help text',
                'field_constraint'    => 'required',
                'field_default_value' => '0',
                'count'               => 0,
            )
        );
        
        foreach ($this->field_data as $key => $field_data) {
            $result = me_cf_insert_field($field_data, true);
            if($key < 2) {
                me_cf_set_field_category($result , $this->parent_cat, $key);
                me_cf_set_field_category($result , $this->parent_cat_2, $key);    
            }else {
                me_cf_set_field_category($result , $this->parent_cat_2, $key);
            }
        }

        
    }

    public function tearDown() {

        parent::tearDown();
        wp_delete_term($this->parent_cat, 'listing_category');
        wp_delete_term($this->parent_cat_2, 'listing_category');
        wp_delete_term($this->parent_cat_3, 'listing_category');

        me_cf_remove_field_category($this->field_id, $this->parent_cat);

        global $wpdb;

        $field_table = $wpdb->prefix . 'marketengine_custom_fields';
        // delete field
        $deleted = $wpdb->query("DELETE FROM $field_table WHERE 1=1");

    }

    public function test_me_query_field()
    {
        $fields = me_cf_fields_query(array('paged' => 2, 'showposts' => 1));
        $this->assertEquals(array( 'field_2', ),wp_list_pluck ( $fields['fields'] , 'field_name')) ;
        $this->assertEquals(3, $fields['found_posts']) ;
    }
}
