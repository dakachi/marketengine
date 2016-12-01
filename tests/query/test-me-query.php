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
        $pages = $this->get_list_of_pages();
        foreach( $pages as $page ) {
            $result = me_get_option_page_id( $page );
            $this->assertEquals(-1, $result);

            $page_id = $this->post_factory->create_object( array('post_type' => 'page') );
            $name = "me_{$page}_page_id";
            $this->options->$name = $page_id;
            $this->options->save();
            $result = me_get_option_page_id($page);
            $this->assertEquals($page_id, $result);
        }
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

    function get_list_of_pages() {
        return array('user_account', 'post_listing', 'edit_listing', 'checkout', 'confirm_order', 'cancel_order', 'inquiry');
    }

    function get_list_of_endpoints() {
        return array('forgot-password', 'register', 'edit-profile', 'change-password', 'listings', 'orders', 'purchases', 'order');
    }
}
