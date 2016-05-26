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

if (get_option('users_can_register')):
?>

	<?php do_action('marketengine_before_user_register_form', $arg = '');?>

	<form id="register-form" action="" method="post">
		<?php do_action('marketengine_user_register_form_start');?>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="username"><?php _e("Username", "enginethemes");?></label>
			    <input type="text" name="username" id="username" value="<?php if (!empty($_POST['user_login'])) {echo esc_attr($_POST['user_login']);}?>">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
					    <label for="firstname"><?php _e("First name", "enginethemes");?></label>
					    <input type="text" name="firstname" id="firstname" value="<?php if (!empty($_POST['firstname'])) {echo esc_attr($_POST['firstname']);}?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
					    <label for="lastname"><?php _e("Last name", "enginethemes");?></label>
					    <input type="text" name="lastname" id="lastname" value="<?php if (!empty($_POST['lastname'])) {echo esc_attr($_POST['lastname']);}?>">
					</div>
				</div>
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="user_email"><?php _e("Email", "enginethemes");?></label>
			    <input type="text" name="user_email" id="user_email" value="<?php if (!empty($_POST['user_email'])) {echo esc_attr($_POST['user_email']);}?>" >
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="password"><?php _e("Create password", "enginethemes");?></label>
			    <input type="password" name="password" id="password">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="confirm-password"><?php _e("Confirm password", "enginethemes");?></label>
			    <input type="password" name="confirm-password" id="confirm-password">
			</div>
		</div>

		<?php do_action('marketengine_user_register_form');?>

		<div class="marketengine-group-field terms-signup">
			<div class="marketengine-checkbox-field">
				<label for="agree-with-tos">
					<input id="agree-with-tos" name="agree-with-tos" type="checkbox"><?php printf(__("I agree to the site's <a href=''>Terms of Service</a>", "enginethemes"));?>
				</label>
			</div>
		</div>
		<div class="marketengine-group-field submit-signup">
			<input class="marketengine-btn disable" type="submit" name="register" value="Sign up">
		</div>
		<a href="#" class="back-home-sigin">&lt; <?php _e("Back to Home", "enginethemes");?></a>
		<?php wp_nonce_field('me-register');?>
		<?php do_action('marketengine_user_register_form_end');?>
	</form>
<?php
endif;