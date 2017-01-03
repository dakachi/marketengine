<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * MarketEngine Dispute Form Handle Class
 *
 * @author         EngineThemes
 * @package         MarketEngine/Includes
 */
class ME_RC_Form_Handle
{
    public static function insert($case_data)
    {
        $sender = get_current_user_id();

        $transaction = me_get_order($case_data['transaction-id']);

        if (!$transaction) {
            return new WP_Error('order_not_found', __('The transaction does not exist.', 'enginethemes'));
        }

        if ($sender != $transaction->post_author) {
            return new WP_Error('permission_dined', __('You can not dispute this transaction.', 'enginethemes'));
        }

        $receiver = $transaction->get_seller();
        if (!$receiver || is_wp_error($receiver)) {
            return new WP_Error('user_not_exists', __('You can not dispute because this user has already remove from system.', 'enginethemes'));
        }

        $error_data = array();

        if (empty($case_data['is_received_item'])) {
            $error_data['invalid_received_item_option'] = __('Did you receive the item?', 'enginethemes');
        }

        if (empty($case_data['dispute_problem'])) {
            $error_data['empty_dispute_problem'] = __('Please tell us your problem.', 'enginethemes');
        }

        if (empty($case_data['dispute_content'])) {
            $error_data['empty_dispute_content'] = __('Please describe something about your problem.', 'enginethemes');
        }

        if (empty($case_data['expect_solution'])) {
            $error_data['empty_expect_solution'] = __('Please choose a resolution you want.', 'enginethemes');
        }

        if (!empty($error_data)) {
            $wp_error = new WP_Error();
            foreach ($error_data as $key => $value) {
                $wp_error->add($key, $value);
            }
            return $wp_error;
        }

        $receiver_id = $receiver->ID;
        $data        = array(
            'post_content' => wp_kses_post($case_data['dispute_content']),
            'post_title'   => 'Dispute transaction #' . $transaction->id,
            'post_type'    => 'dispute',
            'receiver'     => $receiver_id,
            'post_parent'  => $transaction->id,
            'sender'       => $sender,
            'post_status'  => 'me-open',
        );

        $data = array_merge($data, $case_data);
        $case_id = self::create_dispute($data);

        do_action('marketengine_after_dispute', $case_id, $transaction->id, $transaction);

        return $case_id;
    }

    public static function create_dispute($data)
    {
        $case_id = me_insert_message($data);
        if ($case_id) {

            me_update_message_meta($case_id, '_case_problem', $data['dispute_problem']);
            me_update_message_meta($case_id, '_case_problem_description', $data['dispute_content']);
            me_update_message_meta($case_id, '_case_expected_resolution', $data['expect_solution']);

            if ($data['is_received_item']) {
                me_update_message_meta($case_id, '_case_is_received_item', $data['is_received_item']);
            }
            $data['post_parent'] = $case_id;
            self::create_debate($data);
            self::email_seller($data);
        }
        return $case_id;
    }

    public static function create_debate($data)
    {
        $data['post_type'] = 'message';
        if (!empty($data['dispute_file'])) {
            $data['post_content'] .= '[me_message_file id=' . join(',', $data['dispute_file']) . ' ]';
        }

        return me_insert_message($data);

    }

    public static function email_seller() {
        $subject = __("There is a dispute for your transaction.", "enginethemes");
    }
}
