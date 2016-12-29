<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Render order dispute button link on desktop
 * @since 1.1
 */
function me_rc_dispute_button($transaction) {
	$dispute_time_limit = $transaction->get_dispute_time_limit() ;
	if ('me-pending' !== $transaction->post_status && $dispute_time_limit) {
		echo '<div class="me-hidden-sm me-hidden-xs">';
		me_get_template('resolution/dispute-button', array('transaction' => $transaction, 'dispute_time_limit' => $dispute_time_limit));	
		echo '</div>';
	}
}
add_action( 'marketengine_order_extra_content', 'me_rc_dispute_button', 11);


/**
 * Render order dispute button link on mobile
 * @since 1.1
 */
function me_rc_mobile_dispute_button($transaction) {
	$dispute_time_limit = $transaction->get_dispute_time_limit() ;
	if ('me-pending' !== $transaction->post_status && $dispute_time_limit) {
		echo '<div class="me-visible-sm me-visible-xs">';
		me_get_template('resolution/dispute-button', array('transaction' => $transaction, 'dispute_time_limit' => $dispute_time_limit));	
		echo '</div>';
	}
}
add_action( 'marketengine_order_extra_end', 'me_rc_mobile_dispute_button', 11);

/**
 * Render order resolution center link
 * @since 1.1
 */
function me_rc_center_link($transaction) {
	if ('me-disputed' === $transaction->post_status ) {
		$case = '';
		me_get_template('resolution/resolution-link', array('transaction' => $transaction , 'case' => $case));	
	}
}
add_action( 'marketengine_order_extra_content', 'me_rc_center_link', 11);