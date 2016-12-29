<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
function me_rc_button($transaction) {
	me_get_template('resolution/dispute-button', array('transaction' => $transaction));
}
add_action( 'marketengine_order_extra_content', 'me_rc_button', 11);
