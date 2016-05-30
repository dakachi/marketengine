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

?>
<div class="marekengine-authen-wrap authen-reset">
	<form id="reset-pass-form" action="" method="post">
		<h3>RESET PASSWORD</h3>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label class="text">Enter new password</label>
			    <input type="password" name="user_pass">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label class="text">Confirm password</label>
			    <input type="password" name="confirm_pass">
			</div>
		</div>
		<div class="marketengine-group-field submit-reset">
			<input type="submit" class="marketengine-btn" value="SET NEW PASSWORD">
		</div>
		<a href="#" class="back-home-sigin">&lt; Cancel</a>
	</form>
</div>