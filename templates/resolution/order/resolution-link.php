<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="me-orderwarning-info">
	<p><?php echo __('This order has been disputed. In order to resolve problems, move to resolution center', 'enginethemes'); ?></p>
	<a href="<?php echo me_rc_dispute_link($case); ?>" class="me-resolution-center"><?php _e('To the disputed case', 'enginethemes'); ?></a>
</div>