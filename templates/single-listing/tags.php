<?php do_action('marketengine_before_single_listing_tags'); ?>

<div class="me-tags">
	<span><?php _e("Tags:", "enginethemes"); the_terms('', 'listing_tag', '&nbsp;'); ?> </span>
</div>

<?php do_action('marketengine_after_single_listing_tags'); ?>