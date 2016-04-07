<?php
/**
 * Test case for the Ajax callback to update 'some_option'.
 *
 * @group ajax
 */
class My_Some_Option_Ajax_Test extends WP_Ajax_UnitTestCase {
 
    /**
     * Test that the callback saves the value for administrators.
     */
    public function test_some_option_is_saved() {
 
        $this->_setRole( 'administrator' );
 
        $_POST['_wpnonce'] = wp_create_nonce( 'my_nonce' );
        $_POST['option_value'] = 'yes';
 
        try {
            $this->_handleAjax( 'my_ajax_action' );
        } catch ( WPAjaxDieStopException $e ) {
            // We expected this, do nothing.
        }
 
        // Check that the exception was thrown.
        $this->assertTrue( isset( $e ) );
 
        // The output should be a 1 for success.
        $this->assertEquals( '1', $e->getMessage() );
 
        $this->assertEquals( 'yes', get_option( 'some_option' ) );
    }
 
    /**
     * Test that it doesn't work for subscribers.
     */
    public function test_requires_admin_permissions() {
 
        $this->_setRole( 'subscriber' );
 
        $_POST['_wpnonce'] = wp_create_nonce( 'my_nonce' );
        $_POST['option_value'] = 'yes';
 
        try {
            $this->_handleAjax( 'my_ajax_action' );
        } catch ( WPAjaxDieStopException $e ) {
            // We expected this, do nothing.
        }
 
        // Check that the exception was thrown.
        $this->assertTrue( isset( $e ) );
 
        // The output should be a -1 for failure.
        $this->assertEquals( '-1', $e->getMessage() );
 
        // The option should not have been saved.
        $this->assertFalse( get_option( 'some_option' ) );
    }
}