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

    public function action_sync( $request ) {

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

        if (isset($request['group']) && $request['group']) {
            foreach($request['group'] as $key => $v){
                $name = $key;
                $options->$name = $v;
                $options->save();
            }
        }
        else{
            $value = $request['value'];
            $options->$name = $value;
            $options->save();
        }

        $options_arr = $options->get_all_current_options();
        $id = array_search($name, array_keys($options_arr));
        $response = array(
            'success' => true,
            'data' => array(
                'ID'        => $id
            ) ,
            'msg' => __("Update option successfully!", 'enginethemes'),
        );
        return $response;
    }


    /**
     *  Add ME shortcode to the page selected by user
     *  @author     KyNguyen
     */
    public function me_edit_page() {

        $request = $_REQUEST;
        $page_id = $request['page_id'];
        $content = $request['content'];
        $page = array(
            'ID'            => $page_id,
            'post_content'  => $content,
        );

        $error = wp_update_post( $page, true );
        if (is_wp_error($error)) {
            wp_send_json( array(
                'success'    => false,
                'msg'        => "There was an error occurred when you has added {$content} to {$page_id}",
                'error'      => $error
            ) );
        }

        if( !isset($this) ) {
            $option = new ME_Options_Handle();
            $option_sync_data = $option->action_sync($request);
        }
        else{
            $option_sync_data = $this->action_sync($request);
        }

        $response = array(
            'success'       => true,
            'msg'           => "You has added {$content} to {$page_id}",
            'option_sync'   => $option_sync_data
        );
        wp_send_json( $response );
    }

    /**
     *  Sync plugin option
     *  @author     KyNguyen
     */
    public function option_sync() {
        if( !isset($this) ) {
            $option = new ME_Options_Handle();
            $option_sync_data = $option->action_sync($request);
        }
        else{
            $option_sync_data = $this->action_sync($request);
        }

        $response['option_sync'] = $option_sync_data;
        wp_send_json($response);
    }

    /**
     *  Sync endpoint option and flush rewrite
     *  @author     KyNguyen
     */
    public function endpoint_sync() {
        $a = me_setting_endpoint_name();
        me_init_endpoint();
        flush_rewrite_rules();
    }
}


