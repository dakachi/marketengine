<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/reset-pass.php.
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

do_action('marketengine_before_reset_password_form');
?>
<form id="reset-pass-form" action="" method="post">
	<?php do_action('marketengine_reset_password_form_start'); ?>
	<h3><?php _e("RESET PASSWORD", "enginethemes"); ?></h3>
	<?php me_print_notices(); ?>
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label class="text"><?php _e("Enter new password", "enginethemes"); ?></label>
		    <input type="password" name="new_pass">
		</div>
	</div>
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label class="text"><?php _e("Confirm password", "enginethemes"); ?></label>
		    <input type="password" name="confirm_pass">
		</div>
	</div>
	<?php wp_nonce_field('me-reset_password', "_wpnonce");?>
	<div class="marketengine-group-field submit-reset">
		<input type="submit" class="marketengine-btn" name="reset_password" value="<?php _e("SET NEW PASSWORD", "enginethemes"); ?>">
	</div>
	<a href="<?php echo me_get_page_permalink('user-profile'); ?>" class="back-home-sigin"><?php _e("&lt; Cancel", "enginethemes"); ?></a>
	<?php do_action('marketengine_reset_password_form_end'); ?>
</form>
<?php do_action('marketengine_after_reset_password_form'); ?>