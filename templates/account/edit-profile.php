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

<?php do_action('marketengine_before_edit_user_profile_form', $user); ?>

<form id="edit-profile-form" action="" method="post" >

	<?php me_print_notices(); ?>

	<?php do_action('marketengine_edit_user_profile_form_start', $user); ?>

	<div class="marketengine-content">
		<div class="marketengine-profile-info">
			<?php do_action('marketengine_before_edit_user_avatar', $user); ?>
			<div class="marketengine-avatar-user">
				<a class="avatar-user">
					<?php echo $user->get_avatar(); ?>
					<span class="change-avatar-user">
						<i class="icon-uploadprofileimage"></i>
					</span>
				</a>
			</div>

			<?php do_action('marketengine_after_edit_user_avatar', $user); ?>

			<?php do_action('marketengine_before_edit_user_profile', $user); ?>

			<div class="me-row">
				<div class="me-col-md-6">
					<div class="marketengine-group-field">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("First name", "enginethemes");?></label>
							<input type="text" value="<?php echo $user->first_name; ?>" name="first_name" id="first_name" />
						</div>
					</div>
				</div>
				<div class="me-col-md-6">
					<div class="marketengine-group-field">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Last name", "enginethemes");?></label>
							<input type="text" value="<?php echo $user->last_name; ?>" name="last_name" id="last_name">
						</div>
					</div>
				</div>
			</div>
			<div class="marketengine-group-field">
				<div class="marketengine-input-field">
					<label class="text"><?php _e("Display name", "enginethemes");?></label>
					<select name="display_name" id="display_name">
						<?php
						$public_display = array();
						$public_display['display_nickname'] = $user->nickname;
						$public_display['display_username'] = $user->user_login;

						if ($user->first_name) {
						    $public_display['display_firstname'] = $user->first_name;
						}

						if ($user->last_name) {
						    $public_display['display_lastname'] = $user->last_name;
						}

						if ($user->first_name && $user->last_name) {
						    $public_display['display_firstlast'] = $user->first_name . ' ' . $user->last_name;
						    $public_display['display_lastfirst'] = $user->last_name . ' ' . $user->first_name;
						}

						if (!in_array($user->display_name, $public_display)) // Only add this if it isn't duplicated elsewhere
						{
						    $public_display = array('display_displayname' => $user->display_name) + $public_display;
						}

						$public_display = array_map('trim', $public_display);
						$public_display = array_unique($public_display);
						var_dump($public_display);
						foreach ($public_display as $id => $item) {
    					?>
							<option <?php selected($user->display_name, $item);?>><?php echo $item; ?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>

			<?php do_action('marketengine_edit_user_profile', $user); ?>

			<div class="marketengine-group-field me-no-margin-bottom">
				<div class="marketengine-input-field">
					<label class="text"><?php _e("Location", "enginethemes");?></label>
					<input type="text" value="<?php echo $user->location; ?>" name="location" id="location">
				</div>
			</div>
			<?php wp_nonce_field('me-update_profile'); ?>
			<?php do_action('marketengine_after_edit_user_profile', $user); ?>
		</div>
		<div class="marketengine-text-field edit-profile">
			<input type="submit" class="marketengine-btn" name="update_profile" value="<?php _e("Update Profile", "enginethemes");?>" />
			<a href="<?php echo me_get_page_permalink('user-profile'); ?>" class="marketengine-btn"><?php _e("Cancel", "enginethemes");?></a>
		</div>
	</div>

	<?php do_action('marketengine_edit_user_profile_form_end', $user); ?>

</form>
<?php do_action('marketengine_after_edit_user_profile_form', $user); ?>