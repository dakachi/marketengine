<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/account/user-profile.php.
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$user = ME()->get_current_user();
?>

<?php do_action('marketengine_before_user_profile', $user); ?>

<?php me_print_notices(); ?>

<div class="me-authen-wrap me-authen-profile">

	<?php do_action('marketengine_user_profile_start', $user); ?>

		<div class="marketengine-profile-info">

			<?php do_action('marketengine_before_user_profile_avatar', $user); ?>

			<div class="marketengine-avatar-user">
				<a class="avatar-user">
					<?php echo $user->get_avatar(); ?>
				</a>
			</div>

			<?php do_action('marketengine_after_user_profile_avatar', $user); ?>

			<?php do_action('marketengine_before_user_profile_information', $user); ?>

			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-text-field">
						<label class="me-field-title"><?php _e("First name", "enginethemes");?></label>
						<p><?php echo $user->first_name; ?></p>
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-text-field">
						<label class="me-field-title"><?php _e("Last name", "enginethemes");?></label>
						<p><?php echo $user->last_name; ?></p>
					</div>
				</div>
			</div>
			<div class="marketengine-text-field">
				<label class="me-field-title"><?php _e("Display name", "enginethemes");?></label>
				<p><?php echo $user->display_name; ?></p>
			</div>

			<?php do_action('marketengine_user_profile_information', $user); ?>

			<div class="marketengine-text-field">
				<label class="me-field-title"><?php _e("Username", "enginethemes");?></label>
				<p><?php echo $user->user_login; ?></p>
			</div>
			<div class="marketengine-text-field">
				<label class="me-field-title"><?php _e("Email", "enginethemes");?></label>
				<p><?php echo $user->user_email; ?></p>
			</div>

			<div class="marketengine-text-field">
				<label class="me-field-title">
					<?php _e("Paypal Email <i>(this email will be used for Paypal payment)</i>", "enginethemes"); ?>
				</label>
				<p><?php echo $user->paypal_email ? $user->paypal_email : __('Not yet received info', 'enginethemes'); ?></p>
			</div>

			<div class="marketengine-text-field">
				<label class="me-field-title"><?php _e("Location", "enginethemes");?></label>
				<p><?php echo $user->location ? $user->location : __('Not yet received info', 'enginethemes'); ?></p>
			</div>

			<div class="marketengine-text-field me-no-margin-bottom">
				<label class="me-field-title"><?php _e("About me", "enginethemes");?></label>
				<p><?php echo $user->description ? $user->description : __('Not yet received info', 'enginethemes'); ?></p>
			</div>

			<?php do_action('marketengine_after_user_profile_information', $user); ?>

		</div>
		<div class="marketengine-text-field edit-profile">
			<a href="<?php echo me_get_endpoint_url('edit-profile'); ?>" class="marketengine-btn"><?php _e("Edit Profile", "enginethemes");?></a>
		</div>
		<a href="<?php echo me_get_endpoint_url('change-password'); ?>" class="back-home-sigin me-backlink"><?php _e("Change Password", "enginethemes");?></a>

	<?php do_action('marketengine_user_profile_end', $user); ?>
</div>
<?php do_action('marketengine_after_user_profile', $user); ?>