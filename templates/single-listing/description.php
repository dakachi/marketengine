<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php do_action('marketengine_before_single_listing_details');?>

<div itemprop="description" class="me-description listing-description">

	<?php do_action('marketengine_single_listing_details_start');?>

	<h3><?php _e("Explore this listing", "enginethemes");?></h3>
	<?php the_content();?>

	<?php do_action('marketengine_single_listing_details_end');?>

</div>
<?php do_action('marketengine_after_single_listing_details');?>