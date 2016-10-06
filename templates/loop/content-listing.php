<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$listing = me_get_listing();
$listing_type = $listing->get_listing_type();
// TODO: update schema type, price and unit
?>

<?php do_action('marketengine_before_listing_item', $listing); ?>

<li class="me-item-post me-col-md-3" itemscope itemtype="http://schema.org/Product">

	<?php do_action('marketengine_listing_item_start', $listing); ?>

	<div class="me-item-wrap">
		<a href="<?php the_permalink(); ?>" title="<?php printf(__("View %s", "enginethemes"), get_the_title()); ?>" class="me-item-img">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
			<span><?php _e("VIEW DETAILS", "enginethemes"); ?></span>
		</a>
		<div class="me-item-content">

			<h2  itemprop="name">
				<a href="<?php the_permalink(); ?>" title="<?php printf(__("View %s", "enginethemes"), get_the_title()); ?>">
					<?php the_title(); ?>
				</a>
			</h2>

			<?php do_action('marketengine_after_listing_item_price'); ?>

			<?php 
				if('purchasion' == $listing_type) :
					me_get_template('loop/purchasion', array('listing' => $listing));
				else : 
					me_get_template('loop/contact', array('listing' => $listing));
				endif; 
			 ?>

			<?php do_action('marketengine_after_listing_item_price'); ?>

			<div class="me-item-author">
				<?php printf(__("by %s", "enginethemes"), get_the_author_posts_link()); ?>
			</div>
		</div>
	</div>

	<?php do_action('marketengine_listing_item_end', $listing); ?>

</li>

<?php do_action('marketengine_after_listing_item', $listing); ?>