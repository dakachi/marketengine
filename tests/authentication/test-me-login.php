<?php
class Tests_ME_Login extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_login_empty_pass() {
        $user = ME()->user->login(array('user_login' => 'dakachi', 'user_password' => ''));
        $this->assertEquals(new WP_Error('password_required', 'Password is required.'), $user);
    }
    // incorrect_password
    public function test_login_wrong_pass() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $user = ME()->user->login(array('user_login' => 'dakachi', 'user_password' => '212'));
        $this->assertEquals(new WP_Error('incorrect_password', '<strong>ERROR</strong>: The password you entered for the username <strong>dakachi</strong> is incorrect. <a href="http://example.org/wp-login.php?action=lostpassword">Lost your password?</a>'), $user);
    }
    // invalid_username
    public function test_login_wrong_user_name() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $user = ME()->user->login(array('user_login' => 'dakachi2', 'user_password' => '123'));
        $this->assertEquals(new WP_Error('invalid_username', '<strong>ERROR</strong>: Invalid username. <a href="http://example.org/wp-login.php?action=lostpassword">Lost your password?</a>'), $user);
    }
    /**
     * test login success
     * @runInSeparateProcess
     */
    public function test_login_success() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $user = ME()->user->login(array('user_login' => 'dakachi', 'user_password' => '123'));
        $this->assertEquals($u1, $user->ID);
    }
}