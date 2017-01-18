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
$user = ME()->get_current_user();
?>

<?php do_action('marketengine_before_change_password_form', $user); ?>

<form id="edit-profile-form" action="" method="post" >

	<?php me_print_notices(); ?>

	<?php do_action('marketengine_change_password_form_start'); ?>

	<div class="marketengine-content">
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="text"><?php _e("Your current password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="current_password" id="current_password">
				</div>
			</div>
		</div>
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="text"><?php _e("New password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="new_password" id="new_password">
				</div>
			</div>
		</div>	
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="text"><?php _e("Confirm password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="confirm_password" id="confirm_password">
				</div>
			</div>
		</div>

		<?php do_action('marketengine_change_password_form'); ?>

		<?php wp_nonce_field('me_change-password'); ?>

		<div class="marketengine-text-field edit-profile">
			<input type="submit" class="marketengine-btn" name="change_password" value="<?php _e("Change password", "enginethemes");?>" />
			<a href="<?php echo me_get_page_permalink('user-profile'); ?>" class="marketengine-btn"><?php _e("Cancel", "enginethemes");?></a>
		</div>
	</div>

	<?php do_action('marketengine_change_password_form_end'); ?>

</form>
<?php do_action('marketengine_after_change_password_form', $user); ?>
