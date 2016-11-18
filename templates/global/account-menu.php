<?php
/**
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/account-menu.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */
?>
<?php if( is_user_logged_in() ) : ?>
<nav class="me-menu-account">
	<select class="me-chosen-select" name="" id="" onchange="window.location.href=this.value;">
		<option disabled selected><?php echo get_the_author_meta('display_name', get_current_user_id()); ?></option>
		<option value="<?php echo me_get_auth_url( 'listings' ); ?>"><?php echo __('My Listings', 'enginethemes'); ?></option>
		<option value="<?php echo me_get_auth_url( 'purchases' ); ?>"><?php echo __('Transactions', 'enginethemes'); ?></option>
		<option value="<?php echo me_get_auth_url( 'orders' ); ?>"><?php echo __('Orders', 'enginethemes'); ?></option>
		<option value="<?php echo me_get_page_permalink( 'user_account' ); ?>"><?php echo __('My Profile', 'enginethemes'); ?></option>
		<option value="<?php echo wp_logout_url( get_the_permalink() ); ?>"><?php echo __('Logout', 'enginethemes'); ?></option>
	</select>
</nav>
<?php else: ?>
	<nav class="me-menu-account">
		<select class="me-chosen-select" name="" id="" onchange="window.location.href=this.value;">
			<option disabled selected><?php echo __('MY ACCOUNT', 'enginethemes'); ?></option>
			<option value="<?php echo me_get_page_permalink('user_account'); ?>"><?php echo __('Login', 'enginethemes'); ?></option>
			<?php if( get_option('users_can_register') ) : ?>
			<option value="<?php echo me_get_auth_url( 'register' ); ?>"><?php echo __('Register', 'enginethemes'); ?></option>
			<?php endif; ?>
		</select>
	</nav>
<?php endif; ?>