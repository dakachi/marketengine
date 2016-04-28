<?php
 
/**
 * An example test case.
 */
class MyPlugin_Test_Example extends WP_UnitTestCase {
 
    /**
     * An example test.
     *
     * We just want to make sure that false is still false.
     */
    function test_false_is_false() {
 
        $this->assertFalse( false );
    }

    function test_validate_ME_return_ME_instance() {
    	$this->assertEquals( ME(), MarketEngine::instance() );
    }
}