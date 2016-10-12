<?php $message = me_get_message(); ?>
<li <?php if($message->ID == $_GET['inquiry_id']) {echo 'class="active"';} ?>>
	<a href="<?php echo add_query_arg('inquiry_id', $message->ID); ?>">
		<span class="me-user-avatar">
			<?php echo get_avatar( $message->sender, 36); ?>
		</span>
		<span class="me-contact-author">
			<span><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></span>
		</span>
	</a>
</li>