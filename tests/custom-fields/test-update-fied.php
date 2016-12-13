<?php
class Tests_Update_Field extends WP_UnitTestCase
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

        $result = me_cf_insert_field($this->field_data, true);
        $this->field_id = $result;
        $this->field_data['field_id'] = $result;
    }

    public function test_update_field_success()
    {
        $result = me_cf_update_field($this->field_data, true);
        $this->assertEquals($this->field_id, $result);
    }
}
