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
        marketengine_empty_notices();
        marketengine_add_notice('Success 1!', 'success');
        marketengine_add_notice('Success 2!', 'success');
        marketengine_add_notice('Error!', 'error');
        $notices = marketengine_get_notices();
        $this->assertEquals(array('success' => array('Success 1!', 'Success 2!'), 'error' => array('Error!')), $notices);
    }

    public function test_me_get_error_notice() {
        marketengine_empty_notices();
        marketengine_add_notice('Error!', 'error');
    	$errors = marketengine_get_notices('error');
        $this->assertEquals(array('Error!'), $errors);
    }

    public function test_me_get_success_notice_type() {
        marketengine_empty_notices();
        marketengine_add_notice('Success 1!', 'success');
        marketengine_add_notice('Success 2!', 'success');
    	$success = marketengine_get_notices('success');
        $this->assertEquals(array('Success 1!', 'Success 2!'), $success);
    }

    public function test_me_get_invalid_notice_type() {
        marketengine_empty_notices();
    	$success = marketengine_get_notices('not_notice_type');
        $this->assertEquals(array(), $success);
    }
}
