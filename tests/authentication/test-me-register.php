<?php
class Tests_ME_Register extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    // test register with empty user login field
    public function test_register_empty_userlogin() {
        $error = ME_Authentication::register(array('user_login' => '', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('user_login', 'The user login field is required.'));
    }

    public function test_register_empty_confirm_pass() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass field is required.'));
    }

    public function test_register_user_pass_and_confirm_pass_missmatch() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '1234','user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass and user pass must match.'));
    }

    public function test_register_success() {
        $user = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $u1   = self::factory()->user->get_object_by_id($user);
        $this->assertEquals('dakachi', $u1->user_login);
    }
}