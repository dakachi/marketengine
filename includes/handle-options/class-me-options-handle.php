<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
// TODO: Make this become abstract class
class ME_Options_Handle{
    public function action_sync() {

        if(!current_user_can( 'manage_options' )) {
            wp_send_json( array('success' => false , 'msg' => __("You do not have permission to change option.", 'enginethemes')) );
        }

        $request = $_REQUEST;
        $name = $request['name'];
        $value = array();
        if( is_string($request['value']) ){
            $request['value'] = stripslashes($request['value']);
        }
        if (isset($request['group']) && $request['group']) {
            parse_str($request['value'], $value);
        }else{
            $value = $request['value'];
        }
        /**
         * save option to database
         */
        $options = ME_Options::get_instance();
        $options->$name = $value;
        $options->save();
        /**
         * search index id in option array
         */
        $options_arr = $options->get_all_current_options();
        $id = array_search($name, array_keys($options_arr));
        $response = array(
            'success' => true,
            'data' => array(
                'ID' => $id
            ) ,
            'msg' => __("Update option successfully!", 'enginethemes')
        );
        wp_send_json($response);
    }
}


