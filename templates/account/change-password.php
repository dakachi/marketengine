<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/change-password.php.
 *
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php do_action('marketengine_before_change_password_form', $user); ?>

<form id="edit-profile-form" action="" method="post" >


	<?php do_action('marketengine_change_password_form_start'); ?>

	<div class="me-authen-wrap me-authen-change">

		<?php me_print_notices(); ?>
		
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="me-field-title"><?php _e("Your current password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="current_password" id="current_password">
				</div>
			</div>
		</div>
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="me-field-title"><?php _e("New password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="new_password" id="new_password">
				</div>
			</div>
		</div>
		<div class="marketengine-profile-info">
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="me-field-title"><?php _e("Confirm password", "enginethemes");?></label>
					<input class="required" type="password" value="" name="confirm_password" id="confirm_password">
				</div>
			</div>
		</div>

		<?php do_action('marketengine_change_password_form'); ?>

		<?php wp_nonce_field('me_change-password'); ?>

		<div class="marketengine-text-field edit-profile">
			<input type="submit" class="marketengine-btn" name="change_password" value="<?php _e("CHANGE PASSWORD", "enginethemes");?>" />
		</div>
		<a href="<?php echo me_get_page_permalink('user_account'); ?>" class="back-home-sigin me-backlink"><?php _e("&lt; My profile", "enginethemes");?></a>
	</div>

	<?php do_action('marketengine_change_password_form_end'); ?>

</form>
<?php do_action('marketengine_after_change_password_form', $user); ?>
