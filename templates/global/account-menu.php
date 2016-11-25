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
	<!-- <select class="" name="" id="" onchange="window.location.href=this.value;">
		<option disabled selected><?php //echo get_the_author_meta('display_name', get_current_user_id()); ?></option>
		<option value="<?php //echo me_get_auth_url( 'listings' ); ?>"><?php //echo __('My Listings', 'enginethemes'); ?></option>
		<option value="<?php //echo me_get_auth_url( 'orders' ); ?>"><?php //echo __('My Orders', 'enginethemes'); ?></option>
		<option value="<?php //echo me_get_auth_url( 'purchases' ); ?>"><?php //echo __('My Purchases', 'enginethemes'); ?></option>
		<option value="<?php //echo me_get_page_permalink( 'user_account' ); ?>"><?php //echo __('My Profile', 'enginethemes'); ?></option>
		<option value="<?php //echo wp_logout_url( get_the_permalink() ); ?>"><?php //echo __('Logout', 'enginethemes'); ?></option>
	</select> -->
	<span class="me-my-account"><?php echo get_the_author_meta('display_name', get_current_user_id()); ?></span>
	<ul class="me-account-list">
		<li><a href="<?php echo me_get_auth_url( 'listings' ); ?>"><?php echo __('My Listings', 'enginethemes'); ?></a></li>
		<li><a href="<?php echo me_get_auth_url( 'orders' ); ?>"><?php echo __('My Orders', 'enginethemes'); ?></a></li>
		<li><a href="<?php echo me_get_auth_url( 'purchases' ); ?>"><?php echo __('My Purchases', 'enginethemes'); ?></a></li>
		<li><a href="<?php echo me_get_page_permalink( 'user_account' ); ?>"><?php echo __('My Profile', 'enginethemes'); ?></a></li>
		<li><a href="<?php echo wp_logout_url( get_the_permalink() ); ?>"><?php echo __('Logout', 'enginethemes'); ?></a></li>
	</ul>
</nav>
<?php else: ?>
	<nav class="me-menu-account">
		<!-- <select class="" name="" id="" onchange="window.location.href=this.value;">
			<option disabled selected><?php //echo __('MY ACCOUNT', 'enginethemes'); ?></option>
			<option value="<?php //echo me_get_page_permalink('user_account'); ?>"><?php //echo __('Login', 'enginethemes'); ?></option>
			<?php //if( get_option('users_can_register') ) : ?>
			<option value="<?php //echo me_get_auth_url( 'register' ); ?>"><?php //echo __('Register', 'enginethemes'); ?></option>
			<?php //endif; ?>
		</select> -->

		<span class="me-my-account"><?php echo __('MY ACCOUNT', 'enginethemes'); ?></span>
		<ul class="me-account-list">
			<li><a href="<?php echo me_get_page_permalink('user_account'); ?>"><?php echo __('Login', 'enginethemes'); ?></a></li>
			<?php if( get_option('users_can_register') ) : ?>
			<li><a href="<?php echo me_get_auth_url( 'register' ); ?>"><?php echo __('Register', 'enginethemes'); ?></a></li>
			<?php endif; ?>
			
		</ul>
	</nav>
<?php endif; ?>