<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_Session {
	/**
	 * @var int/string $_session_key
	 * current user session key
	 */
	protected $_session_key;
	/**
	 * @var array $_data
	 * user session data
	*/
	protected $_data;
	/**
	 * @var string $_cookie
	 * the session cookie name
	 */
	protected $_cookie;
	/**
	 * @var int $_expired_time
	 * session expired time
	 */
	protected $_expired_time;
	/**
	 * @var int $_expirant_time
	 * session expirant
	 */
	protected $_expirant_time;
	/**
	 * @var string $_table
	 * db table sesion name
	 */
	protected $_table;

	public function __construct() {
		global $wpdb;
		$this->_cookie = 'wp_marketengine_cookie_' . COOKIEHASH;
		$this->_table  = $wpdb->prefix . 'marketengine_sessions';
		$cookie = $this->get_session_cookie();

		if( $cookie ) {
			if( time() > $this->_expired_time ) {
				$this->_session_key = $this->generate_id();
				$this->set_expiration();
				$this->update_session_expired_time();
			}
		}else {
			$this->_session_key = $this->generate_id();
			$this->set_expiration();
			$this->set_cookie();
		}

		$this->_data = $this->get_session_data();
		//TODO: hook action to clean session
		// nonce_user_logged_out // wp_logout // shutdown
	}

	public function has_session(){
		return isset( $_COOKIE[ $this->_cookie ] ) || is_user_logged_in();
	}
	/**
     * set exprire time
     */
    protected function set_expiration() {
		$this->_expirant_time = time() + (int)apply_filters('et_session_expiration_variant', 24 * 60);
		$this->_expired_time = time() + (int)apply_filters('et_session_expiration', 20 * 60);
    }

	public function get_session_data() {
		global $wpdb;
		// TODO: process cache
		$session_key = $this->_session_key;
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
		if( $this->has_session() ) {
			$id = $wpdb->get_var( $wpdb->prepare( "SELECT session_id FROM $this->_table WHERE session_key = %s;", $this->_session_key ) );
			if( $id ) {
				$wpdb->insert(
				$this->_table,
					array(
						'session_id' => '',
						'session_key' => $this->_session_key,
						'session_value' => serialize( $this->_data ),
						'session_expiry' => $this->_expirant_time
					),
					array(
						'%d',
						'%s',
						'%s',
						'%s'
					)
				);
			}else {
				$wpdb->update(
					$this->_table,
					array(
						'session_value' => serialize( $this->_data ),
						'session_expiry' => $this->_expirant_time
					),
					array( 'session_key' => $this->_session_key ),
					array(
						'%s',
						'%s'
					)
				);
			}
		}
    }

	public function update_session_expired_time() {
		$wpdb->update(
			$this->_table,
			array(
				'session_expiry' => $this->_expirant_time
			),
			array( 'session_key' => $session_key ),
			array(
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

    public function set_cookie() {
		$hash = wp_hash( $this->_session_key . $this->_expired_time );
		setcookie( $this->_cookie, $this->_session_key . '||' . $this->_expired_time .'||'. $this->_expirant_time .'||'. $hash, $this->_expired_time, '/' );
	}

	public function get_session_cookie() {
		if( ! isset( $_COOKIE[ $this->_cookie ] )) {
			return false;
		}

		$cookie = stripslashes( $_COOKIE[ $this->_cookie ] );
		$cookie_data = explode('||', $cookie);

		$hash = $cookie_data[3];
		$session_id = $cookie_data[0];
		$exprired_time = $cookie_data[1];
		if( $hash !== wp_hash( $session_id . $exprired_time ) ) {
			return false;
		}

		$this->_session_key = $session_id;
		$this->_expired_time = $exprired_time;

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