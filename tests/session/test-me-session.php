<?php
class Test_ME_Session extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        parent::setUp();
    }
    /**
     * test get session data
     */
    public function test_me_session_get_session_data() {
        me_empty_notices();
        me_add_notice('Success 1!', 'success');
        me_add_notice('Success 2!', 'success');
        me_add_notice('Error!', 'error');

        $cookie = 'wp_marketengine_cookie_' . COOKIEHASH;
        $_COOKIE[ $cookie ] = 'wowowowow';
        ME()->session->save_session_data();

        $session_data = ME()->session->get_session_data();
        $this->assertEquals(array('me_notices' => array('success' => array('Success 1!', 'Success 2!'), 'error' => array('Error!'))), $session_data);
    }

	public function test_me_session_update_expiry() {
		global $wpdb;

		me_add_notice('Success 1!', 'success');
       	$cookie = 'wp_marketengine_cookie_' . COOKIEHASH;
		$table = $wpdb->prefix . 'marketengine_sessions';

        ME()->session->save_session_data();

        $wpdb->update(
        	$table,
			array(
				'session_expiry' => 12213,
			),
			array('session_key' => ME()->session->get_session_key()),
			array(
				'%d',
			)
        );

		$token = ME()->session->update_session_expired_time();

		$session_expiry_2 = $wpdb->get_var($wpdb->prepare(
            "SELECT session_expiry
				FROM $table
				WHERE session_key = %s",
            ME()->session->get_session_key()
        ));
        $this->assertEquals(ME()->session->get_session_key(), $token);
        $this->assertEquals(ME()->session->get_expirant_time(), $session_expiry_2);
	}

	public function test_me_session_destroy(){
		global $wpdb;

		me_add_notice('Success 1!', 'success');
       	$cookie = 'wp_marketengine_cookie_' . COOKIEHASH;
		$table = $wpdb->prefix . 'marketengine_sessions';

        ME()->session->save_session_data();

        $wpdb->update(
        	$table,
			array(
				'session_expiry' => 12213,
			),
			array('session_key' => ME()->session->get_session_key()),
			array(
				'%d',
			)
        );

		ME()->session->destroy_session();

		$session = $wpdb->get_var($wpdb->prepare(
            "SELECT session_expiry
				FROM $table
				WHERE session_key = %s",
            ME()->session->get_session_key()
        ));

        $this->assertEmpty($session);
	}
}
