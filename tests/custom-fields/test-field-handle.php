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
        $this->cat1 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 1',
            )
        );
        $this->cat2 = $this->listing_category->create_object(
            array(
                'taxonomy' => 'listing_category',
                'name' => 'Cat 2',
            )
        );
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

    public function test_insert_text_field_successfully() {
        $field_data = $this->field_data;
        $field_data['field_for_categories'] = array($this->cat1);
        $this->field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertInternalType('integer', $this->field_id);
    }

    public function test_text_field_is_has_categories() {
        $this->test_insert_text_field_successfully();
        $field = marketengine_cf_get_field($this->field_id);

        $this->assertEquals(count(array($this->cat1)), $field['count']);

        $field_categories = marketengine_cf_get_field_categories($this->field_id);
        $this->assertEquals(array($this->cat1), $field_categories);
    }

    public function test_insert_text_field_empty_field_category() {
        $field_data = $this->field_data;
        $field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertEquals(new WP_Error('invalid_taxonomy', 'Categories is required!'), $field_id);
    }

    public function test_update_text_field_successfully() {
        $this->test_insert_text_field_successfully();
        $field = marketengine_cf_get_field($this->field_id);

        $new_data = array(
            'field_title'         => 'Text Field Edited',
            'field_placeholder'   => 'Field Placeholder',
            'field_description'   => 'Field Description',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => '',
            'field_for_categories'=> array($this->cat2),
        );
        $new_data = wp_parse_args($new_data, $field);

        $field_id = ME_Custom_Field_Handle::insert($new_data, true);
        $this->assertInternalType('integer', absint($field_id));

        $categories = marketengine_cf_get_field_categories($field_id);
        $this->assertEquals($categories, $new_data['field_for_categories']);

        $field = marketengine_cf_get_field($field_id);
        unset($new_data['field_for_categories']);
        $this->assertEquals($new_data, $field);
    }

    public function test_insert_date_field() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'date';
        $field_data['field_for_categories'] = array($this->cat1);
        $this->field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertInternalType('integer', $this->field_id);
    }

    public function test_insert_number_field_successfully() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'number';
        $field_data['field_minimum_value'] = 1;
        $field_data['field_maximum_value'] = 100;
        $field_data['field_for_categories'] = array($this->cat1);

        $this->field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertInternalType('integer', $this->field_id);
    }

    public function test_insert_number_field_failed() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'number';
        $field_data['field_minimum_value'] = 100;
        $field_data['field_maximum_value'] = 1;
        $field_data['field_for_categories'] = array($this->cat1);

        $field_id = ME_Custom_Field_Handle::insert($field_data);

        $this->assertEquals(new WP_Error('number_field_attributes_invalid', __('Maximum value must be greater than minimum value.','enginethemes')), $field_id);
    }

    public function test_insert_number_field_empty_minimum_value() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'number';
        $field_data['field_maximum_value'] = 1;
        $field_data['field_for_categories'] = array($this->cat1);

        $field_id = ME_Custom_Field_Handle::insert($field_data);

        $this->assertInternalType('integer', $field_id);
    }

    public function test_insert_number_field_empty_maximum_value() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'number';
        $field_data['field_minimum_value'] = 1;
        $field_data['field_for_categories'] = array($this->cat1);

        $field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertInternalType('integer', $field_id);
    }

    public function test_insert_checkbox_successfully() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'checkbox';
        $options = "option-1 : Option 1" . PHP_EOL;
        $options .= "Option 2" . PHP_EOL;
        $options .= "option-3";
        $field_data['field_options'] = $options;
        $field_data['field_for_categories'] = array($this->cat1);

        $this->field_id = ME_Custom_Field_Handle::insert($field_data);
        $this->assertInternalType('integer', $this->field_id);
    }

    public function test_insert_checkbox_options() {
        $options = "option-1 : Option 1" . PHP_EOL;
        $options .= "option-2 : Option 2" . PHP_EOL;
        $options .= "option-3 : option-3";

        $this->test_insert_checkbox_successfully();
        $field = marketengine_cf_get_field($this->field_id);
        $field_options = marketengine_cf_get_field_options($field['field_name']);

        $this->assertEquals($options, marketengine_field_option_to_string($field_options));
    }

    public function test_insert_checkbox_empty_options() {
        $field_data = $this->field_data;
        $field_data['field_type'] = 'checkbox';
        $field_data['field_for_categories'] = array($this->cat1);
        $field_data['field_options'] = '';

        $field_id = ME_Custom_Field_Handle::insert($field_data);

        $this->assertEquals(new WP_Error('field_option_empty', __("Field option cannot be empty.", 'enginethemes')), $field_id);
    }

    public function test_update_checkbox_options() {
        $this->test_insert_checkbox_successfully();
        $field = marketengine_cf_get_field($this->field_id);
        $options = "option-3" . PHP_EOL;
        $options .= "option-1 : Option 2";

        $new_data = array(
            'field_title'         => 'Text Field Edited',
            'field_placeholder'   => 'Field Placeholder',
            'field_description'   => 'Field Description',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => '',
            'field_for_categories'=> array($this->cat2),
            'field_options'       => $options,
        );
        $new_data = wp_parse_args($new_data, $field);

        $field_id = ME_Custom_Field_Handle::insert($new_data, true);
        $this->assertInternalType('integer', absint($field_id));

        $new_options = "option-3 : option-3" . PHP_EOL;
        $new_options .= "option-1 : Option 2";

        $field_options = marketengine_cf_get_field_options($field['field_name']);
        $field_options = marketengine_field_option_to_string($field_options);

        $this->assertEquals($new_options, $field_options);
    }

    public function test_update_checkbox_empty_options() {
        $this->test_insert_checkbox_successfully();
        $field = marketengine_cf_get_field($this->field_id);
        $options = "";

        $new_data = array(
            'field_for_categories'=> array($this->cat2),
            'field_options'       => $options,
        );
        $new_data = wp_parse_args($new_data, $field);

        $field_id = ME_Custom_Field_Handle::insert($new_data, true);
        $this->assertEquals(new WP_Error('field_option_empty', __("Field option cannot be empty.", 'enginethemes')), $field_id);
    }
}