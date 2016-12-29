<?php

/**
* MarketEngine Dispute Form Handle Class
*
* @author 		EngineThemes
* @package 		MarketEngine/Includes
*/
class ME_Dispute_Form_Handle {
	public static function insert($case_data) {
		$sender = get_current_user_id();

		$transaction = me_get_order($case_data['transaction-id']);

		$listings = $transaction->get_listing_items();
		$listing_item = array_pop($listings);
		$listing_obj = me_get_listing($listing_item['ID']);

		$receiver = $listing_obj->post_author;

		if(empty($case_data['me-receive-item'])) {
			return new WP_Error('invalid_received_item_option', __('Did you receive the item?', 'enginethemes'));
		}

		if(empty($case_data['me-dispute-problem'])) {
			return new WP_Error('empty_dispute_problem', __('Please tell us your problem.', 'enginethemes'));
		}

		if(empty($case_data['me-dispute-problem-description'])) {
			return new WP_Error('empty_dispute_problem_description', __('Please describe something about your problem.', 'enginethemes'));
		}

		if(empty($case_data['me-dispute-get-refund'])) {
			return new WP_Error('empty_expected_solution', __('Please choose a resolution you want.'));
		}

		$default = array(
            'post_content' => 'Dispute transaction #' . $transaction->id,
            'post_title'   => 'Dispute transaction #' . $transaction->id,
            'post_type'    => 'dispute',
            'receiver'     => $receiver,
            'post_parent'  => $transaction->id,
            'sender'       => $sender,
            'post_status'  => 'me-open',
        );

        $case = me_insert_message($default);

        //TODO: change order status
        //TODO: add dispute case meta
        self::update_dispute_case_meta($case, $case_data);

        do_action('marketengine_after_insert_dispute_case', $case, $transaction);

        return $case;
	}

	public static function update_dispute_case_meta($case_id, $data) {
		//TODO: luu bang message itemmeta
		update_post_meta($case_id, '_case_problem', $data['me-dispute-problem']);
		update_post_meta($case_id, '_case_problem_description', $data['me-dispute-problem-description']);
		update_post_meta($case_id, '_case_expected_resolution', $data['me-dispute-get-refund']);

		if($data['me-receive-item']) {
			update_post_meta($case_id, '_case_is_received_item', $data['me-receive-item']);
		}

		//TODO: process case media
		if(!empty($data['me-dispute-media'])) {
			// update_post_meta($case_id, '_case_media', $data['me-dispute-media']);
		}
	}
}