<?php
class Tests_Field_Handle extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp()
    {
        parent::setUp();
        $this->cat = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 1',
            )
        );
        $this->text_field_data = array(
            'field_name'          => 'text_field',
            'field_title'         => 'Text Field',
            'field_type'          => 'text',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->number_field_data = array(
            'field_name'          => 'number_field',
            'field_title'         => 'Number Field',
            'field_type'          => 'number',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->date_field_data = array(
            'field_name'          => 'date_field',
            'field_title'         => 'Date Field',
            'field_type'          => 'date',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->checkbox_field_data = array(
            'field_name'          => 'checkbox_field',
            'field_title'         => 'Checkbox Field',
            'field_type'          => 'checkbox',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->single_dropdown_field_data = array(
            'field_name'          => 'single_select_field',
            'field_title'         => 'Single Select Field',
            'field_type'          => 'single-select',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->multi_dropdown_field_data = array(
            'field_name'          => 'multi_select_field',
            'field_title'         => 'Multi Select Field',
            'field_type'          => 'multi-select',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );
        $this->field_options = array(
            'option-1'    => 'Option 1',
            'option-2'    => 'Option 2',
            'option-3'    => 'Option 3',
        );
    }

    public function tearDown() {
        parent::tearDown();
        global $wpdb;

        $field_table = $wpdb->prefix . 'marketengine_custom_fields';
        // delete field
        $deleted = $wpdb->query("DELETE FROM $field_table WHERE 1=1");
    }



    public function test_insert_field_fail() {
        $field_id = ME_Custom_Field_Handle::insert(array());
        $this->assertTrue(is_wp_error($field_id));
    }

    public function test_insert_text_field() {
        $this->text_field_data['field_for_categories'] = array($this->cat);
        $field_id = ME_Custom_Field_Handle::insert($this->text_field_data);
        $this->assertInternalType('integer', $field_id);

        $field = me_cf_get_field($field_id);
        $this->assertEquals(count($this->text_field_data['field_for_categories']), $field['count']);

        $field_categories = me_cf_get_field_categories($field_id);
        $this->assertEquals($this->text_field_data['field_for_categories'], $field_categories);
    }

    public function test_insert_date_field() {

    }

    public function test_insert_number_field() {

    }

    public function test_insert_checkbox_field() {

    }

    public function test_insert_single_dropdown_field() {

    }

    public function test_insert_multi_dropdown_field() {

    }
}
