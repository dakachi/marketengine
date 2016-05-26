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
?>
	<form id="login-form" action="" method="post">

	<?php do_action('marketengine_user_login_form_start');?>

		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="username"><?php _e("Email/Username", "enginethemes");?></label>
			    <input type="text" name="user_login" id="username" value="<?php if (!empty($_POST['user_login'])) {echo esc_attr($_POST['user_login']);}?>">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="password"><?php _e("Password", "enginethemes");?></label>
			    <input type="password" name="user_password" id="password">
			</div>
		</div>

		<?php do_action('marketengine_user_login_form');?>

		<div class="marketengine-group-field submit-sigin">
			<input type="submit" class="marketengine-btn" name="login" value="login">
		</div>
		<div class="marketengine-group-field forgot-sigin">
			<a href="#" class="forgot-pass"><?php _e("Forgot password?", "enginethemes");?></a>
			<span class="account-register"><?php _e("Need an account?", "enginethemes");?><a href="#"><?php _e("Register", "enginethemes");?></a></span>
		</div>
		<a href="#" class="back-home-sigin">&lt; <?php _e("Back to Home", "enginethemes");?></a>

		<?php wp_nonce_field('me-login', "_wpnonce");?>

		<?php do_action('marketengine_user_login_form_end');?>
	</form>

<?php
do_action('marketengine_after_user_login_form');