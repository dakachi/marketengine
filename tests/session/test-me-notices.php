<?php
class Test_ME_Notices extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        parent::setUp();
    }
    /**
     * test me add/get notice
     */
    public function test_me_add_notice() {
        me_empty_notices();
        me_add_notice('Success 1!', 'success');
        me_add_notice('Success 2!', 'success');
        me_add_notice('Error!', 'error');
        $notices = me_get_notices();
        $this->assertEquals(array('success' => array('Success 1!', 'Success 2!'), 'error' => array('Error!')), $notices);
    }

    public function test_me_get_error_notice() {
        me_empty_notices();
        me_add_notice('Error!', 'error');
    	$errors = me_get_notices('error');
        $this->assertEquals(array('Error!'), $errors);
    }

    public function test_me_get_success_notice_type() {
        me_empty_notices();
        me_add_notice('Success 1!', 'success');
        me_add_notice('Success 2!', 'success');
    	$success = me_get_notices('success');
        $this->assertEquals(array('Success 1!', 'Success 2!'), $success);
    }

    public function test_me_get_invalid_notice_type() {
        me_empty_notices();
    	$success = me_get_notices('not_notice_type');
        $this->assertEquals(array(), $success);
    }
}
