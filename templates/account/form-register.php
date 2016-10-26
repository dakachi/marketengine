<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/form-register.php.
 *
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
if (get_option('users_can_register')):
?>

	<?php do_action('marketengine_before_user_register_form');?>
<div class="marekengine-authen-wrap authen-register">

	<form id="register-form" action="" method="post">

		<h3><?php _e("Register", "enginethemes"); ?></h3>

		<?php me_print_notices(); ?>
		<?php do_action('marketengine_user_register_form_start');?>

		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="username"><?php _e("User Login", "enginethemes");?></label>
			    <input type="text" name="user_login" class="required" id="username" value="<?php if (!empty($_POST['user_login'])) {echo esc_attr($_POST['user_login']);}?>">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
					    <label for="firstname"><?php _e("First name", "enginethemes");?></label>
					    <input type="text" name="first_name" id="firstname" value="<?php if (!empty($_POST['first_name'])) {echo esc_attr($_POST['first_name']);}?>">
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-input-field">
					    <label for="lastname"><?php _e("Last name", "enginethemes");?></label>
					    <input type="text" name="last_name" id="lastname" value="<?php if (!empty($_POST['last_name'])) {echo esc_attr($_POST['last_name']);}?>">
					</div>
				</div>
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="user_email"><?php _e("Email", "enginethemes");?></label>
			    <input type="email" name="user_email" class="required email" id="user_email" value="<?php if (!empty($_POST['user_email'])) {echo esc_attr($_POST['user_email']);}?>" >
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="password"><?php _e("Create password", "enginethemes");?></label>
			    <input type="password" name="user_pass" class="required" id="password">
			</div>
		</div>
		<div class="marketengine-group-field">
			<div class="marketengine-input-field">
			    <label for="confirm-password"><?php _e("Confirm password", "enginethemes");?></label>
			    <input type="password" name="confirm_pass" class="required" id="confirm-password">
			</div>
		</div>

		<?php do_action('marketengine_user_register_form');?>

		<?php if (!empty($_REQUEST['redirect'])): ?>
			<input type="hidden" name="redirect" value="<?php echo $_REQUEST['redirect']; ?>" />
		<?php endif;?>

		<div class="marketengine-group-field me-terms-signup">
			<div class="marketengine-checkbox-field">
				<label for="agree-with-tos">
					<input id="agree-with-tos" name="agree_with_tos" class="required" type="checkbox"><?php printf(__("I agree to the site's <a href=''>Terms of Service</a>", "enginethemes"));?>
				</label>
			</div>
		</div>
		<div class="marketengine-group-field me-submit-signup">
			<input class="marketengine-btn me-submit-signup-btn disable" type="submit" name="register" value="<?php _e("Sign up", "enginethemes")?>">
		</div>
		<a href="<?php echo home_url(); ?>" class="back-home-sigin">&lt; <?php _e("Back to Home", "enginethemes");?></a>
		<?php wp_nonce_field('me-register');?>
		<?php do_action('marketengine_user_register_form_end');?>
	</form>
</div>
<?php
endif;
	do_action('marketengine_before_user_register_form');