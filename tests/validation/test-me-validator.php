<?php
class Tests_ME_Validator extends WP_UnitTestCase {
	// test data is required 
	function test_me_get_invalid_message_required() {
		$data = array('user_login' => '', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'agree_with_tos' => true);
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'user_email' => 'required|email',
            'agree_with_tos' => 'required'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals(array('user_login' => "The user login field is required.") , $invalid_data );
	}
	// test data is email
	function test_me_get_invalid_message_email() {
		$data = array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi.gmail.com', 'agree_with_tos' => true);
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'user_email' => 'required|email',
            'agree_with_tos' => 'required'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals(array('user_email' => "The user email must be a valid email address.") , $invalid_data );
	}

	// test data is number
	function test_me_get_invalid_message_numeric() {
		$data = array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'phone' => 'ss');
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'phone' => 'numeric',
            'user_email' => 'required|email'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals(array('phone' => "The phone must be a number.") , $invalid_data );
	}

	// test data is url
	function test_me_get_invalid_message_url() {
		$data = array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'site' => 'da');
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'site' => 'url',
            'user_email' => 'required|email'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals(array('site' => "The site format is invalid.") , $invalid_data );
	}
	// test number min
	function test_me_get_invalid_message_min() {
		$data = array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 'min' => '5');
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'min' => 'min:6|numeric',
            'user_email' => 'required|email'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals( array('min' => array('numeric' => __('The min must be at least 6.',"enginethemes" ),
		        'file'    => __('The min must be at least 6 kilobytes.',"enginethemes" ),
		        'string'  => __('The min must be at least 6 characters.',"enginethemes" ),
		        'array'   => __('The min must have at least 6 items.',"enginethemes" ))), $invalid_data );
	}

	// test data is url
	function test_me_get_invalid_message_same() {
		$data = array('user_login' => 'dakachi', 'user_pass' => '123', 'user_email' => 'dakachi@gmail.com', 're_user_pass' => 'da');
		$rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            're_user_pass' => 'same:user_pass',
            'user_email' => 'required|email'
        );

        $invalid_data = me_get_invalid_message($data, $rules);
		$this->assertEquals(array('re_user_pass' => "The re user pass and user pass must match.") , $invalid_data );
	}
}
