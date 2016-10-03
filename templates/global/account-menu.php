<?php if( is_user_logged_in() ) : ?>
<nav class="me-menu-account">
	<select name="" id="" onchange="window.location.href=this.value;">
		<option disabled selected><?php echo __('MY ACCOUNT', 'enginethemes'); ?></option>
		<option value="#"><?php echo __('Dashboard', 'enginethemes'); ?></option>
		<option value="<?php echo me_get_auth_url( 'listings' ); ?>"><?php echo __('My Listing', 'enginethemes'); ?></option>
		<option value="#"><?php echo __('Transactions', 'enginethemes'); ?></option>
		<option value="#"><?php echo __('Inbox', 'enginethemes'); ?></option>
		<option value="<?php echo wp_logout_url( get_the_permalink() ); ?>"><?php echo __('Logout', 'enginethemes'); ?></option>
	</select>
</nav>
<?php else: ?>
	<nav class="me-menu-account">
		<select name="" id="" onchange="window.location.href=this.value;">
			<option disabled selected><?php echo __('MY ACCOUNT', 'enginethemes'); ?></option>
			<option value="<?php echo me_get_page_permalink('user_account'); ?>"><?php echo __('Login', 'enginethemes'); ?></option>
			<?php if( get_option('users_can_register') ) : ?>
			<option value="<?php echo me_get_auth_url( 'register' ); ?>"><?php echo __('Register', 'enginethemes'); ?></option>
			<?php endif; ?>
		</select>
	</nav>
<?php endif; ?>