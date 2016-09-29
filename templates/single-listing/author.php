<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$seller = new ME_Seller( $author_id );
$display_name = $seller->display_name ? $seller->display_name : '';
$location = $seller->location[0] ? $seller->location[0] : '';
?>
<div class="me-authors">
	<span class="me-avatar">
		<?php echo $seller->get_avatar(); ?>
		<b><?php echo $display_name; ?></b>
	</span>
	<ul class="me-author-info">
		<li>
			<span class="pull-left"><?php echo __('From:'); ?></span>
			<b class="pull-right"><?php echo $location; ?></b>
		</li>
		<li>
			<span class="pull-left"><?php echo __('Language:'); ?></span>
			<b class="pull-right"></b>
		</li>
		<li>
			<span class="pull-left"><?php echo __('Member Sinced:'); ?></span>
			<b class="pull-right"><?php echo date( 'd M, Y', strtotime($seller->user_registered)); ?></b>
		</li>
	</ul>
	<a href="<?php echo get_author_posts_url($author_id); ?>" class="me-view-profile">View profile</a>
</div>