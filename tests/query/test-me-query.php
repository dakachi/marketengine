<?php
class Test_ME_Query extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
        $this->post_factory = new WP_UnitTest_Factory_For_Post();
        $this->options = ME_Options::get_instance();
    }

    public function setUp() {
        parent::setUp();
    }

    public function test_me_get_page_id() {
        $result = me_get_page_id('test_page');
        $this->assertEquals(-1, $result);

        $page_id = $this->post_factory->create_object( array('post_type' => 'page') );
        $name = 'me_test_page_page_id';
        $this->options->$name = $page_id;
        $this->options->save();
        $result = me_get_page_id('test_page');
        $this->assertEquals($page_id, $result);
    }

    public function test_me_get_endpoint_name() {
        $result = me_get_endpoint_name('forgot-password');
        $this->assertEquals('forgot-password', $result);

        $option_name = 'ep_forgot_password';
        $this->options->$option_name = 'quen-mat-khau';
        $this->options->save();
        $result = me_get_endpoint_name('forgot_password');
        $this->assertEquals('quen-mat-khau', $result);
    }
}
