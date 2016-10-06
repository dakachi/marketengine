<?php
$display_name = get_the_author_meta('display_name', $author_id);
$location = get_the_author_meta('location', $author_id);
$member_sinced = date_i18n( get_option( 'date_format' ), strtotime(get_the_author_meta( 'user_registered', $author_id )) );
?>
<div class="me-authors">
	<span class="me-avatar">
		<?php echo get_avatar( $author_id ); ?>
		<b><?php echo $display_name; ?></b>
	</span>
	<ul class="me-author-info">
		<li>
			<span class="pull-left"><?php echo __('From:', 'enginethemes'); ?></span>
			<b class="pull-right"><?php echo $location ?></b>
		</li>
		<li>
			<span class="pull-left"><?php echo __('Language:', 'enginethemes'); ?></span>
			<b class="pull-right">Vietnam</b>
		</li>
		<li>
			<span class="pull-left"><?php echo __('Member Sinced:', 'enginethemes'); ?></span>
			<b class="pull-right"><?php echo $member_sinced; ?></b>
		</li>
	</ul>
	<a href="<?php echo get_author_posts_url($author_id); ?>" class="me-view-profile"><?php echo __('View profile', 'enginethemes'); ?></a>
</div>