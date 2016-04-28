<?php
class Tests_ME_Reset_Pass extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }
    // reset pass success
    public function test_reset_pass_success() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

        $user = ME()->user->reset_pass( array('user_login' => 'dakachi', 'new_pass' => '123', 'retype_pass' => '123', 'key' => $key ) );
        $this->assertEquals( $u1, $user->ID );

		//retrieve the mailer instance
		$mailer = tests_retrieve_phpmailer_instance();
		$this->assertEquals( 'dakachi@gmail.com', $mailer->get_recipient( 'to' )->address );
    }

    // invalid key
    public function test_reset_pass_invalid_key() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

        $error = ME()->user->reset_pass( array('user_login' => 'dakachi', 'new_pass' => '123', 'retype_pass' => '123', 'key' => $key.'1' ) );
        $this->assertEquals(new WP_Error( 'invalid_key', 'Invalid key'), $error );
    }
    // expired activation key
    public function test_reset_pass_expired_key() {
        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

        add_filter( 'password_reset_expiration', array($this, 'me_reset_expiration'));

        $auth = new ME_Auth_Form();
        $error = ME()->user->reset_pass( array('user_login' => 'dakachi', 'new_pass' => '123', 'retype_pass' => '123', 'key' => $key ) );
        $this->assertEquals(new WP_Error( 'expired_key', 'Invalid key'), $error );

        remove_filter( 'password_reset_expiration', array($this, 'me_reset_expiration'));
    }
    // set the token expired time to 0
    public function me_reset_expiration() {
        return 0;
    }
    // invalid user login
    public function test_reset_pass_invalid_user_login() {

        $u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $u2  = self::factory()->user->create(array('user_login' => 'dakachi2', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $key = get_password_reset_key( get_userdata( $u1 ) );

        $error = ME()->user->reset_pass( array('user_login' => 'dakachi2', 'new_pass' => '123', 'retype_pass' => '123', 'key' => $key ) );
        $this->assertEquals(new WP_Error( 'invalid_key', 'Invalid key'), $error );

    }
    // retype password mismatch error
    public function test_reset_pass_password_mismatch() {
        $error = ME()->user->reset_pass( array('user_login' => 'dakachi', 'new_pass' => '123', 'retype_pass' => '124', 'key' => 'zadq13412') );
        $this->assertEquals(new WP_Error( 'retype_pass', 'The retype pass and new pass must match.'), $error );
    }
}