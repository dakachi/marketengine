<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/form-login.php.
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$notices = me_get_notices();
echo "<pre>";
print_r($notices);
echo "</pre>";
me_empty_notices();

do_action('marketengine_before_user_login_form');
if (get_option('users_can_register')):
?>
<form id="login-form" action="" method="post">
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label for="username"><?php _e("Email/Username", "enginethemes");?></label>
		    <input type="text" name="user_login" id="username">
		</div>
	</div>
	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label for="password"><?php _e("Password", "enginethemes");?></label>
		    <input type="password" name="user_password" id="password">
		</div>
	</div>
	<div class="marketengine-group-field submit-sigin">
		<input type="submit" class="marketengine-btn" value="login">
	</div>
	<div class="marketengine-group-field forgot-sigin">
		<a href="#" class="forgot-pass"><?php _e("Forgot password?", "enginethemes");?></a>
		<span class="account-register"><?php _e("Need an account?", "enginethemes");?><a href="#"><?php _e("Register", "enginethemes");?></a></span>
	</div>
	<a href="#" class="back-home-sigin">&lt; <?php _e("Back to Home", "enginethemes");?></a>
	<input type="hidden" name="login" value="1" />
	<?php wp_nonce_field('me-login', "_wpnonce");?>
</form>
<?php endif;
