<li>
	<a href="<?php echo get_author_posts_url($message->sender); ?>" >
		<span class="me-mgs-author-avatar">
			<?php echo me_get_avatar( $message->sender, '36'); ?>
		</span>
	</a>
	<div class="me-message-author">
		<a href="<?php echo get_author_posts_url($message->sender); ?>" >
			<h4 class="me-author"><?php echo get_the_author_meta( 'display_name', $message->sender ); ?></h4>
		</a>
		<p><?php echo apply_filters( 'the_marketengine_message', $message->post_content ); ?></p>
		<span><?php echo human_time_diff( strtotime($message->post_date) ); ?></span>
	</div>
</li>