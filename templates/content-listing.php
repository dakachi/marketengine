<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
global $post;
$listing = ME()->listing_factory->get_listing($post);
$listing_type = $listing->get_listing_type();
// TODO: update schema type, price and unit
?>

<?php do_action('marketengine_before_listing_item', $listing); ?>

<li class="me-item-post me-col-md-3" itemscope itemtype="http://schema.org/Product">
	<?php do_action('marketengine_listing_item_start', $listing); ?>
	<div class="me-item-wrap">
		<a href="<?php the_permalink(); ?>" title="<?php printf(__("View %s", "enginethemes"), get_the_title()); ?>" class="me-item-img">
			<?php the_post_thumbnail(); ?>
			<span><?php _e("VIEW DETAILS", "enginethemes"); ?></span>
		</a>
		<div class="me-item-content">
			<h2  itemprop="name">
				<a href="<?php the_permalink(); ?>" title="<?php printf(__("View %s", "enginethemes"), get_the_title()); ?>"><?php the_title(); ?></a>
			</h2>
			<?php do_action('marketengine_after_listing_item_price'); ?>
			<?php if('contact' === $listing_type) : ?>
				<div class="me-item-contact">
					<span class="post-price"><?php _e("Contact", "enginethemes"); ?></span>
				</div>
				<div class="me-contact-now">
					<a href="#" class="me-contactnow-btn"><?php _e("CONTACT NOW", "enginethemes"); ?></a>
				</div>
			<?php endif; ?>
			<?php if('purchasion' == $listing_type) :
				$price = $listing->get_price();
				$pricing_unit = $listing->get_pricing_unit();
			?>
				<div class="me-item-price">
					<span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="me-price pull-left">
						<b itemprop="priceCurrency" content="USD">$</b>
						<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
					</span>
					<div class="me-rating pull-right">
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star-o"></i>
					</div>
				</div>
				<div class="me-buy-now">
					<form method="post">
						<?php if('' !== $pricing_unit) : ?>
							<input type="hidden" required min="1" value="1" name="qty" />
						<?php endif; ?>
						
						<?php wp_nonce_field('me-add-to-cart'); ?>

						<?php do_action('marketengine_single_listing_add_to_cart_form_field'); ?>

						<input type="hidden" name="add_to_cart" value="<?php echo $post->ID; ?>" />
						<input type="submit" class="me-buy-now-btn" value="<?php _e("BUY NOW", "enginethemes"); ?>">
					</form>
					<!-- <a href="#" class="me-buynow-btn"><?php _e("BUY NOW", "enginethemes"); ?></a> -->
				</div>
			<?php endif; ?>
			<?php do_action('marketengine_after_listing_item_price'); ?>
			<div class="me-item-author">
				<?php printf(__("by %s", "enginethemes"), get_the_author_posts_link()); ?>
			</div>
		</div>
	</div>

	<?php do_action('marketengine_listing_item_end', $listing); ?>
	
</li>

<?php do_action('marketengine_after_listing_item', $listing); ?>