<?php
global $current_user;
$user = new ME_User($current_user);
?>
<div class="marketengine marketengine-content">
	<div class="me-container-fluid">
		<div class="me-row">
			<div class="me-col-md-2">
				<div class="marketengine-avatar-user">
					<a class="avatar-user">
						<?php echo get_avatar($current_user->ID); ?>
					</a>
					<span>Test Administrator</span>
				</div>
			</div>
			<div class="me-col-md-10">
				<div class="marketengine-profile-info">
					<div class="me-row">
						<div class="me-col-md-7">
							<div class="me-row">
								<div class="me-col-md-6">
									<div class="marketengine-text-field">
										<span><?php _e("First name", "enginethemes");?></span>
										<p>Text</p>
									</div>
								</div>
								<div class="me-col-md-6">
									<div class="marketengine-text-field">
										<span><?php _e("Last name", "enginethemes");?></span>
										<p>Admin</p>
									</div>
								</div>
							</div>
							<div class="marketengine-text-field">
								<span><?php _e("Display name", "enginethemes");?></span>
								<p>Text	Admin</p>
							</div>
							<div class="marketengine-text-field">
								<span><?php _e("Username", "enginethemes");?></span>
								<p>admin</p>
							</div>
							<div class="marketengine-text-field">
								<span><?php _e("Email", "enginethemes");?></span>
								<p>admin@enginethemes.com</p>
							</div>
							<div class="marketengine-text-field me-no-margin-bottom">
								<span><?php _e("Location", "enginethemes");?></span>
								<p>Vietnamese</p>
							</div>
						</div>
						<div class="me-col-md-5"></div>
					</div>
				</div>
				<div class="marketengine-text-field edit-profile">
					<a href="<?php echo me_get_endpoint_url('edit-profile'); ?>" class="marketengine-btn"><?php _e("EditProfile", "enginethemes");?></a>
				</div>
			</div>
		</div>
	</div>
</div>