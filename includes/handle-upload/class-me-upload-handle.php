<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME Authentication Form
 *
 * Class control user data in authentication form
 *
 * @version     1.0
 * @package     Includes/Authentication
 * @author      Dakachi
 * @category    Class
 */
class ME_Upload_Handle extends ME_Form {

    public static function init_hooks() {
        add_action('wp_ajax_upload_multi_file', array(__CLASS__, 'upload_multi_file'));
        add_action('wp_ajax_upload_single_file', array(__CLASS__, 'upload_single_file'));
    }

    public static function upload_multi_file()
    {
        if( !empty($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'marketengine') )
        {
            $filename = $_REQUEST['filename'];
            $file = $_FILES[$filename];
            $attachment = self::handle_file($file);

            marketengine_get_template('upload-file/multi-file-form', array(
                'image_id' => $attachment['id'],
                'filename' => $filename,
                'close' => true
            ));
        }
        exit;
    }

    public static function upload_single_file()
    {
        if( !empty($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'marketengine') )
        {
            $filename = $_REQUEST['filename'];
            $file = $_FILES[$filename];
            $attachment = self::handle_file($file);
            $close = intval($_REQUEST['removable']);
            
            if($attachment && $filename == 'message_file') {
                $message_data = array(
                    'listing_id' => absint( $_REQUEST['listing_id'] ),
                    'content'    => '[me_message_file id='.$attachment['id'].' ]',
                    'inquiry_id' => absint( $_REQUEST['inquiry_id'] ),
                );
                $result = ME_Inquiry_Handle::insert_message($message_data);
                $message = marketengine_get_message($result);
                marketengine_get_template('inquiry/message-item', array('message' => $message));
                exit;
            }

            marketengine_get_template('upload-file/single-file-form', array(
                'image_id' => $attachment['id'],
                'filename' => $filename,
                'close' => $close,
            ));
        }
        exit;
    }

    public static function handle_file($file)
    {
        $return = false;
        $uploaded_file = wp_handle_upload($file, array('test_form' => false));

        if(isset($uploaded_file['file'])) {
            $file_loc = $uploaded_file['file'];
            $file_name = basename($file['name']);
            $file_type = wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file_loc);
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }
        return $return;
    }

}
ME_Upload_Handle::init_hooks();
