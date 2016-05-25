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

    // tesst register with empty confirm passs
    public function test_register_empty_confirm_pass() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass field is required.'));
    }

    // test confirm pass and user pass miss match
    public function test_register_user_pass_and_confirm_pass_missmatch() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '1234', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass and user pass must match.'));
    }

    // test user name existed
    public function test_register_username_existed() {
        $u1    = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi1@gmail.com'));
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('existing_user_login', 'Sorry, that username already exists!'));
    }

    // test email existed
    public function test_register_user_email_existed() {
        $u1    = self::factory()->user->create(array('user_login' => 'dakachi2', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('existing_user_email', 'Sorry, that email address is already used!'));
    }

    // test invalid email format
    public function test_register_invalid_email_format() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi222@1gmail.2com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    // test invalid user name format
    public function test_register_invalid_user_name_format() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi-*&', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi22@gmail.com', 'agree_with_tos' => true));
        $this->assertEquals($error, new WP_Error('user_login', 'Usernames can only contain lowercase letters (a-z) and numbers.'));
    }

    // test tos agreemen not checked
    public function test_register_without_agree_tos() {
        $error = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@1gmail.com'));
        $this->assertEquals($error, new WP_Error('agree_with_tos', 'The agree with tos field is required.'));
    }

    // test register successfull
    public function test_register_success() {
        $user = ME_Authentication::register(array('user_login' => 'dakachi', 'user_pass' => '123', 'confirm_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true));
        $u1   = self::factory()->user->get_object_by_id($user);
        $this->assertEquals('dakachi', $u1->user_login);
    }
}