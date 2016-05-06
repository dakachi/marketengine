<?php
global $wp_sessions;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_Session {

	protected $_session_id;

	protected $_data;

	protected $_cookie;
	protected $_expired_time;
	protected $_exp_variant;

	protected $_table;

	public function __construct() {
		global $wpdb;
		$this->_cookie = 'wp_marketengine_cookie_' . COOKIEHASH;
		$this->_table  = $wpdb->prefix . 'marketengine_sessions';

		if( $cookie = $this->get_session_cookie() ) {
			if( time() > $this->_expired_time ) {
				$this->set_expiration();
				$this->_session_id = $this->generate_id();
				$this->update_session_expired_time();
				// update_option("_et_session_expires_{$this->_session_id}", $this->_expired_time);
			}
		}else {
			$this->_session_id = $this->generate_id();
			$this->set_expiration();
			$this->set_cookie();
		}

		$this->_data = $this->read_session_data();

		//TODO: hook action to clean session
	}

	public function update_session_expired_time() {

	}

	public function set_cookie() {
		// TODO: hash the cookie
		$hash = md5( wp_hash( $this->_session_id . $this->_exp_variant, $scheme = 'auth' ) );
		setcookie( $this->_cookie, $this->_session_id . '||' . $this->_expired_time .'||'. $this->_exp_variant .'||'. $hash, $this->_expired_time, '/' );
	}
	/**
     * set exprire time
     */
    protected function set_expiration() {
		$this->_exp_variant = time() + (int)apply_filters('et_session_expiration_variant', 24 * 60);
		$this->_expired_time = time() + (int)apply_filters('et_session_expiration', 20 * 60);
    }

	public function get_session_data() {
		global $wpdb;
		// TODO: process cache
		$session_key = $this->_session_id;
		$sesson_value = $wpdb->get_var( $wpdb->prepare (
			"SELECT session_value
				FROM $this->_table
				WHERE session_key = %s",
    			$session_key
    		));
		return unserialize( $session_value );
    }

	public function save_session_data() {
		global $wpdb;
		// TODO: process cache
		$session_key = $this->_session_id;
		$wpdb->insert(
			$this->_table,
			array(
				'session_id' => '',
				'session_key' => $this->_session_id,
				'session_value' => 'value1',
				'session_expiry' => 123
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s'
			)
		);

		$wpdb->update(
			$this->_table,
			array(
				'session_value' => 'value1',
				'session_expiry' => 123
			),
			array( 'session_key' => $session_key ),
			array(
				'%d',
				'%s',
				'%s',
				'%s'
			)
		);
    }

	public function destroy_session() {
		$wpdb->query( 
			$wpdb->prepare( 
				"DELETE FROM $this->_table
				WHERE session_expiry <= %s",
	        	'gargle'
			)
		);
    }

	public function get_session_cookie() {
		if( ! isset( $_COOKIE[ $this->_cookie ] )) {
			return false;
		}

		$cookie = stripslashes( $_COOKIE[ $this->_cookie ] );
		$cookie_data = explode('||', $cookie);
		//TODO: check hash to secure
		$this->_session_id = $cookie_data[0];
		$this->_expired_time = $cookie_data[1];

		return true;
	}
	/**
	 * Generate a unique customer ID for guests, or return user ID if logged in.
	 *
	 * Uses Portable PHP password hashing framework to generate a unique cryptographically strong ID.
	 *
	 * @return int|string
	 */
	public function generate_id() {
		if ( is_user_logged_in() ) {
			return get_current_user_id();
		} else {
			require_once( ABSPATH . 'wp-includes/class-phpass.php');
			$hasher = new PasswordHash( 8, false );
			return md5( $hasher->get_random_bytes( 32 ) );
		}
	}
}