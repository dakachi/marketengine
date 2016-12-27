<?php
/**
 * MarketEngine Resolution Center Functions
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Includes
 * @category 	Functions
 *
 * @version     1.0.0
 * @since 		1.0.1
 */

/**
 * Returns the url of resolution center
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function me_resolution_center_url() {
	return me_get_auth_url('resolution-center');
}

function me_rc_status_list() {
	$statuses = array(
		'me-open'		=> __('Open', 'enginethemes'),
		'me-waiting'	=> __('Waiting', 'enginethemes'),
		'me-escalated'	=> __('Escalated', 'enginethemes'),
		'me-closed'		=> __('Closed', 'enginethemes'),
		'me-resolved'	=> __('Resolved', 'enginethemes'),
	);

	return apply_filters('me_rc_statuses', $statuses);
}

function me_rc_dispute_problems() {
	$problems =  array(
		'problem-1'		=> __('Problem 1', 'enginethemes'),
		'problem-2'		=> __('Problem 2', 'enginethemes'),
		'problem-3'		=> __('Problem 3', 'enginethemes'),
		'problem-4'		=> __('Problem 4', 'enginethemes'),
	);

	return apply_filters('me_rc_dispute_problems', $problems);
}

function me_rc_expected_resolutions( $is_received_item = false ) {
	if($is_received_item) {
		$resolutions = array(
			'partial-refund' 	=> array(
				'label'			=> __('Get refund only', 'enginethemes'),
				'description'	=> __('(keep the item and negotiate a partial refund with the seller)', 'enginethemes'),
			),
			'return-item' 		=> array(
				'label'			=> __('Return &amp; get refund', 'enginethemes'),
				'description'	=> __('(return the item and request a full refund)', 'enginethemes'),
			),
			'item-replaced' 	=> array(
				'label'			=> __('Get item replaced', 'enginethemes'),
				'description'	=> __('(get a replaced item without refund)', 'enginethemes'),
			),
		);
		$resolutions = apply_filters('me_rc_expected_resolutions_if_received_item', $resolutions);
	} else {
		$resolutions = array(
			'full-refund' 	=> array(
				'label'			=> __('Get full refund', 'enginethemes'),
				'description'	=> __('(request the money back for item not received)', 'enginethemes'),
			),
			'receive-item' 		=> array(
				'label'			=> __('Get the item', 'enginethemes'),
				'description'	=> __('(request the item shipped)', 'enginethemes'),
			),
		);
		$resolutions = apply_filters('me_rc_expected_resolutions_if_no_received_item', $resolutions);
	}
	return $resolutions;
}