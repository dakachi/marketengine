<?php
class Tests_ME_Create_Dispute extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
    	parent::setUp();
    	$this->user_1 = self::factory()->user->create(array('role' => 'author', 'user_email' => 'dakachi@gmail.com'));
        update_user_meta( $this->user_1, 'paypal_email', 'dinhle1987-per@yahoo.com' );
        
        $this->user_2 = self::factory()->user->create(array('role' => 'author', 'user_email' => 'dakachi_2@gmail.com'));

    	$this->p1 = me_test_create_basic_purchase_listing($this->user_1);
    	$this->order = me_test_create_basic_order($this->p1, $this->user_2);
    }

    public function test_create_dispute_case_with_empty_problem() {
    	$this->assertEquals(3, $this->p1);
    }
}   