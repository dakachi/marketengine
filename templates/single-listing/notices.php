<?php if(!me_is_activated_user()) : ?>

<div class="me-authen-active">

	<?php if( me_get_notices() ) : ?>

		<?php me_print_notices(); ?>

	<?php else: ?>

		<p><?php _e("You need to active your account before buy listings.", "enginethemes"); ?></p>

	<?php
		$profile_link = me_get_page_permalink('user_account');
        $activate_email_link = add_query_arg(array( 'resend-confirmation-email' => true, '_wpnonce' => wp_create_nonce('me-resend_confirmation_email') ), $profile_link);
    ?>

        <p><a id="resend-confirmation-email" href="<?php echo $activate_email_link; ?>"><?php _e("Resend activation email.", "enginethemes"); ?></a></p>

	<?php endif; ?>

</div>

<?php endif; ?>