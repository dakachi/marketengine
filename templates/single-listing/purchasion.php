<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing_Purchase($post);
$price = $listing->get_price();
$pricing_unit = $listing->get_pricing_unit();
?>

<?php do_action('marketengine_before_single_listing_price'); ?>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="me-price">
	<span class="me-amount">
		<b itemprop="priceCurrency" content="USD">$</b>
		<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
	</span>

	<div class="me-addtocart">
		<form method="post">

			<?php do_action('marketengine_single_listing_add_to_cart_form_start'); ?>

			<?php if('' !== $pricing_unit) : ?>
				<div class="me-quantily">
					<input type="number" required min="1" />
				</div>
			<?php endif; ?>
			
			<?php wp_nonce_field('me-create_order'); ?>

			<?php do_action('marketengine_single_listing_add_to_cart_form_field'); ?>

			<input type="hidden" name="add_to_cart" value="<?php echo $post->ID; ?>" />
			<input type="submit" class="me-buy-now-btn" value="<?php _e("BUY NOW", "enginethemes"); ?>">

			<?php do_action('marketengine_single_listing_add_to_cart_form_end'); ?>

		</form>
	</div>
</div>

<?php do_action('marketengine_after_single_listing_price'); ?>
