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
function me_dispute_statuses() {
	$statuses = array(
		'me-open'		=> __('Open', 'enginethemes'),
		'me-waiting'	=> __('Waiting', 'enginethemes'),
		'me-escalated'	=> __('Escalated', 'enginethemes'),
		'me-closed'		=> __('Closed', 'enginethemes'),
		'me-resolved'	=> __('Resolved', 'enginethemes'),
	);

	return apply_filters('me_dispute_statuses', $statuses);
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
function me_dispute_status_label($status_name) {
	$statuses = me_dispute_statuses();
	return $status_name ? $statuses[$status_name] : '';
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
	return $problem_name ? $problems[$problem_name] : '';
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
function me_rc_dispute_case_query($query) {
	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	$args = array(
		'post_type'		=> 'dispute',
		'paged'			=> $paged,
		'sender'		=> get_current_user_id(),
		'receiver'		=> get_current_user_id(),
	);

	$args = array_merge(apply_filters( 'me_filter_dispute_case', $query), $args);
	$query = new ME_Message_Query($args);

	return $query;
}

function me_dispute_case_id_by_user( $user ) {
    global $wpdb;
    $query = "SELECT $wpdb->marketengine_message_item.ID
        FROM $wpdb->marketengine_message_item
        LEFT JOIN $wpdb->users
        ON ($wpdb->marketengine_message_item.sender = $wpdb->users.ID
        	OR $wpdb->marketengine_message_item.receiver = $wpdb->users.ID)
        WHERE $wpdb->marketengine_message_item.post_type = 'dispute'
        AND $wpdb->users.display_name LIKE '%{$user}%'";

    $results = $wpdb->get_col($query);

    return $results;
}

function me_filter_dispute_case( $query ) {
	$args = array();
	if(!empty($query['status']) && $query['status'] !== 'any') {
		$args['post_status'] = $query['status'];
	}

	if (isset($query['from_date']) || isset($query['to_date'])) {
        $before = $after = '';
        if (isset($query['from_date']) && !empty($query['from_date'])) {
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $query['from_date'])) {
                $after = $query['from_date'] . ' 0:0:1';
            } else {
                $args['post__in'][] = -1;
                return $args;
            }
        }

        if (isset($query['to_date']) && !empty($query['to_date'])) {
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $query['to_date'])) {
                $before = $query['to_date'] . ' 23:59:59';
            } else {
                $args['post__in'][] = -1;
                return $args;
            }
        }

        $args['date_query'] = array(
            array(
                'after'  => $after,
                'before' => $before,
            ),
        );
    }

    if( !empty($query['keyword']) ) {
        $case_id = is_numeric( $query['keyword'] ) ? $query['keyword'] : '';

        $ids = me_dispute_case_id_by_user($query['keyword']);
        if($case_id) {
        	$ids = array_merge($ids, array($case_id));
        }

        if(empty($ids)) {
        	$args['post__in'][] = -1;
        } else {
        	$args['post__in'] = $ids;
        }
    }

	return $args;
}
add_filter('me_filter_dispute_case', 'me_filter_dispute_case');

function me_dispute_case_filter_form_action() {
	global $wp;
	if ('' === get_option('permalink_structure')) {
	    $form_action = remove_query_arg(array('page', 'paged'), add_query_arg($wp->query_string, '', home_url($wp->request)));
	} else {
	    $form_action = preg_replace('%\/page/[0-9]+%', '', home_url(trailingslashit($wp->request)));
	}
	echo $form_action;
	return $form_action;
}

/**
 * Transaction dispute form
 *
 * @param string $action The action dispute user send
 * @param object $transaction The current transaction user want to dispute
 * 
 * @since 1.1 
 */
function me_transaction_dispute_form($action, $transaction) {
    if('dispute' === $action ) {
        me_get_template('resolution/dispute-form', array('transaction' => $transaction));
    }
}
add_action( 'marketengine_order_details_action', 'me_transaction_dispute_form', 10, 2 );