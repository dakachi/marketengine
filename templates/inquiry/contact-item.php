<?php 
$message = me_get_message(); 
$new_message = me_get_message_meta($message->ID, '_me_recevier_new_message', true);
?>

<li <?php if($message->ID == $_GET['inquiry_id']) {echo 'class="active"';} ?>>
	<a href="<?php echo add_query_arg('inquiry_id', $message->ID); ?>">
		<span class="me-user-avatar">
			<?php echo me_get_avatar( $message->sender, 36); ?>
		</span>
		<span class="me-contact-author">
			<span><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></span>

			<?php if($new_message) : ?>
				<span class="me-message-count"><?php echo $new_message; ?></span>
			<?php endif; ?>

		</span>
	</a>
</li>
