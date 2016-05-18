<?php
class Tests_ME_Confirm_Email extends WP_UnitTestCase {
	// test invalid key
	public function test_confirm_invalid_key() {
		$u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
		$key = wp_generate_password( 20 );
		update_user_meta( $u1, 'confirm_key', $key );

		$user = ME_Authentication::confirm_email( array('user_email' => 'dakachi@gmail.com', 'key' => 'abcxyz' ) );
        $this->assertEquals( new WP_Error('invalid_key', 'Invalid key.'), $user );
	}

	// test confirm success with empty key in user meta
	public function test_confirm_with_empty_confirm_key_in_database() {
		$u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
		$user = ME_Authentication::confirm_email( array('user_email' => 'dakachi@gmail.com', 'key' => 'abcxyz' ) );
        $this->assertEquals( $u1, $user->ID );
	}

	// confirm success
	public function test_confirm_email_success() {
		$u1   = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
		$key = wp_generate_password( 20 );
		update_user_meta( $u1, 'confirm_key', $key );
		$user = ME_Authentication::confirm_email( array('user_email' => 'dakachi@gmail.com', 'key' => $key) );
        $this->assertEquals( $u1, $user->ID );
	}
}