<?php
class Tests_ME_Change_Password extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        parent::setUp();
        $this->author_id = self::factory()->user->create( array( 'role' => 'author', 'user_pass' => '123' ) );
        wp_set_current_user( $this->author_id );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_change_password_success() {
        $user_data = array(
            'current_password' => '123',
            'new_password' => '12345',
            'confirm_password' => '12345'
        );
        $user_id = ME_Authentication::change_password($user_data);
        $user = new WP_User($user_id);
        $this->assertTrue(wp_check_password( '12345', $user->data->user_pass, $user->ID ));
    }

    public function test_change_password_fail_with_empty_fields() {
        $user_data = array(
            'current_password' => '',
            'new_password' => '12345',
            'confirm_password' => '12345'
        );
        $error = ME_Authentication::change_password($user_data);
        $this->assertEquals(new WP_Error('current_password', 'The current password field is required.'), $error);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_change_pwd_fail_with_incorrect_current_pwd() {
        $user_data = array(
            'current_password' => '12342',
            'new_password' => '12345',
            'confirm_password' => '12345'
        );
        $error = ME_Authentication::change_password($user_data);
        $this->assertEquals(new WP_Error('current_password_invalid', 'The current password you enter is not correct.'), $error);
    }
    /**
     * @covers ME_Authentication::change_password
     */
    public function test_change_password_fail_confirm_pass_miss_match() {
        $user_data = array(
            'current_password' => '123',
            'new_password' => '12345',
            'confirm_password' => '123456'
        );
        $error = ME_Authentication::change_password($user_data);
        $this->assertEquals(new WP_Error('confirm_password', 'The confirm password and new password must match.'), $error);
    }
    /**
     * @runInSeparateProcess
     */
    public function test_change_password_fail_with_inactive_account() {
        update_option('is_required_email_confirmation', true);
        $key = wp_generate_password(20);
        update_user_meta($this->author_id, 'confirm_key', $key);

        $user_data = array(
            'current_password' => '123',
            'new_password' => '12345',
            'confirm_password' => '12345'
        );
        $error = ME_Authentication::change_password($user_data);
        $this->assertEquals(new WP_Error('inactive_account', 'Please confirm your email first.'), $error);
    }
}
