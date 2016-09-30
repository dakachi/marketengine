<li>
	<span class="me-mgs-author-avatar">
		<?php echo get_avatar( $message->sender, '36'); ?>
	</span>
	<div class="me-message-author">
		<h4 class="me-author"><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></h4>
		<p><?php echo nl2br(esc_html( $message->post_content )); ?></p>
		<span><?php echo human_time_diff( strtotime($message->post_date) ); ?></span>
	</div>
</li>