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
	if ( $transaction->post_author == get_current_user_id() && 'me-pending' !== $transaction->post_status && $dispute_time_limit) {
		// echo '<div class="me-hidden-sm me-hidden-xs">';
		me_get_template('resolution/order/dispute-button', array('transaction' => $transaction, 'dispute_time_limit' => $dispute_time_limit));
		// echo '</div>';
	}
}
add_action( 'marketengine_order_extra_content', 'me_rc_dispute_button', 11);

/**
 * Load the resolution link template
 * @param object $transaction The me order object
 */
function me_rc_center_link($transaction) {
	if ('me-disputed' === $transaction->post_status ) {
		$case = new ME_Message_Query(array('post_type' => 'dispute', 'post_parent' => $transaction->id));
		$case = array_pop($case->posts);
		$case_id = $case->ID;
		me_get_template('resolution/order/resolution-link', array('transaction' => $transaction , 'case' => $case_id));
	}
}
/**
 * Render order resolution center link
 * @since 1.1
 */
function me_rc_center_desktop_link($transaction) {
	// echo '<div class="me-hidden-sm me-hidden-xs">';
	me_rc_center_link($transaction);
	// echo '</div>';
}
add_action( 'marketengine_order_extra_content', 'me_rc_center_desktop_link', 11);

/**
 * Render order dispute button link on mobile
 * @since 1.1
 */
function me_rc_mobile_dispute_button($transaction) {
	$dispute_time_limit = $transaction->get_dispute_time_limit() ;
	if ( $transaction->post_author == get_current_user_id() && 'me-pending' !== $transaction->post_status && $dispute_time_limit) {
		echo '<div class="me-visible-sm me-visible-xs">';
		me_get_template('resolution/order/dispute-button', array('transaction' => $transaction, 'dispute_time_limit' => $dispute_time_limit));
		echo '</div>';
	}
}
// add_action( 'marketengine_order_extra_end', 'me_rc_mobile_dispute_button', 11);

/**
 * Render order resolution center link
 * @since 1.1
 */
function me_rc_center_mobile_link($transaction) {
	// echo '<div class="me-visible-sm me-visible-xs">';
	me_rc_center_link($transaction);
	// echo '</div>';
}
// add_action( 'marketengine_order_extra_end', 'me_rc_center_mobile_link', 11);

/**
 * Transaction dispute form
 *
 * @param string $action The action dispute user send
 * @param object $transaction The current transaction user want to dispute
 *
 * @since 1.1
 */
function me_transaction_dispute_form($action, $transaction)
{
    if ('dispute' === $action) {
        me_get_template('resolution/form/dispute-form', array('transaction' => $transaction));
    }
}
add_action('marketengine_order_details_action', 'me_transaction_dispute_form', 10, 2);

/**
 * Add a dispute to the transaction breadcrum
 * @since 1.1
 */
function me_transaction_dispute_breadcrumb() {
    if(!empty($_GET['action']) && 'dispute' == $_GET['action'] ) : ?>
        <li><a href="#"><?php _e("Dispute", "enginethemes"); ?></a></li>
    <?php endif; 
}
add_action( 'marketengine_order_breadcrumb_end', 'me_transaction_dispute_breadcrumb' );