<?php
class Test_ME_Session extends WP_UnitTestCase {

	private $_table;
	public function __construct($factory = null) {
		global $wpdb;
		parent::__construct($factory);
		$this->_table = $wpdb->prefix . 'marketengine_sessions';
	}
	/**
     * test get session data
     * @runInSeparateProcess
     */
	public function test_read_session_data() {
		global $wpdb;
		$data = serialize( array('a' => 'b'));
		$session_id = 'aaaaaaaaa';
		// $wpdb->query(
		// 	"INSERT INTO $this->_table
		// 		VALUES ('', $session_id, $data, '231289037910' ))"
  		//	);

		$session  = new ME_Session();
		$data = $session->get_session_data();
		$this->assertEquals( array('a' => 'c'), unserialize( $data ) );
	}
}