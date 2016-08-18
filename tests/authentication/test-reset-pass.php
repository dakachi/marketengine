<?php
class Tests_ME_Reset_Pass extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }
    // reset pass success
    public function test_reset_pass_success() {
        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        $user = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key,
            )
        );
        $this->assertEquals($u1, $user->ID);
    }

    public function test_reset_pass_success_mail_address() {
        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi1',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        $user = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi1',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key,
            )
        );

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertEquals('dakachi@gmail.com', $mailer->get_recipient('to')->address);
        reset_phpmailer_instance();
    }

    public function test_reset_pass_success_mail_content() {
        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi1',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        $user = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi1',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key,
            )
        );

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $mail_content_expected = '<p>Hello Dakachi1,</p>' .
            '<p>You have successfully changed your password. Click this link  http://example.org to login to your Test Blog account.</p>';
        $this->assertStringStartsWith($mail_content_expected, $mailer->get_sent()->body);
        reset_phpmailer_instance();
    }

    // invalid key
    public function test_reset_pass_invalid_key() {
        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        $error = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key . '1',
            )
        );
        $this->assertEquals(new WP_Error('invalid_key', 'Invalid key'), $error);
    }
    // expired activation key
    public function test_reset_pass_expired_key() {
        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        add_filter('password_reset_expiration', array($this, 'me_reset_expiration'));

        $auth = new ME_Auth_Form();
        $error = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key,
            )
        );
        $this->assertEquals(new WP_Error('expired_key', 'Invalid key'), $error);

        remove_filter('password_reset_expiration', array($this, 'me_reset_expiration'));
    }
    // set the token expired time to 0
    public function me_reset_expiration() {
        return 0;
    }
    // invalid user login
    public function test_reset_pass_invalid_user_login() {

        $u1 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $u2 = self::factory()->user->create(
            array(
                'user_login' => 'dakachi2',
                'user_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
            )
        );
        $key = get_password_reset_key(get_userdata($u1));

        $error = ME_Authentication::reset_pass(
            array(
                'user_login' => 'dakachi2',
                'new_pass' => '123',
                'confirm_pass' => '123',
                'key' => $key,
            )
        );
        $this->assertEquals(new WP_Error('invalid_key', 'Invalid key'), $error);

    }
    // retype password mismatch error
    public function test_reset_pass_password_mismatch() {
        $error = ME_Authentication::reset_pass(
            array('user_login' => 'dakachi',
                'new_pass' => '123',
                'confirm_pass' => '124',
                'key' => 'zadq13412',
            )
        );
        $this->assertEquals(new WP_Error('confirm_pass', 'The confirm password and new password must match.'), $error);
    }
}