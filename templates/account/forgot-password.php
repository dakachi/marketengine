<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/forgot-password.php.
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<form id="forgot-password-form" action="" method="post">
	<h3><?php _e("Forgot Password", "enginethemes"); ?></h3>
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <span class="text"><?php _e("Enter your email", "enginethemes"); ?></span>
		    <input type="email" name="email">
		</div>
	</div>
	<div class="marketengine-group-field submit-forgot">
		<input type="submit" class="marketengine-btn" value="<?php _e("Submit", "enginethemes"); ?>">
	</div>
	<a href="<?php echo me_get_page_permalink('user-profile'); ?>" class="back-home-sigin"><?php _e("&lt; Back to login", "enginethemes"); ?></a>
</form>
