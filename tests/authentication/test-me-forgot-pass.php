<?php
class Tests_ME_Forgot_Pass extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_forgot_pass_success() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

		$auth = new ME_Auth_Form();
    	$mailer = $auth->retrieve_password( array('user_login' => 'dakachi') );

		// WordPress 3.2 and later correctly split the address into the two parts and send them seperately to PHPMailer
		// Earlier versions of PHPMailer were not touchy about the formatting of these arguments.

		//retrieve the mailer instance
		$mailer = tests_retrieve_phpmailer_instance();
		$this->assertEquals( 'dakachi@gmail.com',      $mailer->get_recipient( 'to' )->address );
		//$this->assertEquals( 'dakachi',                 $mailer->get_recipient( 'to' )->name );
		$this->assertStringStartsWith( "Someone has requested a password reset for the following account:",        $mailer->get_sent()->body );
    }

    // email invalid
    public function test_forgot_pass_invalid_email() {
    	$user = array('user_login' => 'dakachi@gmail.com');
    	$auth = new ME_Auth_Form();
    	$error = $auth->retrieve_password( $user );
    	$this->assertEquals( new WP_Error('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.')), $error);
    }
    // username invalid
    public function test_forgot_pass_invalid_userlogin() {
    	$user = array('user_login' => 'dakachi');
    	$auth = new ME_Auth_Form();
    	$error = $auth->retrieve_password( $user );
    	$this->assertEquals( new WP_Error('invalidcombo', __('<strong>ERROR</strong>: Invalid username or email.')), $error);
    }
    // empty user login
    public function test_forgot_pass_empty_user_login() {
    	$user = array();
    	$auth = new ME_Auth_Form();
    	$error = $auth->retrieve_password( $user );
    	$this->assertEquals( new WP_Error('empty_username', __('<strong>ERROR</strong>: Enter a username or email address.')), $error);
    }
}