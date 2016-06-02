<?php
class Tests_ME_Register extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    // test register successfull
    public function test_register_success() {
        $user = ME_Authentication::register(
            array(
                'user_login' => 'dakachi2',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals('dakachi2', $user->user_login);
    }

    // test send register successfull email
    public function test_register_success_email() {
        $user = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $u1 = self::factory()->user->get_object_by_id($user);

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertEquals('dakachi@gmail.com', $mailer->get_recipient('to')->address);
        reset_phpmailer_instance();
    }

    // test send register successfull email
    public function test_register_success_email_content() {
        $user = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertStringStartsWith("<p>Hello Dakachi dang,", $mailer->get_sent()->body);
        reset_phpmailer_instance();
    }

    // test send register successfull email
    public function test_register_success_send_confirmation_email() {
        update_option('is_required_email_confirmation', true);
        $user = ME_Authentication::register(
            array(
                'user_login' => 'dakachi2',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi2@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertEquals('dakachi2@gmail.com', $mailer->get_recipient('to')->address);
        reset_phpmailer_instance();
    }

    // test send register successfull email
    public function test_register_success_confirmation_email_content() {
        update_option('is_required_email_confirmation', true);
        $user = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );

        //retrieve the mailer instance
        $mailer = tests_retrieve_phpmailer_instance();
        $this->assertStringStartsWith("<p>Hello Dakachi dang,</p>", $mailer->get_sent()->body);
        reset_phpmailer_instance();
    }

    // test register with empty user login field
    public function test_register_empty_userlogin() {
        $error = ME_Authentication::register(
            array(
                'user_login' => '',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_login', 'The user login field is required.'));
    }

    // tesst register with empty confirm passs
    public function test_register_empty_confirm_pass() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass field is required.'));
    }

    // test confirm pass and user pass miss match
    public function test_register_user_pass_and_confirm_pass_missmatch() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '1234',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('confirm_pass', 'The confirm pass and user pass must match.'));
    }

    // test user name existed
    public function test_register_username_existed() {
        $u1 = self::factory()->user->create(array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi1@gmail.com'));
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('existing_user_login', 'Sorry, that username already exists!'));
    }

    // test email existed
    public function test_register_user_email_existed() {
        $u1 = self::factory()->user->create(array('user_login' => 'dakachi2', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com'));
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('existing_user_email', 'Sorry, that email address is already used!'));
    }

    // test invalid email format
    public function test_register_invalid_email_format() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi222@#!@gmail2.com2',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    public function test_register_invalid_email_format_with_two_at_sign() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'john@box@host.net',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    public function test_register_invalid_email_format_with_leading_dot() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => '.john@host.net',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    public function test_register_invalid_email_format_with_leading_dash_in_domain_name() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'john@-host.net',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    public function test_register_invalid_email_format_with_multiple_dots() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'john..a@kachi.host.net',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('user_email', 'The user email must be a valid email address.'));
    }

    // test invalid user name format
    public function test_register_invalid_user_name_format_with_at_sign() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi@',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi222@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('invalid_username', '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.'));
    }

    // test invalid user name format
    public function test_register_invalid_user_name_format_with_hyphen_sign() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi-',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi222@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('invalid_username', '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.'));
    }

    // test invalid user name format
    public function test_register_invalid_user_name_format_with_special_char() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi$%',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi222@gmail.com',
                'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('invalid_username', '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.'));
    }


    // test tos agreemen not checked
    public function test_register_without_agree_tos() {
        $error = ME_Authentication::register(
            array(
                'user_login' => 'dakachi',
                'user_pass' => '123',
                'confirm_pass' => '123',
                'user_email' => 'dakachi222@2gmail.com',
                // 'agree_with_tos' => true,
                'first_name' => 'dakachi',
                'last_name' => 'dang'
            )
        );
        $this->assertEquals($error, new WP_Error('agree_with_tos', 'The agree with tos field is required.'));
    }
}