<?php
class Tests_Get_Fields extends WP_UnitTestCase
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
            $result = marketengine_cf_insert_field($field_data, true);
            if($key < 2) {
                marketengine_cf_set_field_category($result , $this->parent_cat, $key);
                marketengine_cf_set_field_category($result , $this->parent_cat_2, $key);    
            }else {
                marketengine_cf_set_field_category($result , $this->parent_cat_2, $key);
            }
        }

        
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

    public function test_me_get_field_in_category()
    {
        $fields = marketengine_cf_get_fields($this->parent_cat);
        $this->assertEquals(array('field_1', 'field_2'),wp_list_pluck ( $fields , 'field_name')) ;
        $this->assertEquals(array(2, 2),wp_list_pluck ( $fields , 'count')) ;
    }

    public function test_me_get_all_feilds()
    {
        $fields = marketengine_cf_get_fields();
        $this->assertEquals(array('field_1', 'field_2', 'field_3'),wp_list_pluck ( $fields , 'field_name')) ;
        $this->assertEquals(array(2, 2, 1),wp_list_pluck ( $fields , 'count')) ;
    }
}
