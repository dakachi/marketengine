<?php
class Tests_ME_Forgot_Pass extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function test_forgot_pass_success_mail_address() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        //$key = get_password_reset_key( get_userdata( $u1 ) );

    	$mailer = ME_Authentication::retrieve_password( array('user_login' => 'dakachi@gmail.com') );

		// WordPress 3.2 and later correctly split the address into the two parts and send them seperately to PHPMailer
		// Earlier versions of PHPMailer were not touchy about the formatting of these arguments.

		//retrieve the mailer instance
		$mailer = tests_retrieve_phpmailer_instance();
		$this->assertEquals( 'dakachi@gmail.com',      $mailer->get_recipient( 'to' )->address );
        reset_phpmailer_instance();
    }

    public function test_forgot_pass_success_mail_content() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

        $mailer = ME_Authentication::retrieve_password( array('user_login' => 'dakachi@gmail.com') );

        // WordPress 3.2 and later correctly split the address into the two parts and send them seperately to PHPMailer
        // Earlier versions of PHPMailer were not touchy about the formatting of these arguments.

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertStringStartsWith( "<p>Hello Dakachi,</p>".
                                        "<p>You have just sent a request to recover the password associated with your account in Test Blog. ",
                                        $mailer->get_sent()->body 
                                    );
        reset_phpmailer_instance();
    }

    // email invalid
    public function test_forgot_pass_email_not_exist() {
    	$user = array('user_login' => 'dakachi@gmail.com');
    	$error = ME_Authentication::retrieve_password( $user );
    	$this->assertEquals( new WP_Error('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.')), $error);
    }
    // username invalid
    public function test_forgot_pass_invalid_userlogin() {
    	$user = array('user_login' => 'dakachi');
    	$error = ME_Authentication::retrieve_password( $user );
    	$this->assertEquals( new WP_Error('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.')), $error);
    }
    // empty user login
    public function test_forgot_pass_empty_user_login() {
    	$user = array();
    	$error = ME_Authentication::retrieve_password( $user );
    	$this->assertEquals( new WP_Error('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.')), $error);
    }

    // email invalid
    public function test_forgot_pass_invalid_email_address() {
        $user = array('user_login' => 'dakachi@2gmail.2com');
        $error = ME_Authentication::retrieve_password( $user );
        $this->assertEquals( new WP_Error('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.')), $error);
    }
}