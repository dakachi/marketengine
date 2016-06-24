<?php
class Tests_ME_Create_Order extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $user_1 = self::factory()->user->create( array( 'role' => 'author' ) );
        $user_2 = self::factory()->user->create( array( 'role' => 'author' ) );
        wp_set_current_user( $user_1 );
    }

    public function test_create_order(){
        
    }

}