<?php
class Tests_Insert_Field extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);

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
    }

    public function tearDown() { 
        parent::tearDown();
        global $wpdb;

        $field_table = $wpdb->prefix . 'marketengine_custom_fields';
        // delete field
        $deleted = $wpdb->query("DELETE FROM $field_table WHERE 1=1");
    }

    public function test_insert_field_success()
    {
        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->assertInternalType('integer', $result);
    }

    public function test_insert_invalid_field_name()
    {
        $this->field_data['field_name'] = 'asqwop-2032*213';

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->assertEquals(new WP_Error('field_name_format_invalid', 'Field name only lowercase letters (a-z, -, _) and numbers are allowed.'), $result);
    }

    public function test_insert_empty_field_name()
    {
        $this->field_data['field_name'] = '';

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->assertEquals(new WP_Error('field_name_format_invalid', 'Field name only lowercase letters (a-z, -, _) and numbers are allowed.'), $result);
    }
    public function test_insert_empty_field_title()
    {
        $this->field_data['field_title'] = '';

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->assertEquals(new WP_Error('field_title_empty', 'Field title can not be empty.'), $result);
    }

    public function test_insert_empty_field_type()
    {
        $this->field_data['field_type'] = '';

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->assertEquals(new WP_Error('field_type_empty', 'Field type can not be empty.'), $result);
    }
}
