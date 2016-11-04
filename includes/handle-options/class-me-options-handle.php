<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Options_Handle{

    public $_instance;

    public function get_instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *  Sync option
     *  @author     KyNguyen
     */

    public function option_sync() {
        if(!current_user_can( 'manage_options' )) {
            wp_send_json( array('success' => false , 'msg' => __("You do not have permission to change option.", 'enginethemes')) );
        }

        $request = $_REQUEST;

        $name = $request['name'];
        $value = array();

        $options = ME_Options::get_instance();

        if( is_string($request['value']) ){
            $request['value'] = stripslashes($request['value']);
        }

        if( is_int($request['value']) ){
            wp_send_json( 'adas' );
        }

        $value = $request['value'];
        $options->$name = $value;
        $options->save();

        $options_arr = $options->get_all_current_options();
        $id = array_search($name, array_keys($options_arr));
        $response = array(
            'success' => true,
            'data' => array(
                'ID'        => $id
            ) ,
            'msg' => __("Update option successfully!", 'enginethemes'),
        );
        wp_send_json( $response );
    }
}


