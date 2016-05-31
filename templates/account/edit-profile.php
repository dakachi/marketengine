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
$me_user = ME()->get_current_user();
?>

<form id="edit-rpfile-form" action="" method="post">
	<div class="me-container-fluid">
		<div class="me-row">
			<div class="me-col-md-3">
				<div class="marketengine-avatar-user">
					<a class="avatar-user">
						<?php echo $me_user->get_avatar(); ?>
					</a>
					<span><?php echo $me_user->display_name; ?></span>
				</div>
			</div>
			<div class="me-col-md-9">
				<div class="marketengine-profile-info">
					<div class="me-row">
						<div class="me-col-md-6">
							<div class="marketengine-group-field">
								<div class="marketengine-input-field">
									<label class="text"><?php _e("First name", "enginethemes"); ?></label>
									<input type="text" value="<?php echo $me_user->first_name; ?>">
								</div>
							</div>
						</div>
						<div class="me-col-md-6">
							<div class="marketengine-group-field">
								<div class="marketengine-input-field">
									<label class="text"><?php _e("Last name", "enginethemes"); ?></label>
									<input type="text" value="<?php echo $me_user->last_name; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="marketengine-group-field">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Display name", "enginethemes"); ?></label>
							<input type="text" value="<?php echo $me_user->display_name; ?>">
						</div>
					</div>
					<div class="marketengine-group-field me-no-margin-bottom">
						<div class="marketengine-input-field">
							<label class="text"><?php _e("Location", "enginethemes"); ?></label>
							<input type="text" value="<?php echo $me_user->location; ?>">
						</div>
					</div>

				</div>
				<div class="marketengine-text-field edit-profile">
					<input type="submit" class="marketengine-btn" value="<?php _e("Update Profile", "enginethemes");?>">
				</div>
			</div>
		</div>
	</div>
</form>