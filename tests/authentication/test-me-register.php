<?php
class Tests_ME_Register extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    // test register with empty user login field
    public function test_register_empty_userlogin() {
        $auth  = ME_User::instance();
        $error = $auth->register(array('user_login' => '', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('user_login', 'The user login field is required.'));
    }

    public function test_register_success() {
        $auth = ME_User::instance();
        $user = $auth->register(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $u1   = self::factory()->user->get_object_by_id($user);
        $this->assertEquals('dakachi', $u1->user_login);
    }
}