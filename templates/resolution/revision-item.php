<li class="me-contact-dispute-event">
	<p>
		<b><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></b>
		<i>has closed the dipute</i>
	</p>
	<span><?php echo date_i18n(get_option('date_format') .' ' . get_option('time_format') ,strtotime($message->post_date) ); ?></span>
</li>