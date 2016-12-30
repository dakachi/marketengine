<?php
/**
 * MarketEngine Resolution Center Functions
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Includes
 * @category 	Functions
 *
 * @version     1.0.0
 * @since 		1.1.0
 */

/**
 * Returns the url of resolution center
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_resolution_center_url() {
	return me_get_auth_url('resolution-center');
}

/**
 * Returns dispute case statuses.
 *
 * @return array $statuses
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_statuses() {
	$statuses = array(
		'me-open'		=> __('Open', 'enginethemes'),
		'me-waiting'	=> __('Waiting', 'enginethemes'),
		'me-escalated'	=> __('Escalated', 'enginethemes'),
		'me-closed'		=> __('Closed', 'enginethemes'),
		'me-resolved'	=> __('Resolved', 'enginethemes'),
	);

	return apply_filters('me_rc_statuses', $statuses);
}

/**
 * Returns the label of a dispute case status.
 *
 * @param 	string $status_name
 * @return 	string status label
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_status_label($status_name) {
	$statuses = me_rc_statuses();
	return $statuses[$status_name];
}

/**
 * Returns dispute problem options.
 *
 * @return 	array $problems
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_dispute_problems() {
	$problems =  array(
		'problem-1'		=> __('Problem 1', 'enginethemes'),
		'problem-2'		=> __('Problem 2', 'enginethemes'),
		'problem-3'		=> __('Problem 3', 'enginethemes'),
		'problem-4'		=> __('Problem 4', 'enginethemes'),
	);

	return apply_filters('me_rc_dispute_problems', $problems);
}

/**
 * Returns the label of a problem.
 *
 * @param 	string $problem_name
 * @return 	string problem label
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_dispute_problem_label($problem_name) {
	$problems = me_rc_dispute_problems();
	return $problems[$problem_key];
}

/**
 * @todo chia ra thanh 2 ham
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_expected_solutions( $is_received_item = false ) {
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
	}

	return apply_filters('me_rc_expected_solutions', $resolutions, $is_received_item);
}

/**
 * Returns the dispute case query.
 *
 * @since 	1.1.0
 * @version 1.0.0
 */
function me_rc_dispute_case_query() {
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	$args = array(
		'post_type'		=> 'dispute',
		'paged'			=> $paged,
		'sender'		=> get_current_user_id(),
		'receiver'		=> get_current_user_id(),
	);

	// $args = array_merge(apply_filters( 'me_filter_inquiry', $_GET, $role ), $args);
	$query = new ME_Message_Query($args);

	return $query;
}