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

<?php do_action('marketengine_before_forgot_password_form');?>

<form id="forgot-password-form" action="" method="post">
	<h3><?php _e("Forgot Password", "enginethemes"); ?></h3>

	<?php me_print_notices(); ?>
	<?php do_action('marketengine_forgot_password_form_start');?>

	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <span class="text"><?php _e("Enter your email", "enginethemes"); ?></span>
		    <input class="required email" type="email" name="user_email" value="<?php if (!empty($_POST['user_email'])) {echo esc_attr($_POST['user_email']);}?>">
		</div>
	</div>

	<?php do_action('marketengine_forgot_password_form');?>
	<?php wp_nonce_field( 'me-forgot_pass'); ?>

	<div class="marketengine-group-field submit-forgot">
		<input type="submit" class="marketengine-btn" name="forgot_pass" value="<?php _e("Submit", "enginethemes"); ?>">
	</div>
	<a href="<?php echo me_get_page_permalink('user-profile'); ?>" class="back-home-sigin"><?php _e("&lt; Back to login", "enginethemes"); ?></a>

	<?php do_action('marketengine_forgot_password_form_start');?>
</form>
<?php do_action('marketengine_after_forgot_password_form');?>